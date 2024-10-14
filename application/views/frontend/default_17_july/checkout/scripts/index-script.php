<!-- Leaflet JS -->
<script src="<?php echo base_url('assets/global/leaflet/leaflet.js'); ?>"></script>

<script>
"use strict";


$(document).ready(function() {
    $.ajax({
        url: '<?php echo site_url('cart/isPromoApplied'); ?>',
        type: 'POST',
        success: function(response) {
            try {
                var responseData = JSON.parse(response);
                if(responseData.discount){
                    var discountPercentage = parseInt(responseData.discount);
                    var amount = parseFloat($('#grand_total_code').val());
                    var discountAmount = (amount * discountPercentage) / 100;
                    $('#discount_amount').val(discountAmount.toFixed(2));
                    $('#discount_amount_label').text(discountAmount.toFixed(2));
                    $('#grand_total_label').text((amount - discountAmount).toFixed(2));
                    $('#discount_amount_lable').text(discountPercentage.toFixed(2));
                }
            } catch (error) {
                console.error('error response:', error);
            }
        },
        error: function(xhr, status, error) {
            console.error('failed:', status, error);
        }
    });
});


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

jQuery("ul.billing-list-topbar li.payment,#billing-btn").click(function(){
  jQuery("ul.billing-list-topbar li.payment").addClass("acitve");

  jQuery("ul.billing-list-topbar li.payment .img-box").addClass("red");
  jQuery("ul.billing-list-topbar li.billing .img-box").removeClass("red");
  jQuery("ul.billing-list-topbar li.order .img-box").removeClass("red");

  jQuery("ul.billing-list-topbar li.billing").removeClass("acitve");
  jQuery("ul.billing-list-topbar li.order").removeClass("acitve");
});

jQuery("ul.billing-list-topbar li.billing,#address-btn").click(function(){
  jQuery("ul.billing-list-topbar li.billing").addClass("acitve");

  jQuery("ul.billing-list-topbar li.billing .img-box").addClass("red");
  jQuery("ul.billing-list-topbar li.payment .img-box").removeClass("red");
  jQuery("ul.billing-list-topbar li.order .img-box").removeClass("red");

  jQuery("ul.billing-list-topbar li.payment").removeClass("acitve");
  jQuery("ul.billing-list-topbar li.order").removeClass("acitve");
});

jQuery("ul.billing-list-topbar li.order,#paymentbtn").click(function(){
  jQuery("ul.billing-list-topbar li.order").addClass("acitve");

  jQuery("ul.billing-list-topbar li.order .img-box").addClass("red");
  jQuery("ul.billing-list-topbar li.billing .img-box").removeClass("red");
  jQuery("ul.billing-list-topbar li.payment .img-box").removeClass("red");

  jQuery("ul.billing-list-topbar li.billing").removeClass("acitve");
  jQuery("ul.billing-list-topbar li.payment").removeClass("acitve");
});

jQuery("ul.billing-list-topbar li.billing .img-box,#address-btn").click(function(){
  jQuery("#billing-address").show();
  jQuery("#your-address,#payment-option").hide();
});

jQuery("ul.billing-list-topbar li.payment .img-box,#billing-btn").click(function(){
  jQuery("#payment-option").show();
  jQuery("#your-address,#billing-address").hide();
});

jQuery("ul.billing-list-topbar li.order .img-box,#paymentbtn").click(function(){
  jQuery("#your-address").show();
  jQuery("#billing-address,#payment-option").hide();
});



</script>
<script>
    function submitForm() {
        // Collect form data
        var formData = $('#billing-form').serialize();

        // Send data via AJAX
        $.ajax({
            type: 'POST',
            url: '<?= base_url('checkout/save_billing_data') ?>', // Adjust the URL to your controller method
            data: formData,
            success: function(response) {
                // Handle the response (if needed)
                console.log(response);
                jQuery("ul.billing-list-topbar li.payment").addClass("acitve");

jQuery("ul.billing-list-topbar li.payment .img-box").addClass("red");
jQuery("ul.billing-list-topbar li.billing .img-box").removeClass("red");
jQuery("ul.billing-list-topbar li.order .img-box").removeClass("red");

jQuery("ul.billing-list-topbar li.billing").removeClass("acitve");
jQuery("ul.billing-list-topbar li.order").removeClass("acitve");
jQuery("#payment-option").show();
  jQuery("#your-address,#billing-address").hide();
            }
        });
    }


    function submitAddressForm() {
        // Collect form data
        var addressFormData = $('#address-form').serialize();

        // Send data via AJAX
        $.ajax({
            type: 'POST',
            url: '<?= base_url('checkout/save_address_data') ?>', // Adjust the URL to your controller method
            data: addressFormData,
            success: function(response) {
                // Handle the response (if needed)
                console.log(response);
                jQuery("ul.billing-list-topbar li.order").addClass("acitve");

  jQuery("ul.billing-list-topbar li.order .img-box").addClass("red");
  jQuery("ul.billing-list-topbar li.billing .img-box").removeClass("red");
  jQuery("ul.billing-list-topbar li.payment .img-box").removeClass("red");

  jQuery("ul.billing-list-topbar li.billing").removeClass("acitve");
  jQuery("ul.billing-list-topbar li.payment").removeClass("acitve");
  jQuery("#your-address").show();
  jQuery("#billing-address,#payment-option").hide();
            }
        });
    }


    
</script>
