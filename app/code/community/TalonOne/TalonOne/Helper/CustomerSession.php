<?php

class TalonOne_TalonOne_Helper_CustomerSession extends Mage_Core_Helper_Abstract
{
    public function update($customerSessionId, $talonOneCustomerSession)
    {
        $response = Mage::helper('talonone_talonone/api')->put('customer_sessions/' . $customerSessionId, $talonOneCustomerSession);
        Mage::helper('talonone_talonone')->checkResponse($response);
    }
}