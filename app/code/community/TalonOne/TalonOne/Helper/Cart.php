<?php

class TalonOne_TalonOne_Helper_Cart extends Mage_Core_Helper_Abstract
{

    public function addFreeItemsToCart($quote)
    {
        $cartWasUpdated = false;
        $cart = Mage::getSingleton('checkout/cart');
        foreach (Mage::helper('talonone_talonone')->getEffectCollection()->getFreeItems() as $freeItem) {
            $product = $this->addFreeProduct($quote, $freeItem->getSku());
            if ($product) {
                $act = $cart->addProduct($product, [
                    'product' => $product->getId(),
                    'qty' => 1,
                    'price' => 0,
                    'cost' => 0,
                ]);
                $quote = $act->getQuote();
                foreach ($quote->getAllItems() as $item) {
                    if ($item->getSku() === $freeItem->getSku()) {
                        $price = 0.0;
                        $item->setCustomPrice($price);
                        $item->setOriginalCustomPrice($price);
                        $item->getProduct()->setIsSuperMode(true);
                        $item->save();
                        break;
                    }
                }
                $quote->save();
                $cartWasUpdated = true;
            }
        }
        if ($cartWasUpdated) {
            $cart->save();
            Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
        }
    }

    public function getFreeItemFromCartBySku($quote, $sku)
    {
        foreach ($quote->getAllVisibleItems() as $item) {
            if ($item->getSku() === $sku) {
                return $item;
            }
        }
        return null;
    }

    protected function addFreeProduct($quote, $sku)
    {
        $item = $this->getFreeItemFromCartBySku($quote, $sku);
        if (empty($item)) {
            $newProd = Mage::getModel('catalog/product');
            return $newProd->load($newProd->getIdBySku($sku));
        }
        return null;
    }
}