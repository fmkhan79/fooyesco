<?php
$restaurant_ids = $this->cart_model->get_restaurant_ids();
if (count($restaurant_ids) > 0) :
    foreach ($restaurant_ids as $restaurant_id) :
        $restaurant_details = $this->restaurant_model->get_by_id($restaurant_id);
?>
        <div class="booking-checkbox_wrap">
            <div class="row">
                <div class="col-sm-8">
                    <h6 class="text-left">
                        <a href="<?php echo site_url('site/restaurant/' . rawurlencode(sanitize($restaurant_details['slug'])) . '/' . sanitize($restaurant_details['id'])); ?>" class="restaurant-name"><?php echo sanitize($restaurant_details['name']); ?></a>
                    </h6>
                </div>
                <div class="col-sm-4">
                    <span class="cart-page-restaurant-delivery-details">
                        <div><?php echo site_phrase('delivery_charge'); ?> : <strong><?php echo delivery_charge($restaurant_details['id']) > 0 ? currency(sanitize(delivery_charge($restaurant_details['id']))) : site_phrase('free'); ?></strong></div>
                        <div><?php echo site_phrase('maximum_time_to_deliver'); ?> : <strong><?php echo sanitize(maximum_time_to_deliver($restaurant_details['id'])); ?></strong></div>
                    </span>
                </div>
            </div>
            <hr>
            <div class="booking-checkbox">
                <?php
                $cart_items = $this->cart_model->get_cart_by_condition(['customer_id' => $this->session->userdata('user_id'), 'restaurant_id' => sanitize($restaurant_details['id'])]);
                foreach ($cart_items as $cart_item) : ?>
                    <div class="row mb-1">
                        <div class="col-md-1">
                            <img src="<?php echo base_url('uploads/menu/' . sanitize($cart_item['menu_thumbnail'])); ?>" class="cart-page-menu-thumbnail" alt="">
                        </div>
                        <div class=" col-md-3">
                            <div class="cart-page-menu-title">
                                <?php echo sanitize($cart_item['menu_name']); ?>
                            </div>
                            <div class="cart-page-menu-servings">
                                <?php echo site_phrase('servings') . ': ' . site_phrase(sanitize($cart_item['servings'])); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="cart-page-menu-unit-price float-sm-left">
                                <?php echo site_phrase('unit_price') . ': ' . currency(sanitize(get_menu_price($cart_item['menu_id'], $cart_item['servings']))); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="cart-page-menu-quantity float-sm-left">
                                <?php echo site_phrase('quantity') . ': ' . sanitize($cart_item['quantity']); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="cart-page-menu-sub-total float-sm-right">
                                <?php echo site_phrase('sub_total') . ': ' . currency(sanitize($cart_item['price'])); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="cart-page-actions float-lg-right">
                                <a class="text-black" href="javascript:void(0)" onclick="showCartModal('<?php echo site_url('modal/showup/cart/edit/' . sanitize($cart_item['id'])); ?>', '<?php echo site_phrase('update_item'); ?>')"><i class="ti-pencil-alt"></i></a>
                                <a class="text-danger" href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('cart/delete/' . sanitize($cart_item['id'])); ?>')"><i class="ti-trash"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="booking-checkbox_wrap mt-2">
        <div class="row justify-content-md-end">
            <div class="col-sm-8 text-right">
                <h6><?php echo site_phrase('total_bill', true); ?></h6>
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
                        <td class="bill-value"><?php echo currency(sanitize($this->cart_model->get_total_delivery_charge())); ?></td>
                    </tr>
                    <tr>
                        <td class="bill-type"><?php echo site_phrase('grand_total'); ?> :</td>
                        <td class="bill-value"><?php echo currency(sanitize($this->cart_model->get_grand_total())); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <form action="<?php echo site_url('checkout'); ?>" method="get">
                                <input type="hidden" name="address_number" id="address-number" value="">
                                <div class="featured-btn-wrap text-right mt-3"><button type="submit" class="btn btn-danger btn-sm pl-5 pr-5 pt-2 pb-2"><?php echo site_phrase('checkout_order', true); ?></button></div>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="booking-checkbox_wrap mb-2">
        <div class="row">
            <div class="col-sm-12 text-center">
                <?php if ($this->session->flashdata('confirm_order')) : ?>
                    <h5><?php echo site_phrase('congratulations'); ?>!</h5>
                    <img src="<?php echo base_url('assets/frontend/default/images/tick.png'); ?>" class="img-fluid success-tick" alt="<?php echo "success-logo"; ?>">
                    <span class="d-block mt-2"><?php echo site_phrase('your_order_has_been_placed_successfully'); ?>.</span>
                    <span class="d-block mt-2"><?php echo site_phrase('check_your_order_status'); ?> <a href="<?php echo site_url('orders/today'); ?>"><?php echo strtolower(site_phrase('here')); ?>.</a></span>
                <?php else : ?>
                    <img src="<?php echo base_url('assets/frontend/default/images/empty-cart.png'); ?>" class="img-fluid" alt="<?php echo "empty-cart-logo"; ?>">
                    <span class="d-block mt-2"><?php echo site_phrase('you_got_nothing_to_order'); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
