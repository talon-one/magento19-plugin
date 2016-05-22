<?php

class TalonOne_TalonOne_Block_Coupon extends Mage_Core_Block_Template
{

    public function showCouponInput(){
        return Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_SHOW_COUPON_INPUT);
    }

    public function getCouponCode()
    {
        $session = Mage::getSingleton('checkout/session');
        $coupon_code = $session->getData('talonone_coupon_code');

        return $coupon_code;
    }

    public function getFormActionUrl()
    {
        return $this->getUrl('talonone/TalonOne/couponPost', array('_secure' => $this->_isSecure()));
    }

}