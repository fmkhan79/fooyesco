<?php
$menu_id = $param2;
$menu_ingredient_id = $param3;
$menu_data = $this->menu_model->get_by_id($menu_id);
$menu_ingredient_details = $this->ingredient_model->get_menu_ingredients_by_id($menu_ingredient_id);
?>
<form action="<?php echo site_url('ingredient/menu_ingredient/edit/' . $menu_ingredient_details['id']); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="menu_id" value="<?php echo sanitize($menu_data['id']); ?>">
    <div class="form-group">
        <label for="ingredient"><?php echo get_phrase("ingredient"); ?><span class="text-danger">*</span></label>
        <select class="custom-select" name="ingredient_id" id="ingredient_id">
            <option value=""><?php echo get_phrase('choose_an_ingredient'); ?></option>
            <?php
            $ingredients = $this->ingredient_model->get_ingredients($menu_data['restaurant_id']);
            foreach ($ingredients as $key => $ingredient) : ?>
                <option value="<?php echo sanitize($ingredient['id']); ?>" <?php if ($menu_ingredient_details['ingredient_id'] == $ingredient['id']) echo 'selected'; ?>>
                    <?php echo sanitize($ingredient['ingredient_name']); ?> - <?php echo currency($ingredient['unit_price']) . ' / ' . strtolower($ingredient['unit']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="quantity_added"><?php echo get_phrase("quantity_added"); ?><span class="text-danger">*</span> <small>(<?php echo strtolower(get_phrase("kilogram")); ?>, <?php echo strtolower(get_phrase("gram")); ?>, <?php echo strtolower(get_phrase("pound")); ?>, <?php echo strtolower(get_phrase("ounce")); ?>, <?php echo get_phrase("piece"); ?> etc.)</small> </label>
        <input type="number" class="form-control" id="quantity_added" name="quantity_added" min="0" step="0.001" placeholder="E.g. : 0.7" value="<?php echo $menu_ingredient_details['quantity_added']; ?>">
    </div>
    <button type="submit" class="btn btn-primary mt-4"><?php echo get_phrase('update_menu_ingredient'); ?></button>
</form>