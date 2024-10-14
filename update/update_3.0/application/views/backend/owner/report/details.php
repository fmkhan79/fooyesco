<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="alert alert-info alert-dismissible fade show lighten-info" role="alert">
            <strong><?php echo get_phrase('heads_up'); ?>!</strong>
            <p>
                <?php echo get_phrase('the_appeared_total_bill_for_each_order_is_the_summation_of_your_specific_restaurant_delivery_charge'); ?>, <?php echo strtolower(get_phrase('the_items_ordered')); ?> <?php echo strtolower(get_phrase('and')); ?> <?php echo sanitize(get_delivery_settings('vat')); ?>% VAT.
                <strong>
                    <?php echo get_phrase('it_can_be_different_from_the_actual_total_bill_because_customer_can_order_from_another_restaurant_also'); ?>.
                </strong>
            </p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</div>
<?php if (count($commission_details)) : ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php echo get_phrase("order_wise_commission_list_for_owner", true); ?> <small>( <?php echo sanitize(get_delivery_settings('restaurant_revenue')) . '% ' . get_phrase('commission_in_each_order') ?>)</small>
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