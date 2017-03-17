<?php
use comercia\Util;

class ControllerCommonSendcloud extends Controller
{
    function checkout()
    {
        $settings = Util::config()->getGroup("sendcloud");

        //if this is the right location to inject the sendcloud checkout options
        if ($settings["sendcloud_checkout_route"] == Util::request()->get()->route) {
            //add the sendcloud api
            Util::document()->addScript('//embed.sendcloud.sc/spp/1.0.0/api.min.js');

            //inject our sendcloud code
            Util::document()->addScript('view/javascript/sendcloud_injector.js');

            //avoid injecting wrong information
            $settings["sendcloud_checkout_api_key"]=$settings["sendcloud_api_key"];
            $settings["sendcloud_checkout_address2_as_housenumber"]=$settings["sendcloud_address2_as_housenumber"];
            $settings=Util::arrayHelper()->keepPrefix("sendcloud_checkout", $settings);

            //inject the settings into javascript
            Util::document()->addVariable('sendcloud_settings', $settings);

            //add language
            $sendcloud_language = comercia\util::load()->language("checkout/sendcloud");
            Util::document()->addVariable('action_location_picker', $sendcloud_language["action_location_picker"]);
        }

    }



}

?>