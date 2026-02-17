<?php
    items_menu();
    
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
        // ==========================
        // 🔥 Dynamic Addon Logic
        // ==========================

        $pizzas = [];
        $extras = [];

        if (!empty($cart_item['options_1_details'])) {

            foreach ($cart_item['options_1_details'] as $opt) {

                $variantName   = $opt['variantName'] ?? '';
                $subOptionName = $opt['subOptionName'] ?? '';

                // Dynamic Pizza Detection (Pizza 1, Pizza 2, Pizza 3...)
                if (preg_match('/Pizza\s*(\d+)/i', $variantName, $matches)) {

                    $pizzaNumber = $matches[1];
                    $pizzas[$pizzaNumber][] = $subOptionName;

                } else {

                    $extras[] = $subOptionName;
                }
            }
        }
?>

        <!-- 🔥 Display Dynamic Pizzas -->
        <?php if (!empty($pizzas)): ?>
            <?php foreach ($pizzas as $number => $items): ?>
                <ul class="options-list">
                    <li><strong>Pizza <?= $number ?></strong></li>
                    <?php foreach ($items as $item): ?>
                        <li><?= html_entity_decode(sanitize($item)) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- 🔥 Display Extras -->
        <?php if (!empty($extras)): ?>
            <ul class="options-list">
                <li><strong>Extras</strong></li>
                <?php foreach ($extras as $item): ?>
                    <li><?= html_entity_decode(sanitize($item)) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Variant Display -->
      <?php
$variant = null; // 🔥 reset every loop

if (!empty($cart_item['variant_id'])) {

    $variant = $this->cart_model->get_variant_details($cart_item['variant_id']);

    if (!empty($variant) && !empty($variant->name)):
?>
        <p class="text-muted" style="font-size: 12px;">
            Selected: <?= html_entity_decode(sanitize($variant->name)) ?>
        </p>
<?php
    endif;
}
?>


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

?>
