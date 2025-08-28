<!-- Leaflet JS -->
<script src="<?php echo base_url('assets/global/leaflet/leaflet.js'); ?>"></script>
<script src="<?php echo base_url('assets/frontend/default/js/init.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous"></script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRluKUOUHip7mS2d-BWqzfXpIu--VXroo&callback=initMap&libraries=places&v=weekly"
    defer>
</script>


<style>
    .pac-container div:not(.pac-item) {
        display: none;
    }
</style>
<script>
    "use strict";

    // $('#to').keyup(function() {
    //   var foo = $(this).val().split(" ").join(""); // remove hyphens
    //   if (foo.length > 0) {
    //     foo = foo.match(new RegExp('.{1,4}', 'g')).join(" ");
    //   }
    //   $(this).val(foo);
    // });

    // $('#online_discount').on('change', function() {
    //     let isChecked = $(this).is(':checked') ? 1 : 0;

    //      $.ajax({
    //         url: '<?php echo site_url("GuestCheckout/update_online_discount_status"); ?>',
    //         type: 'POST',
    //         data: { online_discount: isChecked },
    //         success: function(response) {
    //             console.log('Updated successfully:', response);
    //                         viewselected_cat_items_summary_total();

    //         },
    //         error: function(xhr, status, error) {
    //             console.error('Error updating:', error);
    //         }
    //     });
    // });

    $(document).ready(function() {

        let savedValue = "<?= $this->session->userdata('is_online_discount_checked') ?>";
        if (savedValue == '1') {
            $('#online_discount').prop('checked', true);
        } else {
            $('#online_discount').prop('checked', false);
        }

        var appliedPromo = <?php echo json_encode($this->session->userdata('applied_promo')); ?>;

        if (appliedPromo && appliedPromo.offer_code) {
            const promoCodeInput = document.getElementById("promo_code");
            const messageEl = document.getElementById("promo_code_message");

            // Recheck promo with backend (optional — but you're doing it here)
            $.ajax({
                url: "<?= site_url('PromoCode/check_promo') ?>",
                type: "POST",
                data: {
                    promo_code: appliedPromo.offer_code
                },
                dataType: "json",
                success: function(data) {
                    if (data.success && data.data && data.data.discount) {
                        const discount = data.data.discount;

                        // Update UI
                        if (promoCodeInput && messageEl) {
                            promoCodeInput.value = appliedPromo.offer_code;
                            promoCodeInput.readOnly = true;

                            $("#apply_promo").addClass("d-none");
                            $("#remove_promo").removeClass("d-none");
                            // $('.online-disc').removeClass('d-none');
                            messageEl.innerText = `Promo applied successfully! ${discount}% off.`;
                            messageEl.className = "text-success";

                            // Refresh totals
                            viewselected_cat_items_summary_total();
                        }
                    } else {
                        // Promo is no longer valid — optionally clear session
                        messageEl.innerText = data.message || "Invalid promo code.";
                        messageEl.className = "text-danger";
                    }
                },
                error: function() {
                    messageEl.innerText = "Something went wrong. Try again.";
                    messageEl.className = "text-danger";
                }
            });
        }


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
                jQuery("ul.billing-list-topbar li.order").addClass("acitve");
                // jQuery("ul.billing-list-topbar li.payment").addClass("acitve");
                jQuery('ul.billing-list-topbar li.billing').removeClass('acitve')

                jQuery("ul.billing-list-topbar li.payment .img-box").removeClass("red");
                jQuery("ul.billing-list-topbar li.billing .img-box").removeClass("red");
                jQuery("ul.billing-list-topbar li.order .img-box").addClass("red");

                jQuery("ul.billing-list-topbar li.billing").removeClass("acitve");
                jQuery("ul.billing-list-topbar li.order").addClass("acitve");

                jQuery('#billing-address').removeClass('d-block');
                jQuery('#billing-address').addClass('d-none');

                jQuery('#your-address').removeClass('d-none');
                jQuery('#your-address').addClass('d-block');

                // jQuery("#payment-option").show();
                const orderTypeValue = localStorage.getItem('order-type');
                if (orderTypeValue == "collection") {
                    // debugger;
                    jQuery("ul.billing-list-topbar li.order").addClass("acitve");

                    jQuery("ul.billing-list-topbar li.order .img-box").addClass("red");
                    jQuery("ul.billing-list-topbar li.billing .img-box").removeClass("red");
                    jQuery("ul.billing-list-topbar li.payment .img-box").removeClass("red");

                    jQuery("ul.billing-list-topbar li.billing").removeClass("acitve");
                    jQuery("ul.billing-list-topbar li.payment").removeClass("acitve");

                    jQuery("#your-address").show();
                    jQuery("#payment-option,#billing-address").hide();

                } else {

                    jQuery("#your-address,#billing-address").hide();
                    jQuery("#payment-option").show();

                }


            }
        });
    }


    // function submitAddressForm() {
    //     // Collect form data
    //     var addressFormData = $('#address-form').serialize();

    //     // Send data via AJAX
    //     $.ajax({                                                                    
    //         type: 'POST',               
    //         url: '<?= base_url('GuestCheckout/save_address_data') ?>', // Adjust the URL to your controller method
    //         data: addressFormData,
    //         success: function(response) {
    //             // Handle the response (if needed)
    //             console.log(response);
    //             jQuery("ul.billing-list-topbar li.order").addClass("acitve");

    //             jQuery("ul.billing-list-topbar li.order .img-box").addClass("red");
    //             jQuery("ul.billing-list-topbar li.billing .img-box").removeClass("red");
    //             jQuery("ul.billing-list-topbar li.payment .img-box").removeClass("red");

    //             jQuery("ul.billing-list-topbar li.billing").removeClass("acitve");
    //             jQuery("ul.billing-list-topbar li.payment").removeClass("acitve");
    //             jQuery("#your-address").show();
    //             jQuery("#your-address").removeClass("d-none");
    //             jQuery("#billing-address,#payment-option").hide();
    //         }
    //     });
    // }


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
                // alert("<?php echo $this->lang->line('fail'); ?>")
            }
        });
        // holdModal('popup');
    }


    // GET THE CART SUMMARY AND DISPAY IN RIGHT SIDE
    function viewselected_cat_items_summary() {
        $.ajax({
            url: '<?php echo base_url(); ?>site/selected_cat_items_summary/',
            success: function(res) {

                if (!res || res.trim() === "") {
                    window.location.href = '<?php echo base_url(); ?>';
                    return;
                }

                // console.log(res, 'selected_cat_items_summary');
                $("#item-list").empty(); // Empty the content of the div
                $("#item-list").html(res); // Replace with the 'res' response
            },
            error: function() {
                // alert("<?php echo $this->lang->line('fail'); ?>")
            }
        });
        // holdModal('popup');
    }

    var promoData = <?php echo json_encode($this->session->userdata('applied_promo')); ?>;
    // console.log(promoData);
    // GET THE CART total price AND DISPAY IN RIGHT SIDE
    function viewselected_cat_items_summary_total() {

        $.ajax({
            data: {
                order_type: document.querySelector("input[name='order_type']").value
            },
            url: '<?php echo base_url(); ?>cart/get_order_summary/',
            type: 'POST',
            success: function(res) {
                // Parse the JSON string into a JavaScript object
                var data = JSON.parse(res);

                // console.log(data)
                // Access the 'sub_total' property and display its value
                var subTotalValue = data.sub_total;
                var totalDeliveryValue = data.total_delivery_charge;
                var totalVatValue = data.vat_charges;
                var grandSubTotalValue = data.grand_total;
                var totalServicePrice = data.total_service_price;
                var totalDiscountPrice = data.total_discount_applied;
                var discountP = data.discounted_amount;
                var bagCharges = data.bag_price;

                $(".bag-charges").text(bagCharges);

                // Now you can use subTotalValue as needed, for example, displaying it in the console

                $(".subtotal-price").text(subTotalValue);
                // $(".total-delivery-price").text(totalDeliveryValue);
                $(".total-vat-price").text(totalVatValue);
                $(".grand-product-price").text(grandSubTotalValue);
                $(".total-service-price").text(totalServicePrice);
                $(".discount-label").text("Discount ("+ totalDiscountPrice +")");
                $(".total-discount-applied").text("-" + discountP);
                $('.grand-product-price').text('£' + (grandSubTotalValue).toFixed(2));

            },
            error: function() {
                // alert("<?php echo $this->lang->line('fail'); ?>")
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


    // function apply_promo_action() {
    //     console.log("working");
    //     var promoCode = $('#promo_code').val();
    //     var amount = $('#grand_total_code').val(); /* Get the order amount */ ;
    //     console.log(amount);
    //     $.ajax({
    //         url: '<?php echo site_url('cart/checkPromoCode'); ?>',
    //         type: 'POST',
    //         data: {
    //             promo_code: promoCode,
    //             amount: amount
    //         },
    //         success: function(response) {
    //             console.log(response);
    //             if (!isNaN(response)) { // Check if response is a number
    //                 $('#promo_code_message').text(response + '% discount applied.').addClass(
    //                     'text-success').removeClass('text-danger');
    //                 updateDiscountCodeToCart(promoCode, response); // Call the function with user_id
    //             } else {
    //                 $('#promo_code_message').text('Invalid promo code').addClass('text-danger')
    //                     .removeClass('text-success');
    //             }
    //         }
    //     });
    // }




    function apply_promo_action() {
        const promoCode = document.getElementById("promo_code").value.trim();
        const messageEl = document.getElementById("promo_code_message");

        if (promoCode === "") {
            messageEl.innerText = "Please enter a promo code.";
            messageEl.className = "text-danger";
            return;
        }

        $.ajax({
            url: "<?= site_url('PromoCode/check_promo') ?>", // must set session if promo is valid
            type: "POST",
            data: {
                promo_code: promoCode
            },
            dataType: "json",
            success: function(data) {
                if (data.success && data.data) {
                    const discount = data.data.discount;

                    messageEl.innerText = `Promo applied successfully! ${discount}% off.`;
                    messageEl.className = "text-success";
                            // $('.online-disc').removeClass('d-none');
                    document.getElementById("promo_code").readOnly = true;
                    document.getElementById("apply_promo").classList.add("d-none");
                    document.getElementById("remove_promo").classList.remove("d-none");

                    viewselected_cat_items_summary_total();
                } else {
                    messageEl.innerText = data.message || "Invalid promo code.";
                    messageEl.className = "text-danger";
                }
            },
            error: function() {
                messageEl.innerText = "Something went wrong. Try again.";
                messageEl.className = "text-danger";
            }
        });
    }


    function remove_promo() {
        const messageEl = document.getElementById("promo_code_message");

        $.ajax({
            url: "<?= base_url('PromoCode/remove_promo') ?>",
            type: "POST",
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    // Reset promo input
                    document.getElementById("promo_code").value = "";
                    document.getElementById("promo_code").readOnly = false;

                    messageEl.innerText = data.message;
                    messageEl.className = "text-warning";
                    // $('.online-disc').addClass('d-none');
                    document.getElementById("remove_promo").classList.add("d-none");
                    document.getElementById("apply_promo").classList.remove("d-none");
                    viewselected_cat_items_summary_total();
                } else {
                    messageEl.innerText = "Failed to remove promo.";
                    messageEl.className = "text-danger";
                }
            },
            error: function() {
                messageEl.innerText = "Something went wrong while removing promo.";
                messageEl.className = "text-danger";
            }
        });
    }


    // function remove_promo() {
    //     const messageEl = document.getElementById("promo_code_message");
    //     document.getElementById("promo_code").value = "";
    //     document.getElementById("promo_code").readOnly = false;
    //     messageEl.innerText = "Promo code removed.";
    //     messageEl.className = "text-warning";
    //     document.getElementById("remove_promo").classList.add("d-none");
    //     document.getElementById("apply_promo").classList.remove("d-none");
    // }

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
                        var amount = parseFloat($('.grand_total_code').val());
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





    // function remove_promo() {
    //     var userId = $('#user_id').val();

    //     $.ajax({
    //         url: '<?php echo site_url('cart/updateDiscountCodeCart'); ?>',
    //         type: 'POST',
    //         data: {
    //             userId: userId,
    //             promo_code: '',
    //             discount: -1
    //         },
    //         success: function(response) {
    //             console.log(response);
    //             window.location.reload();
    //         }
    //     });
    // }

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

            if ($(".order.last.acitve").length == 1) {
                return;
            }

            var test = $(this).val();
            jQuery("span.collect-box").hide();
            jQuery("#" + test).show();
        });
    });

    jQuery('label.c-basketSwitcher-switch').click(function() {
        if ($(".order.last.acitve").length == 1) {
            return;
        }
        jQuery('label.c-basketSwitcher-switch').removeClass('c-basketSwitcher-switch--active');
        jQuery(this).addClass('c-basketSwitcher-switch--active');
    });

    // jQuery('.c-basketSwitcher-switch input:checked').parent().addClass('c-basketSwitcher-switch--active');
</script>


<script type="text/javascript">
    $(document).ready(function() {
        assignRandomNamesToInputs();
        var autocomplete_to;

        setTimeout(function() {
            const marchBounds = new google.maps.LatLngBounds({
                    lat: 52.5435,
                    lng: 0.0720
                }, // Southwest corner
                {
                    lat: 52.5610,
                    lng: 0.1120
                } // Northeast corner
            );

            // Initialize Google Maps autocomplete for "to" address
            autocomplete_to = new google.maps.places.Autocomplete(
                document.getElementById('to'), {
                    libraries: ['street_address', 'premise'],
                    componentRestrictions: {
                        country: "uk"
                    },
                    bounds: marchBounds,
                }
            );

            google.maps.event.addListener(autocomplete_to, 'place_changed', function() {
                var place = autocomplete_to.getPlace();
                if (place.address_components && place.address_components.length > 0) {
                    var addressComp = place.address_components[place.address_components.length - 1].short_name;

                    // document.querySelector("input[name='random2']").value = addressComp;
                    // document.querySelector("input[name='random3']").value = place.address_components[0].short_name;
                    // document.querySelector("input[name='random4']").value = place.address_components[1].short_name;

                    document.querySelector(`[name="${nameMap['postcode']}"]`).value = addressComp;
                    document.querySelector(`[name="${nameMap['flat']}"]`).value = place.address_components[0].short_name;
                    document.querySelector(`[name="${nameMap['street']}"]`).value = place.address_components[1].short_name;

                    $("#lat_to").val(place.geometry.location.lat());
                    $("#long_to").val(place.geometry.location.lng());

                    // Call the function to calculate distance here
                    calculateDistance();
                }
            });

            // Address input validation to prevent alphabetic characters
            var address = document.querySelector("input[data-field='address']");
            address.addEventListener('input', function() {
                const value = address.value.trim();

                //     if (/[a-zA-Z]/.test(value[value.length - 1]) && !/\d/.test(value)) {
                //   // Remove the letter just typed
                //   address.value = value.slice(0, -1);
                // }
                // Reset bounds if no alphabets are present
                if (/^\d/.test(value)) {
                    autocomplete_to.setOptions({
                        strictBounds: false
                    });
                    autocomplete_to.setBounds(marchBounds);
                } else {
                    autocomplete_to.setOptions({
                        strictBounds: true
                    });
                    autocomplete_to.setBounds(null); // Restrict to empty bounds if alphabets are present
                }
            });

            // Optional: Reset autocomplete on clearing the address field (if needed)
            address.addEventListener('focus', function() {
                autocomplete_to.setOptions({
                    strictBounds: false
                });
                autocomplete_to.setBounds(marchBounds);
            });

            // Handle button clicks and interactions
            document.getElementById("checking").onclick = function() {
                document.getElementById('instructions_hidden').innerHTML = document.querySelector(`[name="${nameMap['instructions']}"]`).value || "No instructions provided";
                // document.getElementById("show-address").innerHTML = document.querySelector("input[name='random1']").value + "<br> House/Street: " + document.querySelector("input[name='random4']").value + "<br> Street/Name: " + document.querySelector("input[name='random2']").value;
                document.getElementById("show-address").innerHTML =
                    document.querySelector(`[name="${nameMap['address']}"]`).value + "<br> House/Street: " +
                    document.querySelector(`[name="${nameMap['street']}"]`).value + "<br> Street/Name: " +
                    document.querySelector(`[name="${nameMap['postcode']}"]`).value;

                const addressData = {
                    address: document.querySelector(`[name="${nameMap['address']}"]`).value,
                    street: document.querySelector(`[name="${nameMap['street']}"]`).value,
                    postcode: document.querySelector(`[name="${nameMap['postcode']}"]`).value,
                    flat: document.querySelector(`[name="${nameMap['flat']}"]`)?.value || '',
                    instructions: document.querySelector(`[name="${nameMap['instructions']}"]`)?.value || '',
                };

                // Store to localStorage
                localStorage.setItem('address_data', JSON.stringify(addressData));
            }

        }, 2000);


        let orderTypeForActive = localStorage.getItem('order-type');
        if (orderTypeForActive == "collection") {

                document.querySelectorAll(".remove-required-collection").forEach(element => {
                    element.removeAttribute("required");

                    let id = `label[for="input${element.id}"]`;
                    let label = document.querySelector(id);
                    if (label) {
                        label.textContent = label.textContent.replace("*", "") + " (Optional)";
                    }
                });

                document.querySelector("#checking").classList.remove("disabled");


                document.getElementById("delivery-charge").classList.add("d-none");
                document.getElementById("delivery-charge").classList.remove("d-flex");
                document.querySelector(".discount-label").innerText = "Discount (25%)";

                document.getElementById("collection-time").classList.remove("d-none");
                document.getElementById("additional-delivery-notes").classList.add("d-none");
                document.getElementById("cash_button").innerHTML = "Cash On Collection";
                document.querySelectorAll("span.order_type").forEach(otype => {
                    otype.innerHTML = "Your";
                });
            } else {

                document.querySelector("#checking").classList.add("disabled", "true");


                document.querySelectorAll(".remove-required-collection").forEach(element => {

                    element.setAttribute("required", "true");

                    let id = `label[for="input${element.id}"]`;
                    let label = document.querySelector(id);
                    if (label) {
                        label.textContent = label.textContent.replace("(Optional)", "") + "*";
                    }
                });

                document.getElementById("delivery-charge").classList.remove("d-none");
                document.getElementById("delivery-charge").classList.add("d-flex");
                document.querySelector(".discount-label").innerText = "Discount (20%)";

                document.getElementById("collection-time").classList.add("d-none");
                document.getElementById("additional-delivery-notes").classList.remove("d-none");
                document.getElementById("cash_button").innerHTML = "Cash On Delivery";
                document.querySelectorAll("span.order_type").forEach(otype => {
                    otype.innerHTML = "Delivery";
                });
            }

        const radioButtons = document.querySelectorAll('input[name="basket-switcher"]');
        const hiddenInputs = document.querySelectorAll('input[name="order_type"]');

        radioButtons.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.checked) {
                    let value = radio.value;
                    hiddenInputs.forEach(hiddenInput => {
                        console.log(hiddenInput.value);
                        hiddenInput.value = value;
                        if (value == "collection") {

                            document.querySelectorAll(".remove-required-collection").forEach(element => {
                                element.removeAttribute("required");

                                let id = `label[for="input${element.id}"]`;
                                let label = document.querySelector(id);
                                if (label) {
                                    label.textContent = label.textContent.replace("*", "") + " (Optional)";
                                }
                            });

                            document.querySelector("#checking").classList.remove("disabled");


                            document.getElementById("delivery-charge").classList.add("d-none");
                            document.getElementById("delivery-charge").classList.remove("d-flex");
                            document.querySelector(".discount-label").innerText = "Discount (25%)";

                            document.getElementById("collection-time").classList.remove("d-none");
                            document.getElementById("additional-delivery-notes").classList.add("d-none");
                            document.getElementById("cash_button").innerHTML = "Cash On Collection";
                            document.querySelectorAll("span.order_type").forEach(otype => {
                                otype.innerHTML = "Your";
                            });
                        } else {

                            document.querySelector("#checking").classList.add("disabled", "true");


                            document.querySelectorAll(".remove-required-collection").forEach(element => {

                                element.setAttribute("required", "true");

                                let id = `label[for="input${element.id}"]`;
                                let label = document.querySelector(id);
                                if (label) {
                                    label.textContent = label.textContent.replace("(Optional)", "") + "*";
                                }
                            });

                            document.getElementById("delivery-charge").classList.remove("d-none");
                            document.getElementById("delivery-charge").classList.add("d-flex");
                            document.querySelector(".discount-label").innerText = "Discount (20%)";

                            document.getElementById("collection-time").classList.add("d-none");
                            document.getElementById("additional-delivery-notes").classList.remove("d-none");
                            document.getElementById("cash_button").innerHTML = "Cash On Delivery";
                            document.querySelectorAll("span.order_type").forEach(otype => {
                                otype.innerHTML = "Delivery";
                            });
                        }
                    });

                    viewselected_cat_items_summary_total();
                }
            });
        });

    });


    document.getElementById("checking").onclick = function() {
        if (document.querySelector("input[name='address']").value == "" && document.querySelector("input[name='street']").value == "" && document.querySelector("input[name='zip_code']").value == "") {
            document.getElementById("show-address").innerHTML = "Not Given";
        }
        document.getElementById("show-address").innerHTML =
            (document.querySelector("input[name='address']").value || "Not given") +
            "<br> House/Street: " + (document.querySelector("input[name='street']").value || "Not given") +
            "<br> Street/Name: " + (document.querySelector("input[name='zip_code']").value || "Not given");

    }

    //    debugger;

    // Get value from Local Storage
    const orderTypeValue = localStorage.getItem('order-type');

    if (orderTypeValue) {
        // Update all hidden input fields with the order type
        document.querySelectorAll('input[name="order_type"]').forEach(input => {
            input.value = orderTypeValue;
        });

        if (orderTypeValue === "delivery") {
            // const liOrder = document.querySelector('ul.billing-list-topbar li.order');
            const liBilling = document.querySelector('ul.billing-list-topbar li.billing');
            const liPayment = document.querySelector('ul.billing-list-topbar li.payment');
            liBilling.classList.remove('acitve');
            liBilling.querySelector('.img-box').classList.remove('red');
            liPayment.classList.add('acitve');
            jQuery('#billing-address').addClass('d-none');
            jQuery('#payment-option').addClass('d-block');

            // if (liPayment) liPayment.querySelector('.img-box').style.display = 'none';
            // if (liPayment) liPayment.classList.remove("acitve");
            const headingInPaymentMehod = document.getElementById('p-gateways')
            if (headingInPaymentMehod) headingInPaymentMehod.style.display = 'none';
        }

        if (orderTypeValue === "collection") {
            // debugger;
            // Topbar styling
            const liOrder = document.querySelector('ul.billing-list-topbar li.order');
            const liBilling = document.querySelector('ul.billing-list-topbar li.billing');
            const liPayment = document.querySelector('ul.billing-list-topbar li.payment');
            // if (liPayment) liPayment.querySelector('.img-box').style.display = 'none';
            if (liPayment) liPayment.querySelector('.img-box').style.display = 'none';

            liPayment.classList.add('highlighted');


            if (liOrder.classList.contains('acitve')) {
                console.log('Order Active');
                liPayment.classList.remove('highlighted');
            }


            // const paymentGateway = document.getElementById('p-gateways');
            // const paymentMethod = document.getElementById('p-method'

            // if (liOrder) liOrder.classList.add("col-md-12");
            // if (liOrder) liOrder.querySelector('.img-box').classList.add("red");
            // if (liOrder) liOrder.classList.add("mx-auto");

            // if (paymentGateway) paymentGateway.classList.add("d-none");
            // if (paymentMethod) paymentMethod.classList.add("mx-auto");

            // if (liBilling) liBilling.classList.remove("acitve");
            if (liPayment) liPayment.classList.remove("acitve");

            // const orderImg = document.querySelector('ul.billing-list-topbar li.order .img-box');
            // const billingImg = document.querySelector('ul.billing-list-topbar li.billing .img-box');
            // const paymentImg = document.querySelector('ul.billing-list-topbar li.payment .img-box');

            // if (orderImg) orderImg.classList.add("red");
            // if (billingImg) billingImg.classList.remove("red");
            // if (paymentImg) paymentImg.classList.remove("red");

            // Show/Hide sections
            // const paymentOption = document.getElementById("payment-option");
            // const billingAddress = document.getElementById("billing-address");
            // const yourAddress = document.getElementById("your-address");

            // if (paymentOption) paymentOption.classList.add("d-none");
            // if (billingAddress) billingAddress.classList.add("d-none");
            // if (yourAddress) {
            // //  yourAddress.classList.remove("d-none");  
            // //  yourAddress.style.display = "block";    
            // //  document.querySelector('.delivery-text').classList.add('d-none');

            //     }
            // Set section display manually if needed
            // const paymentSection = document.querySelector(".payment");
            // if (paymentSection) paymentSection.style.display = "none";

            // const billingSection = document.querySelector(".billing");
            // if (billingSection) billingSection.style.width = "90%";

            // const orderSection = document.querySelector(".billing");
            // if (orderSection) orderSection.style.display = "none";

            // Collection time visible, hide additional notes
            // const collectionTime = document.getElementById("collection-time");
            // const deliveryNotes = document.getElementById("additional-delivery-notes");
            // if (collectionTime) collectionTime.classList.remove("d-none");
            // if (deliveryNotes) deliveryNotes.classList.add("d-none");

            const headingInPaymentMehod = document.getElementById('p-gateways')
            if (headingInPaymentMehod) headingInPaymentMehod.style.display = 'none';
            // Update cash button text
            const cashButton = document.getElementById("cash_button");
            if (cashButton) cashButton.innerHTML = "Cash On Collection";

            // Change order type display label
            // document.querySelectorAll("span.order_type").forEach(span => {
            //     span.innerHTML = "Your";
            // });
        }
    }





    function calculateDistance() {
        var lat_to = $("#lat_to").val();
        var long_to = $("#long_to").val();

        $("#not-deliever").addClass("d-none");
        $("input[name='address']").css("border", "1px solid rgba(0, 0, 0, .15)");
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
                    //  debugger;

                    if (response.message == 'Not delivery at this location') {
                        // Handle 'Not delivery' error
                        $($(".rr-btn.border-0.mt-4")[1]).prop("disabled", "true"); // Disable button
                        $("input[name='address']").css("border", "1px solid red"); // Highlight input
                        $("#not-deliever").toggleClass("d-none"); // Show error message
                    } else if (response.message == 'Free delivery applied') {
                        // Handle Free delivery
                        $($(".rr-btn.border-0.mt-4")[1]).removeAttr("disabled"); // Enable button
                        $("input[name='address']").css("border", "1px solid rgba(0, 0, 0, .15)"); // Reset input border
                        $("#not-deliever").addClass("d-none"); // Hide error message
                        $(".total-delivery-price").text("£0 (Free Delivery)"); // Display free delivery price
                    } else {
                        // Handle regular delivery price
                        $($(".rr-btn.border-0.mt-4")[1]).removeAttr("disabled"); // Enable button
                        $("input[name='address']").css("border", "1px solid rgba(0, 0, 0, .15)"); // Reset input border
                        $("#not-deliever").addClass("d-none"); // Show error message
                        $(".total-delivery-price").text("£" + response.message); // Show delivery price
                        // console.log(response.message);
                        // Update the grand total price
                        console.log(response.message);

                        $.ajax({
                            url: 'Cart/set_delivery_charges',
                            type: 'POST',
                            data: { delivery_charges: response.message },
                            success: function(res) {
                                console.log('Delivery charges saved in session');
                            }
                        });
                        let subTotal = parseFloat($(".subtotal-price").html().replace("£", ""));
                        // let totalVatPrice = parseFloat($(".total-vat-price").html().replace("£", ""));
                        let totalServicePrice = parseFloat($(".total-service-price").html().replace("£", ""));
                        let totalDiscount = parseFloat($(".total-discount-applied").html().replace("£", ""));
                        let bagcharges = parseFloat($(".bag-charges").html().replace("£", ""));
                        // NOTE: The adding of totalDiscount is correct, beacuse the discount is in negative. That's why it is added.

                        let total = subTotal + totalServicePrice + parseFloat(response.message) + totalDiscount + bagcharges;
                    }
                },
                error: function(xhr, status, error) {
                    $(".data").text("An error occurred: " + xhr.responseText);
                }
            });
        }
    }


    document.getElementById("mobile").addEventListener("keypress", function(e) {
        const char = String.fromCharCode(e.which);
        const allowed = /[0-9\+]/; // allow digits and + only
        if (!allowed.test(char)) {
            e.preventDefault(); // block character
        }
    });
    document.getElementById('mobile').addEventListener('input', function() {
        var input = this;
        var pattern = new RegExp(input.getAttribute('pattern'));

        if (!pattern.test(input.value)) {
            input.classList.add('invalid');
        } else {
            input.classList.remove('invalid');
        }
    });



    $(function() {

        $('#txtfname').keydown(function(e) {

            if (e.ctrlKey || e.altKey) {

                e.preventDefault();

            } else {

                var key = e.keyCode;

                if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {

                    e.preventDefault();

                }

            }

        });

    });
    $(function() {

        $('#txtlname').keydown(function(e) {

            if (e.ctrlKey || e.altKey) {

                e.preventDefault();

            } else {

                var key = e.keyCode;

                if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {

                    e.preventDefault();

                }

            }

        });

    });


    $(document).ready(function() {
        // Jab bhi delivery price calculate ho jaye
        if ($('.total-delivery-price').text().trim() !== '') {
            $('.subtotal').hide();
        }

        // Agar dynamically update ho raha hai
        setInterval(function() {
            if ($('.total-delivery-price').text().trim() !== '') {
                $('.subtotal').hide();
            } else {
                $('.subtotal').show();
            }
        }, 500); // Har 500ms mein check karega
    });


    document.addEventListener("DOMContentLoaded", function() {
        const orderTypeMessage = document.getElementById("orderTypeMessage");
        const radioButtons = document.querySelectorAll('input[name="basket-switcher"]');

        function updateMessageFromLocalStorage() {
            const orderType = localStorage.getItem("order-type");
            if (orderType) {
                orderTypeMessage.textContent = `Order Type: ${orderType.charAt(0).toUpperCase()}${orderType.slice(1)}`;

                // Optionally, check the corresponding radio button if it exists
                const matchingRadio = document.querySelector(`input[name="basket-switcher"][value="${orderType}"]`);
                if (matchingRadio) {
                    matchingRadio.checked = true;
                }
            }
        }

        function updateMessageAndSaveToLocalStorage() {
            const selected = document.querySelector('input[name="basket-switcher"]:checked');
            if (selected) {
                const value = selected.value;
                localStorage.setItem("order-type", value);
                orderTypeMessage.textContent = `Selected Order Type = "${value}"`;
                window.location.reload();
            }
        }

        // Set message based on localStorage initially
        updateMessageFromLocalStorage();

        // Update message and localStorage when radio button changes
        radioButtons.forEach((radio) => {
            radio.addEventListener("change", updateMessageAndSaveToLocalStorage);
        });
    });
</script>