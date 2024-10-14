<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><?php echo get_phrase('filter_ingredients'); ?></div>
            <div class="card-body">
                <form action="<?php echo site_url('ingredient/index'); ?>" method="GET">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo get_phrase('restaurant'); ?></label>
                                <select class="form-control select2 w-100" name="restaurant_id" id="restaurant_id">
                                    <option value="" <?php if ($restaurant_id == "all") echo "selected"; ?>><?php echo get_phrase('all'); ?></option>
                                    <?php foreach ($restaurants as $key => $restaurant) : ?>
                                        <option value="<?php echo sanitize($restaurant['id']); ?>" <?php if ($restaurant_id == $restaurant['id']) echo "selected"; ?>><?php echo sanitize($restaurant['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label class="text-white">submit</label>
                            <div class="input-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> <?php echo get_phrase('filter'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if (count($ingredients)) : ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php echo get_phrase("list_of_ingredients", true); ?>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="ingredients" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo get_phrase("ingredient_name"); ?></th>
                                <th><?php echo get_phrase("unit"); ?></th>
                                <th><?php echo get_phrase("unit_price"); ?></th>
                                <th><?php echo get_phrase("action"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ingredients as $key => $ingredient) :
                                $restaurant_details = $this->restaurant_model->get_by_id($ingredient['restaurant_id']);
                            ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('ingredient/edit/' . sanitize($ingredient['id'])); ?>"><?php echo sanitize($ingredient['ingredient_name']); ?></a>
                                        <br>
                                        <small>
                                            <?php echo get_phrase('restaurant'); ?>:
                                            <strong><a href="<?php echo site_url('site/restaurant/' . $restaurant_details['slug'] . '/' . $restaurant_details['id']); ?>" class="text-primary" target="_blank"><?php echo $restaurant_details['name']; ?></a></strong>
                                        </small>
                                    </td>
                                    <td>
                                        <?php echo sanitize($ingredient['unit']); ?>
                                    </td>
                                    <td>
                                        <?php echo currency(sanitize($ingredient['unit_price'])); ?> / <?php echo strtolower(sanitize($ingredient['unit'])); ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn action-dropdown" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo site_url('ingredient/edit/' . sanitize($ingredient['id'])); ?>"><?php echo get_phrase("edit"); ?></a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('ingredient/delete/' . sanitize($ingredient['id'])); ?>')"><?php echo get_phrase("delete"); ?></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th><?php echo get_phrase("ingredient_name"); ?></th>
                                <th><?php echo get_phrase("unit"); ?></th>
                                <th><?php echo get_phrase("unit_price"); ?></th>
                                <th><?php echo get_phrase("action"); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (!count($ingredients)) : ?>
    <?php isEmpty(); ?>
<?php endif; ?>