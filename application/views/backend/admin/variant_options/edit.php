<?php
$menu_id = $param2;
$menu_option_id = $param3;
$menu_options = $this->variation_model->get_options_by_id($menu_option_id);
?>
<form action="<?php echo site_url('variation/option/edit'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="menu_id" value="<?php echo sanitize($menu_id); ?>">
    <input type="hidden" name="menu_option_id" value="<?php echo sanitize($menu_option_id); ?>">
    <div class="form-group">
        <label for="name"><?php echo get_phrase("name"); ?><span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo "E.g : The festive one - medium 11.5"; ?>" value="<?php echo sanitize($menu_options['name']); ?>">
    </div>

    <div class="form-group">
        <label for="price"><?php echo get_phrase("price"); ?><span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="price" name="price" placeholder="<?php echo "E.g : 10,20,30"; ?>" value="<?php echo sanitize($menu_options['price']); ?>">
    </div>
 
    <button type="submit" class="btn btn-primary mt-4"><?php echo get_phrase('update_variant_option'); ?></button>
</form>