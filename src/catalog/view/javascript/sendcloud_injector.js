$(function () {

    var htmlToInject;

    var _position;
    var _selector;
    var _address;
    var _address2;
    var _postcode;
    var _city;
    var _country;
    var _zone;
    var _fake_click;
    var _api_key;
    var _use_address2;
    var _button_css;

    var spAddress;
    var spAddress2;
    var spPostcode;
    var spCity;
    var spCountry;

    var shippingSaved = false;
    var shippingMethodSaved = false;

    function init() {
        //Get the needed selectors
        _position = sendcloud_settings["sendcloud_checkout_picker_position"];
        _selector = sendcloud_settings["sendcloud_checkout_picker_selector"];
        _address = sendcloud_settings["sendcloud_checkout_selector_address"];
        _postcode = sendcloud_settings["sendcloud_checkout_selector_postcode"];
        _city = sendcloud_settings["sendcloud_checkout_selector_city"];
        _country = sendcloud_settings["sendcloud_checkout_selector_country"];
        _zone = sendcloud_settings["sendcloud_checkout_selector_zone"];
        _fake_click=sendcloud_settings["sendcloud_checkout_selector_fake_click"];
        _api_key=sendcloud_settings["sendcloud_checkout_api_key"];
        _use_address2=sendcloud_settings["sendcloud_checkout_address2_as_housenumber"];
        _address2=sendcloud_settings["sendcloud_checkout_selector_address2"];
        _button_css = sendcloud_settings["sendcloud_checkout_button_css"];
        //inject the picker
        inject("<div class='pull-left sendcloud'><a class='btn btn-info locationPicker'>" + action_location_picker + "</a></div>");
    }


    function inject(html) {
        htmlToInject = html;

        //start the timer to inject when an object pops up.. After some testing it turned out this is way faster than the options jquery offers for this.
        injectionTimer();
    }

    function injectionTimer() {
        doInject();
        setTimeout(injectionTimer, 250);
    }

    function doInject() {
        //see if there is something to inject at all
        $selectedObject = $(_selector);
        if ($selectedObject.length > 0) {

            //create the object to inject
            var $injectObject = $(htmlToInject)
            $(".locationPicker", $injectObject).click(openLocationPicker);

            if ($(_address).length && $(_address).val() != spAddress) {
                $(_address).val(spAddress);
                $(_address2).val(spAddress2);
                $(_city).val(spCity);
                $(_postcode).val(spPostcode);
                $(_country).val(spCountry);
            }

            if ($(_zone +' option').length > 1 && shippingSaved == false) {
                    $(_zone + ' option:eq(1)').attr('selected', 'selected');
                    if ($('#button-guest-shipping').length > 0) {
                        $('#button-guest-shipping').trigger("click");
                    } else {
                        $('#button-shipping-address').trigger("click");
                    }
                shippingSaved = true;
            }

            if (!$('#collapse-shipping-method').hasClass('in') && (!($('a[href=\'#collapse-payment-method\']').length))) {
                $('a[href=\'#collapse-shipping-method\']').trigger('click');
            }

            $selectedObject.each(function(){
                $this=$(this);

                if (_position == "after" && $(".sendcloud",$this.parent()).length<1) {
                    $this.after($injectObject);
                } else if (_position == "before" && $(".sendcloud",$this.parent()).length<1) {
                    $this.before($injectObject);
                } else if (_position == "replace" && $(".sendcloud",$this).length<1) {
                    $this.html($injectObject);
                } else if (_position == "append" && $(".sendcloud",$this).length<1) {
                    $this.append($injectObject);
                } else if (_position == "prepend" && $(".sendcloud",$this).length<1) {
                    $this.prepend($injectObject);
                }
            });
        }
    }

    function getCountryCode(isocode){
        $.ajax({
            url: 'index.php?route=common/sendcloud/getCountryId&isocode='+isocode,
            type: 'get',
            success: function (json) {
                spCountry = parseInt(json);
                return json;
            }
        });
    }

    function openLocationPicker() {
        //call the sendcloud api to show service points
        if($(_fake_click).prop('checked') == false){
            $(_fake_click).click();
        }
        var config = {
            // API key is required, replace it below with your API key
            'apiKey': _api_key,
            'country': "nl",
            'postalCode': $(_postcode).val(),
            'language': "nl",
            'carriers': [],
            'servicePointId': 0
        }
        sendcloud.servicePoints.open(
            // first arg: config object
            config,
            // second arg: success callback function
            function (servicePointObject) {
                $(_city).val(servicePointObject.city);
                $(_postcode).val(servicePointObject.postal_code);

                spCity = servicePointObject.city;
                spPostcode = servicePointObject.postal_code;
                spCountry = servicePointObject.country;

                spCountry = getCountryCode(spCountry);

                if(_use_address2){
                    $(_address).val(servicePointObject.street);
                    $(_address2).val(servicePointObject.house_number);

                    spAddress = servicePointObject.street;
                    spAddress2 = servicePointObject.house_number;
                }else{
                    $(_address).val(servicePointObject.street + " " + servicePointObject.house_number);

                    spAddress = servicePointObject.street + " " + servicePointObject.house_number;
                }
            },
            // third arg: failure callback function
            // this is also called with ["Closed"] when the SPP window is closed.
            function (errors) {
                errors.forEach(function (error) {
                    console.log('Failure callback, reason: ' + error);
                });
            }
        );
    }


    init();
});