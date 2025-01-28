<!-- NAVIGATION BAR -->

<?php include APPPATH . 'views/frontend/default/navigation/dark.php';


$cash_on_delivery_settings = get_payment_settings("cash_on_delivery");
$cash_on_delivery_settings = json_decode($cash_on_delivery_settings);

$paypal_settings = get_payment_settings("paypal");
$paypal_settings = json_decode($paypal_settings);

$stripe_settings = get_payment_settings("stripe");
$stripe_settings = json_decode($stripe_settings);

?>

<!-- MAIN CONTENT -->
<style>
    #item-list .d-flex.p-1,#item-list .product-price img{
        display:none!important;
    }
    .disabled {
        pointer-events: none;
        /* Prevent clicks */
        opacity: 0.5;
        /* Make it look disabled */
        cursor: not-allowed;
        /* Change cursor to indicate it's not clickable */

    }

    @media (max-width: 768px) {
        .detail-wbox {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding: 0 !important;
        }

        .payment-text {
            font-size: medium;

        }

        .delivery-text {
            font-size: large;
        }

    }

    /* .order-delivery-types{
    display:none;
} */
</style>
<section class="detail-wbox mt-4 mb-2 p-5 d-flex justify-content-around">
    <div class="container bg-white text-dark border border-light p-5 w-75">
        <ul class="d-flex justify-content-between align-item-center billing-list-topbar p-0">
            <li class="billing acitve">
                <div class="img-box text-center red">Customer <img class="billing-active"
                        src="<?php echo base_url('assets/frontend/default/images/billing-list-icon-acitve.png') ?>" />
                    <img class="billing-notactive"
                        src="<?php echo base_url('assets/frontend/default/images/billing-list-icon.png') ?>" />
                </div>
            </li>
            <li class="payment">
                <div class="img-box text-center">Address Info <img class="billing-active"
                        src="<?php echo base_url('assets/frontend/default/images/billing-list-icon-acitve.png') ?>" />
                    <img class="billing-notactive"
                        src="<?php echo base_url('assets/frontend/default/images/billing-list-icon.png') ?>" />
                </div>
            </li>
            <li class="order last">
                <div class="img-box text-center">Payment
                    <img class="billing-active"
                        src="<?php echo base_url('assets/frontend/default/images/billing-list-icon-acitve.png') ?>" />
                    <img class="billing-notactive"
                        src="<?php echo base_url('assets/frontend/default/images/billing-list-icon.png') ?>" />
                </div>
            </li>
        </ul>
        <div id="billing-address">
            <h4 class="mt-5 text-dark">Customer Details</h4>

            <form id="billing-form" onsubmit="submitForm(); return false;" method="POST" autocomplete="off">
                <div class="form-row mt-4">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">First Name *</label>
                        <input type="text" class="form-control" id="txtfname" name="first_name" required
                            placeholder="Enter first name..." value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Last Name *</label>
                        <input type="text" id="txtlname" class="form-control" name="last_name" required
                            placeholder="Enter last name..." value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Mobile *</label>
                        <input type="tel" class="form-control" name="phone_mobile" id="mobile" required
                            placeholder="Enter mobile..." pattern="^(\+447\d{9}|07\d{9})$" value=""
                            title="Please enter a valid mobile number starting with +447 or 07 followed by 9 digits">
                        <small>Format: +44 7123 456 789 or 07123 456 789</small><br>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="inputAddress">Email *</label>
                        <input type="email" class="form-control" name="email" id="email" required
                            value="" placeholder="Enter email...">
                    </div>
                </div>

                <div class="form-row">


                    <div class="form-group col-md-6 d-none" id="collection-time">
                        <label for="inputPassword4">Collection Time (Optional)</label>
                        <input type="text" class="form-control" name="collection_time" placeholder="Wednesday 12:30">
                    </div>

                </div>

                <!-- <div class="form-group">
                    <label>Note for Delivery: </label>
                    <textarea class="form-control" name="note" placeholder="Details" rows="5"></textarea>
                </div> -->

                <button type="submit" class="rr-btn border-0 mt-4">Go to next step: Address Details</button>
            </form>
        </div>

        <div id="payment-option">
            <h4 class="mt-5 text-dark"><span class="order_type">Delivery</span> Address</h4>

            <form id="address-form" onsubmit="submitAddressForm(); return false;" autocomplete="off">
                <div class="form-row mt-4">
                    <div class="form-group col-md-6">

                        <label for="inputAddress">Enter Your Address*</label>
                        <input type="text" name="additional_address" class="form-control" id="to" required
                            placeholder="Enter Your Address">

                        <small class="text-danger d-none" id="not-deliever"> Address not in deliverable range </small>
                        <input type="hidden" placeholder="Latitude" id="lat_to">
                        <input type="hidden" placeholder="Longitude" id="long_to">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Zipcode*</label>
                        <input type="text" name="zipcode" class="form-control" id="city" placeholder="Zipcode" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">House/Flat Number*</label>
                        <input type="text" class="form-control" name="street" placeholder="House/Flat Number" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Street Name*</label>
                        <input type="text" class="form-control" id="street-value" name="zip_code" placeholder="Street Number" required>
                    </div>
                    <!-- <div class="form-group col-md-6">
                        <label for="inputAddress">City</label>
                        <input type="text" name="city" class="form-control" id="city" placeholder="City">
                    </div> -->

                    <!-- <div class="form-group col-md-6">
                <label for="inputPassword4">Country</label>
                <input type="text" name="country" class="form-control" placeholder="Country" value="London" disabled>
            </div> -->

                </div>

                <div class="form-row">

                    <div class="form-group col-md-12" id="additional-delivery-notes">
                        <label for="inputPassword4">Any Additional Delivery Instructions</label>
                        <textarea name="number" class="form-control" placeholder="No"></textarea>
                    </div>
                    <!-- <div class="form-group col-md-6">
                    <label for="inputAddress">Post Code *</label>

                    <input type="text" class="form-control" name="zip_code" id="post" required placeholder="Code"
                        minlength="7" maxlength="8" pattern="[A-Za-z0-9]+"
                        title="Only alphanumeric characters are allowed (no special characters)">

                </div> -->

                </div>


                <div class="form-check mt-4 d-flex">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1"><strong>The shipping address does not
                            match
                            the
                            billing address</strong></label>
                </div>

                <button id="checking" type="submit" class="rr-btn border-0 mt-4 disabled">Go to next step: Place Order</button>
                <!-- <button id="calculate_distance">Calculate Distance</button> -->

            </form>
        </div>

        <div id="your-address">
            <!-- <h4 class="mt-5 text-dark"><?php //echo site_phrase('choose_way_of_payment', true); 
                                            ?></h4> -->

            <!-- <pre><php print_r($this->session->all_userdata()); ?></pre> -->
            <?php if (
                $this->session->userdata('customer_login') ||
                $this->session->userdata('owner_login') ||
                $this->session->userdata('user_id') ||
                $this->session->userdata('guest_checkout')
            ) :  ?>


                <!-- <pre><php print_r($this->session->all_userdata()); ?></pre> -->



                <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>
                <?php
                $restaurant_ids = $this->cart_model->get_restaurant_ids();
                if (count($restaurant_ids) > 0) : ?>
                    <div class="row justify-content-center">
                        <div class="col-md-12 responsive-wrap">
                            <div class="booking-checkbox_wrap">
                                <div class="row">

                                    <div class="col-md-6 payment-gateways">
                                        <h4 class="delivery-text"><span class="order_type">Delivery</span> Address</h4>
                                        <span id="show-address"></span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <h4 class="payment-text">Choose Payment Method To Proceed</h4>


                                        <!-- ORDER DELIVERY TYPE -->

                                        <!-- <tr>
                                    <td>
                                        <div class="order-delivery-types">
                                            <input id="delivery" type="radio" name="order_type" value="delivery"
                                                onchange="$('#order-type').text('<?php //echo site_phrase('delivery'); 
                                                                                    ?>'); $('.order_type').val('delivery'); loadFetchedUrl(); $('.delivery-order').removeClass('d-none'); $('.pickup-order').addClass('d-none');"
                                                <?php //if ($order_type == "delivery") echo "checked"; 
                                                ?> />
                                            <label class="order-delivery-type-label order-type-delivery" for="delivery">
                                                <div class="order-type-overlay">
                                                    <p>
                                                        <?php //echo site_phrase('delivery'); 
                                                        ?>
                                                    </p>
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <?php

                                        // $pickup_order_status = 0; if (count($restaurant_ids) == 1 && pickup_order_availability($restaurant_ids[0])) { $pickup_order_status = 1; }
                                        ?>
                                        <div class="order-delivery-types">
                                            <input id="pickup" type="radio" name="order_type" value="pickup"
                                                onchange="$('#order-type').text('<?php //echo site_phrase('pickup'); 
                                                                                    ?>'); $('.order_type').val('pickup'); loadFetchedUrl(); $('.delivery-order').addClass('d-none'); $('.pickup-order').removeClass('d-none');"
                                                <?php //if ($order_type == "pickup") echo "checked"; 
                                                ?>
                                                <?php //if (!$pickup_order_status) echo 'disabled'; 
                                                ?> />
                                            <label class="order-delivery-type-label order-type-pickup" for="pickup">
                                                <div class="order-type-overlay">
                                                    <p>
                                                        <?php //echo site_phrase('Pickup'); 
                                                        ?>
                                                    </p>
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr> -->


                                        <!-- CASH ON DELIVERY FORM -->
                                        <?php if ($cash_on_delivery_settings[0]->active) {
                                            include "cash_on_delivery/cash_on_delivery_form.php";
                                        } ?>

                                        <!-- STRIPE FORM -->
                                        <?php if ($stripe_settings[0]->active) {
                                            include "stripe/stripe_form.php";
                                        } ?>

                                        <!-- PAYPAL FORM -->
                                        <?php if ($paypal_settings[0]->active) {
                                            include "paypal/paypal_form.php";
                                        } ?>
                                        <!-- <div class="featured-btn-wrap text-right col-12 p-0">
                                            <button
                                                onclick="redirect()"
                                                class="btn btn-dark btn-sm pl-5 pr-5 pt-3 pb-3 w-100 rr-btn border-0 mt-2"><?php echo site_phrase('proceed', true); ?></button>
                                        </div> -->

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    <?php else : ?>
        <div class="row justify-content-md-center">
            <div class="col-md-12 responsive-wrap">
                <div class="booking-checkbox_wrap mb-2">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <img src="<?php echo base_url('assets/frontend/default/images/empty-cart.png'); ?>"
                                class="img-fluid" alt="<?php echo "empty-cart-logo"; ?>">
                            <span class="d-block mt-2"><?php echo site_phrase('you_got_nothing_to_order'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php else : ?>
    <div class="text-center">
        <h5><?php echo site_phrase('user_is_not_logged_in'); ?></h5>
    </div>
<?php endif; ?>
<!-- </form> -->
    </div>
    </div>

    <div class="order-summery-box d-none d-md-block" id="order-summary">
        <div>
            <h3>Order Summary</h3>
            <p class="green">You're all set</p>

            <div id="item-list">

            </div>

            <div class="c-basketSwitcher u-spacingBottom d-flex align-items-center justify-content-between my-4">
                <label class="c-basketSwitcher-switch d-flex align-items-center justify-content-between">
                    <input type="radio" name="basket-switcher" value="delivery" checked="checked"
                        class="is-visuallyHidden"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <g clip-path="url(#clip0_4609_18686)">
                            <path
                                d="M5 21C6.65685 21 8 19.6569 8 18C8 16.3431 6.65685 15 5 15C3.34315 15 2 16.3431 2 18C2 19.6569 3.34315 21 5 21Z"
                                stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M19 21C20.6569 21 22 19.6569 22 18C22 16.3431 20.6569 15 19 15C17.3431 15 16 16.3431 16 18C16 19.6569 17.3431 21 19 21Z"
                                stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 19V15L9 12L14 8L16 11H19" stroke="black" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M17 6C17.5523 6 18 5.55228 18 5C18 4.44772 17.5523 4 17 4C16.4477 4 16 4.44772 16 5C16 5.55228 16.4477 6 17 6Z"
                                stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clippath id="clip0_4609_18686">
                                <rect width="24" height="24" fill="white" />
                            </clippath>
                        </defs>
                    </svg>
                    <div class="c-basketSwitcher-eta-wrapper"><span>
                            Delivery<br />
                        </span> <span class="c-basketSwitcher-eta">
                            from 7:35
                        </span></div>
                </label> <label class="c-basketSwitcher-switch d-flex align-items-center justify-content-between"><input
                        type="radio" name="basket-switcher" value="collection" class="is-visuallyHidden"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                        <g clip-path="url(#clip0_4609_18694)">
                            <path
                                d="M18 20C19.3807 20 20.5 18.8807 20.5 17.5C20.5 16.1193 19.3807 15 18 15C16.6193 15 15.5 16.1193 15.5 17.5C15.5 18.8807 16.6193 20 18 20Z"
                                stroke="#F2F2F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M6.5 8V19C6.50019 19.2107 6.56691 19.4159 6.69063 19.5864C6.81436 19.7569 6.98877 19.884 7.18899 19.9495C7.3892 20.015 7.605 20.0156 7.80558 19.9513C8.00617 19.8869 8.1813 19.7608 8.306 19.591L12 14.5V14.555"
                                stroke="#F2F2F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M6.5 8H21.5L18 15L10.9 14.253C10.1757 14.1769 9.48595 13.9045 8.90511 13.4651C8.32427 13.0258 7.87439 12.4362 7.604 11.76L4.751 4.63C4.67702 4.44425 4.54906 4.28494 4.38364 4.17264C4.21822 4.06034 4.02294 4.00021 3.823 4H2.5"
                                stroke="#F2F2F2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clippath id="clip0_4609_18694">
                                <rect width="24" height="24" fill="white" transform="translate(0.5)" />
                            </clippath>
                        </defs>
                    </svg>
                    <div class="c-basketSwitcher-eta-wrapper"><span>
                            Collection<br />
                            15 Minutes
                        </span></div>
                </label>
            </div>

            <div class="total-price-box d-flex justify-content-between align-items-center">
                <div class="subtotal">Subtotal</div>
                <div class="subtotal-price"></div>
            </div>

            <div class="total-price-box d-flex justify-content-between align-items-center">
                <div class="subtotal">Delivery Charges</div>
                <div class="total-delivery-price">x</div>
            </div>

            <div class="total-price-box d-none justify-content-between align-items-center">
                <div class="subtotal">VAT Charges</div>
                <div class="total-vat-price"></div>
            </div>

            <div class="total-price-box d-flex justify-content-between align-items-center">
                <div class="subtotal">Service Charges</div>
                <div class="total-service-price"></div>
            </div>

            <?php
            $cart_items = $this->cart_model->get_cart_by_condition(['customer_id' => $this->session->userdata('user_id'), 'restaurant_id' => sanitize($restaurant_details['id'])]);
            ?>

            <hr />
            <?php if (sizeof($cart_items) > 0) { ?>
                <div class="row justify-content-md-end">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="promo_code">Promo Code</label>
                            <div class="d-flex gap-2 justify-content-center">
                                <input type="text" class="form-control" id="promo_code" name="promo_code"
                                    value="<?php echo $cart_items[0]['offer_code'] ?>" required>
                                <?php if (isset($cart_items[0]['offer_code'])) { ?>
                                    <div class="btn btn-sm btn-danger m-2" onclick="remove_promo()">
                                        <i class="fa fa-times"></i>
                                    </div>
                                <?php } ?>
                                <div class="btn btn-sm btn-danger m-2" id="remove_promo" style="display:none"
                                    onclick="remove_promo()">
                                    <i class="fa fa-times"></i>
                                </div>
                            </div>
                            <small id="promo_code_message"></small> <!-- Container for messages -->
                            <?php if (isset($cart_items[0]['offer_code'])) { ?>
                                <small class="text-success">Promo is already applied.</small>
                                <!-- Container for messages -->
                            <?php } else { ?>
                                <div class="btn btn-sm btn-warning w-100 mt-2 text-dark" id="apply_promo"
                                    onclick="apply_promo_action()">APPLY COUPON CODE
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- <div class="offer-spend my-3">Offer Spend £28.05 more to get 10% off</div> -->

            <div class="day-time-box my-4 p-2">

                <div class="d-flex align-items-center justify-content-between mb-2">
                    Day <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <g clip-path="url(#clip0_4609_18708)">
                            <path
                                d="M11.795 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V7C3 6.46957 3.21071 5.96086 3.58579 5.58579C3.96086 5.21071 4.46957 5 5 5H17C17.5304 5 18.0391 5.21071 18.4142 5.58579C18.7893 5.96086 19 6.46957 19 7V11"
                                stroke="#F54748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M18 22C20.2091 22 22 20.2091 22 18C22 15.7909 20.2091 14 18 14C15.7909 14 14 15.7909 14 18C14 20.2091 15.7909 22 18 22Z"
                                stroke="#F54748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 3V7" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M7 3V7" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M3 11H19" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M18 16.4961V18.0001L19 19.0001" stroke="#F54748" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clippath id="clip0_4609_18708">
                                <rect width="24" height="24" fill="white" />
                            </clippath>
                        </defs>
                    </svg>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    Time <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <g clip-path="url(#clip0_4609_18717)">
                            <path
                                d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                                stroke="#F54748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 12L15 10" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M12 7V12" stroke="#F54748" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clippath id="clip0_4609_18717">
                                <rect width="24" height="24" fill="white" />
                            </clippath>
                        </defs>
                    </svg>
                </div>

            </div>

            <div class="total-price-box d-flex justify-content-between align-items-center">
                <div class="subtotal">Total</div>

                <div class="grand-product-price"></div>
            </div>

            <?php $restaurant_ids = $this->cart_model->get_restaurant_ids(); ?>
            <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>



            <!-- <a href="<?php echo base_url('cart'); ?>" class="d-block order-red-btn text-center mt-4">Order
                        Now!</a> -->
        </div>
    </div>
</section>

<script>
    // var checking = $("#")
</script>

<!-- END MAIN CONTENT -->