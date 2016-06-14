<?php

class TalonOne_TalonOne_Helper_CustomerProfile extends Mage_Core_Helper_Abstract
{
    public function update($integrationId, $talonOneCustomerProfile)
    {
        Mage::helper('talonone_talonone/api')->put('customer_profiles/' . $integrationId, $talonOneCustomerProfile);
    }

    public function createOrUpdateCustomerProfile()
    {
        $customerSession = Mage::getSingleton('customer/session');
        $customer = $customerSession->getCustomer();
        if ($customerSession->isLoggedIn() && $customer) {
            $talonOneCustomerProfile = Mage::getModel('talonone_talonone/customerProfile_factory')->bind($customer);
            $this->update($customer->getId(), $talonOneCustomerProfile);
        }
    }
}