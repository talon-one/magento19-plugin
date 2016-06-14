<?php

class TalonOne_TalonOne_Test_Model_Effect_Collection extends EcomDev_PHPUnit_Test_Case
{

    /**
     * @test
     */
    public function testCollectionFilters()
    {
        $c = $this->getEffectCollection();

        $this->assertEquals($c->count(), 4);
        $this->assertFalse($c->isEmpty());
        $this->assertNotEquals($c->getDiscounts(), null);
        $this->assertEquals($c->getDiscountAmount(), 20);
        $this->assertTrue($c->isFreeShipping(), true);
        $this->assertNotEquals($c->getFreeItems(), null);
    }

    /**
     * @test
     */
    public function testCollectionDiff()
    {
        $c = $this->getEffectCollection();
        $c2 = $this->getEffectCollection();

        $this->assertFalse($c->hasDiffEffects($c2));
        $this->assertFalse($c2->hasDiffEffects($c));

        $c->addEffect(Mage::getModel('talonone_talonone/effect')->bindArray(array('setDiscount', 'test_description_2', '40')));

        $this->assertTrue($c->hasDiffEffects($c2));
        $this->assertTrue($c2->hasDiffEffects($c));
    }

    private function getEffectCollection()
    {
        $e = Mage::getModel('talonone_talonone/effect')->bindArray(array('setDiscount', 'test_description', '10'));
        $e2 = Mage::getModel('talonone_talonone/effect')->bindArray(array('setDiscount', 'test_description', '10'));
        $e3 = Mage::getModel('talonone_talonone/effect')->bindArray(array('addFreeItem', 'Free Shipping', 'test_sku', '10'));
        $e4 = Mage::getModel('talonone_talonone/effect')->bindArray(array('setDiscount', 'Free Shipping', 'test_sku', '10'));
        $c = Mage::getModel('talonone_talonone/effect_collection');

        $c->addEffect($e);
        $c->addEffect($e2);
        $c->addEffect($e3);
        $c->addEffect($e4);

        return $c;
    }
}