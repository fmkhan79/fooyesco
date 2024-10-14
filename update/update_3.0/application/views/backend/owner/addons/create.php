<form action="<?php echo site_url('addon/addons/create'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="menu_id" value="<?php echo sanitize($menu_data['id']); ?>">
    <div class="form-group">
        <label for="addon_name"><?php echo get_phrase("addon_name"); ?><span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="addon_name" name="addon_name" placeholder="<?php echo "E.g : " . get_phrase("extra_cheese"); ?>">
    </div>
    <div class="form-group">
        <label for="addon_price"><?php echo get_phrase("addon_price"); ?><span class="text-danger">*</span></label>
        <input type="number" class="form-control" id="addon_price" name="addon_price" placeholder="<?php echo get_phrase('enter_addon_price'); ?>" step=".01">
    </div>
    <button type="submit" class="btn btn-primary mt-4"><?php echo get_phrase('add_addon'); ?></button>
</form>