<?php

class TalonOne_TalonOne_Test_Helper_Api extends EcomDev_PHPUnit_Test_Case
{

    /** @var TalonOne_TalonOne_Helper_Api $helper */
    protected $_helper;

    /**
     * Setup Method
     *
     * @return void
     */
    public function setUp()
    {
        $this->_helper = Mage::helper('talonone_talonone/api');
    }

    /**
     * @test
     * @return void
     */
    public function testPostEventApi(){

        $data = array('sessionId' => 'test', 'type' => 'test', 'value' => array('profileId' => 'test'));
        $this->_helper->post('events', $data);
    }

}