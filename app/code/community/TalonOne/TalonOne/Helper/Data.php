<?php

class TalonOne_TalonOne_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_SHOW_COUPON_INPUT = 'talonone/settings/talonone_show_coupon_input';
    const XML_PATH_APPLICATION_ID = 'talonone/settings/talonone_application_id';
    const XML_PATH_SECRET_KEY = 'talonone/settings/talonone_secret_key';

    public function isValidCouponCode()
    {
        return $this->getCouponCode() && !$this->getEffectCollection()->isEmpty();
    }

    public function getCouponCode()
    {
        return Mage::getSingleton('checkout/session')->getTalonOneCouponCode();
    }

    public function setCuponCode($cuponCode)
    {
        if (!empty($this->getCouponCode())) {
            $this->getEffectCollection()->rollBackEffects();
        }
        Mage::getSingleton('checkout/session')->setTalonOneCouponCode($cuponCode);
    }

    public function setLastError($error)
    {
        Mage::getSingleton('checkout/session')->setTalonOneLastError($error);
    }

    public function getLastError()
    {
        $error = Mage::getSingleton('checkout/session')->getTalonOneLastError();
        Mage::getSingleton('checkout/session')->unsTalonOneLastError();
        return $error;
    }

    public function getEffectCollection()
    {
        $effects = Mage::getSingleton('checkout/session')->getTalonOneEffects();
        if ($effects) {
            return $effects;
        }
        return Mage::getModel('talonone_talonone/effect_collection');
    }

    public function setEffectCollection(TalonOne_TalonOne_Model_Effect_Collection $effectCollection)
    {
        return Mage::getSingleton('checkout/session')->setTalonOneEffects($effectCollection);
    }

    public function unsEffectCollection()
    {
        return Mage::getSingleton('checkout/session')->unsTalonOneEffects();
    }
}
