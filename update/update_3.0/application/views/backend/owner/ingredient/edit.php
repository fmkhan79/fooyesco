<!-- Content Header (Page header) -->
<?php include  'header.php'; ?>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('add_form'); ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="<?php echo site_url('ingredient/update'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo sanitize($ingredient['id']); ?>">
                            <div class="form-group">
                                <label for="restaurant_id"><?php echo get_phrase("restaurant"); ?> <span class="text-danger">*</span></label> <small class="float-right"><a href="<?php echo site_url('restaurant/create'); ?>"><?php echo get_phrase("create_new_restaurant"); ?></a></small>
                                <select class="form-control select2" name="restaurant_id">
                                    <option value=""><?php echo get_phrase("choose_restaurant"); ?></option>
                                    <?php foreach ($restaurants as $key => $restaurant) : ?>
                                        <option value="<?php echo sanitize($restaurant['id']); ?>" <?php if ($ingredient['restaurant_id'] == $restaurant['id']) echo "selected"; ?>><?php echo sanitize($restaurant['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ingredient_name"><?php echo get_phrase("ingredient_name"); ?><span class="text-danger">*</span></label>
                                <input type="text" id="ingredient_name" class="form-control" name="ingredient_name" placeholder="<?php echo get_phrase("enter_ingredient_name"); ?>" value="<?php echo sanitize($ingredient['ingredient_name']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="unit"><?php echo get_phrase("unit"); ?><span class="text-danger">*</span></label>
                                <input type="text" id="unit" class="form-control" name="unit" placeholder="<?php echo strtolower(get_phrase("kilogram")); ?>, <?php echo strtolower(get_phrase("gram")); ?>, <?php echo strtolower(get_phrase("pound")); ?>, <?php echo strtolower(get_phrase("ounce")); ?>, <?php echo get_phrase("piece"); ?> etc" value="<?php echo sanitize($ingredient['unit']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="unit_price"><?php echo get_phrase("price_per_unit") . ' (' . currency_code_and_symbol('code') . ')'; ?> <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="unit_price" name="unit_price" placeholder="<?php echo get_phrase('enter_price_per_unit'); ?>" step="0.01" min="0" value="<?php echo sanitize($ingredient['unit_price']); ?>">
                            </div>
                            <button class="btn btn-primary"><?php echo get_phrase('save_ingredient'); ?></button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>