<?php

class TalonOne_TalonOne_Model_CustomerProfile extends TalonOne_TalonOne_Model_PaymentProfile
{
    protected $_name;
    protected $_advocateId;
    protected $_gender;
    protected $_birthDate;
    protected $_email;
    protected $_phone1;
    protected $_phone2;
    protected $_fax;
    protected $_url1;
    protected $_url2;
    protected $_url3;
    protected $_language;
    protected $_locale;
    protected $_signUpDate;

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getAdvocateId()
    {
        return $this->_advocateId;
    }

    public function setAdvocateId($advocateId)
    {
        $this->_advocateId = $advocateId;
    }

    public function getGender()
    {
        return $this->_gender;
    }

    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    public function getBirthDate()
    {
        return $this->_birthDate;
    }

    public function setBirthDate($birthDate)
    {
        $this->_birthDate = $birthDate;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function getPhone1()
    {
        return $this->_phone1;
    }

    public function setPhone1($phone1)
    {
        $this->_phone1 = $phone1;
    }

    public function getPhone2()
    {
        return $this->_phone2;
    }

    public function setPhone2($phone2)
    {
        $this->_phone2 = $phone2;
    }

    public function getFax()
    {
        return $this->_fax;
    }

    public function setFax($fax)
    {
        $this->_fax = $fax;
    }

    public function getUrl1()
    {
        return $this->_url1;
    }

    public function setUrl1($url1)
    {
        $this->_url1 = $url1;
    }

    public function getUrl2()
    {
        return $this->_url2;
    }

    public function setUrl2($url2)
    {
        $this->_url2 = $url2;
    }

    public function getUrl3()
    {
        return $this->_url3;
    }

    public function setUrl3($url3)
    {
        $this->_url3 = $url3;
    }

    public function getLanguage()
    {
        return $this->_language;
    }

    public function setLanguage($language)
    {
        $this->_language = $language;
    }

    public function getLocale()
    {
        return $this->_locale;
    }

    public function setLocale($locale)
    {
        $this->_locale = $locale;
    }

    public function getSignUpDate()
    {
        return $this->_signUpDate;
    }

    public function setSignUpDate($signUpDate)
    {
        $this->_signUpDate = $signUpDate;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), array_filter(array(
            'name' => $this->getName(),
            'advocateId' => $this->getAdvocateId(),
            'gender' => $this->getGender(),
            'birthDate' => $this->getBirthDate(),
            'email' => $this->getEmail(),
            'phone1' => $this->getPhone1(),
            'phone2' => $this->getPhone2(),
            'fax' => $this->getFax(),
            'url1' => $this->getUrl1(),
            'url2' => $this->getUrl2(),
            'url3' => $this->getUrl3(),
            'language' => $this->getLanguage(),
            'locale' => $this->getLocale(),
            'signupDate' => $this->getSignUpDate(),
        )));
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function bindBillingAddress($billingAddress)
    {
        if ($billingAddress) {
            $this->setPhone1((string)$billingAddress->getTelephone());
            $this->setFax((string)$billingAddress->getFax());
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
            $this->setPhone2((string)$shippingAddress->getTelephone());
            $this->setShippingName((string)$shippingAddress->getName());
            $this->setShippingAddress1((string)$shippingAddress->getStreet(-1));
            $this->setShippingCity((string)$shippingAddress->getCity());
            $this->setShippingPostalCode((string)$shippingAddress->getPostcode());
            $this->setShippingCountry((string)$shippingAddress->getCountry());
        }
    }
}
