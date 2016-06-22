<?php

class TalonOne_TalonOne_Model_Effect_Collection
{
    protected $_effects = [];
    protected $_removedFreeItemsSku = [];

    public function count()
    {
        return count($this->_effects);
    }

    public function getEffects()
    {
        return $this->_effects;
    }

    public function setEffects($effects)
    {
        $this->_effects = $this->filterRemovedFreeItems($effects);
    }

    public function filterRemovedFreeItems($effects)
    {
        return array_filter($effects, function ($effect) {
            return (!$effect->isFreeItem()) ||
                ($effect->isFreeItem() && !in_array($effect->getSku(), $this->_removedFreeItemsSku));
        });
    }

    public function isEmpty()
    {
        return ($this->count() == 0);
    }

    public function addEffect(TalonOne_TalonOne_Model_Effect $effect)
    {
        array_push($this->_effects, $effect);
    }

    public function bindEffectsFromArray($effects)
    {
        foreach ($effects as $effect) {
            $this->addEffect(Mage::getModel('talonone_talonone/effect')->bindArray($effect));
        }
    }

    public function getDiscounts()
    {
        return array_filter($this->_effects, function ($effect) {
            return $effect->isDiscount();
        });
    }

    public function getDiscountAmount()
    {
        return array_reduce($this->getDiscounts(), function ($c, $v) {
            return ($c + $v->getValue());
        }, 0);
    }

    public function getDiscountDescriptions()
    {
        return array_reduce($this->getDiscounts(), function ($c, $v) {
            return ($c ? $c . ', ' : '') . $v->getDescription();
        }, '');
    }

    public function isFreeShipping()
    {
        return count(array_filter($this->_effects, function ($effect) {
            return $effect->isFreeShipping();
        })) > 0;
    }

    public function getFreeItems()
    {
        return array_filter($this->_effects, function ($effect) {
            return $effect->isFreeItem();
        });
    }

    public function removeItemBySku($sku)
    {
        foreach ($this->_effects as $key => $effect) {
            if ($effect->isFreeItem() && ($effect->getSku() == $sku)) {
                unset($this->_effects[$key]);
                array_push($this->_removedFreeItemsSku, $sku);
            }
        }
        $this->save();
    }

    public function hasDiffEffects(TalonOne_TalonOne_Model_Effect_Collection $newEffectCollection)
    {
        if ($newEffectCollection->getHash() === $this->getHash()) {
            return false;
        }

        return ($this->uDiffEffects($this, $newEffectCollection) + $this->uDiffEffects($newEffectCollection, $this)) > 0;
    }

    public function updateEffects(TalonOne_TalonOne_Model_Effect_Collection $newEffectCollection)
    {
        if ($newEffectCollection->isEmpty()) {
            $this->rollBackEffects();
            return;
        }

        if ($newEffectCollection->hasDiffEffects($this)) {
            $this->rollBackEffects(false);
        }

        $this->setEffects($newEffectCollection->getEffects());
        $this->save();
    }

    public function rollBackEffects($removeCouponCode = true)
    {
        $session = Mage::getSingleton('checkout/session');
        if ($removeCouponCode) {
            $session->unsTalonOneCouponCode();
        }

        if (!$this->isEmpty()) {
            Mage::helper('talonone_talonone')->unsEffectCollection();
            $quote = $session->getQuote();
            foreach ($this->getFreeItems() as $effect) {
                $effect->removeFreeItemFromCart($quote);
            }
            $quote->setTotalsCollectedFlag(false);
            $quote->collectTotals();
            $quote->save();
        }
    }

    public function checkFreeItemCount($quote)
    {
        foreach ($this->getFreeItems() as $item) {
            foreach ($quote->getAllVisibleItems() as $cartItem) {
                if (($cartItem->getSku() === $item->getSku()) && ($cartItem->getQty() > 1)) {
                    $cartItem->setQty(1);
                }
            }
        }
    }

    public function getHash()
    {
        return hash('md5', serialize($this->getEffects()));
    }

    protected function uDiffEffects(
        TalonOne_TalonOne_Model_Effect_Collection $firstEffectCollection,
        TalonOne_TalonOne_Model_Effect_Collection $secondEffectCollection
    ) {
        $effects = $firstEffectCollection->getEffects();
        return count(array_udiff($firstEffectCollection->getEffects(), $secondEffectCollection->getEffects(),
            function ($oldEffect, $newEffect) use ($effects) {
                if ($oldEffect->equals($newEffect)) {
                    return 0;
                }
                return count(array_filter($effects, function ($effect) use ($newEffect) {
                    return $effect->equals($newEffect);
                })) == 0 ? 1 : -1;
            }));

    }

    protected function save()
    {
        Mage::helper('talonone_talonone')->setEffectCollection($this);
    }
}
