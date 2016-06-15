<?php

class TalonOne_TalonOne_Test_Model_CartItem extends EcomDev_PHPUnit_Test_Case
{

    /**
     * @test
     */
    public function testCartItem()
    {
        $c = new TalonOne_TalonOne_Model_CartItem();
        $c->setName('HappySocks');
        $c->setSku('XYZ11');
        $c->setQuantity(2);
        $c->setCategory('Socks');
        $c->setCurrency('EUR');
        $c->setPrice('10.4');
        $c->setWeight('1');
        $c->setLength('1');
        $c->setHeight('1');
        $c->setWidth('1');

        $testArray = [
            'name' => $c->getName(),
            'sku' => $c->getSku(),
            'quantity' => $c->getQuantity(),
            'currency' => $c->getCurrency(),
            'price' => $c->getPrice(),
            'category' => $c->getCategory(),
            'weight' => $c->getWeight(),
            'height' => $c->getHeight(),
            'width' => $c->getWidth(),
            'length' => $c->getLength(),
        ];

        $this->assertEquals($c->getName(), 'HappySocks');
        $this->assertEquals($c->getSku(), 'XYZ11');
        $this->assertEquals($c->getQuantity(), 2);
        $this->assertEquals($c->getCategory(), 'Socks');
        $this->assertEquals($c->getCurrency(), 'EUR');
        $this->assertEquals($c->getPrice(), '10.4');
        $this->assertEquals($c->getWeight(), '1');
        $this->assertEquals($c->getLength(), '1');
        $this->assertEquals($c->getHeight(), '1');
        $this->assertEquals($c->getWidth(), '1');
        $this->assertEquals($c->toArray(), $testArray);
        $this->assertEquals($c->jsonSerialize(), $testArray);
    }
}