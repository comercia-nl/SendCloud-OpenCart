$(function(){
    $("#checkout-picker").hide();
    $("#checkout-disable").hide();
    $("#checkout-advanced").hide();

    if ($("[name=sendcloud_checkout_preset]").val() != "") {
        $("#checkout-picker").show();
        $("#checkout-method").hide();
        $("#checkout-disable").show();
        $("#checkout_preset_options").val($("[name=sendcloud_checkout_preset]").val());
    }

    $(".checkout-picker-button").click(function(){
        $("#checkout-method").hide();
        $("#checkout-picker").show();
        $("#checkout-advanced").hide();
        $("#checkout-disable").show();
    });

    $(".checkout-disable-button").click(function(){
        $("#checkout-method").show();
        $("#checkout-picker").hide();
        $("#checkout-advanced").hide();
        $("#checkout-disable").hide();

        $("#checkout-advanced").find('input:text').val('');
        $("#checkout-advanced").find('input:hidden').val('');
    });

    $(".checkout-advanced-button").click(function(){
        $("#checkout-method").hide();
        $("#checkout-picker").hide();
        $("#checkout-advanced").show();
        $("#checkout-disable").show();
    });

    $("#checkout_preset_apply").click(function(){
       var presetName=$("#checkout_preset_options").val();
       var preset=picker_presets[presetName];
       for(var key in preset){
           var val=preset[key];
           $("[name="+key+"]").val(val);
       }

        $("checkout-disable").show();
        $("#checkout-picker").show();
        $("#checkout-advanced").hide();
    });

})