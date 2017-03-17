$(function(){
    $("#checkout-picker").hide();
    $("#checkout-advanced").hide();

    $(".checkout-picker-button").click(function(){
        $("#checkout-method").hide();
        $("#checkout-picker").show();
        $("#checkout-advanced").hide();
    });

    $(".checkout-advanced-button").click(function(){
        $("#checkout-method").hide();
        $("#checkout-picker").hide();
        $("#checkout-advanced").show();
    });

    $("#checkout_preset_apply").click(function(){
       var presetName=$("#checkout_preset_options").val();
       var preset=picker_presets[presetName];
       for(var key in preset){
           var val=preset[key];
           $("[name="+key+"]").val(val);
       }

        $("#checkout-method").show();
        $("#checkout-picker").hide();
        $("#checkout-advanced").hide();
    });

})