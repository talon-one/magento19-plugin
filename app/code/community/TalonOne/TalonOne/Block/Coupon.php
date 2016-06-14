<?php

class TalonOne_TalonOne_Block_Coupon extends Mage_Core_Block_Template
{

    public function showCouponInput()
    {
        return Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_SHOW_COUPON_INPUT);
    }

    public function isValidCouponCode()
    {
        return Mage::helper('talonone_talonone')->isValidCouponCode();
    }

    public function getCouponCode()
    {
        return Mage::helper('talonone_talonone')->getCouponCode();
    }

    public function getLastError()
    {
        return Mage::helper('talonone_talonone')->getLastError();
    }

    public function getFormActionUrl()
    {
        return $this->getUrl('talonone/TalonOne/couponPost', array('_secure' => $this->_isSecure()));
    }

}