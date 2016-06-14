<?php

class TalonOne_TalonOne_Helper_CustomerSession extends Mage_Core_Helper_Abstract
{
    public function update($customerSessionId, $talonOneCustomerSession)
    {
        $session = Mage::getSingleton('checkout/session');
        $newCustomerSessionHash = hash('md5', json_encode($talonOneCustomerSession));
        $customerSessionHash = $session->getTalonOneCustomerSessionHash();
        if ($newCustomerSessionHash != $customerSessionHash) {
            $session->setTalonOneCustomerSessionHash($newCustomerSessionHash);
            $response = Mage::helper('talonone_talonone/api')->put('customer_sessions/' . $customerSessionId, $talonOneCustomerSession);
            Mage::helper('talonone_talonone/api')->checkResponse($response['body']);
        }
    }

    public function updateCustomerSession($state = 'open')
    {
        $talonOneCustomerSessionFactory = Mage::getModel('talonone_talonone/customerSession_factory');
        $talonOneCustomerSession = $talonOneCustomerSessionFactory->bind(Mage::getSingleton('checkout/session'));
        $talonOneCustomerSession->setState($state);
        $this->update($this->getCustomerSessionId(), $talonOneCustomerSession);
    }

    public function getCustomerId() {
        $customerSession = Mage::getSingleton('customer/session');
        if ($customerSession->isLoggedIn()) {
            return $customerSession->getCustomer()->getId();
        }
        return '';
    }

    public function getCustomerSessionId()
    {
        $customerSession = Mage::getSingleton('customer/session');
        if ($customerSession->isLoggedIn()) {
            return $customerSession->getSessionId();
        }
        return Mage::getSingleton("core/session")->getSessionId();
    }

    public function closeCustomerSession()
    {
        $this->updateCustomerSession('closed');
        Mage::helper('talonone_talonone')->getEffectCollection()->rollBackEffects();
    }
}