<?php

class TalonOne_TalonOne_Test_Model_Effect extends EcomDev_PHPUnit_Test_Case
{
    
    /**
     * @test
     * @covers TalonOne_TalonOne_Model_Effect::bindArray
     */
    public function testBindingArray()
    {
        $a = array('setDiscount', 'test_description', '10');
        $e = Mage::getModel('talonone_talonone/effect')->bindArray($a);
        
        $this->assertEquals($e->getMethod(), $a[0]);
        $this->assertEquals($e->getDescription(), $a[1]);
        $this->assertEquals($e->getValue(), $a[2]);
        $this->assertEquals($e->getSku(), null);
        $this->assertFalse($e->isFreeItem());

        $a2 = array('addFreeItem', 'test_description', 'sku', '10');
        $e2 = Mage::getModel('talonone_talonone/effect')->bindArray($a2);

        $this->assertEquals($e2->getMethod(), $a2[0]);
        $this->assertEquals($e2->getDescription(), $a2[3]);
        $this->assertEquals($e2->getValue(), $a2[1]);
        $this->assertEquals($e2->getSku(), $a2[2]);
        $this->assertTrue($e2->isFreeItem());
    }

    /**
     * @test
     * @covers TalonOne_TalonOne_Model_Effect::isDiscount
     * @covers TalonOne_TalonOne_Model_Effect::isFreeShipping
     * @covers TalonOne_TalonOne_Model_Effect::isFreeItem
     */
    public function testEffectAttributes()
    {
        $e = Mage::getModel('talonone_talonone/effect')->bindArray(array('setDiscount', 'test_description', '10'));

        $this->assertTrue($e->isDiscount());
        $this->assertFalse($e->isFreeShipping());
        $this->assertFalse($e->isFreeItem());
    }

    /**
     * @test
     * @covers TalonOne_TalonOne_Model_Effect::equals
     */
    public function testEffectsEquality()
    {
        $e = Mage::getModel('talonone_talonone/effect')->bindArray(array('setDiscount', 'test_description', '10'));
        $e2 = Mage::getModel('talonone_talonone/effect')->bindArray(array('setDiscount', 'test_description', '10'));
        $e3 = Mage::getModel('talonone_talonone/effect')->bindArray(array('addFreeItem', 'Free Shipping', 'test_sku', '10'));
        $e4 = Mage::getModel('talonone_talonone/effect')->bindArray(array('setDiscount', 'Free Shipping', 'test_sku', '10'));


        $this->assertTrue($e->equals($e2), true);
        $this->assertFalse($e->equals($e3), false);
        $this->assertFalse($e3->equals($e4), false);
    }
}