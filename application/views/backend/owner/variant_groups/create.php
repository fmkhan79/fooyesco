<form action="<?php echo site_url('variation/group/create'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="menu_id" value="<?php echo sanitize($param2); ?>">
    <input type="hidden" name="variant_options_id" value="<?php echo sanitize($param3); ?>">
    <div class="form-group">
        <label for="name"><?php echo get_phrase("name"); ?><span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Pizza 1, Pizza 2, Pizza 3">
      </div>

    <button type="submit" class="btn btn-primary mt-4">Add Variant Group</button>
</form>