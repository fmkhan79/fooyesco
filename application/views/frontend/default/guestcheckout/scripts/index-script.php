<!-- Leaflet JS -->
<script src="<?php echo base_url('assets/global/leaflet/leaflet.js'); ?>"></script>
<script src="<?php echo base_url('assets/frontend/default/js/init.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous"></script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRluKUOUHip7mS2d-BWqzfXpIu--VXroo&callback=initMap&libraries=places&v=weekly"
    defer></script>

<script>
"use strict";

// $('#to').keyup(function() {
//   var foo = $(this).val().split(" ").join(""); // remove hyphens
//   if (foo.length > 0) {
//     foo = foo.match(new RegExp('.{1,4}', 'g')).join(" ");
//   }
//   $(this).val(foo);
// });

$(document).ready(function() {
    $.ajax({
        url: '<?php echo site_url('cart/isPromoApplied'); ?>',
        type: 'POST',
        success: function(response) {
            try {
                var responseData = JSON.parse(response);
                if (responseData.discount) {
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

    if ($(this).val() === "cash_on_delivery") {
        $("#pay-with-cash-on-delivery-form").show();
    } else if ($(this).val() === "paypal") {
        $("#pay-with-paypal-form").show();
    } else if ($(this).val() === "stripe") {
        $("#pay-with-stripe-form").show();
    }
});

jQuery("ul.billing-list-topbar li.payment,#billing-btn").click(function() {
    jQuery("ul.billing-list-topbar li.payment").addClass("acitve");

    jQuery("ul.billing-list-topbar li.payment .img-box").addClass("red");
    jQuery("ul.billing-list-topbar li.billing .img-box").removeClass("red");
    jQuery("ul.billing-list-topbar li.order .img-box").removeClass("red");

    jQuery("ul.billing-list-topbar li.billing").removeClass("acitve");
    jQuery("ul.billing-list-topbar li.order").removeClass("acitve");
});

jQuery("ul.billing-list-topbar li.billing,#address-btn").click(function() {
    jQuery("ul.billing-list-topbar li.billing").addClass("acitve");

    jQuery("ul.billing-list-topbar li.billing .img-box").addClass("red");
    jQuery("ul.billing-list-topbar li.payment .img-box").removeClass("red");
    jQuery("ul.billing-list-topbar li.order .img-box").removeClass("red");

    jQuery("ul.billing-list-topbar li.payment").removeClass("acitve");
    jQuery("ul.billing-list-topbar li.order").removeClass("acitve");
});

jQuery("ul.billing-list-topbar li.order,#paymentbtn").click(function() {
    jQuery("ul.billing-list-topbar li.order").addClass("acitve");

    jQuery("ul.billing-list-topbar li.order .img-box").addClass("red");
    jQuery("ul.billing-list-topbar li.billing .img-box").removeClass("red");
    jQuery("ul.billing-list-topbar li.payment .img-box").removeClass("red");

    jQuery("ul.billing-list-topbar li.billing").removeClass("acitve");
    jQuery("ul.billing-list-topbar li.payment").removeClass("acitve");
});

jQuery("ul.billing-list-topbar li.billing .img-box,#address-btn").click(function() {
    jQuery("#billing-address").show();
    jQuery("#your-address,#payment-option").hide();
});

jQuery("ul.billing-list-topbar li.payment .img-box,#billing-btn").click(function() {
    jQuery("#payment-option").show();
    jQuery("#your-address,#billing-address").hide();
});

jQuery("ul.billing-list-topbar li.order .img-box,#paymentbtn").click(function() {
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
        url: '<?= base_url('GuestCheckout/save_billing_data') ?>', // Adjust the URL to your controller method
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
        url: '<?= base_url('GuestCheckout/save_address_data') ?>', // Adjust the URL to your controller method
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


function calculatePrice() {
    console.log("i am hear");
    var menuPrice = $("#menu-price").val();
    var price = menuPrice;
    var currency = $('#currency').val();
    menuPrice = currency + menuPrice;
    console.log(menuPrice);
    $('#totalprice').val(price);
    // Find the price element within the modal content and update its text
    $('#popup #add-order-price').text(menuPrice); // Replace '£15.99' with the new price you want to set
}
// GET AND DISPLAY THE MENU ITEMS BASED ON SUB CATAGORY
function viewselected_cat_items(maincatid, menu_selection = null) {

    var menu_option = menu_selection;
    console.log('--menu_selection', menu_selection);
    menu_selection = '.' + menu_selection;
    console.log('--menu_selection:after', menu_selection);
    // Get the selected radio button element
    var selectedRadioButton = document.querySelector('input[type="radio"][value="' + maincatid + '"].menuoptions');

    // Check if the radio button is found
    if (selectedRadioButton) {
        // Get the data-item-price attribute value
        var itemPrice = selectedRadioButton.getAttribute('data-item-price');

        if (itemPrice) {
            var currency = $('#currency').val();
            // Use the itemPrice as needed (e.g., log it to the console)
            console.log("Item price: " + itemPrice);
            itemPrice = currency + itemPrice;
            // Find the price element within the modal content and update its text
            $('#popup #add-order-price').text(itemPrice); // Replace '£15.99' with the new price you want to set

        } else {
            var menuPrice = $('#menu-price').val();
            console.log("--menu-price", menuPrice);

            var currency = $('#currency').val();
            menuPrice = currency + menuPrice;
            $('#popup #add-order-price').text(menuPrice.toFixed(
                2)); // Replace '£15.99' with the new price you want to set
        }

        // You can perform further actions with the itemPrice value here
    } else {
        console.log("Radio button not found");
    }
    console.log(maincatid);
    $.ajax({
        url: '<?php echo base_url(); ?>site/selected_cat_items/' + maincatid + '/' + menu_option,
        success: function(res) {
            // $("#sub-catagories-and-items").html(res);
            $(menu_selection).html(res);
            // menu-option-1
            // console.log(res);
        },
        error: function() {
            alert("<?php echo $this->lang->line('fail'); ?>")
        }
    });
    // holdModal('popup');
}


// GET THE CART SUMMARY AND DISPAY IN RIGHT SIDE
function viewselected_cat_items_summary() {
    $.ajax({
        url: '<?php echo base_url(); ?>site/selected_cat_items_summary/',
        success: function(res) {
            console.log(res, 'selected_cat_items_summary');
            $("#item-list").empty(); // Empty the content of the div
            $("#item-list").html(res); // Replace with the 'res' response
        },
        error: function() {
            alert("<?php echo $this->lang->line('fail'); ?>")
        }
    });
    // holdModal('popup');
}

// GET THE CART total price AND DISPAY IN RIGHT SIDE
function viewselected_cat_items_summary_total() {
    $.ajax({
        url: '<?php echo base_url(); ?>cart/get_order_summary/',
        success: function(res) {
            // Parse the JSON string into a JavaScript object
            var data = JSON.parse(res);

            // Access the 'sub_total' property and display its value
            var subTotalValue = data.sub_total;
            var totalDeliveryValue = data.total_delivery_charge;
            var totalVatValue = data.vat_charges;
            var grandSubTotalValue = data.grand_total;
            var totalServicePrice = data.total_service_price;


            // Now you can use subTotalValue as needed, for example, displaying it in the console
            console.log("Sub Total:", subTotalValue);
            $(".subtotal-price").text(subTotalValue);
            // $(".total-delivery-price").text(totalDeliveryValue);
            $(".total-vat-price").text(totalVatValue);
            $(".grand-product-price").text(grandSubTotalValue);
            $(".total-service-price").text(totalServicePrice);
           

        },
        error: function() {
            alert("<?php echo $this->lang->line('fail'); ?>")
        }
    });
    // holdModal('popup');
}

$(document).ready(function() {
    viewselected_cat_items_summary();

    viewselected_cat_items_summary_total();
});


$(document).ready(function() {
    // Function to calculate and log the total price
    function calculateTotalPrice() {
        var totalPrice = 0;
        var quantity_for_menu = $('#quantity_for_menu').val();
        var menu_pric = $("#menu-price").val();
        console.log('quantity_for_menu', quantity_for_menu);
        console.log('menu_pric', menu_pric);
        // Get all selected radio buttons with data-item-price attribute inside the modal
        var selectedRadioButtons = $('#popup').find('input.menuoptions:checked[data-item-price]');

        // Loop through each selected radio button and accumulate the prices
        selectedRadioButtons.each(function() {
            var price = parseFloat($(this).attr('data-item-price')); // Get the price as a float
            if (price) {
                totalPrice += price; // Accumulate the price
            }
        });

        // Log or use the total price as needed
        console.log('Total Price:', totalPrice);


        if (totalPrice == 0) {
            totalPrice = parseInt(menu_pric);
        }
        console.log('totalPrice', totalPrice);


        totalPrice_with_quty = totalPrice.toFixed(2) * quantity_for_menu;
        // You can perform actions with the totalPrice here
        var currency = $('#currency').val();
        // Update the value of the total price input field
        $('#totalprice').val(totalPrice.toFixed(2)); // Set the total price, rounding it to 2 decimal places

        totalPrice_with_quty = currency + totalPrice_with_quty.toString();
        console.log(typeof(totalPrice_with_quty), '--type');

        $('#popup #add-order-price').text(
            totalPrice_with_quty); // Replace '£15.99' with the new price you want to set

    }

    // Listen for changes in the modal and capture changes to the radio buttons
    $('#popup').on('change', 'input.menuoptions', function() {
        calculateTotalPrice(); // Calculate total price on change
    });

    $('#popup').on('click', '.glyphicon-plus', function() {
        console.log("quantity_for_menu");
        calculateTotalPrice(); // Calculate total price on change
    });


    $('#popup').on('click', '.glyphicon-minus', function() {
        console.log("quantity_for_menu");
        calculateTotalPrice(); // Calculate total price on change
    });

    // Initial calculation on page load
    // calculateTotalPrice();
});


function apply_promo_action() {
    console.log("working");
    var promoCode = $('#promo_code').val();
    var amount = $('#grand_total_code').val(); /* Get the order amount */ ;
    console.log(amount);
    $.ajax({
        url: '<?php echo site_url('cart/checkPromoCode'); ?>',
        type: 'POST',
        data: {
            promo_code: promoCode,
            amount: amount
        },
        success: function(response) {
            console.log(response);
            if (!isNaN(response)) { // Check if response is a number
                $('#promo_code_message').text(response + '% discount applied.').addClass(
                    'text-success').removeClass('text-danger');
                updateDiscountCodeToCart(promoCode, response); // Call the function with user_id
            } else {
                $('#promo_code_message').text('Invalid promo code').addClass('text-danger')
                    .removeClass('text-success');
            }
        }
    });
}

// isPromoApplied

$(document).ready(function() {
    $.ajax({
        url: '<?php echo site_url('cart/isPromoApplied'); ?>',
        type: 'POST',
        success: function(response) {
            try {
                var responseData = JSON.parse(response);
                if (responseData.discount) {
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





function remove_promo() {
    var userId = $('#user_id').val();

    $.ajax({
        url: '<?php echo site_url('cart/updateDiscountCodeCart'); ?>',
        type: 'POST',
        data: {
            userId: userId,
            promo_code: '',
            discount: -1
        },
        success: function(response) {
            console.log(response);
            window.location.reload();
        }
    });
}

function updateDiscountCodeToCart(promoCode, discount) {
    var userId = $('#user_id').val();
    console.log('User Id : ', userId);
    console.log('promoCode : ', promoCode);
    console.log('discount : ', discount);
    var amount = $('#grand_total_code').val();

    $.ajax({
        url: '<?php echo site_url('cart/updateDiscountCodeCart'); ?>',
        type: 'POST',
        data: {
            userId: userId,
            promo_code: promoCode,
            discount: discount
        },
        success: function(response) {
            console.log(response);
            // Calculate discount amount
            var discountPercentage = discount;
            var discountAmount = (amount * discount) / 100;
            console.log(discountPercentage, 'cart')

            // Update discount amount in the <td> element
            // $('#discount_amount').val(discountAmount.toFixed(2)); // Set hidden input value
            // $('#discount_amount_lable').text(discountPercentage); // Set visible label text
            // $('#grand_total_label').text((amount - discountAmount).toFixed(2));
            $('#apply_promo').remove();
            $('#remove_promo').show();
        }
    });
}

// Cart functionality management
function updateCart(cartId, isIncreased) {
    var currentQuantity = $('#cart-quantity-' + cartId).text();

    // SHOWING PLACEHOLDERS
    $(".summary-loader").removeClass('d-none');
    $('#sub-total-' + cartId).html('<i class="fas fa-spinner fa-pulse"></i>');
    $('.cart-actions').prop('disabled', true);

    if (isIncreased) {
        currentQuantity = parseInt(currentQuantity) + 1;
    } else {
        currentQuantity = parseInt(currentQuantity) - 1;
        if (currentQuantity == 0) {
            currentQuantity = 1;
        }
    }
    $('#cart-quantity-' + cartId).text(currentQuantity);

    $.ajax({
        url: '<?php echo site_url('cart/update_cart'); ?>',
        type: 'POST',
        data: {
            cartId: cartId,
            quantity: currentQuantity,
        },
        success: function(updatedPrice) {
            $('#sub-total-' + cartId).text(updatedPrice);
            $.ajax({
                url: '<?php echo site_url('cart/reload_cart_summary'); ?>',
                success: function(response) {
                    $('#cart-summary').html(response);
                    $('.cart-actions').prop('disabled', false);
                    $(".summary-loader").addClass('d-none');
                }
            });
        }
    });
}


jQuery(document).ready(function() {
    jQuery("input[name$='basket-switcher']").click(function() {
        var test = $(this).val();
        jQuery("span.collect-box").hide();
        jQuery("#" + test).show();
    });
});

jQuery('label.c-basketSwitcher-switch').click(function() {
    jQuery('label.c-basketSwitcher-switch').removeClass('c-basketSwitcher-switch--active');
    jQuery(this).addClass('c-basketSwitcher-switch--active');
});

jQuery('.c-basketSwitcher-switch input:checked').parent().addClass('c-basketSwitcher-switch--active');
</script>


<script type="text/javascript">
    $(document).ready(function() {
        var autocomplete_to;

        // Initialize Google Maps autocomplete for "to" address
        autocomplete_to = new google.maps.places.Autocomplete(
            document.getElementById('to'),
            { types: ['geocode'] }
        );

        google.maps.event.addListener(autocomplete_to, 'place_changed', function() {
            var place = autocomplete_to.getPlace();
            $("#lat_to").val(place.geometry.location.lat());
            $("#long_to").val(place.geometry.location.lng());

            // Call the function to calculate distance here
            calculateDistance();
        });
    });

    
    document.getElementById("checking").onclick = function(){
        document.getElementById("show-address").innerHTML = document.querySelector("input[name='additional_address']").value + "<br> House/Street: " + document.querySelector("input[name='street']").value
    }
  
    const radioButtons = document.querySelectorAll('input[name="basket-switcher"]');
    const hiddenInputs = document.querySelectorAll('input[name="order_type"]');

    radioButtons.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.checked) {
                let value = radio.value;
                // Loop through all hidden inputs and update their value
                hiddenInputs.forEach(hiddenInput => {
                    hiddenInput.value = value;
                    if(value == "collection"){
                        document.getElementById("collection-time").classList.remove("d-none");

                        document.getElementById("additional-delivery-notes").classList.add("d-none");
                        document.getElementById("cash_button").innerHTML ="Cash On Collection";
                          
                        document.querySelectorAll("span.order_type").forEach(otype => {
                            
                            otype.innerHTML = "Your";
                        });                  
                    }else{
                        document.getElementById("collection-time").classList.add("d-none");

                        document.getElementById("additional-delivery-notes").classList.remove("d-none");
                        document.getElementById("cash_button").innerHTML = "Cash On Delivery";                        
                        document.querySelectorAll("span.order_type").forEach(otype => {
                            otype.innerHTML = "Delivery";
                        });                  
                    }
                });
            }
        });
    });
    
    function calculateDistance() {
    var lat_to = $("#lat_to").val();
    var long_to = $("#long_to").val();

    $("#not-deliever").addClass("d-none"); 
    $("input[name='additional_address']").css("border", "1px solid rgba(0, 0, 0, .15)"); 
    $($(".rr-btn.border-0.mt-4")[1]).removeAttr("disabled"); 
    var button = document.getElementById("checking");
    button.classList.remove("disabled"); 
    button.style.pointerEvents = "auto"; 

    if (lat_to && long_to) {
        // Perform the AJAX request
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?= site_url('GuestCheckout/send_distance') ?>",
            data: {
                lat_to: lat_to,
                long_to: long_to,
            },
            success: function(response) {
                if (response.message == 'Not delivery at this location') {
                    // Handle 'Not delivery' error
                    $($(".rr-btn.border-0.mt-4")[1]).prop("disabled", "true"); // Disable button
                    $("input[name='additional_address']").css("border", "1px solid red"); // Highlight input
                    $("#not-deliever").toggleClass("d-none"); // Show error message
                } else if (response.message == 'Free delivery applied') {
                    // Handle Free delivery
                    $($(".rr-btn.border-0.mt-4")[1]).removeAttr("disabled"); // Enable button
                    $("input[name='additional_address']").css("border", "1px solid rgba(0, 0, 0, .15)"); // Reset input border
                    $("#not-deliever").addClass("d-none"); // Hide error message
                    $(".total-delivery-price").text("£0 (Free Delivery)"); // Display free delivery price
                } else {
                    // Handle regular delivery price
                    $($(".rr-btn.border-0.mt-4")[1]).removeAttr("disabled"); // Enable button
                    $("input[name='additional_address']").css("border", "1px solid rgba(0, 0, 0, .15)"); // Reset input border
                    $("#not-deliever").toggleClass("d-none"); // Show error message
                    $(".total-delivery-price").text("£" + response.message); // Show delivery price

                    // Update the grand total price
                    let subTotal = parseFloat($(".subtotal-price").html().replace("£", ""));
                    let totalVatPrice = parseFloat($(".total-vat-price").html().replace("£", ""));
                    let totalServicePrice = parseFloat($(".total-service-price").html().replace("£", ""));
                    let total = subTotal + totalVatPrice + totalServicePrice + parseFloat(response.message);
                    $(".grand-product-price").text("£" + total);
                }
            },
            error: function(xhr, status, error) {
                $(".data").text("An error occurred: " + xhr.responseText);
            }
        });
    }
}

</script>
