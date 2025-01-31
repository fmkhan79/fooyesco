<div class="col-lg-4 col-md-6">
    <div class="card card-outline">
        <div class="card-header bg-warning">
            <h3 class="card-title"><?php echo get_phrase('pending_orders'); ?> (<?php echo count($orders['pending']); ?>)</h3>
        </div>
        <div class="card-body">
            <?php foreach ($orders['pending'] as $pending) :
                $order_details = $this->order_model->details(sanitize($pending['code']));
                $payment_data = $this->payment_model->get_payment_data_by_order_code($pending['code']);
            ?>
                <div class="card card-outline card-warning">
                    <div class="card-body">
                        <span class="d-block text-xs"><strong><?php echo get_phrase('code'); ?> : </strong> <?php echo sanitize($pending['code']); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('order_placed_at'); ?> : </strong> <?php echo date('h:i:s A', sanitize($pending['order_placed_at'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('ordered_items'); ?> : </strong> <?php echo count($order_details); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('total_bill'); ?> : </strong><?php echo currency(sanitize($pending['grand_total'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('payment_status'); ?> : </strong>
                            <?php if ($payment_data['amount_to_pay'] == $payment_data['amount_paid']) : ?>
                                <span class="badge badge-success lighten-success"><?php echo get_phrase(sanitize('paid')); ?></span>
                            <?php else : ?>
                                <span class="badge badge-danger lighten-danger"><?php echo get_phrase(sanitize('unpaid')); ?></span>
                            <?php endif; ?>
                        </span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('payment_method'); ?> : </strong>
                            <?php echo ucfirst(str_replace('_', ' ', sanitize($payment_data['payment_method']))); ?>
                        </span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('ordered_from'); ?> : </strong>
                            <?php
                            $restaurant_ids = $this->order_model->get_restaurant_ids(sanitize($pending['code']));
                            foreach ($restaurant_ids as $restaurant_id) :
                                $restaurant_detail = $this->restaurant_model->get_by_id(sanitize($restaurant_id)); ?>
                                ∙ <?php echo sanitize($restaurant_detail['name']); ?>
                            <?php endforeach; ?>
                        </span>

                        <div class="row mt-2">
                            <div class="col-12">
                                <a href="<?php echo site_url('orders/details/' . sanitize($pending['code'])); ?>" class="btn btn-secondary btn-block btn-sm text-xs"><?php echo get_phrase('details'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (!count($orders['pending'])) : ?>
                <h6 class="text-center"><?php echo get_phrase('no_data_found'); ?></h6>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-6">
    <div class="card card-outline">
        <div class="card-header bg-info">
            <h3 class="card-title"><?php echo get_phrase('approved_orders'); ?> (<?php echo count($orders['approved']); ?>)</h3>
        </div>

        <div class="card-body">
            <?php foreach ($orders['approved'] as $approved) :
                $order_details = $this->order_model->details(sanitize($approved['code']));
                $payment_data = $this->payment_model->get_payment_data_by_order_code($approved['code']);
            ?>
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <span class="d-block text-xs"><strong><?php echo get_phrase('code'); ?> : </strong> <?php echo sanitize($approved['code']); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('order_placed_at'); ?> : </strong> <?php echo date('h:i:s A', sanitize($approved['order_placed_at'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('ordered_items'); ?> : </strong> <?php echo count($order_details); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('total_bill'); ?> : </strong><?php echo currency(sanitize($approved['grand_total'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('payment_status'); ?> : </strong>
                            <?php if ($payment_data['amount_to_pay'] == $payment_data['amount_paid']) : ?>
                                <span class="badge badge-success lighten-success"><?php echo get_phrase(sanitize('paid')); ?></span>
                            <?php else : ?>
                                <span class="badge badge-danger lighten-danger"><?php echo get_phrase(sanitize('unpaid')); ?></span>
                            <?php endif; ?>
                        </span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('payment_method'); ?> : </strong>
                            <?php echo ucfirst(str_replace('_', ' ', sanitize($payment_data['payment_method']))); ?>
                        </span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('ordered_from'); ?> : </strong>
                            <?php
                            $restaurant_ids = $this->order_model->get_restaurant_ids(sanitize($approved['code']));
                            foreach ($restaurant_ids as $restaurant_id) :
                                $restaurant_detail = $this->restaurant_model->get_by_id(sanitize($restaurant_id)); ?>
                                <?php if (isset($restaurant_detail['id'])) : ?>
                                    ∙ <?php echo sanitize($restaurant_detail['name']); ?>
                                <?php else : ?>
                                    <span class="text-red">∙ <?php echo get_phrase("not_found"); ?></span>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </span>

                        <div class="row mt-2">
                            <div class="col-12">
                                <a href="<?php echo site_url('orders/details/' . sanitize($approved['code'])); ?>" class="btn btn-secondary btn-block btn-sm text-xs"><?php echo get_phrase('details'); ?></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            <?php endforeach; ?>
            <?php if (!count($orders['approved'])) : ?>
                <h6 class="text-center"><?php echo get_phrase('no_data_found'); ?></h6>
            <?php endif; ?>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<div class="col-lg-4 col-md-6">
    <div class="card card-outline">
        <div class="card-header bg-success">
            <h3 class="card-title"><?php echo get_phrase('delivered_orders'); ?> (<?php echo count($orders['delivered']); ?>)</h3>
        </div>
        <div class="card-body">
            <?php foreach ($orders['delivered'] as $delivered) :
                $order_details = $this->order_model->details(sanitize($delivered['code']));
                $payment_data = $this->payment_model->get_payment_data_by_order_code($delivered['code']);
            ?>
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <span class="d-block text-xs"><strong><?php echo get_phrase('code'); ?> : </strong> <?php echo sanitize($delivered['code']); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('order_placed_at'); ?> : </strong> <?php echo date('h:i:s A', sanitize($delivered['order_placed_at'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('ordered_items'); ?> : </strong> <?php echo count($order_details); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('total_bill'); ?> : </strong><?php echo currency(sanitize($delivered['grand_total'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('payment_status'); ?> : </strong>
                            <?php if ($payment_data['amount_to_pay'] == $payment_data['amount_paid']) : ?>
                                <span class="badge badge-success lighten-success"><?php echo get_phrase(sanitize('paid')); ?></span>
                            <?php else : ?>
                                <span class="badge badge-danger lighten-danger"><?php echo get_phrase(sanitize('unpaid')); ?></span>
                            <?php endif; ?>
                        </span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('payment_method'); ?> : </strong>
                            <?php echo ucfirst(str_replace('_', ' ', sanitize($payment_data['payment_method']))); ?>
                        </span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('ordered_from'); ?> : </strong>
                            <?php
                            $restaurant_ids = $this->order_model->get_restaurant_ids(sanitize($delivered['code']));
                            foreach ($restaurant_ids as $restaurant_id) :
                                $restaurant_detail = $this->restaurant_model->get_by_id(sanitize($restaurant_id)); ?>
                                ∙ <?php echo sanitize($restaurant_detail['name']); ?>
                            <?php endforeach; ?>
                        </span>

                        <div class="row mt-2">
                            <div class="col-12">
                                <a href="<?php echo site_url('orders/details/' . sanitize($delivered['code'])); ?>" class="btn btn-success btn-block btn-sm text-xs"><?php echo get_phrase('details'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (!count($orders['delivered'])) : ?>
                <h6 class="text-center"><?php echo get_phrase('no_data_found'); ?></h6>
            <?php endif; ?>
        </div>
    </div>
</div>