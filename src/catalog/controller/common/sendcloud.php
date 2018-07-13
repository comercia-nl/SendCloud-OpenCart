<?php

use comercia\Util;

class ControllerCommonSendcloud extends Controller
{
    function checkout()
    {
        if (strpos(strtolower(Util::request()->get()->route), "checkout") !== false) {
            Util::document()->addScript('//embed.sendcloud.sc/spp/1.0.0/api.min.js');
            Util::document()->addScript('view/javascript/sendcloud.js');
            comercia\util::load()->language("checkout/sendcloud");
        }
    }

    public function saveSPInfo()
    {
        $spId = Util::request()->post()->id;
        $orderId = \comercia\Util::session()->order_id;
        if (!empty($spId)) {
            $this->db->query("UPDATE " . DB_PREFIX . "order SET sendcloud_sp_id = '" . $spId . "', shipping_zone = '', shipping_zone_id=0 WHERE order_id = '" . $orderId . "'");
        }

        $shippingInfo = Util::session()->shipping_address;

        if (Util::config()->sendcloud_address2_as_housenumber) {
            $shippingInfo["address_1"]=Util::request()->post()->street;
            $shippingInfo["address_2"]=Util::request()->post()->house_number;
        }else{
            $shippingInfo["address_1"]=Util::request()->post()->street." ".Util::request()->post()->house_number;
        }
        $shippingInfo["postcode"]=Util::request()->post()->postal_code;
        $shippingInfo["city"]=Util::request()->post()->city;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode(true));
    }

    public function getSPInfo()
    {
        $result = [
            "country" => Util::session()->shipping_address['iso_code_2'],
            "postalCode" => Util::session()->shipping_address['postcode'],
            "apiKey" => Util::config()->sendcloud_api_key
        ];

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($result));
    }
}

?>