<style>.options-list{padding-left:20px;}.options-list ul {padding-left:10px;}.var_options li {font-size:14px;}</style>
<?php
$restaurant_ids = $this->cart_model->get_restaurant_ids();
if (count($restaurant_ids) > 0):
    foreach ($restaurant_ids as $restaurant_id):

        $restaurant_details = $this->restaurant_model->get_by_id($restaurant_id);

        $cart_items = $this->cart_model->get_cart_by_condition([
            'customer_id'  => $this->session->userdata('user_id'),
            'restaurant_id' => sanitize($restaurant_details['id'])
        ]);

        foreach ($cart_items as $cart_item):
        
?>

            <div class="d-flex price-box justify-content-between">
                <div class="product-tile">
                    <span>
                        <span id="cart-quantity-<?php echo sanitize($cart_item['id']); ?>">
                            <?php echo sanitize($cart_item['quantity']); ?>
                        </span>
                        x <?php echo html_entity_decode(sanitize($cart_item['menu_name'])); ?>
                    </span>
                    <?php
                    $variant = null; 

                    if (!empty($cart_item['variant_id'])) {

                        $variant = $this->cart_model->get_variant_details($cart_item['variant_id']);

                        if (!empty($variant) && !empty($variant->name)):
                    ?>

                            <p class="text-muted" style="font-size: 14px;line-height:normal;margin-bottom:0px;">
                                <?= html_entity_decode(sanitize($variant->name)) ?>
                            </p>
                    <?php
                        endif;
                    }
                    ?>
                </div>
                <div class="d-flex">
                    <button type="button"
                        class="cart-actions mr-1 cart-btns"
                        onclick="updateCart('<?php echo sanitize($cart_item['id']); ?>', true)">
                        <i class="fas fa-plus"></i>
                    </button>

                    <button type="button"
                        class="cart-actions mr-1 cart-btns"
                        onclick="updateCart('<?php echo sanitize($cart_item['id']); ?>', false)">
                        <i class="fas fa-minus"></i>
                    </button>

                    <button type="button"
                        class="cart-actions mr-1 cart-btns"
                        onclick="confirm_modal_withoutPopup('<?php echo site_url('cart/delete/' . sanitize($cart_item['id'])); ?>',this)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                 <div class="product-price">
                    <img src="<?php echo base_url('assets/frontend/default/images/cart-red.png') ?>" />
                    <span id="sub-total-<?= sanitize($cart_item['id']) ?>">
                        <?php echo currency(sanitize($cart_item['price'])); ?>
                    </span>
                </div>

            </div>
            <div class="var_options">
                <ul class="options-list">
                    <?= $cart_item['html_output_for_recipts']?>
                </ul>

            </div>
            <hr>

<?php
        endforeach;
    endforeach;
endif;
?>