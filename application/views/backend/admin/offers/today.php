<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Filter offers</div>
            <div class="card-body">
                <form action="<?php echo site_url('orders/today'); ?>" method="GET">
                    <div class="row">
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
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label><?php echo get_phrase('status'); ?></label>
                                <select class="form-control select2 w-100" name="status" id="status">
                                    <option value="" <?php if ($status == "all") echo "selected"; ?>><?php echo get_phrase('all'); ?></option>
                                    <option value="pending" <?php if ($status == "pending") echo "selected"; ?>><?php echo get_phrase('pending'); ?></option>
                                    <option value="preparing" <?php if ($status == "preparing") echo "selected"; ?>><?php echo get_phrase('preparing'); ?></option>
                                    <option value="prepared" <?php if ($status == "prepared") echo "selected"; ?>><?php echo get_phrase('prepared'); ?></option>
                                    <option value="delivered" <?php if ($status == "delivered") echo "selected"; ?>><?php echo get_phrase('delivered'); ?></option>
                                    <option value="canceled" <?php if ($status == "canceled") echo "selected"; ?>><?php echo get_phrase('canceled'); ?></option>
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
<?php if (count($orders)) : ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php echo get_phrase("list_of_todays_orders", true); ?>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="orders" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo get_phrase("order_code"); ?></th>
                                <th><?php echo get_phrase("ordered_from"); ?></th>
                                <th><?php echo get_phrase("order_placing_time"); ?></th>
                                <th><?php echo get_phrase("delivery_details"); ?></th>
                                <th><?php echo get_phrase("payment_details"); ?></th>
                                <th><?php echo get_phrase("order_status"); ?></th>
                                <th><?php echo get_phrase("action"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orders as $order) : ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo site_url('orders/details/' . $order['code']); ?>"><?php echo sanitize($order['code']); ?></a>
                                    </td>
                                    <td>
                                        <?php
                                        $restaurant_ids = $this->order_model->get_restaurant_ids($order['code']);
                                        foreach ($restaurant_ids as $restaurant_id) :
                                            $restaurant_detail = $this->restaurant_model->get_by_id($restaurant_id); ?>
                                            <?php if (isset($restaurant_detail['id'])) : ?>
                                                <a href="<?php echo site_url('site/restaurant/' . sanitize(rawurlencode($restaurant_detail['slug'])) . '/' . sanitize($restaurant_detail['id'])); ?>" class="text-dark" target="_blank"><small class="d-block"> ∙ <?php echo sanitize($restaurant_detail['name']); ?></small></a>
                                            <?php else : ?>
                                                <a href="javascript:void(0)" class="text-red"><small class="d-block"> ∙ <?php echo get_phrase("not_found");; ?></small></a>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <i class="far fa-clock"></i> <?php echo date('h:i A', sanitize($order['order_placed_at'])); ?>
                                    </td>
                                    <td>
                                        <?php if ($order['order_type'] == "pickup") : ?>
                                            <small><strong><?php echo get_phrase('order_type'); ?> : </strong> <span class="badge badge-success lighten-success"><?php echo get_phrase('pickup'); ?></span></small>
                                            <small class="d-block">
                                                <strong><?php echo get_phrase('customer'); ?> : </strong> <?php echo sanitize($order['customer_name']); ?>
                                            </small>
                                        <?php else : ?>
                                            <small><strong><?php echo get_phrase('order_type'); ?> : </strong> <span class="badge badge-warning lighten-warning"><?php echo get_phrase('delivery'); ?></span></small>
                                            <small class="d-block">
                                                <strong><?php echo get_phrase('customer'); ?> : </strong> <?php echo sanitize($order['customer_name']); ?>
                                            </small>
                                            <small data-toggle="tooltip" data-placement="top" title="<?php echo sanitize($order['delivery_address']); ?>">
                                                <strong><?php echo get_phrase('address'); ?> : </strong> <?php echo ellipsis(sanitize($order['delivery_address'])); ?>
                                            </small>
                                            <small class="d-block">
                                                <strong><?php echo get_phrase('assigned_driver'); ?> : </strong>
                                                <?php if (isset($order['driver_id']) && !empty($order['driver_id'])) : ?>
                                                    <?php echo sanitize($order['driver_name']); ?>
                                                <?php else : ?>
                                                    <span class="badge badge-danger lighten-danger"><?php echo get_phrase('not_assigned_yet'); ?></span>
                                                <?php endif; ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $payment_data = $this->payment_model->get_payment_data_by_order_code($order['code']); ?>
                                        <small class="d-block">
                                            <strong><?php echo get_phrase('amount'); ?> : </strong> <?php echo currency(sanitize($payment_data['amount_to_pay'])); ?>
                                        </small>
                                        <small class="d-block">
                                            <strong><?php echo get_phrase('status'); ?> : </strong>
                                            <?php if ($payment_data['amount_to_pay'] == $payment_data['amount_paid']) : ?>
                                                <span class="badge badge-success lighten-success"><?php echo get_phrase(sanitize('paid')); ?></span>
                                            <?php else : ?>
                                                <span class="badge badge-danger lighten-danger"><?php echo get_phrase(sanitize('unpaid')); ?></span>
                                            <?php endif; ?>
                                        </small>
                                        <small class="d-block">
                                            <strong><?php echo get_phrase('method'); ?> : </strong> <?php echo ucfirst(str_replace('_', ' ', sanitize($payment_data['payment_method']))); ?>
                                        </small>
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
                                    <td class="text-center">
                                        <button class="btn action-dropdown" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?php echo site_url('orders/details/' . sanitize($order['code'])); ?>"><?php echo get_phrase("details"); ?></a></li>
                                            <?php if (empty($order['driver_id'])) : ?>
                                                <li><a class="dropdown-item" href="<?php echo site_url('orders/details/' . sanitize($order['code'])); ?>"><?php echo get_phrase("assign_a_driver"); ?></a></li>
                                            <?php endif; ?>
                                            <?php if ($order['order_status'] == 'pending') : ?>
                                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($order['code']) . '/approved'); ?>')"><?php echo get_phrase("aprrove_this_order"); ?></a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('orders/cancel/' . sanitize($order['code'])); ?>')"><?php echo get_phrase("cancel_this_order"); ?></a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo get_phrase("order_code"); ?></th>
                                <th><?php echo get_phrase("ordered_from"); ?></th>
                                <th><?php echo get_phrase("order_placing_time"); ?></th>
                                <th><?php echo get_phrase("delivery_address"); ?></th>
                                <th><?php echo get_phrase("payment_details"); ?></th>
                                <th><?php echo get_phrase("order_status"); ?></th>
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

<?php if (!count($orders)) : ?>
    <?php isEmpty(); ?>
<?php endif; ?>