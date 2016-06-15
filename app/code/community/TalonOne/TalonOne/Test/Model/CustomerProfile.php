<?php


class TalonOne_TalonOne_Test_Model_CustomerProfile extends EcomDev_PHPUnit_Test_Case
{

    /**
     * @test
     */
    public function testCustomerProfile()
    {
        $c = $this->getSampleCustomerProfile();

        $this->assertEquals($c->getAdvocateId(), 'aid');
        $this->assertEquals($c->getBirthDate(), '10-12-1988');
        $this->assertEquals($c->getEmail(), 'test@talon.one');
        $this->assertEquals($c->getFax(), '');
        $this->assertEquals($c->getGender(), 'male');
        $this->assertEquals($c->getLanguage(), 'DE');
        $this->assertEquals($c->getLocale(), 'DE');
        $this->assertEquals($c->getName(), 'Zenon Nowak');
        $this->assertEquals($c->getPhone1(), '555-666-222');
        $this->assertEquals($c->getPhone2(), '');
        $this->assertEquals($c->getUrl1(), '');
        $this->assertEquals($c->getUrl2(), '');
        $this->assertEquals($c->getUrl3(), '');
        $this->assertEquals($c->jsonSerialize(), $c->toArray());
    }


    private function getSampleCustomerProfile()
    {
        $c = new TalonOne_TalonOne_Model_CustomerProfile();
        $c->setAdvocateId('aid');
        $c->setBirthDate('10-12-1988');
        $c->setEmail('test@talon.one');
        $c->setFax('');
        $c->setGender('male');
        $c->setLanguage('DE');
        $c->setLocale('DE');
        $c->setName('Zenon Nowak');
        $c->setPhone1('555-666-222');
        $c->setPhone2('');
        $c->setUrl1('');
        $c->setUrl2('');
        $c->setUrl3('');

        $c->setBillingAddress1('');
        $c->setBillingAddress2('');
        $c->setBillingAddress3('');
        $c->setBillingAddress4('');
        $c->setBillingCity('Berlin');
        $c->setBillingCountry('Germany');
        $c->setBillingName($c->getName());
        $c->setBillingSalutation('Mr.');
        $c->setBillingPostalCode('43112');

        $c->setShippingAddress1('');
        $c->setShippingAddress2('');
        $c->setShippingAddress3('');
        $c->setShippingAddress4('');
        $c->setShippingCity('Berlin');
        $c->setShippingCountry('Germany');
        $c->setShippingName($c->getName());
        $c->setShippingSalutation('Mr.');
        $c->setShippingPostalCode('43112');

        $c->setPaymentMethod('PAYPAL');
        $c->setPaymentIdHash(md5($c->getName() . $c->getPaymentMethod()));

        return $c;
    }
}