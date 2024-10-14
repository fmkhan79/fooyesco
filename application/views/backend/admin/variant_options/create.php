<form action="<?php echo site_url('variation/option/create'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="menu_id" value="<?php echo sanitize($param2); ?>">
    <div class="form-group">
        <label for="name"><?php echo get_phrase("name"); ?><span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo "E.g : The festive one - medium 11.5"; ?>">
      </div>

    <div class="form-group">
        <label for="price"><?php echo get_phrase("price"); ?><span class="text-danger">*</span></label>
      <input type="number" step="any" class="form-control" id="price" name="price" placeholder="E.g : 10,20,20">
    </div>
    <button type="submit" class="btn btn-primary mt-4"><?php echo get_phrase('add_variant_option'); ?></button>
</form>