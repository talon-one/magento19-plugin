<?php

class TalonOne_TalonOne_Model_CustomerSession_Factory
{
    public function bind(Mage_Checkout_Model_Session $checkoutSession)
    {
        $quote = $checkoutSession->getQuote();
        $totals = $quote->getTotals();
        
        $talonOneCustomerSession = Mage::getModel('talonone_talonone/customerSession');
        $talonOneCustomerSession->setCoupon((string)$checkoutSession->getTalonOneCouponCode());
        $talonOneCustomerSession->setState('open');
        $talonOneCustomerSession->setCartItems(Mage::getModel('talonone_talonone/cartItem_collection_factory')->bind($quote));
        $talonOneCustomerSession->setTimezone(Mage::app()->getStore()->getConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_TIMEZONE));
        $talonOneCustomerSession->setCurrency(Mage::app()->getStore()->getCurrentCurrencyCode());
        $talonOneCustomerSession->setTotal((float)round($totals["grand_total"]->getValue()));
        $talonOneCustomerSession->setProfileId(Mage::helper('talonone_talonone/customerSession')->getCustomerId());
        $talonOneCustomerSession->bindBillingAddress($quote->getBillingAddress());
        $talonOneCustomerSession->bindShippingAddress($quote->getShippingAddress());

        $payment = $quote->getPayment();
        if ($payment) {
            try {
                $talonOneCustomerSession->setPaymentMethod((string)$payment->getMethodInstance()->getCode());
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }

        return $talonOneCustomerSession;
    }
}