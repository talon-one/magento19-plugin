<?php

class TalonOne_TalonOne_Model_CustomerProfile_Factory
{
    public function bind(Mage_Customer_Model_Customer $customer)
    {
        $talonOneCustomerProfile = Mage::getModel('talonone_talonone/customerProfile');
        $talonOneCustomerProfile->setName($customer->getName());
        $talonOneCustomerProfile->setSignUpDate(strtotime($customer->getCreatedAt()));
        $talonOneCustomerProfile->setBirthDate($customer->getDob() ? strtotime($customer->getDob()) : null);
        $talonOneCustomerProfile->bindBillingAddress($customer->getDefaultBillingAddress());
        $talonOneCustomerProfile->bindShippingAddress($customer->getDefaultShippingAddress());

        $gender = ($customer->getGender()) ? Mage::getResourceSingleton('customer/customer')->getAttribute('gender')->getSource()->getOptionText($customer->getGender()) : null;
        if ($gender) {
            $talonOneCustomerProfile->setGender($gender);
        }

        return $talonOneCustomerProfile;
    }
}
