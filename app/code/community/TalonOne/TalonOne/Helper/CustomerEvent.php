<?php

class TalonOne_TalonOne_Helper_CustomerEvent extends Mage_Core_Helper_Abstract
{
    public function update($talonOneCustomerEvent)
    {
        $response = Mage::helper('talonone_talonone/api')->post('events', $talonOneCustomerEvent);
        Mage::helper('talonone_talonone/api')->checkResponse($response['body']);
    }

    public function postEvent($type, $values)
    {
        $talonOneEvent = Mage::getModel('talonone_talonone/event');
        $talonOneEvent->setType($type);
        $talonOneEvent->setValue($values);
        $talonOneEvent->setProfileId(Mage::helper('talonone_talonone/customerSession')->getCustomerId());
        $talonOneEvent->setSessionId(Mage::helper('talonone_talonone/customerSession')->getCustomerSessionId());
        $this->update($talonOneEvent);
    }
}