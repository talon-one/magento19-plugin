<?php

class TalonOne_TalonOne_Model_Observer
{

    public function hookToCustomerLoginAfter($observer)
    {
        $request = $observer->getEvent()->getRequest()->getParams();

        $helper = Mage::helper('talonone_talonone');
        $helper->createOrUpdateCustomerProfile();

    }

    public function hookToControllerActionPostDispatch($observer)
    {
        $fullActionName = $observer->getEvent()->getControllerAction()->getFullActionName();
        $request = $observer->getControllerAction()->getRequest();

        $values = array('url' => $request->getRequestUri());

        switch ($fullActionName) {
            case 'checkout_cart_add':
                Mage::dispatchEvent('add_to_cart_after', array('request' => $request));
                break;
            case 'checkout_cart_updatePost':
                Mage::dispatchEvent('update_cart_after', array('request' => $request));
                break;
        }

        $helper = Mage::helper('talonone_talonone');
        $helper->postEvent($fullActionName, $values);
    }

    public function hookToAddToCartAfter($observer)
    {
        $request = $observer->getEvent()->getRequest()->getParams();

        $helper = Mage::helper('talonone_talonone');
        $helper->updateCustomerSession();

    }

    public function hookToUpdateCartAfter($observer)
    {
        $request = $observer->getEvent()->getRequest()->getParams();

        $helper = Mage::helper('talonone_talonone');
        $helper->updateCustomerSession();
    }

}
