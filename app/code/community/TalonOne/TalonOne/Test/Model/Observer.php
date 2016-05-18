<?php


class TalonOne_TalonOne_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{

    /**
     * @test
     * @return TalonOne_TalonOne_Model_Observer
     */
    public function checkClass()
    {
        $observer = Mage::getModel('talonone_talonone/observer');
        $this->assertInstanceOf(
            'TalonOne_TalonOne_Model_Observer',
            $observer,
            'Observer can be instantiated'
        );
        return $observer;
    }

}
