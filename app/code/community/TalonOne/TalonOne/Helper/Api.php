<?php

class TalonOne_TalonOne_Helper_Api extends Mage_Core_Helper_Abstract
{

    public function get($url, $data = array())
    {
        return $this->call('GET', $url, $data);
    }

    public function post($url, $data = array())
    {
        return $this->call('POST', $url, $data);
    }

    public function put($url, $data = array())
    {
        return $this->call('PUT', $url, $data);
    }

    public function delete($url, $data = array())
    {
        return $this->call('DELETE', $url, $data);
    }

    public function checkResponse($response)
    {
        if (is_array($response) && array_key_exists('event', $response) && is_array($response['event'])
            && array_key_exists('effects', $response['event'])) {
            $newEffectCollection = Mage::getModel('talonone_talonone/effect_collection');
            $newEffectCollection->bindEffectsFromArray($response['event']['effects']);
            Mage::helper('talonone_talonone')->getEffectCollection()->updateEffects($newEffectCollection);
        }
    }

    protected function call($method, $url, $data = array())
    {
        $serviceUrl = Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_BASE_URL);
        $shopId = Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_APPLICATION_ID);
        $secretKey = Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_SECRET_KEY);
        $url = rtrim($serviceUrl, '/') . '/v1/' . $url;
        $dataJson = json_encode($data);
        $signature = hash_hmac('md5', $dataJson, hex2bin($secretKey));
        $headers = 'Content-Signature: signer=' . $shopId . '; signature=' . $signature;
        $client = new Zend_Http_Client();
        try {
            $client->setUri($url)
                ->setMethod($method)
                ->setHeaders($headers)
                ->setRawData($dataJson)
                ->setEncType('application/json');
            $response = $client->request();
        } catch (Exception $e) {
            Mage::logException($e);
            $response = new Zend_Http_Response(500, array(), '');
        }
        return array(
            'status' => $response->getStatus(),
            'message' => $response->getMessage(),
            'body' => json_decode($response->getBody(), true)
        );
    }
}
