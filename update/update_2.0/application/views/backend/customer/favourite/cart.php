<?php $menu_details = $this->menu_model->get_by_id($param2); ?>
<!--Header-->
<div class="modal-header">
    <img src="<?php echo base_url('uploads/menu/' . sanitize($menu_details['thumbnail'])); ?>" alt="avatar" class="rounded-circle img-responsive foodmenu-thumbnail-for-cart">
</div>
<!--Body-->
<div class="modal-body text-center mb-1">
    <h6 class="mt-1 mb-2"><?php echo sanitize($menu_details['name']); ?></h6>
    <!-- IF SERVINGS IS MENU -->
    <?php if ($menu_details['servings'] == "menu") : ?>
        <small><?php echo get_phrase('price'); ?> : <strong><?php echo currency(sanitize(get_menu_price($menu_details['id']))); ?></strong></small>
        <div class="form-group">
            <input type="number" class="form-control text-center" id="quantity_for_menu" min="1" value="1">
        </div>

        <?php if (is_open($menu_details['restaurant_id'])) : ?>
            <?php if ($menu_details['availability']) : ?>
                <button class="btn btn-success btn-block" onclick="addToCart('<?php echo sanitize($menu_details['id']); ?>', 'menu', $('#quantity_for_menu').val())"><?php echo get_phrase('add_to_cart'); ?></button>
            <?php else : ?>
                <button class="btn btn-secondary btn-block"><?php echo get_phrase('unavailable_item', true); ?></button>
            <?php endif; ?>
        <?php else : ?>
            <button class="btn btn-secondary btn-block"><?php echo get_phrase('already_closed', true); ?></button>
        <?php endif; ?>


        <!-- IF SERVINGS IS PLATE -->
    <?php else : ?>

        <small><?php echo get_phrase('full_plate_price', true); ?> : <strong><?php echo currency(sanitize(get_menu_price($menu_details['id'], "full_plate"))); ?></strong></small><br>
        <small><?php echo get_phrase('half_plate_price', true); ?> : <strong><?php echo currency(sanitize(get_menu_price($menu_details['id'], "half_plate"))); ?></strong></small>

        <div class="form-group">
            <select class="custom-select mb-2 mr-sm-2 mb-sm-0 form-control" id="plate-servings">
                <option value="full_plate"><?php echo get_phrase('full_plate'); ?></option>
                <option value="half_plate"><?php echo get_phrase('half_plate'); ?></option>
            </select>
        </div>
        <div class="form-group">
            <input type="number" class="form-control text-center" id="quantity_for_full_plate" min="1" value="1">
        </div>

        <?php if (is_open($menu_details['restaurant_id'])) : ?>
            <?php if ($menu_details['availability']) : ?>
                <button class="btn btn-success btn-block" onclick="addToCart('<?php echo sanitize($menu_details['id']); ?>', $('#plate-servings').val(), $('#quantity_for_full_plate').val())"><?php echo get_phrase('add_to_cart'); ?></button>
            <?php else : ?>
                <button class="btn btn-secondary btn-block"><?php echo get_phrase('unavailable_item', true); ?></button>
            <?php endif; ?>
        <?php else : ?>
            <button class="btn btn-secondary btn-block"><?php echo get_phrase('already_closed', true); ?></button>
        <?php endif; ?>

    <?php endif; ?>
</div>
