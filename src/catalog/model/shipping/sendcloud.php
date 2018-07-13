<?php

use comercia\Util;

require_once(DIR_SYSTEM . "sendcloud/sendcloud_api.php");

class ModelShippingSendcloud extends Model
{
    function getQuote($address)
    {
        $acceptedMethods = [];
        $sendcloud_settings = Util::config()->getGroup('sendcloud');
        if (!empty($sendcloud_settings['sendcloud_api_key']) && !empty($sendcloud_settings['sendcloud_api_secret'])) {
            $api = new SendcloudApi('live', $sendcloud_settings['sendcloud_api_key'], $sendcloud_settings['sendcloud_api_secret']);
            $methods = $api->shipping_methods->get();
            $weight = $this->cart->getWeight();
            foreach ($methods as $method) {
                if ($this->methodIsValid($method, $address, $weight)) {
                    $info = $this->toOcMethod($method, $address);
                    if ($info) {
                        $acceptedMethods[$info["key"]] = $info["method"];
                    }
                }
            }
        }
        if (count($acceptedMethods)) {
            return array(
                'code' => 'sendcloud',
                'title' => "Sendcloud",
                'quote' => $acceptedMethods,
                'sort_order' => $this->config->get('sendcloud_sort_order'),
                'error' => false
            );
        }

    }

    private function toOcMethod($method, $address)
    {
        if ($method["service_point_input"] == "required") {
            return $this->ocServicepointMethod($method, $address);
        } else {
            return $this->ocNormalMethod($method, $address);
        }
    }

    function ocServicepointMethod($method,$address)
    {
        if(!Util::config()->sendcloud_locationpicker){
            return false;
        }
        $country =$this->getCountry($method,$address);
        return ["key" => $method["id"],
            "method" => [
                'code' => 'sendcloud.' . $method['id'],
                'title' => $method["name"]."<script id='spmethod_".$method['id']."'>initLocationPicker('".$method['id']."','".$method['carrier']."')</script>",
                'cost' => $country["price"],
                'tax_class_id' => $this->config->get('sendcloud_tax_class_id'),
                'text' => $this->currency->format($this->tax->calculate($country["price"], $this->config->get('sendcloud_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
            ]];

    }

    function ocNormalMethod($method, $address)
    {

        $country =$this->getCountry($method,$address);

        return ["key" => $method["id"],
            "method" => [
                'code' => 'sendcloud.' . $method['id'],
                'title' => $method["name"],
                'cost' => $country["price"],
                'tax_class_id' => $this->config->get('sendcloud_tax_class_id'),
                'text' => $this->currency->format($this->tax->calculate($country["price"], $this->config->get('sendcloud_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])

            ]];
    }

    function getCountry($method, $address)
    {
        return array_values(array_filter($method["countries"],
            function ($country) use ($address) {
                return $address["iso_code_3"] == $country["iso_3"] || $address["iso_code_2"] == $country["iso_2"];
            }))[0];
    }

    private function methodIsValid($method, $address, $weight)
    {
        if ($weight < 0.001) {
            $weight = 0.001;
        }

        if ($method["max_weight"] >= $weight && $method["min_weight"] <= $weight) {
            foreach ($method["countries"] as $country) {
                if ($address["iso_code_3"] == $country["iso_3"] || $address["iso_code_2"] == $country["iso_2"]) {
                    return true;
                }
            }
        }
        return false;
    }
}

?>