<?php

class TalonOne_TalonOne_Model_CartItem_Collection_Factory
{
    public function bind($quote)
    {
        $cartItemCollection = Mage::getModel('talonone_talonone/cartItem_collection');
        foreach ($quote->getAllVisibleItems() as $item) {
            $productItem = $item->getProduct();
            $cartItem = Mage::getModel('talonone_talonone/cartItem');
            $cartItem->setName($productItem->getName());
            $cartItem->setSku($productItem->getSku());
            $cartItem->setQuantity($item->getQty());
            $cartItem->setCurrency(Mage::app()->getStore()->getCurrentCurrencyCode());
            $cartItem->setQuantity($item->getQty());
            $cartItem->setPrice((float)$item->getPrice());
            $cartItem->setWeight((float)$productItem->getWeight());
            $productsCollection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('entity_id', array('in' => array($item->getProductId())))
                ->addAttributeToSelect('height')
                ->addAttributeToSelect('width')
                ->addAttributeToSelect('length')
                ->setPageSize('1');
            $productAttr = $productsCollection->getItemById(1);
            if ($productAttr) {
                $cartItem->setHeight((float)$productAttr->getHeight());
                $cartItem->setWidth((float)$productAttr->getWeight());
                $cartItem->setLength((float)$productAttr->getLeight());
            }
            if ($productItem->getCategoryIds()) {
                $categoryCollection = Mage::getModel('catalog/category')->getCollection()
                    ->addAttributeToFilter('entity_id', array('in' => $productItem->getCategoryIds()))
                    ->addAttributeToSelect('name');
                $cartItem->setCategory(implode(',', $categoryCollection->getColumnValues('name')));
            }
            $cartItemCollection->addItem($cartItem);
        }

        return $cartItemCollection;
    }

}