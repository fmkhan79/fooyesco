<?php
$menu_options = $this->variation_model->get_options(sanitize($param2));
?>
<?php if (is_array($menu_options) && count($menu_options) > 0) : ?>
    <!-- <form action="" method="post" enctype="multipart/form-data"> -->
    <?php  /* echo site_url('variation/variant/create'); */ ?>
    <?php
    //  var_dump(sanitize($param2)); 
    ?>
        <input type="hidden" name="menu_id" value="<?php echo sanitize($param2); ?>">
        <!-- 
        <div class="form-group">
            <label for="variant_price"><?php echo get_phrase("variant_price"); ?><span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="variant_price" name="variant_price" placeholder="<?php echo get_phrase('enter_variant_price'); ?>" step=".01">
        </div> -->

        <?php
        
        // var_dump($menu_options);
        foreach ($menu_options as $key => $menu_option) : ?>
            <div class="form-group">
                <div class="form-row">
                <label class="col-sm-2 col-form-label"  for="menu_variation_options">
                    <?php echo get_phrase(sanitize($menu_option['name'])); ?><span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                <button style="float:right" data-menu-id="<?php echo $menu_option['menu_id']; ?>" data-variation-id="<?php echo $menu_option['id']; ?>" class="btn btn-warning add_variant add_variant_item_<?php echo $menu_option['id']; ?>" > 
                    Add Food Sub Category
                </button>    
                <!-- <button style="float:right" data-menu-id="<?php echo $menu_option['menu_id']; ?>" data-variation-id="<?php echo $menu_option['id']; ?>" class="btn btn-primary add_variant add_variant_item_<?php echo $menu_option['id']; ?>" > 
                    Add Item
                </button> -->
                </div>
                </div>

                <div class="variant_items_<?php echo $menu_option['id']; ?>" >
                </div>
               
            </div>
        <?php endforeach; ?>
        <!-- <button type="submit" class="btn btn-primary mt-4"><?php echo get_phrase('add_variant'); ?></button> -->
    <!-- </form> -->
<?php else : ?>
    <div class="alert alert-info lighten-info text-center">
        <i class="icon fas fa-exclamation-triangle"></i> <strong><?php echo get_phrase('heads_up'); ?></strong>!
        <?php echo get_phrase('add_variant_option_first_to_add_menu_variants'); ?>.
    </div>
<?php endif; ?>


