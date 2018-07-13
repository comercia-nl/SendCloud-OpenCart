function initLocationPicker(mid,carrier) {
    $elem=$("#spmethod_"+mid);
    $elem.parent().on("click","*",function(){
      openLocationPicker(carrier);
    });
}

function openLocationPicker(carrier) {
    $.ajax({
        url: 'index.php?route=common/sendcloud/getSPInfo',
        type: 'get',
        success: function (spInfo) {
            var config = {
                // API key is required, replace it below with your API key
                'apiKey': spInfo.apiKey,
                'country': spInfo.country,
                'postalCode': spInfo.postalCode,
                'language': "nl",
                'carriers': [carrier],
                'servicePointId': 0
            };

            sendcloud.servicePoints.open(
                // first arg: config object
                config,
                // second arg: success callback function
                function (servicePointObject) {
                    $.post("index.php?route=common/sendcloud/saveSPInfo", servicePointObject);
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
    });
}

