<?php

class TalonOne_TalonOne_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_PATH_SHOW_COUPON_INPUT = 'talonone/settings/talonone_show_coupon_input';
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
            'shippingCost' => (float)$quote->getShippingAddress()->getShippingAmount(),
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

            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $cartItem = array(
                'name' => $product->getName(),
                'sku' => $product->getSku(),
                'quantity' => $item->getQty(),
                'currency' => Mage::app()->getStore()->getCurrentCurrencyCode(),
                'price' => (float)$product->getPrice(),
                'weight' => (float)$product->getWeight(),
                'height' => (float)$product->getHeight(),
                'width' => (float)$product->getWidth(),
                'length' => (float)$product->getLength(),
            );

            if ($item->getProduct()->getCategory()) {
                $cartItem['category'] = $product->getCategory()->getName();
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
        $eventEffects = $response['event']['effects'];

        if (count($eventEffects) > 0) {
            $newEffects = array();
            foreach ($eventEffects as $effect) {
                switch ($effect[1]) {
                    case "setDiscountAmount":
                        $newEffect = array('name' => $effect[1], 'discount_description' => $effect[2], 'discount_amount' => $effect[3]);
                        break;
                }
                array_push($newEffects, $newEffect);
            }
            $this->updateEffects($newEffects);
        }
    }

    private function updateEffects($newEffects)
    {
        $effects = Mage::getSingleton('checkout/session')->getTalonOneEffects();
        if($effects) {
            $effects = array_merge($effects, $newEffects);
        } else {
            $effects = $newEffects;
        }
        Mage::getSingleton('checkout/session')->setTalonOneEffects($effects);
    }

    public function injectEffects($quote)
    {
        $effects = Mage::getSingleton('checkout/session')->getTalonOneEffects();
        if ($effects) {
            foreach ($effects as $effect) {
                switch ($effect['name']) {
                    case "setDiscountAmount":
                        $this->setDiscountAmount($quote, $effect['discount_description'], $effect['discount_amount']);
                        break;
                }
            }
        }
    }

    private function setDiscountAmount($quote, $discountDescription, $discountAmount)
    {
        Mage::log('setDiscountAmount: ' . $discountDescription . ' -> ' . $discountAmount . ' quoteId:' . $quote->getId());
        if ($quote->getId()) {
            if ($discountAmount > 0) {
                $quote->setSubtotal(0);
                $quote->setBaseSubtotal(0);
                $quote->setSubtotalWithDiscount(0);
                $quote->setBaseSubtotalWithDiscount(0);
                $quote->setGrandTotal(0);
                $quote->setBaseGrandTotal(0);

                $canAddItems = $quote->isVirtual() ? ('billing') : ('shipping');
                foreach ($quote->getAllAddresses() as $address) {

                    $address->setSubtotal(0);
                    $address->setBaseSubtotal(0);
                    $address->setGrandTotal(0);
                    $address->setBaseGrandTotal(0);

                    $address->collectTotals();

                    $quote->setSubtotal((float)$quote->getSubtotal() + $address->getSubtotal());
                    $quote->setBaseSubtotal((float)$quote->getBaseSubtotal() + $address->getBaseSubtotal());
                    $quote->setSubtotalWithDiscount(
                        (float)$quote->getSubtotalWithDiscount() + $address->getSubtotalWithDiscount()
                    );
                    $quote->setBaseSubtotalWithDiscount(
                        (float)$quote->getBaseSubtotalWithDiscount() + $address->getBaseSubtotalWithDiscount()
                    );
                    $quote->setGrandTotal((float)$quote->getGrandTotal() + $address->getGrandTotal());
                    $quote->setBaseGrandTotal((float)$quote->getBaseGrandTotal() + $address->getBaseGrandTotal());
                    $quote->save();

                    $quote->setGrandTotal($quote->getGrandTotal() - $discountAmount)
                        ->setBaseGrandTotal($quote->getBaseGrandTotal() - $discountAmount)
                        ->setSubtotalWithDiscount($quote->getBaseSubtotal() - $discountAmount)
                        ->setBaseSubtotalWithDiscount($quote->getBaseSubtotal() - $discountAmount)
                        ->save();

                    if ($address->getAddressType() == $canAddItems) {

                        $address->setSubtotalWithDiscount((float)$address->getSubtotalWithDiscount() - $discountAmount);
                        $address->setGrandTotal((float)$address->getGrandTotal() - $discountAmount);
                        $address->setBaseSubtotalWithDiscount((float)$address->getBaseSubtotalWithDiscount() - $discountAmount);
                        $address->setBaseGrandTotal((float)$address->getBaseGrandTotal() - $discountAmount);

                        $address->setDiscountAmount(-($discountAmount));
                        $address->setDiscountDescription($discountDescription);
                        $address->setBaseDiscountAmount(-($discountAmount));

                        $address->save();
                    }
                }
            }
        }
    }
}

