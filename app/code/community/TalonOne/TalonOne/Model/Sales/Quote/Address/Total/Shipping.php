<?php

class TalonOne_TalonOne_Model_Sales_Quote_Address_Total_Shipping extends Mage_Sales_Model_Quote_Address_Total_Shipping
{
    public function __construct()
    {
        $this->setCode('shipping');
    }

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this;
        }

        $effects = Mage::helper('talonone_talonone')->getEffectCollection();
        if ($effects->isFreeShipping()) {
            $quote = $address->getQuote();
            $canAddItems = $quote->isVirtual() ? ('billing') : ('shipping');
            if ($address->getAddressType() == $canAddItems) {
                foreach ($items as $item) {
                    $item->getBaseShippingAmount(0);
                    $item->setShippingAmount(0);
                    $item->setFreeShipping(1);
                }
                $address->setFreeShipping(1)
                    ->setShippingAmount(0)
                    ->setBaseShippingAmount(0)
                    ->setShippingTaxAmount(0)
                    ->setBaseShippingTaxAmount(0)
                    ->setShippingDescription('Free Shipping');
                $address->setShippingDescription('Free Shipping');
            }
        }

        return $this;
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        parent::fetch($address);
        $amount = $address->getShippingAmount();
        $effects = Mage::helper('talonone_talonone')->getEffectCollection();
        if ($effects && $effects->isFreeShipping()) {
            if ($amount == 0 || $address->getShippingDescription()) {
                $title = Mage::helper('sales')->__('Shipping & Handling');
                if ($address->getShippingDescription()) {
                    $title .= ' (' . $address->getShippingDescription() . ')';
                }
                $address->addTotal(array(
                    'code' => $this->getCode(),
                    'title' => $title,
                    'value' => $address->getShippingAmount()
                ));
            }
        } elseif ($amount == 0 && $address->getShippingDescription() == 'Free Shipping') {
            $address->setShippingDescription('');
        }

        return $this;
    }
}
