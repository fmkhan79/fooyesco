<?php
$restaurant_ids = $this->cart_model->get_restaurant_ids();
if (count($restaurant_ids) > 0):
    foreach ($restaurant_ids as $restaurant_id):
        $restaurant_details = $this->restaurant_model->get_by_id($restaurant_id);
        ?>
<div class="booking-checkbox_wrap">
    <div class="row">
        <div class="col-sm-7">
            <h2 class="text-left text-theme-dark red">
                <a href="<?php echo site_url('site/restaurant/' . rawurlencode(sanitize($restaurant_details['slug'])) . '/' . sanitize($restaurant_details['id'])); ?>"
                    class="restaurant-name">
                    <?php echo sanitize($restaurant_details['name']); ?>
                </a>
            </h2>
        </div>
        <div class="col-sm-5">
            <span class="cart-page-restaurant-delivery-details d-flex">
                <!-- <div>
                            <.?php echo site_phrase('delivery_charge'); ?> : <strong>
                                <.?php echo delivery_charge($restaurant_details['id']) > 0 ? currency(sanitize(delivery_charge($restaurant_details['id']))) : site_phrase('free'); ?>
                            </strong>
                        </div> -->
                <div class="ml-5">
                    <?php echo site_phrase('maximum_time_to_deliver'); ?> : <strong>
                        <?php echo sanitize(maximum_time_to_deliver($restaurant_details['id'])); ?>
                    </strong>
                </div>
            </span>
        </div>
    </div>
    <hr />
    <div class="row mb-1">
        <div class="col-md-1">
            <span>Item</span>
        </div>
        <div class=" col-md-4">

        </div>
        <div class="col-md-3">
            Quanity
        </div>
        <div class="col-md-2">
            Price
        </div>
    </div>
    <hr>
    <div class="booking-checkbox">
        <?php
                $cart_items = $this->cart_model->get_cart_by_condition(['customer_id' => $this->session->userdata('user_id'), 'restaurant_id' => sanitize($restaurant_details['id'])]);
                // var_dump($cart_items[0]);
                foreach ($cart_items as $cart_item): ?>
        <div class="row mb-1">
            <div class="col-md-1">
                <img src="<?php echo base_url('uploads/menu/' . sanitize($cart_item['menu_thumbnail'])); ?>"
                    class="cart-page-menu-thumbnail img-thumbnail" alt="">
            </div>
            <div class=" col-md-4">
                <div class="cart-page-menu-title">
                    <?php echo sanitize($cart_item['menu_name']); ?>
                </div>
            </div>
            <div class="col-md-2">
                <div class="cart-page-menu-quantity float-sm-left">
                    <span id="cart-quantity-<?php echo sanitize($cart_item['id']); ?>">
                        <?php echo sanitize($cart_item['quantity']); ?>
                    </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="cart-page-menu-sub-total float-sm-right">
                    <span id="sub-total-<?php echo sanitize($cart_item['id']); ?>">
                        <?php echo currency(sanitize($cart_item['price'])); ?>
                    </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="cart-page-actions float-lg-right">
                    <button type="button" class="btn btn-default btn-circle cart-actions"
                        onclick="updateCart('<?php echo sanitize($cart_item['id']); ?>', true)"><i
                            class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-circle cart-actions"
                        onclick="updateCart('<?php echo sanitize($cart_item['id']); ?>', false)"><i
                            class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-circle cart-actions"
                        onclick="confirm_modal_withoutPopup('<?php echo site_url('cart/delete/' . sanitize($cart_item['id'])); ?>')"><i
                            class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>
<div class="booking-checkbox_wrap mt-2" id="cart-summary">
    <!--Promo Code Field -->
    <?php if(sizeof($cart_item) > 0) { ?>
    <div class="row justify-content-md-end">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="promo_code">Promo Code</label>
                <div class="d-flex gap-2 justify-content-center">
                    <input type="text" class="form-control" id="promo_code" name="promo_code"
                        value="<?php echo $cart_items[0]['offer_code'] ?>" required>
                    <?php if(isset($cart_items[0]['offer_code'])){ ?>
                    <div class="btn btn-sm btn-danger m-2" onclick="remove_promo()">
                        <i class="fa fa-times"></i>
                    </div>
                    <?php } ?>
                    <div class="btn btn-sm btn-danger m-2" id="remove_promo" style="display:none" onclick="remove_promo()">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <small id="promo_code_message"></small> <!-- Container for messages -->
                <?php if(isset($cart_items[0]['offer_code'])){ ?>
                <small class="text-success">Promo is already applied.</small> <!-- Container for messages -->
                <?php } else { ?>
                <div class="btn btn-sm btn-warning w-100 mt-2 text-dark" id="apply_promo" onclick="apply_promo_action()">APPLY COUPON CODE
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php include 'summary.php'; ?>
</div>
<?php else: ?>
<div class="booking-checkbox_wrap mb-2">
    <div class="row">
        <div class="col-sm-12 text-center">
            <?php if ($this->session->flashdata('confirm_order')): ?>
            <h5>
                <?php echo site_phrase('congratulations'); ?>!
            </h5>
            <img src="<?php echo base_url('assets/frontend/default/images/tick.png'); ?>" class="img-fluid success-tick" height="72"
                alt="<?php echo "success-logo"; ?>">
            <span class="d-block mt-2">
                <?php echo site_phrase('your_order_has_been_placed_successfully'); ?>.
            </span>
            <span class="d-block mt-2">
                                <!-- <?php // echo site_phrase('check_your_order_status'); ?> <a href="<?php // echo site_url('orders/today'); ?>"> -->
                    <!-- <php echo strtolower(site_phrase('here')); ?>. -->
                <!-- </a> -->
            </span>
            <?php else: ?>
            <section class="detail-wbox mt-4 mb-2">
                <div class="container bg-white text-dark border border-light">
                    <h4 class="mt-5 mb-5 text-dark">Empty Cart</h4>
                    <div class="wishlist-txt text-center my-4">
                        <img class="my-5 img-fluid"
                            src="<?php echo base_url('assets/frontend/default/images/empty-cart-img.png'); ?>"
                            alt="<?php echo "empty-cart-logo"; ?>" />
                        <p class="my-4"></p>
                        <a href="<?php echo site_url('site/restaurants/popular'); ?>" class="rr-btn">Continue
                            Shopping</a>
                    </div>
                </div>
            </section>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<section class="dt-hide"><img class="img-fluid"
        src="<?php echo base_url('assets/frontend/default/images/footer-mob-img.png'); ?>" /></section>
<section class="footer-top mt-4">
    <div class="container-fluid">
        <div class="d-md-flex ">
            <div class="col-md-6">
                <h3>It's Now <span class="red">More Easy</span> to <span class="yellow">Order</span> by Our Mobile <span
                        class="red">App</span></h3>
                <p>All you need to do is downlode one of the best delivery apps, make a and most companies are opting
                    for mobile app devlopment for food delivery</p>
                <div class="google-btns"><a href="#" class="goole-play-btn"><img
                            src="<?php echo base_url('assets/frontend/default/images/google-play-icon.png'); ?>" /></a>
                    <a href="#"><img
                            src="<?php echo base_url('assets/frontend/default/images/app-store-icon.png'); ?>" /></a>
                </div>
            </div>
            <div class="col-md-6 mob-hide"><img class="img-fluid"
                    src="<?php echo base_url('assets/frontend/default/images/footer-top-img.png'); ?>" /></div>
        </div>
    </div>
</section>