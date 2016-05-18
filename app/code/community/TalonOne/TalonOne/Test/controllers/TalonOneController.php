<?php

class TalonOne_TalonOne_Test_TalonOneController extends EcomDev_PHPUnit_Test_Case
{

    public function testCoupon(){

        $test_code = 'AS34SDF54DFG';
        $test_code2 = 'AS34SDF54DFGasd';

        Mage::app()->getRequest()->setPost('coupon_code', $test_code);

        $checkoutSession = Mage::getSingleton('checkout/session');
        $coupon_code = $checkoutSession->getData('talonone_coupon_code');

        $this->assertEquals(
            $test_code2,
            $coupon_code
        );

    }

}