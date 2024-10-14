<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo get_phrase('ingredients_of_this_menu'); ?></h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase("ingredient"); ?></th>
                            <th><?php echo get_phrase("quantity_added"); ?></th>
                            <th><?php echo get_phrase("price"); ?></th>
                            <th><?php echo get_phrase('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $menu_ingredients = $this->ingredient_model->get_menu_ingredients($menu_data['id']); ?>
                        <?php foreach ($menu_ingredients->result_array() as $key => $menu_ingredient) :
                            $ingredient_details = $this->ingredient_model->get_by_id($menu_ingredient['ingredient_id']);
                        ?>
                            <tr>
                                <td>
                                    <strong><?php echo $ingredient_details['ingredient_name']; ?></strong><br>
                                    <small>
                                        <strong class="text-secondary"><?php echo get_phrase('unit_price'); ?></strong> : <?php echo currency($ingredient_details['unit_price']) . ' / ' . strtolower($ingredient_details['unit']); ?>
                                    </small>
                                </td>
                                <td>
                                    <?php echo $menu_ingredient['quantity_added'] . ' ' . strtolower($ingredient_details['unit']); ?>
                                </td>
                                <td>
                                    <?php echo currency($menu_ingredient['ingredient_amount']); ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-xs action-dropdown" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="showAjaxModal('<?php echo site_url('modal/popup/menu/edit-ingredient/' . sanitize($menu_data['id']) . '/' . sanitize($menu_ingredient['id'])); ?>', '<?php echo get_phrase('edit_ingredient_menu'); ?>')">
                                                <?php echo get_phrase("edit"); ?>
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('ingredient/menu_ingredient/delete/' . sanitize($menu_ingredient['id'])); ?>')"><?php echo get_phrase("delete"); ?></a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if ($menu_ingredients->num_rows() == 0) : ?>
                            <tr>
                                <td colspan="4"><?php echo get_phrase('no_data_found'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo get_phrase('add_ingredient_to_this_menu'); ?></h3>
            </div>
            <div class="card-body">
                <form action="<?php echo site_url('ingredient/menu_ingredient/add'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="menu_id" value="<?php echo sanitize($menu_data['id']); ?>">
                    <div class="form-group">
                        <label for="ingredient_id" class="form-control-plaintext"><?php echo get_phrase("ingredient"); ?><span class="text-danger">*</span> <small class="float-right"><a href="<?php echo site_url('ingredient/create'); ?>"><?php echo get_phrase("create_new_ingredient"); ?></a></small> </label>
                        <select class="form-control select2 w-100" name="ingredient_id" id="ingredient_id">
                            <option value=""><?php echo get_phrase('choose_an_ingredient'); ?></option>
                            <?php
                            $ingredients = $this->ingredient_model->get_ingredients($menu_data['restaurant_id']);
                            foreach ($ingredients as $key => $ingredient) : ?>
                                <option value="<?php echo sanitize($ingredient['id']); ?>">
                                    <?php echo sanitize($ingredient['ingredient_name']); ?> - <?php echo currency($ingredient['unit_price']) . ' / ' . strtolower($ingredient['unit']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity_added"><?php echo get_phrase("quantity_added"); ?><span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="quantity_added" name="quantity_added" min="0" step="0.001" placeholder="E.g. : 0.5">
                        <small class="text-muted"> <span class="text-danger"><?php echo get_phrase('example'); ?>:</span> <?php echo strtolower(get_phrase('if_the_unit_is_gram_and_the_ingredient_was_added')); ?> 75 <?php echo strtolower(get_phrase('gram_then_just_put')); ?> 75.</small>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4"><?php echo get_phrase('add_ingredient_to_the_menu'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>