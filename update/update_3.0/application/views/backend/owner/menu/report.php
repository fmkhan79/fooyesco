<!-- Content Header -->
<?php include 'header.php'; ?>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><?php echo get_phrase('filter_menu_report'); ?></div>
            <div class="card-body">
                <form action="<?php echo site_url('menu/report'); ?>" method="GET">
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
                                <?php echo get_phrase("food_menu_report", true); ?>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="report" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo get_phrase("menu_title"); ?></th>
                                        <th><?php echo get_phrase("total_quantity_sold"); ?></th>
                                        <th><?php echo get_phrase("total_menu_amount_sold"); ?></th>
                                        <th><?php echo get_phrase("total_ingredient_amount_spent"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($reports as $key => $report) :
                                        $this->db->select_sum('ingredient_amount');
                                        $this->db->where('menu_id', $report['menu_id']);
                                        $total_ingredient_amount_spent = $this->db->get('menu_ingredients')->row_array();
                                    ?>
                                        <tr>
                                            <td><?php echo ++$key; ?></td>
                                            <td>
                                                <?php $menu_details = $this->menu_model->get_by_id($report['menu_id']); ?>
                                                <a href="<?php echo site_url('menu/edit/' . $menu_details['id']); ?>" class="text-secondary"><?php echo $menu_details['name']; ?></a>
                                                <br>
                                                <small><?php echo get_phrase('restaurant'); ?>:
                                                    <strong><a href="<?php echo site_url('site/restaurant/' . slugify($menu_details['restaurant_name']) . '/' . $menu_details['restaurant_id']); ?>" class="text-primary" target="_blank"><?php echo $menu_details['restaurant_name']; ?></a></strong></small>
                                            </td>
                                            <td>
                                                <?php echo $report['quantity']; ?> <?php echo $report['quantity'] > 1 ? strtolower(get_phrase('pieces')) : strtolower(get_phrase('piece')); ?>
                                            </td>
                                            <td>
                                                <?php echo currency($report['total']); ?>
                                            </td>
                                            <td>
                                                <?php
                                                $total_price = 0;
                                                if ($total_ingredient_amount_spent['ingredient_amount']) {
                                                    $total_price = $total_ingredient_amount_spent['ingredient_amount'] * $report['quantity'];
                                                    if (!is_int($total_price)) {
                                                        $lengh_of_decimal_value = strlen(substr(strrchr($total_price, "."), 1));
                                                        $total_price = $lengh_of_decimal_value > 3 ? number_format((float)$total_price, 3, '.', '') : $total_price;
                                                    }
                                                }

                                                echo currency($total_price);
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo get_phrase("menu_title"); ?></th>
                                        <th><?php echo get_phrase("total_quantity_sold"); ?></th>
                                        <th><?php echo get_phrase("total_menu_amount_sold"); ?></th>
                                        <th><?php echo get_phrase("total_ingredient_amount_spent"); ?></th>
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