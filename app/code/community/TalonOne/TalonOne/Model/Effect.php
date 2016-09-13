<?php

class TalonOne_TalonOne_Model_Effect
{
    protected $_method;
    protected $_description;
    protected $_value;
    protected $_sku;

    public function isDiscount()
    {
        return ($this->getMethod() === 'setDiscount' && $this->getDescription() !== 'Free Shipping');
    }

    public function isFreeShipping()
    {
        return ($this->getMethod() === 'setDiscount' && $this->getDescription() === 'Free Shipping');
    }

    public function isFreeItem()
    {
        return ($this->getMethod() === 'addFreeItem');
    }

    public function isInvalidateCoupon()
    {
        return ($this->getMethod() === 'invalidateCoupon');
    }

    public function isRejectCoupon()
    {
        return ($this->getMethod() === 'rejectCoupon');
    }

    public function getMethod()
    {
        return $this->_method;
    }

    public function setMethod($method)
    {
        $this->_method = $method;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
    }

    public function getValue()
    {
        return $this->_value;
    }

    public function setValue($value)
    {
        $this->_value = $value;
    }

    public function setSku($sku)
    {
        $this->_sku = $sku;
    }

    public function getSku()
    {
        return $this->_sku;
    }

    public function bindArray($array)
    {
        switch ($array[0]) {
            case 'addFreeItem':
                $this->bindAddFreeItem($array);
                break;
            case 'rejectCoupon':
            case 'invalidateCoupon':
                $this->bindInvalideCupon($array);
                break;
            default:
                $this->bindDefaultEffect($array);
        }

        return $this;
    }

    public function equals(TalonOne_TalonOne_Model_Effect $effect)
    {
        if ($this->isFreeShipping() || $this->getHash() === $effect->getHash()) {
            return true;
        }
        return false;
    }

    public function getHash()
    {
        return hash('md5', serialize($this));
    }

    public function removeFreeItemFromCart($quote)
    {
        $item = Mage::helper('talonone_talonone/cart')->getFreeItemFromCartBySku($quote, $this->getSku());
        if ($item) {
            Mage::getSingleton('checkout/cart')->removeItem($item->getItemId())->save();
            Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
        }
    }

    private function bindDefaultEffect($array)
    {
        list($method, $description, $value) = $array;
        $this->setMethod($method);
        $this->setDescription($description);
        $this->setValue($value);
    }

    private function bindInvalideCupon($array)
    {
        list($method, $value) = $array;
        $this->setMethod($method);
        $this->setValue($value);
    }

    private function bindAddFreeItem($array)
    {
        list($method, $value, $sku, $description) = $array;
        $this->setSku($sku);
        $this->setMethod($method);
        $this->setDescription($description);
        $this->setValue($value);
    }
}
