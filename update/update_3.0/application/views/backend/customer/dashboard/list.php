<?php
$orders = $this->order_model->get_todays_orders();
$customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id'));
?>

<div class="row">
    <div class="col-lg-5">
        <!-- TABLE: LATEST ORDERS -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo get_phrase("todays_orders", true); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase("code"); ?></th>
                                <th><?php echo get_phrase("ordered_at"); ?></th>
                                <th><?php echo get_phrase("order_status"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orders as $order) : ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo site_url('orders/details/' . sanitize($order['code'])); ?>"><?php echo sanitize($order['code']); ?></a>
                                    </td>
                                    <td>
                                        <small><i class="far fa-clock"></i> <?php echo date('h:i A', sanitize($order['order_placed_at'])); ?></small>
                                    </td>
                                    <td>
                                        <?php if ($order['order_status'] == 'pending') : ?>
                                            <span class="badge badge-warning lighten-warning"><?php echo get_phrase(sanitize($order['order_status'])); ?></span>
                                        <?php elseif ($order['order_status'] == 'delivered') : ?>
                                            <span class="badge badge-success lighten-success"><?php echo get_phrase(sanitize($order['order_status'])); ?></span>
                                        <?php elseif ($order['order_status'] == 'canceled') : ?>
                                            <span class="badge badge-danger lighten-danger"><?php echo get_phrase(sanitize($order['order_status'])); ?></span>
                                        <?php else : ?>
                                            <span class="badge badge-primary lighten-primary"><?php echo get_phrase(sanitize($order['order_status'])); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (count($orders) == 0) : ?>
                                <tr>
                                    <td colspan="3"><?php echo get_phrase('you_have_not_ordered_anything_today'); ?>.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-lg-7">
        <!-- TABLE: LATEST ORDERS -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo get_phrase("your_addresses_to_deliver", true); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                    <small>
                                        <strong><?php echo get_phrase('address'); ?> 1</strong> :
                                        <?php if (empty($customer_details['address_1'])) : ?>
                                            <strong class="text-danger"><?php echo get_phrase('not_found'); ?></strong>
                                        <?php else : ?>
                                            <?php echo sanitize($customer_details['address_1']); ?>
                                        <?php endif; ?>
                                    </small>
                                    <br>
                                    <small>
                                        <strong><?php echo get_phrase('latitude'); ?></strong> :
                                        <?php if (empty($customer_details['coordinate_1']['latitude'])) : ?>
                                            <strong class="text-danger"><?php echo get_phrase('not_found'); ?></strong>
                                        <?php else : ?>
                                            <?php echo sanitize($customer_details['coordinate_1']['latitude']); ?>
                                        <?php endif; ?>
                                        <br>
                                        <strong><?php echo get_phrase('longitude'); ?></strong> :
                                        <?php if (empty($customer_details['coordinate_1']['longitude'])) : ?>
                                            <strong class="text-danger"><?php echo get_phrase('not_found'); ?></strong>
                                        <?php else : ?>
                                            <?php echo sanitize($customer_details['coordinate_1']['longitude']); ?>
                                        <?php endif; ?>
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small>
                                        <strong><?php echo get_phrase('address'); ?> 2</strong> :
                                        <?php if (empty($customer_details['address_2'])) : ?>
                                            <strong class="text-danger"><?php echo get_phrase('not_found'); ?></strong>
                                        <?php else : ?>
                                            <?php echo sanitize($customer_details['address_2']); ?>
                                        <?php endif; ?>
                                    </small>
                                    <br>
                                    <small>
                                        <strong><?php echo get_phrase('latitude'); ?></strong> :
                                        <?php if (empty($customer_details['coordinate_2']['latitude'])) : ?>
                                            <strong class="text-danger"><?php echo get_phrase('not_found'); ?></strong>
                                        <?php else : ?>
                                            <?php echo sanitize($customer_details['coordinate_2']['latitude']); ?>
                                        <?php endif; ?>
                                        <br>
                                        <strong><?php echo get_phrase('longitude'); ?></strong> :
                                        <?php if (empty($customer_details['coordinate_2']['longitude'])) : ?>
                                            <strong class="text-danger"><?php echo get_phrase('not_found'); ?></strong>
                                        <?php else : ?>
                                            <?php echo sanitize($customer_details['coordinate_2']['longitude']); ?>
                                        <?php endif; ?>
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small>
                                        <strong><?php echo get_phrase('address'); ?> 3</strong> :
                                        <?php if (empty($customer_details['address_3'])) : ?>
                                            <strong class="text-danger"><?php echo get_phrase('not_found'); ?></strong>
                                        <?php else : ?>
                                            <?php echo sanitize($customer_details['address_3']); ?>
                                        <?php endif; ?>
                                    </small>
                                    <br>
                                    <small>
                                        <strong><?php echo get_phrase('latitude'); ?></strong> :
                                        <?php if (empty($customer_details['coordinate_3']['latitude'])) : ?>
                                            <strong class="text-danger"><?php echo get_phrase('not_found'); ?></strong>
                                        <?php else : ?>
                                            <?php echo sanitize($customer_details['coordinate_3']['latitude']); ?>
                                        <?php endif; ?>
                                        <br>
                                        <strong><?php echo get_phrase('longitude'); ?></strong> :
                                        <?php if (empty($customer_details['coordinate_3']['longitude'])) : ?>
                                            <strong class="text-danger"><?php echo get_phrase('not_found'); ?></strong>
                                        <?php else : ?>
                                            <?php echo sanitize($customer_details['coordinate_3']['longitude']); ?>
                                        <?php endif; ?>
                                    </small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="<?php echo site_url('settings/profile'); ?>" class="btn btn-sm btn-secondary float-right"><?php echo get_phrase('update_address'); ?></a>
            </div>
        </div>
    </div>
</div>