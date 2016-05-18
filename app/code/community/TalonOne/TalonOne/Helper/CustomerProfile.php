<?php

class TalonOne_TalonOne_Helper_CustomerProfile extends Mage_Core_Helper_Abstract
{
    public function update($integrationId, $talonOneCustomerProfile)
    {
        $response = Mage::helper('talonone_talonone/api')->put('customer_profiles/' . $integrationId, $talonOneCustomerProfile);
        Mage::helper('talonone_talonone')->checkResponse($response);
    }
}