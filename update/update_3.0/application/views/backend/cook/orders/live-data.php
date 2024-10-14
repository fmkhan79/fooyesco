<div class="col-lg-3 col-md-6">
    <div class="card card-outline">
        <div class="card-header bg-danger">
            <h3 class="card-title"><?php echo get_phrase('pending_orders'); ?> (<?php echo count($orders['pending']); ?>)</h3>
        </div>
        <div class="card-body">
            <?php foreach ($orders['pending'] as $pending) :
                $order_data = $this->order_model->get_by_code($pending['code']);
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
                                <?php if (isset($restaurant_detail['id'])) : ?>
                                    ∙ <?php echo sanitize($restaurant_detail['name']); ?>
                                <?php else : ?>
                                    <span class="text-red">∙ <?php echo get_phrase("not_found"); ?></span>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('order_type'); ?> : </strong><?php echo sanitize(get_phrase($pending['order_type'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('driver'); ?> : </strong>
                            <?php echo !empty($order_data['driver_name']) ? sanitize($order_data['driver_name']) : "<span class='text-danger'>" . get_phrase('no_assigned_yet') . "</span>"; ?>
                        </span>
                        <span class="d-block text-xs mt-2">
                            <?php foreach ($order_details as $key => $order_detail) : ?>
                                <?php $menu_details = $this->menu_model->get_by_id($order_detail['menu_id']); ?>
                                <div class="ordered-menu-separator">
                                    <strong><?php echo get_phrase('item') . ' ' . $key + 1; ?> : </strong> <?php echo sanitize($menu_details['name']); ?> <strong>X <?php echo sanitize($order_detail['quantity']); ?></strong> <br>
                                    <?php if (!empty($order_detail['variant_id'])) : ?>
                                        <?php
                                        $menu_variant = $this->db->get_where('variants', ['id' => $order_detail['variant_id']])->row_array();
                                        $menu_variant_exploded = explode(',', $menu_variant['variant']);
                                        foreach ($menu_variant_exploded as $menu_variant_with_option_id) :
                                            $menu_variant_with_option_id_exploded = explode('-', $menu_variant_with_option_id);
                                            $menu_variant_option_id = $menu_variant_with_option_id_exploded[0];
                                            $menu_variant_option = $this->db->get_where('variant_options', ['id' => $menu_variant_option_id])->row_array();
                                        ?>
                                            <span class="d-block text-xs"><strong><?php echo sanitize($menu_variant_option['name']); ?> : </strong><?php echo ucfirst(sanitize($menu_variant_with_option_id_exploded[1])); ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($order_detail['addons'])) : ?>
                                        <?php
                                        $addons_exploded = explode(',', $order_detail['addons']);
                                        foreach ($addons_exploded as $key => $addon) :
                                            $addon_details = $this->db->get_where('addons', ['id' => $addon])->row_array();
                                        ?>
                                            <span class="d-block text-xs"><strong><?php echo get_phrase('addon') . ' ' . $key + 1; ?> : </strong><?php echo ucfirst(sanitize($addon_details['name'])); ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </span>
                        <div class="row mt-2">
                            <div class="col-4">
                                <a href="<?php echo site_url('orders/details/' . sanitize($pending['code'])); ?>" class="btn btn-secondary btn-block btn-sm text-xs"><?php echo get_phrase('details'); ?></a>
                            </div>
                            <div class="col-8">
                                <a href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($pending['code']) . '/approved'); ?>')" class="btn btn-warning btn-block btn-sm text-xs"><?php echo get_phrase('approve_this_order'); ?></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            <?php endforeach; ?>
            <?php if (!count($orders['pending'])) : ?>
                <h6 class="text-center"><?php echo get_phrase('no_data_found'); ?></h6>
            <?php endif; ?>
        </div>
        <!-- /.card-body -->
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card card-outline">
        <div class="card-header bg-warning">
            <h3 class="card-title"><?php echo get_phrase('approved_orders'); ?> (<?php echo count($orders['approved']); ?>)</h3>
        </div>
        <div class="card-body">
            <?php foreach ($orders['approved'] as $approved) :
                $order_data = $this->order_model->get_by_code($approved['code']);
                $order_details = $this->order_model->details(sanitize($approved['code']));
                $payment_data = $this->payment_model->get_payment_data_by_order_code($approved['code']);
            ?>
                <div class="card card-outline card-warning">
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
                        <span class="d-block text-xs"><strong><?php echo get_phrase('order_type'); ?> : </strong><?php echo sanitize(get_phrase($approved['order_type'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('driver'); ?> : </strong>
                            <?php echo !empty($order_data['driver_name']) ? sanitize($order_data['driver_name']) : "<span class='text-danger'>" . get_phrase('no_assigned_yet') . "</span>"; ?>
                        </span>
                        <span class="d-block text-xs mt-2">
                            <?php foreach ($order_details as $key => $order_detail) : ?>
                                <?php $menu_details = $this->menu_model->get_by_id($order_detail['menu_id']); ?>
                                <div class="ordered-menu-separator">
                                    <strong><?php echo get_phrase('item') . ' ' . $key + 1; ?> : </strong> <?php echo sanitize($menu_details['name']); ?> <strong>X <?php echo sanitize($order_detail['quantity']); ?></strong> <br>
                                    <?php if (!empty($order_detail['variant_id'])) : ?>
                                        <?php
                                        $menu_variant = $this->db->get_where('variants', ['id' => $order_detail['variant_id']])->row_array();
                                        $menu_variant_exploded = explode(',', $menu_variant['variant']);
                                        foreach ($menu_variant_exploded as $menu_variant_with_option_id) :
                                            $menu_variant_with_option_id_exploded = explode('-', $menu_variant_with_option_id);
                                            $menu_variant_option_id = $menu_variant_with_option_id_exploded[0];
                                            $menu_variant_option = $this->db->get_where('variant_options', ['id' => $menu_variant_option_id])->row_array();
                                        ?>
                                            <span class="d-block text-xs"><strong><?php echo sanitize($menu_variant_option['name']); ?> : </strong><?php echo ucfirst(sanitize($menu_variant_with_option_id_exploded[1])); ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($order_detail['addons'])) : ?>
                                        <?php
                                        $addons_exploded = explode(',', $order_detail['addons']);
                                        foreach ($addons_exploded as $key => $addon) :
                                            $addon_details = $this->db->get_where('addons', ['id' => $addon])->row_array();
                                        ?>
                                            <span class="d-block text-xs"><strong><?php echo get_phrase('addon') . ' ' . $key + 1; ?> : </strong><?php echo ucfirst(sanitize($addon_details['name'])); ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </span>
                        <div class="row mt-2">
                            <div class="col-4">
                                <a href="<?php echo site_url('orders/details/' . sanitize($approved['code'])); ?>" class="btn btn-secondary btn-block btn-sm text-xs"><?php echo get_phrase('details'); ?></a>
                            </div>
                            <div class="col-8">
                                <a href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($approved['code']) . '/preparing'); ?>')" class="btn btn-info btn-block btn-sm text-xs"><?php echo get_phrase('mark_as_preparing'); ?></a>
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


<div class="col-lg-3 col-md-6">
    <div class="card card-outline">
        <div class="card-header bg-info">
            <h3 class="card-title"><?php echo get_phrase('preparing_orders'); ?> (<?php echo count($orders['preparing']); ?>)</h3>
        </div>
        <div class="card-body">
            <?php foreach ($orders['preparing'] as $preparing) :
                $order_data = $this->order_model->get_by_code($preparing['code']);
                $order_details = $this->order_model->details(sanitize($preparing['code']));
                $payment_data = $this->payment_model->get_payment_data_by_order_code($preparing['code']);
            ?>
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <span class="d-block text-xs"><strong><?php echo get_phrase('code'); ?> : </strong> <?php echo sanitize($preparing['code']); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('order_placed_at'); ?> : </strong> <?php echo date('h:i:s A', sanitize($preparing['order_placed_at'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('ordered_items'); ?> : </strong> <?php echo count($order_details); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('total_bill'); ?> : </strong><?php echo currency(sanitize($preparing['grand_total'])); ?></span>
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
                            $restaurant_ids = $this->order_model->get_restaurant_ids(sanitize($preparing['code']));
                            foreach ($restaurant_ids as $restaurant_id) :
                                $restaurant_detail = $this->restaurant_model->get_by_id(sanitize($restaurant_id)); ?>
                                ∙ <?php echo sanitize($restaurant_detail['name']); ?>
                            <?php endforeach; ?>
                        </span>

                        <span class="d-block text-xs"><strong><?php echo get_phrase('order_type'); ?> : </strong><?php echo sanitize(get_phrase($preparing['order_type'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('driver'); ?> : </strong>
                            <?php echo !empty($order_data['driver_name']) ? sanitize($order_data['driver_name']) : "<span class='text-danger'>" . get_phrase('no_assigned_yet') . "</span>"; ?>
                        </span>
                        <span class="d-block text-xs mt-2">
                            <?php foreach ($order_details as $key => $order_detail) : ?>
                                <?php $menu_details = $this->menu_model->get_by_id($order_detail['menu_id']); ?>
                                <div class="ordered-menu-separator">
                                    <strong><?php echo get_phrase('item') . ' ' . $key + 1; ?> : </strong> <?php echo sanitize($menu_details['name']); ?> <strong>X <?php echo sanitize($order_detail['quantity']); ?></strong> <br>
                                    <?php if (!empty($order_detail['variant_id'])) : ?>
                                        <?php
                                        $menu_variant = $this->db->get_where('variants', ['id' => $order_detail['variant_id']])->row_array();
                                        $menu_variant_exploded = explode(',', $menu_variant['variant']);
                                        foreach ($menu_variant_exploded as $menu_variant_with_option_id) :
                                            $menu_variant_with_option_id_exploded = explode('-', $menu_variant_with_option_id);
                                            $menu_variant_option_id = $menu_variant_with_option_id_exploded[0];
                                            $menu_variant_option = $this->db->get_where('variant_options', ['id' => $menu_variant_option_id])->row_array();
                                        ?>
                                            <span class="d-block text-xs"><strong><?php echo sanitize($menu_variant_option['name']); ?> : </strong><?php echo ucfirst(sanitize($menu_variant_with_option_id_exploded[1])); ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($order_detail['addons'])) : ?>
                                        <?php
                                        $addons_exploded = explode(',', $order_detail['addons']);
                                        foreach ($addons_exploded as $key => $addon) :
                                            $addon_details = $this->db->get_where('addons', ['id' => $addon])->row_array();
                                        ?>
                                            <span class="d-block text-xs"><strong><?php echo get_phrase('addon') . ' ' . $key + 1; ?> : </strong><?php echo ucfirst(sanitize($addon_details['name'])); ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </span>
                        <div class="row mt-2">
                            <div class="col-4">
                                <a href="<?php echo site_url('orders/details/' . sanitize($preparing['code'])); ?>" class="btn btn-secondary btn-block btn-sm text-xs"><?php echo get_phrase('details'); ?></a>
                            </div>
                            <div class="col-8">
                                <a href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($preparing['code']) . '/prepared'); ?>')" class="btn btn-success btn-block btn-sm text-xs"><?php echo get_phrase('Mark_as_Prepared'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (!count($orders['preparing'])) : ?>
                <h6 class="text-center"><?php echo get_phrase('no_data_found'); ?></h6>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card card-outline">
        <div class="card-header bg-success">
            <h3 class="card-title"><?php echo get_phrase('ready_for_deliver'); ?> (<?php echo count($orders['prepared']); ?>)</h3>
        </div>
        <div class="card-body">
            <?php foreach ($orders['prepared'] as $prepared) :
                $order_data = $this->order_model->get_by_code($prepared['code']);
                $order_details = $this->order_model->details(sanitize($prepared['code']));
                $payment_data = $this->payment_model->get_payment_data_by_order_code($prepared['code']);
            ?>
                <div class="card card-outline card-success">
                    <div class="card-body">
                        <span class="d-block text-xs"><strong><?php echo get_phrase('code'); ?> : </strong> <?php echo sanitize($prepared['code']); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('order_placed_at'); ?> : </strong> <?php echo date('h:i:s A', sanitize($prepared['order_placed_at'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('ordered_items'); ?> : </strong> <?php echo count($order_details); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('total_bill'); ?> : </strong><?php echo currency(sanitize($prepared['grand_total'])); ?></span>
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
                            $restaurant_ids = $this->order_model->get_restaurant_ids(sanitize($prepared['code']));
                            foreach ($restaurant_ids as $restaurant_id) :
                                $restaurant_detail = $this->restaurant_model->get_by_id(sanitize($restaurant_id)); ?>
                                ∙ <?php echo sanitize($restaurant_detail['name']); ?>
                            <?php endforeach; ?>
                        </span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('order_type'); ?> : </strong><?php echo sanitize(get_phrase($prepared['order_type'])); ?></span>
                        <span class="d-block text-xs"><strong><?php echo get_phrase('driver'); ?> : </strong>
                            <?php echo !empty($order_data['driver_name']) ? sanitize($order_data['driver_name']) : "<span class='text-danger'>" . get_phrase('no_assigned_yet') . "</span>"; ?>
                        </span>
                        <span class="d-block text-xs mt-2">
                            <?php foreach ($order_details as $key => $order_detail) : ?>
                                <?php $menu_details = $this->menu_model->get_by_id($order_detail['menu_id']); ?>
                                <div class="ordered-menu-separator">
                                    <strong><?php echo get_phrase('item') . ' ' . $key + 1; ?> : </strong> <?php echo sanitize($menu_details['name']); ?> <strong>X <?php echo sanitize($order_detail['quantity']); ?></strong> <br>
                                    <?php if (!empty($order_detail['variant_id'])) : ?>
                                        <?php
                                        $menu_variant = $this->db->get_where('variants', ['id' => $order_detail['variant_id']])->row_array();
                                        $menu_variant_exploded = explode(',', $menu_variant['variant']);
                                        foreach ($menu_variant_exploded as $menu_variant_with_option_id) :
                                            $menu_variant_with_option_id_exploded = explode('-', $menu_variant_with_option_id);
                                            $menu_variant_option_id = $menu_variant_with_option_id_exploded[0];
                                            $menu_variant_option = $this->db->get_where('variant_options', ['id' => $menu_variant_option_id])->row_array();
                                        ?>
                                            <span class="d-block text-xs"><strong><?php echo sanitize($menu_variant_option['name']); ?> : </strong><?php echo ucfirst(sanitize($menu_variant_with_option_id_exploded[1])); ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($order_detail['addons'])) : ?>
                                        <?php
                                        $addons_exploded = explode(',', $order_detail['addons']);
                                        foreach ($addons_exploded as $key => $addon) :
                                            $addon_details = $this->db->get_where('addons', ['id' => $addon])->row_array();
                                        ?>
                                            <span class="d-block text-xs"><strong><?php echo get_phrase('addon') . ' ' . $key + 1; ?> : </strong><?php echo ucfirst(sanitize($addon_details['name'])); ?></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </span>
                        <div class="row mt-2">
                            <div class="col-12">
                                <a href="<?php echo site_url('orders/details/' . sanitize($prepared['code'])); ?>" class="btn btn-secondary btn-block btn-sm text-xs">
                                    <?php echo get_phrase('details'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (!count($orders['prepared'])) : ?>
                <h6 class="text-center"><?php echo get_phrase('no_data_found'); ?></h6>
            <?php endif; ?>
        </div>
    </div>
</div>