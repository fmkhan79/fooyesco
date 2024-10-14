<!-- NAVIGATION BAR -->
<?php include APPPATH . 'views/frontend/default/navigation/dark.php';

$cash_on_delivery_settings = get_payment_settings("cash_on_delivery");
$cash_on_delivery_settings = json_decode($cash_on_delivery_settings);

$paypal_settings = get_payment_settings("paypal");
$paypal_settings = json_decode($paypal_settings);

$stripe_settings = get_payment_settings("stripe");
$stripe_settings = json_decode($stripe_settings);
?>
<!-- RESTAURANT TITLE HEADER -->
<div class="container-fluid">
    <div class="row">
        <div class="booking-checkbox_wrap">
            <h5><i class="far fa-credit-card"></i> <?php echo site_phrase('checkout_order', true); ?></h5>
        </div>
    </div>
</div>
<!-- MAIN CONTENT -->
<section class=" light-bg booking-details_wrap">
    <div class="container-fluid">
        <?php if ($this->session->userdata('customer_login') || $this->session->userdata('owner_login')) : ?>
            <?php $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id')); ?>

            <?php
            $restaurant_ids = $this->cart_model->get_restaurant_ids();
            if (count($restaurant_ids) > 0) : ?>
                <div class="row justify-content-center">
                    <div class="col-md-7 responsive-wrap">
                        <div class="booking-checkbox_wrap">
                            <h6><?php echo site_phrase('choose_way_of_payment', true); ?></h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-5 payment-gateways">

                                    <?php if ($cash_on_delivery_settings[0]->active) : ?>
                                        <label for="cash-on-delivery">
                                            <div class="callout callout-primary">
                                                <input type="radio" class="payment-gateway-radio" name="payment_gateway" value="cash_on_delivery" checked="" id="cash-on-delivery">
                                                <img src="<?php echo base_url('assets/payment/cash-on-delivery.png'); ?>" alt="cash-on-delivery">
                                            </div>
                                        </label>
                                    <?php endif; ?>

                                    <?php if ($paypal_settings[0]->active) : ?>
                                        <label for="paypal">
                                            <div class="callout callout-secondary">
                                                <input type="radio" class="payment-gateway-radio" name="payment_gateway" value="paypal" id="paypal">
                                                <img src="<?php echo base_url('assets/payment/paypal.png'); ?>" alt="paypal">
                                            </div>
                                        </label>
                                    <?php endif; ?>

                                    <?php if ($stripe_settings[0]->active) : ?>
                                        <label for="stripe">
                                            <div class="callout callout-secondary">
                                                <input type="radio" class="payment-gateway-radio" name="payment_gateway" value="stripe" id="stripe">
                                                <img src="<?php echo base_url('assets/payment/stripe.png'); ?>" alt="stripe">
                                            </div>
                                        </label>
                                    <?php endif; ?>
                                </div>

                                <div class="col-sm-7 text-right">
                                    <h6><?php echo site_phrase('bill_summary', true); ?></h6>
                                    <table class="bill-table">
                                        <tr>
                                            <td class="bill-type"><?php echo site_phrase('total_menu_price'); ?> :</td>
                                            <td class="bill-value"><?php echo currency(sanitize($this->cart_model->get_total_menu_price())); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="bill-type">VAT :</td>
                                            <td class="bill-value"><?php echo currency(sanitize($this->cart_model->get_vat_amount())); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="bill-type"><?php echo site_phrase('sub_total'); ?> :</td>
                                            <td class="bill-value"><?php echo currency(sanitize($this->cart_model->get_sub_total())); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="bill-type">
                                                <?php echo site_phrase('delivery_charge_for') . ' ' . count($restaurant_ids) . ' ' . site_phrase('restaurants'); ?> :
                                            </td>
                                            <td class="bill-value delivery-order"><?php echo currency(sanitize($this->cart_model->get_total_delivery_charge())); ?></td>
                                            <td class="bill-value pickup-order d-none"><?php echo currency(0); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="bill-type"><?php echo site_phrase('grand_total'); ?> :</td>
                                            <td class="bill-value delivery-order" id=""><?php echo currency(sanitize($this->cart_model->get_grand_total())); ?></td>
                                            <td class="bill-value d-none pickup-order" id=""><?php echo currency(sanitize($this->cart_model->get_grand_total()) - sanitize($this->cart_model->get_total_delivery_charge())); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="bill-type"><?php echo site_phrase('order_type'); ?> :</td>
                                            <td class="bill-value order-type" id="order-type"><?php echo site_phrase('delivery'); ?></td>
                                        </tr>
                                    </table>

                                    <!-- ORDER DELIVERY TYPE -->
                                    <table class="bill-table mt-4">
                                        <tr>
                                            <td>
                                                <div class="order-delivery-types">
                                                    <input id="delivery" type="radio" name="order_type" value="delivery" onchange="$('#order-type').text('<?php echo site_phrase('delivery'); ?>'); $('.order_type').val('delivery'); loadFetchedUrl(); $('.delivery-order').removeClass('d-none'); $('.pickup-order').addClass('d-none');" <?php if ($order_type == "delivery") echo "checked"; ?> />
                                                    <label class="order-delivery-type-label order-type-delivery" for="delivery">
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
                                                    <input id="pickup" type="radio" name="order_type" value="pickup" onchange="$('#order-type').text('<?php echo site_phrase('pickup'); ?>'); $('.order_type').val('pickup'); loadFetchedUrl(); $('.delivery-order').addClass('d-none'); $('.pickup-order').removeClass('d-none');" <?php if ($order_type == "pickup") echo "checked"; ?> <?php if (!$pickup_order_status) echo 'disabled'; ?> />
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
                                                    <button onclick="window.location.replace('<?php echo site_url('cart'); ?>');" class="btn btn-dark btn-sm pl-5 pr-5 pt-2 pb-2 w-100"><?php echo site_phrase('back_to_my_cart', true); ?></button>
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
                                    <img src="<?php echo base_url('assets/frontend/default/images/empty-cart.png'); ?>" class="img-fluid" alt="<?php echo "empty-cart-logo"; ?>">
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
    </div>
</section>