<style>.options-list{padding-left:20px;}.options-list ul {padding-left:10px;}</style>
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
            <div class="price-box d-flex justify-content-between">

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

                    <!-- Check for variants -->
                    <ul class="options-list">
                    <?php 

                    if (!empty($cart_item['options_1_details'])) {
                        
                        $currentGroupID = null;
                        
                        foreach ($cart_item['options_1_details'] as $option) { 

                           // Meaning that this is the last option or the next option belongs to a different group, we close the list.
                            if($currentGroupID != null && $currentGroupID != $option['group']['id']) {
                                echo "</ul>";
                            }   

                            // Meaning that this option has a group associated with it.
                            if($option['group']['id'] != null) {
                                // Meaning that this is the first option or the group has changed from the previous option, we print the group name.
                                if($currentGroupID != $option['group']['id']) {
                                    echo "<li><strong>".$option['group']['name']."</strong></li>";
                                    echo "<ul>";
                                    // Change the Group ID to the current one.
                                    $currentGroupID = $option['group']['id'] ?? null;
                                }
                            }
                            
                            $variantName   = $option['variantName'] ?? '';
                            $selectedOption = $option['subOptionName'] ?? '';

                            echo "<li>".$selectedOption. "</li>";

                         

                        }
                    }

                    ?>
                    </ul>
                    


                </div>

                <!-- Cart Buttons -->
                <div class="d-flex p-1">
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

                <!-- Price -->
                <div class="product-price">
                    <img src="<?php echo base_url('assets/frontend/default/images/cart-red.png') ?>" />
                    <span id="sub-total-<?= sanitize($cart_item['id']) ?>">
                        <?php echo currency(sanitize($cart_item['price'])); ?>
                    </span>
                </div>

            </div>

<?php
        endforeach;
    endforeach;
endif;
?>