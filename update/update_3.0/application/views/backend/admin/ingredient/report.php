<!-- Content Header -->
<?php include 'header.php'; ?>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><?php echo get_phrase('filter_ingredient_report'); ?></div>
            <div class="card-body">
                <form action="<?php echo site_url('ingredient/report'); ?>" method="GET">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo get_phrase('date_range'); ?></label>
                                <input type="hidden" name="date_range" id="selected-date-range-value" value="<?php echo date('F d, Y', sanitize($starting_timestamp)) . ' - ' . date('F d, Y', sanitize($ending_timestamp)); ?>">
                                <div class="input-group">
                                    <button type="button" class="btn btn-default btn-block text-left" id="daterange-btn">
                                        <i class="far fa-calendar-alt"></i> <span id="selected-date-range"><?php echo date('F d, Y', sanitize($starting_timestamp)) . ' - ' . date('F d, Y', sanitize($ending_timestamp)); ?></span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
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

        <!-- REPORT STARTS FROM HERE -->
        <?php if (count($reports)) : ?>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <?php echo get_phrase("food_ingredient_report", true); ?>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="report" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo get_phrase("ingredient_title"); ?></th>
                                        <th><?php echo get_phrase("unit_price"); ?></th>
                                        <th><?php echo get_phrase("total_quantity_spent"); ?></th>
                                        <th><?php echo get_phrase("total_amount_spent"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    foreach ($reports as $key => $report) : ?>
                                        <tr>
                                            <td><?php echo ++$index; ?></td>
                                            <td>
                                                <?php
                                                $ingredient_details = $this->ingredient_model->get_by_id($key);
                                                echo $ingredient_details['ingredient_name'];
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo currency(sanitize($ingredient_details['unit_price'])); ?> / <?php echo strtolower(sanitize($ingredient_details['unit'])); ?>
                                            </td>
                                            <td>
                                                <?php echo sanitize($report['quantity_added']); ?> <?php echo strtolower(sanitize($ingredient_details['unit'])); ?>
                                            </td>
                                            <td>
                                                <?php echo currency(sanitize($report['ingredient_amount'])); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo get_phrase("menu_title"); ?></th>
                                        <th><?php echo get_phrase("unit_price"); ?></th>
                                        <th><?php echo get_phrase("total_quantity_sold"); ?></th>
                                        <th><?php echo get_phrase("total_amount_sold"); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!count($reports)) : ?>
            <?php isEmpty(); ?>
        <?php endif; ?>
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->