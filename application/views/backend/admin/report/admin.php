<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><?php echo get_phrase('filter_orders'); ?></div>
            <div class="card-body">
                <form action="<?php echo site_url('report/admin'); ?>" method="GET">
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
                        <div class="col-lg-2">
                            <label class="text-white"><?php echo get_phrase('submit'); ?></label>

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
<?php if (count($commissions)) : ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php echo get_phrase("order_wise_commission_list_for_admin", true); ?> <small>( <?php echo sanitize(get_delivery_settings('admin_revenue')) . '% ' . sanitize(get_phrase('commission_in_each_order')); ?>)</small>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="commissions" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase("order_code"); ?></th>
                                <th><?php echo get_phrase("ordered_from"); ?></th>
                                <th><?php echo get_phrase("admin_commission"); ?></th>
                                <th><?php echo get_phrase("date"); ?></th>
                                <th><?php echo get_phrase("action"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($commissions as $key => $commission) :
                                $restaurant_detail = $this->restaurant_model->get_by_id(sanitize($commission['restaurant_id']));
                                $owner_details = $this->user_model->get_user_by_id(sanitize($restaurant_detail['owner_id'])); ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo site_url('orders/details/' . sanitize($commission['order_code'])); ?>"><?php echo sanitize($commission['order_code']); ?></a>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('site/restaurant/' . rawurlencode(sanitize($restaurant_detail['slug'])) . '/' . sanitize($restaurant_detail['id'])); ?>" target="_blank"><?php echo sanitize($restaurant_detail['name']); ?></a><br>
                                        <small class="text-muted">
                                            <strong><?php echo get_phrase('owner'); ?> : </strong>
                                            <?php if (get_user_role('user_role', $owner_details['id']) != "admin") : ?>
                                                <a href="<?php echo site_url('owner/profile/' . sanitize($owner_details['id'])) ?>"><?php echo sanitize($owner_details['name']); ?></a>
                                            <?php else : ?>
                                                <?php echo sanitize($owner_details['name']); ?>
                                            <?php endif; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php echo currency(sanitize($commission['admin_commission'])); ?>
                                    </td>
                                    <td>
                                        <?php echo date('D, d-M-Y', sanitize($commission['date_added'])); ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn action-dropdown" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo site_url('orders/details/' . sanitize($commission['order_code'])); ?>"><?php echo get_phrase("order_details"); ?></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo get_phrase("order_code"); ?></th>
                                <th><?php echo get_phrase("ordered_from"); ?></th>
                                <th><?php echo get_phrase("total_commission") . ' : ' . currency(sanitize($this->report_model->filter_and_get_total_admin_commissions())); ?></th>
                                <th><?php echo get_phrase("date"); ?></th>
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

<?php if (!count($commissions)) : ?>
    <?php isEmpty(); ?>
<?php endif; ?>