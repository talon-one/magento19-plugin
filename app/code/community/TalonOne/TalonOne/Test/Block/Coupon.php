<?php

class TalonOne_TalonOne_Test_Block_Coupon extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var TalonOne_TalonOne_Block_Coupon
     */
    protected $_block;

    /**
     * Setup Method
     *
     * @return void
     */
    protected function setUp()
    {
        $this->_block = Mage::getSingleton('core/layout')->createBlock('talonone_talonone/coupon');
    }

    /**
     * @test
     */
    public function testCreateBlock()
    {
        $this->assertInstanceOf('TalonOne_TalonOne_Block_Coupon', $this->_block);
    }
}