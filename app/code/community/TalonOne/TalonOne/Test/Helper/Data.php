<?php

class TalonOne_TalonOne_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    /** @var TalonOne_TalonOne_Test_Helper_Data $_helper */
    protected $_helper;

    /**
     * Setup Method
     *
     * @return void
     */
    protected function setUp()
    {
        $this->_helper = Mage::helper('talonone_talonone');
    }

    /**
     * @test
     * @return void
     */
    public function testCheckExtensionInstallStatus()
    {
        /*$this->assertInternalType(
            'bool',
            $this->_helper->checkExtensionInstallStatus()
        );*/
    }

}
