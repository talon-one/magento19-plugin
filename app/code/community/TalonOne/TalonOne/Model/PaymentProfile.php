<?php

class TalonOne_TalonOne_Model_PaymentProfile implements \JsonSerializable
{
    protected $_billingSalutation;
    protected $_billingName;
    protected $_billingAddress1;
    protected $_billingAddress2;
    protected $_billingAddress3;
    protected $_billingAddress4;
    protected $_billingCity;
    protected $_billingPostalCode;
    protected $_billingCountry;
    protected $_shippingSalutation;
    protected $_shippingName;
    protected $_shippingAddress1;
    protected $_shippingAddress2;
    protected $_shippingAddress3;
    protected $_shippingAddress4;
    protected $_shippingCity;
    protected $_shippingPostalCode;
    protected $_shippingCountry;
    protected $_paymentMethod;
    protected $_paymentIdHash;

    public function getBillingSalutation()
    {
        return $this->_billingSalutation;
    }

    public function setBillingSalutation($billingSalutation)
    {
        $this->_billingSalutation = $billingSalutation;
    }

    public function getPaymentMethod()
    {
        return $this->_paymentMethod;
    }

    public function setPaymentMethod($paymentMethod)
    {
        $this->_paymentMethod = $paymentMethod;
    }

    public function getBillingName()
    {
        return $this->_billingName;
    }

    public function setBillingName($billingName)
    {
        $this->_billingName = $billingName;
    }

    public function getBillingAddress1()
    {
        return $this->_billingAddress1;
    }

    public function setBillingAddress1($billingAddress1)
    {
        $this->_billingAddress1 = $billingAddress1;
    }

    public function getBillingAddress2()
    {
        return $this->_billingAddress2;
    }

    public function setBillingAddress2($billingAddress2)
    {
        $this->_billingAddress2 = $billingAddress2;
    }

    public function getBillingAddress3()
    {
        return $this->_billingAddress3;
    }

    public function setBillingAddress3($billingAddress3)
    {
        $this->_billingAddress3 = $billingAddress3;
    }

    public function getBillingAddress4()
    {
        return $this->_billingAddress4;
    }

    public function setBillingAddress4($billingAddress4)
    {
        $this->_billingAddress4 = $billingAddress4;
    }

    public function getBillingCity()
    {
        return $this->_billingCity;
    }

    public function setBillingCity($billingCity)
    {
        $this->_billingCity = $billingCity;
    }

    public function getBillingPostalCode()
    {
        return $this->_billingPostalCode;
    }

    public function setBillingPostalCode($billingPostalCode)
    {
        $this->_billingPostalCode = $billingPostalCode;
    }

    public function getBillingCountry()
    {
        return $this->_billingCountry;
    }

    public function setBillingCountry($billingCountry)
    {
        $this->_billingCountry = $billingCountry;
    }

    public function getShippingSalutation()
    {
        return $this->_shippingSalutation;
    }

    public function setShippingSalutation($shippingSalutation)
    {
        $this->_shippingSalutation = $shippingSalutation;
    }

    public function getShippingName()
    {
        return $this->_shippingName;
    }

    public function setShippingName($shippingName)
    {
        $this->_shippingName = $shippingName;
    }

    public function getShippingAddress1()
    {
        return $this->_shippingAddress1;
    }

    public function setShippingAddress1($shippingAddress1)
    {
        $this->_shippingAddress1 = $shippingAddress1;
    }

    public function getShippingAddress2()
    {
        return $this->_shippingAddress2;
    }

    public function setShippingAddress2($shippingAddress2)
    {
        $this->_shippingAddress2 = $shippingAddress2;
    }

    public function getShippingAddress3()
    {
        return $this->_shippingAddress3;
    }

    public function setShippingAddress3($shippingAddress3)
    {
        $this->_shippingAddress3 = $shippingAddress3;
    }

    public function getShippingAddress4()
    {
        return $this->_shippingAddress4;
    }

    public function setShippingAddress4($shippingAddress4)
    {
        $this->_shippingAddress4 = $shippingAddress4;
    }

    public function getShippingCity()
    {
        return $this->_shippingCity;
    }

    public function setShippingCity($shippingCity)
    {
        $this->_shippingCity = $shippingCity;
    }

    public function getShippingPostalCode()
    {
        return $this->_shippingPostalCode;
    }

    public function setShippingPostalCode($shippingPostalCode)
    {
        $this->_shippingPostalCode = $shippingPostalCode;
    }

    public function getShippingCountry()
    {
        return $this->_shippingCountry;
    }

    public function setShippingCountry($shippingCountry)
    {
        $this->_shippingCountry = $shippingCountry;
    }

    public function getPaymentIdHash()
    {
        return $this->_paymentIdHash;
    }

    public function setPaymentIdHash($paymentIdHash)
    {
        $this->_paymentIdHash = $paymentIdHash;
    }

    public function toArray()
    {
        return [
            'billingSalutation' => $this->getBillingSalutation(),
            'billingName' => $this->getBillingName(),
            'billingAddress1' => $this->getBillingAddress1(),
            'billingAddress2' => $this->getBillingAddress2(),
            'billingAddress3' => $this->getBillingAddress3(),
            'billingAddress4' => $this->getBillingAddress4(),
            'billingCity' => $this->getBillingCity(),
            'billingPostalCode' => $this->getBillingPostalCode(),
            'billingCountry' => $this->getBillingCountry(),
            'shippingSalutation' => $this->getShippingSalutation(),
            'shippingName' => $this->getShippingName(),
            'shippingAddress1' => $this->getShippingAddress1(),
            'shippingAddress2' => $this->getShippingAddress2(),
            'shippingAddress3' => $this->getShippingAddress3(),
            'shippingAddress4' => $this->getShippingAddress4(),
            'shippingCity' => $this->getShippingCity(),
            'shippingPostalCode' => $this->getShippingPostalCode(),
            'shippingCountry' => $this->getShippingCountry(),
            'paymentMethod' => $this->getPaymentMethod(),
            'paymentIdHash' => $this->getPaymentIdHash(),
        ];
    }

    public function jsonSerialize()
    {
        return array_filter($this->toArray());
    }
}