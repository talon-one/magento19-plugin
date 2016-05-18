<?php

class TalonOne_TalonOne_Model_Sales_Quote_Address_Total_Coupon extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'talonDiscount';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        $this->_setAmount(0);
        $this->_setBaseAmount(0);

        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this; //this makes only address type shipping to come through
        }

        $quote = $address->getQuote();

        $exist_amount = $quote->getDiscountAmount();
        $discount = 10;
        $balance = $discount - $exist_amount;
        $address->setDiscountAmount($balance);
        $address->setBaseDiscountAmount($balance);

        $quote->setDiscountAmount($balance);

        $address->setGrandTotal($address->getGrandTotal() + $address->getDiscountAmount());
        $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBaseDiscountAmount());
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $discount = $address->getDiscountAmount();

        $address->addTotal(array(
            'code'=>$this->getCode(),
            'title'=> 'Custom discount',
            'value'=> $discount
        ));
        return $this;

    }

}