<?php

class TalonOne_TalonOne_Model_Sales_Quote_Address_Total_Discount extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    public function __construct()
    {
        $this->setCode('discount');
    }

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        $this->_setAmount(0);
        $this->_setBaseAmount(0);
        if (!count($this->_getAddressItems($address))) {
            return $this;
        }

        Mage::helper('talonone_talonone/customerSession')->updateCustomerSession();
        $effectsCollection = Mage::helper('talonone_talonone')->getEffectCollection();
        $discountAmount = $effectsCollection->getDiscountAmount();
        $quote = $address->getQuote();
        if ($address->getAddressType() == $this->canAddItem($quote) && $discountAmount > 0) {
            $quote->setDiscountAmount(-$discountAmount);
            $address->setDiscountDescription('Talon Discounts(' . htmlspecialchars($effectsCollection->getDiscountDescriptions()) . ')');
            $address->setDiscountAmount(-$discountAmount);
            $address->setBaseDiscountAmount(-$discountAmount);
            $address->setGrandTotal($address->getGrandTotal() + $address->getDiscountAmount());
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBaseDiscountAmount());
        }

        return $this;
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $quote = $address->getQuote();
        if (($address->getAddressType() == $this->canAddItem($quote)) && ($address->getDiscountAmount() < 0)) {
            if ($address->getGrandTotal() < 0) {
                $address->setDiscountAmount($address->getDiscountAmount() - $address->getGrandTotal());
                $address->setBaseDiscountAmount($address->getBaseDiscountAmount() - $address->getBaseGrandTotal());
                $address->setGrandTotal(0);
                $address->setBaseGrandTotal(0);
            }
            $address->addTotal(array(
                'code' => $this->getCode(),
                'title' => $address->getDiscountDescription(),
                'value' => $address->getDiscountAmount()
            ));
        }
    }

    protected function canAddItem($quote) {
        return $quote->isVirtual() ? ('billing') : ('shipping');
    }
}