<?php

class TalonOne_TalonOne_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_PATH_SHOP_ID = 'talonone/settings/talonone_shop_id';
    const XML_PATH_SECRET_KEY = 'talonone/settings/talonone_secret_key';

    /**
     * Create or update a Customer Profile
     */
    public function createOrUpdateCustomerProfile()
    {
        $customerSession = Mage::getSingleton('customer/session');

        if ($customerSession->isLoggedIn()) {

            $customer = $customerSession->getCustomer();

            $talonOneCustomerProfile = array(
                'name' => $customer->getName(),
                'loyaltyPoints' => 0,
                'advocatePoints' => 0,
                'gender' => $customer->getGender(),
                'birthDate' => $customer->getDob(),
                'closedSessions' => 0,
                'totalSales' => 0,
                'signupDate' => $customer->getCreatedAt()
            );

            Mage::helper('talonone_talonone/customerProfile')->update($customer->getId(), $talonOneCustomerProfile);
        }
    }

    /**
     * Update a Customer Session
     */
    public function updateCustomerSession()
    {
        $checkoutSession = Mage::getSingleton('checkout/session');
        $quote = $checkoutSession->getQuote();
        $totals = $quote->getTotals();
        $grandTotal = round($totals["grand_total"]->getValue());

        $talonOneCustomerSession = array(
            'coupon' => $checkoutSession->getData('talonone_coupon_code'),
            'state' => 'open',
            'cartItems' => $this->getCartItems($quote),
            'shippingCost' => $quote->getShippingAddress()->getShippingAmount(),
            'shippingMethod' => $quote->getShippingAddress()->getShippingMethod(),
            'firstSession' => true,
            'total' => $grandTotal
        );

        $customerSession = Mage::getSingleton('customer/session');
        if ($customerSession->isLoggedIn()) {
            $time_zone = $customerSession->getCustomer()->getTimezone();

            array_push($talonOneCustomerSession, array(
                'profileId' => $customerSession->getCustomer()->getId(),
                'timezone' => $time_zone
            ));

            $customerSessionId = $customerSession->getSessionId();
        } else {
            //empty string for profileId in anonymous session
            array_push($talonOneCustomerSession, array(
                'profileId' => ''
            ));

            $customerSessionId = Mage::getSingleton("core/session")->getSessionId();
        }

        Mage::helper('talonone_talonone/customerSession')->update($customerSessionId, $talonOneCustomerSession);
    }

    /**
     * Get cart items array
     */
    private function getCartItems($quote)
    {
        $cartItems = array();

        foreach ($quote->getAllVisibleItems() as $item) {

            $cartItem = array(
                'name' => $item->getProduct()->getName(),
                'sku' => $item->getProduct()->getSku(),
                'quantity' => $item->getQty(),
                //'currency' => '',
                'price' => (float) $item->getProduct()->getPrice(),
                'weight' => (float) $item->getProduct()->getWeight(),
                //'height' => '',
                //'lenght' => ''
            );

            if ($item->getProduct()->getCategory()) {
                $cartItem['category'] = $item->getProduct()->getCategory()->getName();
            }

            array_push($cartItems, $cartItem);
        }

        return $cartItems;
    }

    /**
     * Post Event
     */
    public function postEvent($type, $values)
    {
        $customerSession = Mage::getSingleton('customer/session');

        $newEvent = array(
            'type' => $type,
            'value' => $values
        );

        if ($customerSession->isLoggedIn()) {
            array_push($newEvent, array(
                'sessionId' => $customerSession->getSessionId(),
                'profileId' => $customerSession->getCustomer()->getId()
            ));
        } else {
            array_push($newEvent, array(
                'sessionId' => Mage::getSingleton("core/session")->getSessionId(),
                'profileId' => '' //empty string for profileId in anonymous session
            ));
        }

        Mage::helper('talonone_talonone/customerEvent')->update($newEvent);
    }

    /**
     * Check and parse response
     */
    public function checkResponse($jsonResponse)
    {
        $response = json_decode($jsonResponse, true);
        $effects = $response['event']['effects'];

        if (count($effects) > 0) {
            foreach ($effects as $effect) {
                switch ($effect[1]) {
                    case "setDiscountAmount":
                        Mage::log($effect[2].' '.$effect[2]);
                        break;
                }

            }
        }

    }
}

