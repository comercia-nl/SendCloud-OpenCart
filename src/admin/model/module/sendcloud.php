<?php

class ModelModuleSendcloud extends Model
{
    function getPickerPresets()
    {
        return array(
            ""=>array(
                "sendcloud_checkout_preset" => "",
                "sendcloud_checkout_route" => "",
                "sendcloud_checkout_picker_selector" => "",
                "sendcloud_checkout_picker_position" => "",
                "sendcloud_checkout_selector_address" => "",
                "sendcloud_checkout_selector_address2" => "",
                "sendcloud_checkout_selector_city" => "",
                "sendcloud_checkout_selector_postcode" => "",
                "sendcloud_checkout_selector_country" => "",
                "sendcloud_checkout_selector_zone" => "",
                "sendcloud_checkout_selector_fake_click" => "",
                "sendcloud_checkout_selector_button_css" => ""
            ),
            "OpenCart" => array(
                "sendcloud_checkout_preset" => "OpenCart",
                "sendcloud_checkout_route" => "checkout/checkout",
                "sendcloud_checkout_picker_selector" => "#collapse-payment-address .buttons",
                "sendcloud_checkout_picker_position" => "before",
                "sendcloud_checkout_selector_address" => "#input-shipping-address-1",
                "sendcloud_checkout_selector_address2" => "#input-shipping-address-2",
                "sendcloud_checkout_selector_city" => "#input-shipping-city",
                "sendcloud_checkout_selector_postcode" => "#input-shipping-postcode",
                "sendcloud_checkout_selector_country" => "#input-shipping-country",
                "sendcloud_checkout_selector_zone" => "#input-shipping-zone",
                "sendcloud_checkout_selector_fake_click" => "input[name=shipping_address]",
                "sendcloud_checkout_selector_button_css" => "btn btn-info"
            ),
            "Journal" => array(
                "sendcloud_checkout_preset" => "Journal",
                "sendcloud_checkout_route" => "checkout/checkout",
                "sendcloud_checkout_picker_selector" => "#shipping-address",
                "sendcloud_checkout_picker_position" => "before",
                "sendcloud_checkout_selector_address" => "#input-shipping-address-1",
                "sendcloud_checkout_selector_address2" => "#input-shipping-address-2",
                "sendcloud_checkout_selector_city" => "#input-shipping-city",
                "sendcloud_checkout_selector_postcode" => "#input-shipping-postcode",
                "sendcloud_checkout_selector_country" => "#input-shipping-country",
                "sendcloud_checkout_selector_zone" => "#input-shipping-zone",
                "sendcloud_checkout_selector_fake_click" => "input[name=shipping_address]",
                "sendcloud_checkout_selector_button_css" => "btn-primary button"
            )
            /*"Ajax Quick Checkout" => array(
                "sendcloud_checkout_preset" => "Ajax Quick Checkout",
                "sendcloud_checkout_route" => "checkout/checkout",
                "sendcloud_checkout_picker_selector" => "#payment_address_shipping_address",
                "sendcloud_checkout_picker_position" => "before",
                "sendcloud_checkout_selector_address" => "#shipping_address_address_1",
                "sendcloud_checkout_selector_address2" => "#shipping_address_address_2",
                "sendcloud_checkout_selector_city" => "#shipping_address_city",
                "sendcloud_checkout_selector_postcode" => "#shipping_address_postcode",
                "sendcloud_checkout_selector_country" => "#shipping_address_country",
                "sendcloud_checkout_selector_zone" => "#shipping_address_zone",
                "sendcloud_checkout_selector_fake_click" => "#payment_address_shipping_address",
                "sendcloud_checkout_selector_button_css" => "btn btn-info"
            ),
            "Quick Checkout"=>array(
                "sendcloud_checkout_preset" => "Quick Checkout",
                "sendcloud_checkout_route" => "quickcheckout/checkout",
                "sendcloud_checkout_picker_selector" => "#shipping",
                "sendcloud_checkout_picker_position" => "before",
                "sendcloud_checkout_selector_address" => "#input-shipping-address-1",
                "sendcloud_checkout_selector_address2" => "#input-shipping-address-2",
                "sendcloud_checkout_selector_city" => "#input-shipping-city",
                "sendcloud_checkout_selector_postcode" => "#input-shipping-postcode",
                "sendcloud_checkout_selector_country" => "#input-shipping-country",
                "sendcloud_checkout_selector_zone" => "#input-shipping-zone",
                "sendcloud_checkout_selector_fake_click" => "#shipping",
                "sendcloud_checkout_selector_button_css" => "btn btn-info"
            )*/
        );
    }
}

?>
