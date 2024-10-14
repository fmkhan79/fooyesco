<?php
$menu_details = $this->menu_model->get_by_id($param2);
if ($menu_details['has_variant']) {
    $variant_options = $this->variation_model->get_options($param2);
}
$addons = $this->addon_model->get_addons($param2);
?>

<!--Body-->
<div class="row">
    <div class="col-md-7">
        <input type="hidden" name="menu-id" id="menu-id" value="<?php echo sanitize($menu_details['id']); ?>">
        <input type="hidden" name="variant-id" id="variant-id" value="">
        <input type="hidden" name="addons" id="addons" value="">
        <!-- VARIANTS -->
        <?php if ($menu_details['has_variant']) : ?>
            <div class="variant-area">
                <?php foreach ($variant_options as $variant_option) : ?>
                    <div class="each-variant">
                        <div class="variant-name">
                            <i class="fas fa-paw"></i> <?php echo ucfirst(sanitize($variant_option['name'])); ?>:
                        </div>
                        <?php $options = explode(',', $variant_option['options']); ?>
                        <?php foreach ($options as $option) : ?>
                            <input type="radio" id="<?php echo sanitize($variant_option['id']); ?>-<?php echo sanitize($option); ?>" name="<?php echo sanitize($variant_option['name']); ?>" value="<?php echo sanitize($variant_option['id']); ?>-<?php echo sanitize($option); ?>" class="menu-variants" onclick="calculateMenuPrice()">
                            <label for="<?php echo sanitize($variant_option['id']); ?>-<?php echo sanitize($option); ?>" class="mr-2">
                                <small><?php echo ucfirst(sanitize($option)); ?></small>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- ADDONS -->
        <?php if ($addons && count($addons)) : ?>
            <div class="addon-area mb-3">
                <div class="mt-3 addon-name">
                    <i class="fas fa-cookie-bite"></i> <?php echo site_phrase('addons'); ?>:
                </div>
                <?php foreach ($addons as $addon) : ?>
                    <input type="checkbox" id="<?php echo sanitize($addon['id']); ?>" name="addons" class="addons" value="<?php echo $addon['id']; ?>" onclick="calculateMenuPrice()">
                    <label for="<?php echo sanitize($addon['id']); ?>" class="mr-2">
                        <small><?php echo ucfirst(sanitize($addon['name'])); ?> : <?php echo currency(sanitize($addon['price'])); ?> </small>
                    </label>
                    <br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <button class="btn quantity-incrementar" type="button" onclick="changeQuantity(0)">-</button>
                    </div>
                    <input type="number" class="form-control text-center bg-white" id="quantity_for_menu" min="1" value="1" aria-describedby="basic-addon1" onchange="calculateMenuPrice()" readonly>
                    <div class="input-group-append">
                        <button class="btn quantity-decrementer" type="button" onclick="changeQuantity(1)">+</button>
                    </div>
                </div>
                <!-- SPECIAL NOTE ON ORDER -->
                <div class="form-group">
                    <textarea name="note" id="note" class="form-control note" rows="4" placeholder="E.g: <?php echo site_phrase('no_mayo'); ?>, <?php echo site_phrase('extra_cheese'); ?>"></textarea>
                </div>
                <?php if (is_open($menu_details['restaurant_id'])) : ?>
                    <?php if ($menu_details['availability']) : ?>
                        <button class="btn btn-block pink-cart-btn" onclick="addToCart()" <?php if ($menu_details['has_variant']) echo 'disabled'; ?>><?php echo site_phrase('add_to_cart'); ?></button>
                    <?php else : ?>
                        <button class="btn btn-secondary btn-block"><?php echo site_phrase('unavailable_item', true); ?></button>
                    <?php endif; ?>
                <?php else : ?>
                    <button class="btn btn-secondary btn-block"><?php echo site_phrase('already_closed', true); ?></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="menu-price mb-2 d-block">
            <span class="total-menu-price-title">
                <?php echo site_phrase('menu_price'); ?>
            </span>
            <strong id="menu-price" class="float-right">
                : <i class="fas fa-spinner fa-pulse d-none"></i> <span class="calculated-price"><?php echo currency(sanitize(get_menu_price($menu_details['id']))); ?></span>
            </strong>
        </div>
        <img src="<?php echo base_url('uploads/menu/' . sanitize($menu_details['thumbnail'])); ?>" alt="" class="w-100 border-radius-4 cart-menu-img">
    </div>
</div>