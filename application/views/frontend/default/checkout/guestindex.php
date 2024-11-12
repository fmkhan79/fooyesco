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

<section class="detail-wbox mt-4 mb-2">
    <div class="container bg-white text-dark border border-light">
        <ul class="d-flex justify-content-between align-item-center billing-list-topbar p-0">
            <li class="billing acitve">
                <div class="img-box text-center red">Customer Details <img class="billing-active"
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
                <div class="img-box text-center">Payment & Order
                    <img class="billing-active"
                        src="<?php echo base_url('assets/frontend/default/images/billing-list-icon-acitve.png') ?>" />
                    <img class="billing-notactive"
                        src="<?php echo base_url('assets/frontend/default/images/billing-list-icon.png') ?>" />
                </div>
            </li>
        </ul>
        <div id="billing-address">
            <h4 class="mt-5 text-dark">Customer Details</h4>

            <form id="billing-form" onsubmit="submitForm(); return false;">
                <div class="form-row mt-4">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">First Name *</label>
                        <input type="text" class="form-control" id="" name="first_name" required
                            placeholder="Enter first name...">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Last Name *</label>
                        <input type="text" class="form-control" name="last_name" required
                            placeholder="Enter last name...">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Mobile *</label>
                        <input type="tel" class="form-control" name="phone_mobile" id="inputAddress" required
                            placeholder="Enter mobile..." pattern="^(\+447\d{9}|07\d{9})$"
                            title="Please enter a valid mobile number starting with +447 or 07 followed by 9 digits">
                        <small>Format: +44 7123 456 789 or 07123 456 789</small><br>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Email *</label>
                        <input type="text" class="form-control" id="" name="email" required
                            placeholder="Enter Email...">
                    </div>


                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Email *</label>
                        <input type="email" class="form-control" name="email" id="inputAddress" required
                            placeholder="Enter email...">
                    </div>

                    <div class="form-group col-md-6 d-none" id="collection-time">
                        <label for="inputPassword4">Collection Time (Optional)</label>
                        <input type="text" class="form-control" name="collection_time" placeholder="Wednesday 12:30">
                    </div>

                </div>

                <div class="form-group">
                    <label>Note for Delivery:</label>
                    <textarea class="form-control" name="note" placeholder="Details" rows="5"></textarea>
                </div>

                <button type="submit" class="rr-btn border-0 mt-4">Go to payments</button>
            </form>
        </div>

        <div id="payment-option">
            <h4 class="mt-5 text-dark"><span class="order_type">Delivery</span> Address</h4>

            <form id="address-form" onsubmit="submitAddressForm(); return false;">
                <div class="form-row mt-4">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Street</label>
                        <input type="text" class="form-control" name="street" placeholder="Street">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">No</label>
                        <input type="text" class="form-control" name="number" placeholder="No">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Additional Address Line 1 *</label>
                        <input type="text" name="additional_address" class="form-control" id="inputAddress" required
                            placeholder="Enter Address...">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputAddress">Zip Code *</label>
                        <input type="text" class="form-control" name="zip_code" id="inputAddress" required
                            placeholder="Code">
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">City</label>
                        <input type="text" name="city" class="form-control" id="inputAddress" placeholder="City">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Country</label>
                        <input type="text" name="country" class="form-control" placeholder="Country">
                    </div>

                </div>
                <div class="form-check mt-4 d-flex">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1"><strong>The shipping address does not match the
                            billing address</strong></label>
                </div>

                <button id="" type="submit" class="rr-btn border-0 mt-4">Save & Continue</button>
            </form>
        </div>

        <div id="your-address">
            <h4 class="mt-5 text-dark"><?php echo site_phrase('choose_way_of_payment', true); ?></h4>

            <?php if ($this->session->userdata('customer_login') || $this->session->userdata('owner_login')) : ?>
            <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>

            <?php
                    $restaurant_ids = $this->cart_model->get_restaurant_ids();
                    if (count($restaurant_ids) > 0) : ?>
            <div class="row justify-content-center">
                <div class="col-md-12 responsive-wrap">
                    <div class="booking-checkbox_wrap">
                        <div class="row">
                            <div class="col-md-7 payment-gateways">

                                <?php if ($cash_on_delivery_settings[0]->active) : ?>
                                <label for="cash-on-delivery">
                                    <div class="callout callout-primary">
                                        <input type="radio" class="payment-gateway-radio" name="payment_gateway"
                                            value="cash_on_delivery" checked="" id="cash-on-delivery">
                                        <img src="<?php echo base_url('assets/payment/cash-on-delivery.png'); ?>"
                                            alt="cash-on-delivery">
                                    </div>
                                </label>
                                <?php endif; ?>

                                <?php if ($paypal_settings[0]->active) : ?>
                                <label for="paypal">
                                    <div class="callout callout-secondary">
                                        <input type="radio" class="payment-gateway-radio" name="payment_gateway"
                                            value="paypal" id="paypal">
                                        <img src="<?php echo base_url('assets/payment/paypal.png'); ?>" alt="paypal">
                                    </div>
                                </label>
                                <?php endif; ?>

                                <?php if ($stripe_settings[0]->active) : ?>
                                <label for="stripe">
                                    <div class="callout callout-secondary">
                                        <input type="radio" class="payment-gateway-radio" name="payment_gateway"
                                            value="stripe" id="stripe">
                                        <img src="<?php echo base_url('assets/payment/stripe.png'); ?>" alt="stripe">
                                    </div>
                                </label>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-5">
                                <h4><?php echo site_phrase('bill_summary', true); ?></h4>
                                <table class="bill-table">
                                    <tr>
                                        <td class="bill-type" style="width:1px"><?php echo site_phrase('total_menu_price'); ?> :</td>
                                        <td class="bill-value">
                                            <?php echo currency(sanitize($this->cart_model->get_total_menu_price())); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bill-type" style="width:1px">VAT :</td>
                                        <td class="bill-value">
                                            <?php echo currency(sanitize($this->cart_model->get_vat_amount())); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="bill-type" style="width:1px"><?php echo site_phrase('sub_total'); ?> :</td>
                                        <td class="bill-value">
                                            <?php echo currency(sanitize($this->cart_model->get_sub_total())); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="bill-type" style="width:1px">
                                            <?php echo site_phrase('delivery_charge_for') . ' ' . count($restaurant_ids) . ' ' . site_phrase('restaurants'); ?>
                                            :
                                        </td>
                                        <td class="bill-value delivery-order">
                                            <?php echo currency(sanitize($this->cart_model->get_total_delivery_charge())); ?>
                                        </td>
                                        <td class="bill-value pickup-order d-none"><?php echo currency(0); ?></td>
                                    </tr>
                                    <tr>
                                        <?php
             $grand_total = $this->cart_model->get_grand_total();
             $discount =  $this->cart_model->get_discound_val();
             $discountAmount = 0;
             if($discount && $discount > 0){
                $discountAmount =  ($grand_total * $discount) / 100;
                }
              ?>
                                        <?php if($discountAmount > 0){ ?>
                                        <input type="hidden" name="discount_amount"
                                            value="<?php echo $discountAmount; ?>">
                                        <td class="bill-type" style="width:1px"><?php echo site_phrase('discount'); ?> :</td>
                                        <td class="bill-value font-weight-bold"><?php echo $discountAmount; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr class="text-danger">
                                        <?php $grand_total = $this->cart_model->get_grand_total(); ?>
                                        <input type="hidden" name="grand_total_code"
                                            value="<?php echo sanitize($grand_total); ?>">
                                        <td class="bill-type" style="width:1px"><?php echo site_phrase('grand_total'); ?> :</td>
                                        <td class="bill-value font-weight-bold">
                                            <?php echo currency(sanitize($grand_total)); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="bill-type" style="width:1px"><?php echo site_phrase('order_type'); ?> :</td>
                                        <td class="bill-value order-type" id="order-type">
                                            <?php echo site_phrase('delivery'); ?></td>
                                    </tr>
                                </table>

                                <!-- ORDER DELIVERY TYPE -->
                                <table class="bill-table mt-4" style='width:90%'>
                                    <tr>
                                        <td>
                                            <div class="order-delivery-types">
                                                <input id="delivery" type="radio" name="order_type" value="delivery"
                                                    onchange="$('#order-type').text('<?php echo site_phrase('delivery'); ?>'); $('.order_type').val('delivery'); loadFetchedUrl(); $('.delivery-order').removeClass('d-none'); $('.pickup-order').addClass('d-none');"
                                                    <?php if ($order_type == "delivery") echo "checked"; ?> />
                                                <label class="order-delivery-type-label order-type-delivery"
                                                    for="delivery">
                                                    <div class="order-type-overlay">
                                                        <p>
                                                            <?php echo site_phrase('delivery'); ?>
                                                        </p>
                                                    </div>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <?php

                                                        $pickup_order_status = 0;
                                                        if (count($restaurant_ids) == 1 && pickup_order_availability($restaurant_ids[0])) {
                                                            $pickup_order_status = 1;
                                                        }
                                                        ?>
                                            <div class="order-delivery-types">
                                                <input id="pickup" type="radio" name="order_type" value="pickup"
                                                    onchange="$('#order-type').text('<?php echo site_phrase('pickup'); ?>'); $('.order_type').val('pickup'); loadFetchedUrl(); $('.delivery-order').addClass('d-none'); $('.pickup-order').removeClass('d-none');"
                                                    <?php if ($order_type == "pickup") echo "checked"; ?>
                                                    <?php if (!$pickup_order_status) echo 'disabled'; ?> />
                                                <label class="order-delivery-type-label order-type-pickup" for="pickup">
                                                    <div class="order-type-overlay">
                                                        <p>
                                                            <?php echo site_phrase('Pickup'); ?>
                                                        </p>
                                                    </div>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <!-- CASH ON DELIVERY FORM -->
                                            <?php if ($cash_on_delivery_settings[0]->active) {
                                                            include "cash_on_delivery/cash_on_delivery_form.php";
                                                        } ?>

                                            <!-- PAYPAL FORM -->
                                            <?php if ($paypal_settings[0]->active) {
                                                            include "paypal/paypal_form.php";
                                                        } ?>

                                            <!-- STRIPE FORM -->
                                            <?php if ($stripe_settings[0]->active) {
                                                            include "stripe/stripe_form.php";
                                                        } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="featured-btn-wrap text-right">
                                                <button
                                                    onclick="window.location.replace('<?php echo site_url('cart'); ?>');"
                                                    class="btn btn-dark bg-warning btn-sm pl-5 pr-5 pt-2 pb-2 w-100 rr-btn border-0 mt-2"><?php echo site_phrase('back_to_my_cart', true); ?></button>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
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

    </div>
</section>

<!-- END MAIN CONTENT -->