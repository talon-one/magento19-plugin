<?php

class TalonOne_TalonOne_Helper_CustomerEvent extends Mage_Core_Helper_Abstract
{
    public function update($talonOneCustomerEvent)
    {
        $response = Mage::helper('talonone_talonone/api')->post('events', $talonOneCustomerEvent);
        Mage::helper('talonone_talonone')->checkResponse($response);
    }
}