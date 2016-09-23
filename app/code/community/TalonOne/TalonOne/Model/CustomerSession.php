<?php

class TalonOne_TalonOne_Model_CustomerSession extends TalonOne_TalonOne_Model_PaymentProfile
{
    protected $_profileId;
    protected $_coupon;
    protected $_state;
    protected $_cartItems;
    protected $_shippingCost;
    protected $_shippingMethod;
    protected $_total;

    public function getProfileId()
    {
        return $this->_profileId;
    }

    public function setProfileId($profileId)
    {
        $this->_profileId = $profileId;
    }

    public function getCoupon()
    {
        return $this->_coupon ? $this->_coupon : '';
    }

    public function setCoupon($coupon)
    {
        $this->_coupon = $coupon;
    }

    public function getState()
    {
        return $this->_state;
    }

    public function setState($state)
    {
        $this->_state = $state;
    }

    public function getCartItems()
    {
        return $this->_cartItems;
    }

    public function setCartItems($cartItems)
    {
        $this->_cartItems = $cartItems;
    }

    public function getShippingCost()
    {
        return $this->_shippingCost;
    }

    public function setShippingCost($shippingCost)
    {
        $this->_shippingCost = $shippingCost;
    }

    public function getShippingMethod()
    {
        return $this->_shippingMethod;
    }

    public function setShippingMethod($shippingMethod)
    {
        $this->_shippingMethod = $shippingMethod;
    }

    public function getTotal()
    {
        return $this->_total;
    }

    public function setTotal($total)
    {
        $this->_total = $total;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'profileId' => $this->getProfileId(),
            'coupon' => $this->getCoupon(),
            'state' => $this->getState(),
            'cartItems' => $this->getCartItems(),
            'shippingCost' => $this->getShippingCost(),
            'shippingMethod' => $this->getShippingMethod(),
            'total' => $this->getTotal(),
        ]);
    }

    public function jsonSerialize()
    {
        return array_filter($this->toArray(), function ($val) {
            return isset($val);
        });
    }
    
    public function bindBillingAddress($billingAddress)
    {
        if ($billingAddress) {
            $this->setBillingName((string)$billingAddress->getName());
            $this->setBillingAddress1((string)$billingAddress->getStreet(-1));
            $this->setBillingCity((string)$billingAddress->getCity());
            $this->setBillingPostalCode((string)$billingAddress->getPostcode());
            $this->setBillingCountry((string)$billingAddress->getCountry());
        }
    }

    public function bindShippingAddress($shippingAddress)
    {
        if ($shippingAddress) {
            $this->setShippingName((string)$shippingAddress->getName());
            $this->setShippingAddress1((string)$shippingAddress->getStreet(-1));
            $this->setShippingCity((string)$shippingAddress->getCity());
            $this->setShippingPostalCode((string)$shippingAddress->getPostcode());
            $this->setShippingCountry((string)$shippingAddress->getCountry());
            if ($shippingAddress->getShippingMethod()) {
                $this->setShippingCost((float)$shippingAddress->getShippingAmount());
                $this->setShippingMethod((string)$shippingAddress->getShippingMethod());
            }
        }
    }
}
