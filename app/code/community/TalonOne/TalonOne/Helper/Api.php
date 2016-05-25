<?php

class TalonOne_TalonOne_Helper_Api extends Mage_Core_Helper_Abstract
{

    private function call($method, $url, $data = array())
    {
        $shop_id = Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_SHOP_ID);
        $secret_key = Mage::getStoreConfig(TalonOne_TalonOne_Helper_Data::XML_PATH_SECRET_KEY);
        $service_url = Mage::getStoreConfig('settings/service_url');
        $url = $service_url . $url;
        $data_json = json_encode($data);

        Mage::log($method.' '.$url);
        Mage::log('DATA JSON: '.$data_json);

        $curl = curl_init();

        switch ($method) {
            case "GET":
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                break;
            case "POST":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        $key = hex2bin($secret_key);
        $signature = hash_hmac('md5', $data_json, $key);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Signature: signer=' . $shop_id . '; signature=' . $signature,
            'Content-Length: ' . strlen($data_json)
        ));

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        Mage::log('RESPONSE: '.$httpcode.' '.$response);

        curl_close($curl);

        return $response;
    }

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
    
}