<!-- Magnific popup JS -->
<script src="<?php echo base_url('assets/frontend/default/js/jquery.magnific-popup.js') ?>"></script>
<!-- Swipper Slider JS -->
<script src="<?php echo base_url('assets/frontend/default/js/swiper.min.js') ?>"></script>

<!-- Leaflet JS -->
<script src="<?php echo base_url('assets/global/leaflet/leaflet.js'); ?>"></script>

<!-- INIT JS -->
<script src="<?php echo base_url('assets/frontend/default/js/init.js') ?>"></script>

<script src="<?php echo base_url('assets/frontend/default/js/owl.carousel.min.js') ?>"></script>

<script>
"use strict";
$(window).scroll(function() {
    // 100 = The point you would like to fade the nav in.

    if ($(window).scrollTop() > 100) {

        $('.fixed').addClass('is-sticky');

    } else {

        $('.fixed').removeClass('is-sticky');

    };
});


jQuery(".filter-list.all-other .icon-arrow-down").click(function() {
    jQuery(".filter-list.all-other ul").toggle();
});

jQuery(".filter-list.price .icon-arrow-down").click(function() {
    jQuery(".filter-list.price ul").toggle();
});

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


//add change event action on checkbox
jQuery("#med-addons input:checkbox").on("change", function() {
    //change input #grandtotal value according check/uncheck checkboxes
    jQuery("#med-addons input#grandtotal").val(function() {
        //declare a variable to keep the sum of the values
        var sum = 0;
        //using an iterator find and sum the values of checked checkboxes
        jQuery("#med-addons input:checkbox:checked").each(function() {
            sum += ~~jQuery(this).val();
        });
        return sum;
    });
});

//here change the value according on checked checkboxes on DOM ready event
jQuery("#grandtotal").val(function() {
    var sum = 0;
    jQuery("#med-addons input:checkbox:checked").each(function() {
        sum += ~~jQuery(this).val();
    });
    return sum;
});


//add change event action on checkbox
jQuery("#lg-addons input:checkbox").on("change", function() {
    //change input #grandtotal value according check/uncheck checkboxes
    jQuery("#grandtotal2").val(function() {
        //declare a variable to keep the sum of the values
        var sum = 0;
        //using an iterator find and sum the values of checked checkboxes
        jQuery("#lg-addons input:checkbox:checked").each(function() {
            sum += ~~jQuery(this).val();
        });
        return sum;
    });
});

//here change the value according on checked checkboxes on DOM ready event
jQuery("#grandtotal2").val(function() {
    var sum = 0;
    jQuery("#lg-addons input:checkbox:checked").each(function() {
        sum += ~~jQuery(this).val();
    });
    return sum;
});


jQuery(document).ready(function() {
    jQuery("input[name$='chooseone']").click(function() {
        var test2 = $(this).val();
        jQuery("div.addons").hide();
        jQuery("#" + test2).show();
    });
});

jQuery('.btn-number').click(function(e) {
    e.preventDefault();

    fieldName = jQuery(this).attr('data-field');
    type = jQuery(this).attr('data-type');
    var input = jQuery("input[name='" + fieldName + "']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if (type == 'minus') {

            if (currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if (parseInt(input.val()) == input.attr('min')) {
                jQuery(this).attr('disabled', true);
            }

        } else if (type == 'plus') {

            if (currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if (parseInt(input.val()) == input.attr('max')) {
                jQuery(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
jQuery('.input-number').focusin(function() {
    jQuery(this).data('oldValue', jQuery(this).val());
});
jQuery('.input-number').change(function() {

    minValue = parseInt(jQuery(this).attr('min'));
    maxValue = parseInt(jQuery(this).attr('max'));
    valueCurrent = parseInt(jQuery(this).val());

    name = jQuery(this).attr('name');
    if (valueCurrent >= minValue) {
        jQuery(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        jQuery(this).val(jQuery(this).data('oldValue'));
    }
    if (valueCurrent <= maxValue) {
        jQuery(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        jQuery(this).val(jQuery(this).data('oldValue'));
    }


});
jQuery(".input-number").keydown(function(e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
        // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});


jQuery('.order-detail-slider').owlCarousel({
    loop: true,
    margin: 13,
    nav: true,
    dots: false,
    autoWidth: true,
    responsive: {
        550: {
            items: 1
        },
        768: {
            items: 3
        },
        1000: {
            items: 8
        }
    }
});
</script>
<script>
"use strict";

var swiper = new Swiper('.swiper-container', {
    slidesPerView: 3,
    slidesPerGroup: 3,
    loop: true,
    loopFillGroupWithBlank: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

if ($('.image-link').length) {
    $('.image-link').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });
}
if ($('.image-link2').length) {
    $('.image-link2').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });
}

// INITIALIZE TOOLTIPS
initToolTip();

// CART OPERATIONS
$(".add-order-txt").click(function() {
    $('.menuoptions:checkbox:checked').each(function() {
        alert($(this).val())
    })
})
// var menuId = $('#menu-id').val();
// var quantity = $('#quantity_for_menu').val();
// var variantId = $('#variant-id').val();
// var addons = $('#addons').val();
// var note = $('#note').val();
// $.ajax({
//   url: '<?php echo site_url('cart/add_to_cart'); ?>',
//   type: 'POST',
//   data: {
//     menuId: menuId,
//     quantity: quantity,
//     variantId: variantId,
//     addons: addons,
//     note: note
//   },
//   success: function (response) {
//     console.log(response);
//     if (response === "multi_restaurant") {
//       toastr.warning('<?php echo site_phrase('sorry_you_can_not_order_from_multiple_restaurant'); ?>');
//     } else {
//       if (Math.floor(response) == response && $.isNumeric(response)) {
//         $('.cart-items').text(response);
//         toastr.success('<?php echo site_phrase('added_to_the_cart'); ?>');
//         $(".modal").modal('hide');
//       }
//     }
//   }
// });
// }

// MAP INITIALIZING
// var map = L.map('map').setView([<?php echo !empty($restaurant_details['latitude']) ? floatval(sanitize($restaurant_details['latitude'])) : 0; ?>, <?php echo !empty($restaurant_details['longitude']) ? floatval(sanitize($restaurant_details['longitude'])) : 0; ?>], 16);
// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// L.marker([<?php echo !empty($restaurant_details['latitude']) ? floatval(sanitize($restaurant_details['latitude'])) : 0; ?>, <?php echo !empty($restaurant_details['longitude']) ? floatval(sanitize($restaurant_details['longitude'])) : 0; ?>]).addTo(map)
//   .bindPopup('<?php echo sanitize($restaurant_details['address']); ?>');

// CHANGING QUANTITY ON INCREMENT OR DECREMENT BUTTON CLICK
function changeQuantity(flag) {
    var currentQuantity = $("#quantity_for_menu").val();
    if (flag === 1) {
        currentQuantity++;
    } else {
        if (currentQuantity > 1) {
            currentQuantity--;
        } else {
            currentQuantity = 1;
            toastr.warning('<?php echo site_phrase('minimum_quantity_is'); ?>: 1');
        }
    }

    $("#quantity_for_menu").val(currentQuantity);
    calculateMenuPrice();
}


// CALCULATE MENU PRICE AFTER CHOOSING MENU VARIANTS
function calculateMenuPrice() {
    var selectedVariants;
    var selectedAddons;
    var quantity;
    var menuId = $("#menu-id").val();

    quantity = $('#quantity_for_menu').val();

    $('input:radio').each(function() {
        if ($(this).is(':checked')) {
            selectedVariants = selectedVariants ? selectedVariants + ',' + $(this).val() : $(this).val();
        }
    });

    $('input:checkbox').each(function() {
        if ($(this).is(':checked')) {
            selectedAddons = selectedAddons ? selectedAddons + ',' + $(this).val() : $(this).val();
        }
    });

    $.ajax({
        url: '<?php echo site_url('cart/get_menu_details_with_variants_and_addons'); ?>',
        type: 'POST',
        data: {
            menuId: menuId,
            selectedVariants: selectedVariants,
            selectedAddons: selectedAddons,
            quantity: quantity
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status) {
                $(".calculated-price").text(response.currencyCode + response.totalPrice);
                $(".calculated-price").removeClass("d-none");
                $(".fa-spinner").addClass('d-none');

                $("#menu-id").val(response.menuId);
                $("#addons").val(response.addons);
                if (response.hasVariant) {
                    $("#variant-id").val(response.variantId);
                    $('.pink-cart-btn').prop("disabled", false);
                }
            } else {
                $("#addons").val(null);
                $("#variant-id").val(null);
                $('.pink-cart-btn').prop("disabled", true);
                $(".calculated-price").addClass("d-none");
                $(".fa-spinner").removeClass('d-none');
            }
        }
    });
}

// CART OPERATIONS
function addToCart() {
    
    var menuId = $('#menu-id').val();
    
    var variant = $('#variant').val();
    
    var quantity = $('#quantity_for_menu').val();

    var totalprice = $('#totalprice').val();
    console.log("Totalprice:", totalprice);
    var variantId = $('#variant-id').val();
    var addons = $('#addons').val();
    var note = $('#note').val();

    // Initialize arrays to store selected items
    var selectedItemsArray1 = [];
    var selectedItemsArray2 = [];
    var selectedItemsArrayOptional = [];

    // Function to collect selected items
    function collectSelectedItems(selector, array) {
        var selectedItems = $(selector);
        selectedItems.each(function() {
            var subVariantId = $(this).data('sub-variant-id');
            var itemId = $(this).data('item-id');
            array.push({
                subVariantId: subVariantId,
                itemId: itemId
            });
            console.log('Data Sub Variant ID:', subVariantId);
            console.log('Data Item ID:', itemId);
        });
    }

    // collect items
    collectSelectedItems('.menu-option-1 .required-item:checked', selectedItemsArray1);
    collectSelectedItems('.menu-option-2 .required-item:checked', selectedItemsArray2);
    collectSelectedItems('.menu-option-1 .optional-item:checked', selectedItemsArrayOptional);

    // Merge selectedItemsArray1 and selectedItemsArrayOptional
    var mergedSelectedItemsArray1 = selectedItemsArray1.concat(selectedItemsArrayOptional);

    // Convert the arrays to JSON strings
    var jsonStringSelectedItems1 = JSON.stringify(mergedSelectedItemsArray1);
    var jsonStringSelectedItems2 = JSON.stringify(selectedItemsArray2);

    console.log('jsonStringSelectedItems1:', jsonStringSelectedItems1);
    console.log('jsonStringSelectedItems2:', jsonStringSelectedItems2);

    // AJAX request to add items to the cart
    $.ajax({
        url: '<?php echo site_url('cart/add_to_cart'); ?>',
        type: 'POST',
        data: {
            menuId: menuId,
            quantity: quantity,
            variantId: variantId,
            addons: addons,
            note: note,
            totalprice: totalprice,
            options_1: jsonStringSelectedItems1,
            options_2: jsonStringSelectedItems2
        },
        success: function(response) {
            console.log(response);
            if (response === "multi_restaurant") {
                toastr.warning(
                    '<?php echo site_phrase('sorry_you_can_not_order_from_multiple_restaurant'); ?>');
            } else {
                if (Math.floor(response) == response && $.isNumeric(response)) {
                    $('.cart-items').text(response);
                    toastr.success('<?php echo site_phrase('added_to_the_cart'); ?>');
                    $(".modal").modal('hide');
                }
                viewselected_cat_items_summary();
                viewselected_cat_items_summary_total();
            }
        }
    }); 
}



//  GET AND DISPALY THE MENU MAIN CATAGORIES BASED ON THE CLICK MENU 
function viewselected_menu(menuid, menuprice) {

    $.ajax({
        url: '<?php echo base_url(); ?>site/selected_menu/' + menuid,
        success: function(res) {
            $("#getdetails_selected_menu").html(res);
            // console.log(res); 
            $('#popup').modal('show');
            calculatePrice();
        },
        error: function() {
            alert("<?php echo $this->lang->line('fail'); ?>")
        }
    });

    // holdModal('popup');
}
</script>
<script type="text/javascript">
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

            if(subTotalValue !== "£0"){
                var button = document.getElementById("guestCheckoutBtn");
                button.classList.remove("disabled"); 
                button.style.pointerEvents = "auto"; 
                    
            }

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
// document.addEventListener("DOMContentLoaded", function() {
//     var empty = document.getElementById("no-menu").value;
//     if (empty === "£0") {

//         // console.log("make price");
//     }
// });

document.addEventListener('DOMContentLoaded', function() {
    const checkoutButton = document.getElementById('checkout-button');

    if(checkoutButton == null)
        return;

    if (checkoutButton.getAttribute('data-disabled') === 'true') {
        checkoutButton.addEventListener('click', function(event) {
            event.preventDefault();
            //alert('Please select an item first.');
        });
    }
});
$(window).scroll(function(e) { 
  var $el = $('.sticky-offset'); 
  var isPositionFixed = ($el.css('position') == 'sticky-offset');
  var scrollOffset = $(this).scrollTop();
  
  

  // Apply padding-top: 50px when the offset value is 750
  if (scrollOffset >= 750) {
    $el.css('margin-top', '60px');
  } else {
    $el.css('margin-top', '0px');
  }

  if (scrollOffset > 200 && !isPositionFixed) { 
    $el.css({'position': 'sticky', 'top': '0px'}); 
  }

  if (scrollOffset < 200 && isPositionFixed) {
    $el.css({'position': 'static', 'top': '0px'}); 
  } 
});


</script>