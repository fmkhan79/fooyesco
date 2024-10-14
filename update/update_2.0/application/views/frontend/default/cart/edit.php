<?php
$cart_item_details = $this->cart_model->get_by_id($param2);
$menu_details = $this->menu_model->get_by_id(sanitize($cart_item_details['menu_id'])); ?>
<!--Header-->
<div class="modal-header">
    <img src="<?php echo base_url('uploads/menu/' . sanitize($menu_details['thumbnail'])); ?>" alt="avatar" class="rounded-circle img-responsive foodmenu-thumbnail-for-cart">
</div>
<!--Body-->
<div class="modal-body text-center mb-1">
    <h6 class="mt-1 mb-2"><?php echo sanitize($menu_details['name']); ?></h6>
    <!-- IF SERVINGS IS MENU -->
    <?php if ($menu_details['servings'] == "menu") : ?>
        <small><?php echo site_phrase('price'); ?> : <strong><?php echo currency(sanitize(get_menu_price($menu_details['id']))); ?></strong></small>
        <div class="form-group">
            <input type="number" class="form-control text-center" id="quantity_for_menu" min="1" value="<?php echo sanitize($cart_item_details['quantity']); ?>">
        </div>
        <!-- SPECIAL NOTE ON ORDER -->
        <div class="form-group">
            <textarea name="note" id="note" class="form-control note" rows="2" placeholder="E.g: <?php echo site_phrase('no_mayo'); ?>, <?php echo site_phrase('extra_cheese'); ?>"><?php echo sanitize($cart_item_details['note']); ?></textarea>
        </div>
        <button class="btn btn-success btn-block" onclick="updateCart('<?php echo sanitize($cart_item_details['id']); ?>', '<?php echo sanitize($menu_details['id']); ?>', 'menu', $('#quantity_for_menu').val(), $('#note').val())"><?php echo site_phrase('update_cart', true); ?></button>

        <!-- IF SERVINGS IS PLATE -->
    <?php else : ?>

        <small><?php echo site_phrase('full_plate_price', true); ?> : <strong><?php echo currency(get_menu_price($menu_details['id'], "full_plate")); ?></strong></small><br>
        <small><?php echo site_phrase('half_plate_price', true); ?> : <strong><?php echo currency(get_menu_price($menu_details['id'], "half_plate")); ?></strong></small>

        <div class="form-group">
            <select class="custom-select mb-2 mr-sm-2 mb-sm-0 form-control" id="plate-servings">
                <option value="full_plate" <?php if ($cart_item_details['servings'] == "full_plate") echo "selected"; ?>><?php echo site_phrase('full_plate'); ?></option>
                <option value="half_plate" <?php if ($cart_item_details['servings'] == "half_plate") echo "selected"; ?>><?php echo site_phrase('half_plate'); ?></option>
            </select>
        </div>
        <div class="form-group">
            <input type="number" class="form-control text-center" id="quantity_for_full_plate" min="1" value="<?php echo sanitize($cart_item_details['quantity']); ?>">
        </div>
        <!-- SPECIAL NOTE ON ORDER -->
        <div class="form-group">
            <textarea name="note" id="note" class="form-control note" rows="2" placeholder="E.g: <?php echo site_phrase('no_mayo'); ?>, <?php echo site_phrase('extra_cheese'); ?>"><?php echo sanitize($cart_item_details['note']); ?></textarea>
        </div>
        <button class="btn btn-success btn-block" onclick="updateCart('<?php echo sanitize($cart_item_details['id']); ?>', '<?php echo sanitize($menu_details['id']); ?>', $('#plate-servings').val(), $('#quantity_for_full_plate').val(), $('#note').val())"><?php echo site_phrase('update_cart', true); ?></button>

    <?php endif; ?>
</div>