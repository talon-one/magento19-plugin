<?php

class TalonOne_TalonOne_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    /** @var TalonOne_TalonOne_Test_Helper_Data $_helper */
    protected $_helper;

    /**
     * @test
     */
    public function testGetEffectCollectionNotNull()
    {
        $this->replaceByMock('singleton', 'checkout/session', $this->mockSession('checkout/session'));

        $this->assertNotEquals($this->_helper->getEffectCollection(), null);

        $this->_helper->unsEffectCollection();
        $this->assertNotEquals($this->_helper->getEffectCollection(), null);
    }

    /**
     * @test
     */
    public function testSetEffectCollection()
    {
        $effectCollection = new TalonOne_TalonOne_Model_Effect_Collection();

        $this->replaceByMock('singleton', 'checkout/session', $this->mockSession('checkout/session'));

        $this->_helper->setEffectCollection($effectCollection);
        $this->assertFalse($this->_helper->getEffectCollection()->hasDiffEffects($effectCollection));
    }

    /**
     * @test
     */
    public function testCuponCode()
    {
        $s = $this->mockSession('checkout/session', ['getTalonOneCouponCode']);
        $s->method('getTalonOneCouponCode')->willReturn('DEMO_VOUCHER');
        $this->replaceByMock('singleton', 'checkout/session', $s);

        $this->assertEquals($this->_helper->getCouponCode(), 'DEMO_VOUCHER');
    }

    /**
     * @test
     */
    public function testLastError()
    {
        $s = $this->mockSession('checkout/session', ['setTalonOneLastError', 'getTalonOneLastError']);
        $s->method('getTalonOneLastError')->willReturn('testError');
        $s->method('setTalonOneLastError')->with($this->equalTo('testError'));
        $this->replaceByMock('singleton', 'checkout/session', $s);

        $this->assertEquals($this->_helper->getLastError(), 'testError');
    }

    /**
     * Setup Method
     *
     * @return void
     */
    protected function setUp()
    {
        $this->_helper = Mage::helper('talonone_talonone');
    }
}
