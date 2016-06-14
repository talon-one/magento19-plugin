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
        $this->assertHelperAlias('talonone_talonone/customerProfile', 'TalonOne_TalonOne_Helper_CustomerProfile');
        $this->assertHelperAlias('talonone_talonone/customerSession', 'TalonOne_TalonOne_Helper_CustomerSession');
        $this->assertHelperAlias('talonone_talonone/customerEvent', 'TalonOne_TalonOne_Helper_CustomerEvent');
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
            'customer_register_success',
            'talonone_talonone/observer',
            'hookToCustomerRegisterSuccess'
        );
        $this->assertEventObserverDefined(
            'frontend',
            'customer_login',
            'talonone_talonone/observer',
            'hookToCustomerLoginAfter'
        );
        $this->assertEventObserverDefined(
            'frontend',
            'customer_save_after',
            'talonone_talonone/observer',
            'hookToCustomerSaveAfter'
        );
        $this->assertEventObserverDefined(
            'frontend',
            'customer_address_save_after',
            'talonone_talonone/observer',
            'hookToCustomerAddressSaveAfter'
        );
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
        $this->assertEventObserverDefined(
            'frontend',
            'save_payment_after',
            'talonone_talonone/observer',
            'hookToSavePaymentAfter'
        );
        $this->assertEventObserverDefined(
            'frontend',
            'sales_quote_collect_totals_after',
            'talonone_talonone/observer',
            'hookToSalesQuoteCollectTotalsAfter'
        );
        $this->assertEventObserverDefined(
            'frontend',
            'sales_order_place_after',
            'talonone_talonone/observer',
            'hookToSalesOrderPlaceAfter'
        );
        $this->assertEventObserverDefined(
            'frontend',
            'sales_quote_save_before',
            'talonone_talonone/observer',
            'hookToSalesQuoteSaveBefore'
        );
        $this->assertEventObserverDefined(
            'frontend',
            'sales_quote_remove_item',
            'talonone_talonone/observer',
            'hookToSalesQuoteRemoveItem'
        );
    }
}