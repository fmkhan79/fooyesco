<!-- Leaflet JS -->
<script src="<?php echo base_url('assets/global/leaflet/leaflet.js'); ?>"></script>

<script>
"use strict";
$('input[type=radio][name=payment_gateway]').change(function(e) {
    // CHANGE THE COLORS FIRST
    $(".callout").removeClass("callout-primary");
    $(".callout").addClass("callout-secondary");
    $(this).closest("div").removeClass("callout-secondary");
    $(this).closest("div").addClass("callout-primary");

    // TOGGLE THE VISIBILITY OF BUTTON
    $(".payment-form").hide();

    if($(this).val() === "cash_on_delivery"){
        $("#pay-with-cash-on-delivery-form").show();
    }else if($(this).val() === "paypal"){
        $("#pay-with-paypal-form").show();
    }else if($(this).val() === "stripe"){
        $("#pay-with-stripe-form").show();
    }
});
</script>
