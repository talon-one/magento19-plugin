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
        $magentoVersion = Mage::getVersion();
        $pluginVersion = Mage::getConfig()->getModuleConfig('TalonOne_TalonOne')->version->asArray();
        $inputShowed = Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_SHOW_COUPON_INPUT);
        $shopId = Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_APPLICATION_ID);
        $secretKey = Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_SECRET_KEY);
        $response = Mage::helper('talonone_talonone/api')->post('events', array(
            'type' => 'check_plugin',
            'value' => array(
                'pluginVersion' => $pluginVersion,
                'magentoVersion' => $magentoVersion,
                'inputShowed' => $inputShowed
            ),
            'sessionId' => '0'
        ));
        $status = (empty($shopId) || empty($secretKey) || $response['status'] != '201') ? 'NOT OK' : 'OK';
        $data = array(
            'status' => $status,
            'pluginVersion' => $pluginVersion,
            'magentoVersion' => $magentoVersion,
            'inputShowed' => (bool)$inputShowed
        );
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data));
    }

    protected function checkCoupon()
    {
        if (!Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_SHOW_COUPON_INPUT)) {
            $this->_redirect('checkout/cart');
            return;
        }

        $helper = Mage::helper('talonone_talonone');
        $newCouponCode = htmlspecialchars($this->getRequest()->getParam('coupon_code'));
        $remove = htmlspecialchars($this->getRequest()->getParam('remove'));
        $ajax = htmlspecialchars($this->getRequest()->getParam('ajax'));

        if ($remove == 1 || empty($newCouponCode)) {
            $helper->getEffectCollection()->rollBackEffects();
        }

        if (!empty($newCouponCode)) {
            $helper->setCuponCode($newCouponCode);
        }

        Mage::helper('talonone_talonone/customerSession')->updateCustomerSession();
        if (!(($remove == 1) || $helper->isValidCouponCode())) {
            $helper->getEffectCollection()->rollBackEffects();
            $helper->setLastError('Invalid coupon code');
        }
        if ($ajax && $ajax == 1) {
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('coupon_valid' => $helper->isValidCouponCode())));
        } else {
            $this->_redirect('checkout/cart');
        }
    }
}