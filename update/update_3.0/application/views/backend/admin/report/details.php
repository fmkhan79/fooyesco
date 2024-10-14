<?php if (count($commission_details)) : ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php echo get_phrase("order_wise_commission_list_for_owner", true); ?> <small>( <?php echo get_delivery_settings('restaurant_revenue') . '% ' . get_phrase('commission_in_each_order') ?>)</small>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="commissions" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase("order_code"); ?></th>
                                <th><?php echo get_phrase("total_bill"); ?></th>
                                <th><?php echo get_phrase("admin_commission"); ?></th>
                                <th><?php echo get_phrase("owner_commission"); ?></th>
                                <th><?php echo get_phrase("action"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($commission_details as $key => $commission_detail) : ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo site_url('orders/details/' . sanitize($commission_detail['order_code'])); ?>"><?php echo sanitize($commission_detail['order_code']); ?></a>
                                    </td>
                                    <td>
                                        <?php echo currency(sanitize($commission_detail['total_bill'])); ?>
                                    </td>
                                    <td>
                                        <?php echo currency(sanitize($commission_detail['admin_commission'])); ?>
                                    </td>
                                    <td>
                                        <?php echo sanitize($commission_detail['owner_commission']) ? currency(sanitize($commission_detail['owner_commission'])) : currency(0); ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url('orders/details/' . sanitize($commission_detail['order_code'])); ?>" class="btn btn-sm btn-outline-primary btn-rounded"><?php echo get_phrase('order_details'); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo get_phrase("order_code"); ?></th>
                                <th><?php echo get_phrase("total_bill"); ?></th>
                                <th><?php echo get_phrase("admin_commission"); ?></th>
                                <th><?php echo get_phrase("owner_commission"); ?></th>
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

<?php if (!count($commission_details)) : ?>
    <?php isEmpty(); ?>
<?php endif; ?>