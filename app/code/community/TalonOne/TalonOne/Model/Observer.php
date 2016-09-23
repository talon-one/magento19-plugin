<?php

class TalonOne_TalonOne_Model_Observer
{
    public function hookToCustomerRegisterSuccess()
    {
        $this->createOrUpdateCustomerProfile();
    }

    public function hookToCustomerLoginAfter()
    {
        $this->createOrUpdateCustomerProfile();
    }

    public function hookToCustomerSaveAfter()
    {
        $this->createOrUpdateCustomerProfile();
    }

    public function hookToCustomerAddressSaveAfter()
    {
        $this->createOrUpdateCustomerProfile();
    }

    public function hookToAddToCartAfter()
    {
        $this->updateCustomerSession();
    }

    public function hookToUpdateCartAfter()
    {
        $this->updateCustomerSession();
    }

    public function hookToSavePaymentAfter()
    {
        $this->updateCustomerSession();
    }

    public function hookToSalesQuoteCollectTotalsAfter(Varien_Event_Observer $observer)
    {
        Mage::helper('talonone_talonone/cart')->addFreeItemsToCart($observer->getEvent()->getQuote());
    }

    public function hookToSalesOrderPlaceAfter()
    {
        Mage::helper('talonone_talonone/customerSession')->closeCustomerSession();
    }

    public function hookToSalesQuoteSaveBefore(Varien_Event_Observer $observer)
    {
        Mage::helper('talonone_talonone')->getEffectCollection()->checkFreeItemCount($observer->getEvent()->getQuote());
    }

    public function hookToSalesQuoteRemoveItem(Varien_Event_Observer $observer)
    {
        Mage::helper('talonone_talonone')->getEffectCollection()->removeItemBySku($observer->getQuoteItem()->getSku());
    }

    public function hookToControllerActionPostDispatch(Varien_Event_Observer $observer)
    {
        $fullActionName = $observer->getEvent()->getControllerAction()->getFullActionName();
        $request = $observer->getControllerAction()->getRequest();
        switch ($fullActionName) {
            case 'checkout_cart_add':
                Mage::dispatchEvent('add_to_cart_after', array('request' => $request));
                break;
            case 'checkout_cart_updatePost':
                Mage::dispatchEvent('update_cart_after', array('request' => $request));
                break;
            case 'checkout_onepage_savePayment':
                Mage::dispatchEvent('save_payment_after', array('request' => $request));
                break;
        }
        Mage::helper('talonone_talonone/customerEvent')->postEvent('action', array('name'=> $fullActionName,'url' => $request->getRequestUri()));
    }

    protected function createOrUpdateCustomerProfile()
    {
        Mage::helper('talonone_talonone/customerProfile')->createOrUpdateCustomerProfile();
    }

    protected function updateCustomerSession()
    {
        Mage::helper('talonone_talonone/customerSession')->updateCustomerSession();
    }
}
