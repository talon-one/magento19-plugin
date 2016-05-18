<?php

class TalonOne_TalonOne_Test_Config_Module extends EcomDev_PHPUnit_Test_Case_Config
{

    public function testModuleConfig()
    {
        $this->assertModuleVersion('0.0.1');
        $this->assertModuleCodePool('community');
    }

    public function testHelperAliases()
    {
        $this->assertHelperAlias('talonone_talonone', 'TalonOne_TalonOne_Helper_Data');
        $this->assertHelperAlias('talonone_talonone/data', 'TalonOne_TalonOne_Helper_Data');
        $this->assertHelperAlias('talonone_talonone/api', 'TalonOne_TalonOne_Helper_Api');
    }

    public function testBlockAliases()
    {
        $this->assertBlockAlias('talonone_talonone/coupon', 'TalonOne_TalonOne_Block_Coupon');
    }

    public function testModelAliases()
    {
        $this->assertModelAlias('talonone_talonone/observer', 'TalonOne_TalonOne_Model_Observer');
    }

    public function testEventObserver()
    {
        $this->assertEventObserverDefined(
            'frontend',
            'controller_action_postdispatch',
            'talonone_talonone/observer',
            'hookToControllerActionPostDispatch'
        );

        $this->assertEventObserverDefined(
            'frontend',
            'add_to_cart_after',
            'talonone_talonone/observer',
            'hookToAddToCartAfter'
        );

        $this->assertEventObserverDefined(
            'frontend',
            'update_cart_after',
            'talonone_talonone/observer',
            'hookToUpdateCartAfter'
        );
    }


}