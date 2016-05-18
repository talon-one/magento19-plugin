<?php

class TalonOne_TalonOne_TalonOneController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Coupon action for form -> talonone/TalonOne/couponPost
     */
    public function couponPostAction()
    {
        $this->checkCoupon();
    }

    /**
     * Coupon action by url
     *
     * Add coupon -> talonone/TalonOne/coupon?coupon_code=123
     * Remove coupon -> talonone/TalonOne/coupon?remove=1
     */
    public function couponAction()
    {
        $this->checkCoupon();
    }

    /**
     * Adres url for check plugin -> talonone/TalonOne/check
     */
    public function checkAction()
    {

        $shop_id = Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_SHOP_ID);
        $secret_key = Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_SECRET_KEY);

        $status = (empty($shop_id) || empty($secret_key)) ? 'BAD' : 'OK';
        $version = Mage::getConfig()->getModuleConfig('TalonOne_TalonOne')->version->asArray();

        $data = array('status'=> $status,'version' => $version);

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data));
    }


    private function checkCoupon(){

        if ($this->getRequest()->getParam('remove')) {
            Mage::getSingleton('checkout/session')->unsetData('talonone_coupon_code');
        } else {
            $coupon_code = $this->getRequest()->getParam('coupon_code');
            $session = Mage::getSingleton('checkout/session');
            $session->setData('talonone_coupon_code', $coupon_code);
        }

        $helper = Mage::helper('talonone_talonone');
        $helper->updateCustomerSession();

        $this->_redirect('checkout/cart');
    }
}