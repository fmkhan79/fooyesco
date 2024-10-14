<?php
$restaurant_ids = $this->cart_model->get_restaurant_ids();
if (count($restaurant_ids) > 0):
    foreach ($restaurant_ids as $restaurant_id):
        $restaurant_details = $this->restaurant_model->get_by_id($restaurant_id);
?>
    <?php
    $cart_items = $this->cart_model->get_cart_by_condition(['customer_id' => $this->session->userdata('user_id'), 'restaurant_id' => sanitize($restaurant_details['id'])]);
    $c = 1;
    foreach ($cart_items as $cart_item):
    ?>
        <div class="price-box d-flex justify-content-between align-items-center">
            <div class="product-tile">
                <span><?php echo sanitize($cart_item['quantity']); ?> x <?php echo sanitize($cart_item['menu_name']); ?></span>
                <?php 
                // Display options_1_details if available
                if (!empty($cart_item['options_1_details'])):
                ?>
                    <ul class="options-list">
                    <?php foreach ($cart_item['options_1_details'] as $option): ?>
                        <li><?php echo $option['subOptionName']; ?></li>
                    <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="product-price">
                <img src="<?php echo base_url('assets/frontend/default/images/cart-red.png') ?>" />
                <span><?php echo currency(sanitize($cart_item['price'])); ?></span>
            </div>
        </div>
    <?php $c++;
    endforeach; ?>
<?php endforeach; ?>
<?php endif; ?>
