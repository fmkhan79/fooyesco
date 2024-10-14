<!-- Content Header -->
<?php include 'header.php'; ?>
<!-- /.content-header -->
<?php
$customer_details = $this->customer_model->get_by_id(sanitize($order_data['customer_id']));
$payment_data = $this->payment_model->get_payment_data_by_order_code($order_code);
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">

                        <h3 class="profile-username text-center"><?php echo sanitize($order_code); ?></h3>

                        <p class="text-muted text-center">
                            <i class='far fa-calendar-alt'></i> <?php echo date('D, d-M-Y', sanitize($order_data['order_placed_at'])); ?><br>
                        </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b><?php echo get_phrase('order_type'); ?>: </b> <a class="float-right">
                                    <?php if ($order_data['order_type'] == "pickup") : ?>
                                        <span class="badge badge-success lighten-success"><?php echo get_phrase('pickup'); ?></span>
                                    <?php else : ?>
                                        <span class="badge badge-warning lighten-warning"><?php echo get_phrase('delivery'); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('total_food_price'); ?>: </b> <a class="float-right"><?php echo currency(sanitize($order_data['total_menu_price'])); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b> <?php echo get_delivery_settings('vat'); ?>% VAT: </b> <a class="float-right"><?php echo currency(sanitize($order_data['total_vat_amount'])); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('sub_total'); ?>: </b> <a class="float-right"><?php echo currency(sanitize($order_data['total_menu_price']) + sanitize($order_data['total_vat_amount'])); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('total_delivery_charge'); ?>: </b> <a class="float-right"><?php echo currency(sanitize($order_data['total_delivery_charge'])); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('grand_total'); ?>: </b> <a class="float-right"><?php echo currency(sanitize($order_data['grand_total'])); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('payment_status'); ?>: </b>
                                <a class="float-right">
                                    <?php if (isset($payment_data['amount_to_pay']) && isset($payment_data['amount_paid']) && $payment_data['amount_to_pay'] == $payment_data['amount_paid']) : ?>
                                        <span class="badge badge-success lighten-success"><?php echo get_phrase(sanitize('paid')); ?></span>
                                    <?php else : ?>
                                        <span class="badge badge-danger lighten-danger"><?php echo get_phrase(sanitize('unpaid')); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="list-group-item border-bottom-0">
                                <b><?php echo get_phrase('payment_method'); ?>: </b>
                                <a class="float-right">
                                    <strong>
                                        <?php echo ucfirst(str_replace('_', ' ', sanitize(isset($payment_data['payment_method']) ? $payment_data['payment_method'] : "Not found"))); ?>
                                    </strong>
                                </a>
                            </li>
                            <?php if (can_process_order()) : ?>
                                <?php if ($order_data['order_status'] == "pending" || $order_data['order_status'] == "approved") : ?>
                                    <li class="list-group-item border-bottom-0">
                                        <a href="javascript:void(0)" class="btn btn-danger btn-block" onclick="confirm_modal('<?php echo site_url('orders/cancel/' . sanitize($order_data['code'])); ?>')"><b> <i class="fas fa-times-rectangle"></i> <?php echo get_phrase('cancel_this_order'); ?></b></a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($order_data['order_status'] == "pending") : ?>
                                    <li class="list-group-item border-bottom-0 text-center">
                                        <a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($order_data['code']) . '/approved'); ?>')"><b> <i class="fas fa-times-rectangle"></i> <?php echo get_phrase('approve'); ?></b></a>
                                        <small class="text-muted"><?php echo get_phrase('update_order_status_to'); ?> <strong><?php echo get_phrase('approved'); ?></strong></small>
                                    </li>
                                <?php elseif ($order_data['order_status'] == "approved") : ?>
                                    <li class="list-group-item border-bottom-0 text-center">
                                        <a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($order_data['code']) . '/preparing'); ?>')"><b> <i class="fas fa-times-rectangle"></i> <?php echo get_phrase('preparing'); ?></b></a>
                                        <small class="text-muted"><?php echo get_phrase('update_order_status_to'); ?> <strong><?php echo get_phrase('preparing'); ?></strong></small>
                                    </li>
                                <?php elseif ($order_data['order_status'] == "preparing") : ?>
                                    <li class="list-group-item border-bottom-0 text-center">
                                        <a href="javascript:void(0)" class="btn btn-danger btn-block bg-maroon" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($order_data['code']) . '/prepared'); ?>')"><b> <i class="fas fa-times-rectangle"></i> <?php echo get_phrase('prepared'); ?></b></a>
                                        <small class="text-muted"><?php echo get_phrase('update_order_status_to'); ?> <strong><?php echo get_phrase('prepared'); ?></strong></small>
                                    </li>
                                <?php elseif ($order_data['order_status'] == "prepared") : ?>
                                    <li class="list-group-item border-bottom-0 text-center">
                                        <?php if ($payment_data['payment_method'] == "cash_on_delivery" && $payment_data['amount_to_pay'] != $payment_data['amount_paid']) : ?>
                                            <a href="javascript:void(0)" class="btn btn-success btn-block" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($order_data['code']) . '/delivered'); ?>')"><b> <i class="fas fa-times-rectangle"></i> <?php echo get_phrase('paid_and_delivered'); ?></b></a>
                                            <small class="text-muted"><?php echo get_phrase('update_order_status_to'); ?> <strong><?php echo get_phrase('delivered'); ?> <?php get_phrase('and'); ?> <span class="text-danger"><?php echo strtolower(get_phrase('mark_this_order_as_paid')); ?></span></strong></small>
                                        <?php else : ?>
                                            <a href="javascript:void(0)" class="btn btn-success btn-block" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($order_data['code']) . '/delivered'); ?>')"><b> <i class="fas fa-times-rectangle"></i> <?php echo get_phrase('delivered'); ?></b></a>
                                            <small class="text-muted"><?php echo get_phrase('update_order_status_to'); ?> <strong><?php echo get_phrase('delivered'); ?></strong></small>
                                        <?php endif; ?>

                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- CUSTOMER INFORMATION Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo get_phrase('customer_information', true); ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url('uploads/user/' . sanitize($customer_details['thumbnail'])); ?>" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?php echo sanitize($customer_details['name']); ?></h3>

                        <p class="text-muted text-center"><i class="far fa-envelope"></i> <?php echo sanitize($customer_details['email']); ?></p>
                    </div>
                    <!-- /.card-body -->
                </div>

                <?php if ($order_data['order_type'] != "pickup") : ?>
                    <!-- Address Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo get_phrase('delivery_address', true); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div id="mapid" class="card-body box-profile"></div>
                        <p class="text-muted text-left p-2"><i class="fas fa-map-signs"></i> <?php echo !empty($customer_details["address_" . $order_data['customer_address_id']]) ? sanitize($customer_details["address_" . $order_data['customer_address_id']]) : get_phrase("not_found"); ?></p>
                        <!-- /.card-body -->
                    </div>
                <?php endif; ?>


                <?php if ($order_data['order_type'] != "pickup") : ?>
                    <!-- About Driver Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo get_phrase('assigned_driver', true); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body box-profile" id="assign_driver">
                            <?php if (!$order_data['driver_id']) : ?>
                                <div class="text-center">
                                    <p class="text-muted text-center"><i class="far fa-frown"></i> <?php echo get_phrase("not_assigned_yet"); ?></p>
                                </div>
                            <?php else : ?>
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url('uploads/user/' . sanitize($order_data['driver_thumbnail'])); ?>" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center"><?php echo !empty($order_data['driver_name']) ? sanitize($order_data['driver_name']) : "-"; ?></h3>

                                <p class="text-muted text-center"><i class="far fa-envelope"></i> <?php echo !empty($order_data['driver_email']) ? sanitize($order_data['driver_email']) : get_phrase("not_found"); ?></p>
                            <?php endif; ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                <?php endif; ?>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link <?php if (!$this->session->flashdata('review_tab')) echo 'active'; ?>" href="#activity" data-toggle="tab"><?php echo get_phrase('Activity'); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="#ordered_items" data-toggle="tab"><?php echo get_phrase('ordered_items'); ?></a></li>
                            <li class="nav-item"><a class="nav-link <?php if ($this->session->flashdata('review_tab')) echo 'active'; ?>" href="#rating_and_review" data-toggle="tab"><?php echo get_phrase('rating_and_review'); ?></a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane <?php if (!$this->session->flashdata('review_tab')) echo 'active'; ?>" id="activity">
                                <!-- The timeline -->
                                <div class="timeline timeline-inverse">
                                    <div class="alert alert-info lighten-info alert-dismissible">
                                        <?php echo get_phrase('order_status'); ?> : <strong><?php echo get_phrase($order_data['order_status']); ?></strong>
                                    </div>
                                    <!-- ORDER PHASES STARTS -->
                                    <?php
                                    $phases  = ['placed', 'approved', 'preparing', 'prepared', 'delivered', 'canceled'];
                                    $bgs = [
                                        'warning',
                                        'primary',
                                        'maroon',
                                        'purple',
                                        'success',
                                        'danger'
                                    ];
                                    $icons = [
                                        'fas fa-folder-plus',
                                        'far fa-thumbs-up',
                                        'fas fa-fire',
                                        'fas fa-truck',
                                        'far fa-check-circle',
                                        'fas fa-times-circle'
                                    ];
                                    $messages = [
                                        'customer_successfully_placed_an_order',
                                        'order_has_been_approved',
                                        'preparing_food',
                                        'food_is_prepared_and_driver_is_on_the_way_to_customers_destination',
                                        'successfully_delivered',
                                        'order_has_been_canceled'
                                    ];
                                    foreach ($phases as $key => $phase) : ?>
                                        <?php if (!empty($order_data['order_' . $phases[$key] . '_at'])) : ?>
                                            <div class="time-label">
                                                <span class="bg-<?php echo sanitize($bgs[$key]); ?>">
                                                    <?php echo date('h:i A', $order_data['order_' . $phases[$key] . '_at']); ?>
                                                </span>
                                            </div>
                                            <div>
                                                <i class="<?php echo sanitize($icons[$key]); ?> bg-<?php echo sanitize($bgs[$key]); ?>"></i>
                                                <div class="timeline-item">
                                                    <div class="timeline-body">
                                                        <?php echo get_phrase($messages[$key]); ?>.
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <!-- ORDER PHASES ENDS -->
                                    <div class="time-label">
                                        <span class="bg-gray">
                                            <?php echo get_phrase('note_from_driver', true); ?>
                                        </span>
                                    </div>
                                    <div>
                                        <i class="far fa-comment-alt bg-secondary"></i>
                                        <div class="timeline-item">
                                            <div class="timeline-body">
                                                <?php echo getter(sanitize($order_data['note']), '...'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="ordered_items">
                                <?php
                                foreach ($ordered_items as $key => $ordered_item) :
                                    $restaurant_details = $this->restaurant_model->get_by_id($ordered_item['restaurant_id']);
                                    $menu_details = $this->menu_model->get_by_id($ordered_item['menu_id']); ?>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="<?php echo base_url('uploads/menu/' . sanitize($menu_details['thumbnail'])); ?>" class="order-detail-menu-thumbnail" alt="">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="order-detail-menu-title">
                                                <?php echo sanitize($menu_details['name']); ?>
                                            </div>
                                            <div class="order-detail-restaurant-name">
                                                <?php echo get_phrase('restaurant') . ': ' . sanitize($restaurant_details['name']); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3 variant-and-addons-area">
                                            <strong class="d-block"><?php echo get_phrase('variant_details'); ?></strong>
                                            <?php if (!empty($ordered_item['variant_id'])) : ?>
                                                <?php
                                                $menu_variant = $this->db->get_where('variants', ['id' => $ordered_item['variant_id']])->row_array();
                                                $menu_variant_exploded = explode(',', $menu_variant['variant']);
                                                foreach ($menu_variant_exploded as $menu_variant_with_option_id) {
                                                    $menu_variant_with_option_id_exploded = explode('-', $menu_variant_with_option_id);
                                                    $menu_variant_option_id = $menu_variant_with_option_id_exploded[0];
                                                    $menu_variant_option = $this->db->get_where('variant_options', ['id' => $menu_variant_option_id])->row_array();
                                                    echo sanitize($menu_variant_option['name']) . ' : ' . ucfirst(sanitize($menu_variant_with_option_id_exploded[1])) . '<br/> ';
                                                }
                                                ?>
                                            <?php else : ?>
                                                <span><?php echo get_phrase('this_menu_has_no_variant'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-2 variant-and-addons-area">
                                            <strong class="d-block"><?php echo get_phrase('addons'); ?></strong>
                                            <?php if (!empty($ordered_item['addons'])) : ?>
                                                <?php
                                                $addons_exploded = explode(',', $ordered_item['addons']);
                                                foreach ($addons_exploded as $key => $addon) {
                                                    $addon_details = $this->db->get_where('addons', ['id' => $addon])->row_array();
                                                    echo ucfirst(sanitize($addon_details['name'])) . ': ' . currency($addon_details['price']) . '<br/> ';
                                                }
                                                ?>
                                            <?php else : ?>
                                                <span><?php echo get_phrase('no_addon_selected'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="order-detail-menu-unit-price mt-2">
                                                <?php echo get_phrase('unit_price'); ?> :
                                                <?php if (!empty($ordered_item['variant_id'])) : ?>
                                                    <?php echo currency($menu_variant['price']); ?>
                                                <?php else : ?>
                                                    <?php echo currency(get_menu_price($ordered_item['menu_id'], $ordered_item['servings'])); ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="order-detail-menu-quantity mt-0">
                                                <?php echo get_phrase('quantity') . ': ' . sanitize($ordered_item['quantity']); ?>
                                            </div>
                                            <div class="order-detail-menu-quantity mt-0">
                                                <?php
                                                if (!empty($ordered_item['addons'])) {
                                                    $total_addon_price = 0;
                                                    $addons_exploded = explode(',', $ordered_item['addons']);
                                                    foreach ($addons_exploded as $key => $addon) {
                                                        $addon_details = $this->db->get_where('addons', ['id' => $addon])->row_array();
                                                        $total_addon_price += $addon_details['price'];
                                                    }
                                                    echo get_phrase('addon_price') . ': ' . currency(sanitize($total_addon_price));
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="order-detail-menu-sub-total float-sm-right">
                                                <?php echo get_phrase('total') . ': ' . currency(sanitize($ordered_item['total'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($ordered_item['note'] && !empty($ordered_item['note'])) : ?>
                                        <div class="row mt-2">
                                            <div class="col note">
                                                <span class="text-danger"><?php echo get_phrase('note'); ?> :</span> <?php echo sanitize($ordered_item['note']); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <hr>
                                <?php endforeach; ?>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane <?php if ($this->session->flashdata('review_tab')) echo 'active'; ?>" id="rating_and_review">
                                <?php if ($order_data['order_status'] == "delivered") : ?>
                                    <?php $restaurant_ids = $this->order_model->get_restaurant_ids(sanitize($order_code));
                                    foreach ($restaurant_ids as $restaurant_id) :
                                        $restaurant_details = $this->restaurant_model->get_by_id(sanitize($restaurant_id));
                                        if ($restaurant_details['owner_id'] != $this->session->userdata('user_id'))
                                            continue;
                                        $review = $this->review_model->get_a_review(['order_code' => sanitize($order_code), 'customer_id' => sanitize($order_data['customer_id']), 'restaurant_id' => sanitize($restaurant_id)]);
                                    ?>
                                        <div class="callout">
                                            <h5><?php echo get_phrase('review_for'); ?> : <?php echo sanitize($restaurant_details['name']); ?></h5>
                                            <div class="card-footer card-comments bg-white">
                                                <div class="card-comment">
                                                    <span class="d-block">
                                                        <strong><?php echo get_phrase('rating'); ?> :</strong>
                                                        <?php if (isset($review['rating'])) : ?>
                                                            <?php for ($i = 1; $i <= sanitize($review['rating']); $i++) : ?>
                                                                <i class="fas fa-star text-warning"></i>
                                                            <?php endfor; ?>
                                                            <?php for ($i = 1; $i <= 5 - sanitize($review['rating']); $i++) : ?>
                                                                <i class="fas fa-star text-black-50"></i>
                                                            <?php endfor; ?>
                                                            <span class="text-muted float-right"><?php echo date('D, d-M-Y', sanitize($review['timestamp'])); ?></span>
                                                        <?php else : ?>
                                                            <span class="font-weight-500"><?php echo get_phrase('customer_has_not_provided_yet'); ?></span>
                                                        <?php endif; ?>
                                                    </span>
                                                    <span class="d-block">
                                                        <strong><?php echo get_phrase('review'); ?> : </strong>
                                                        <?php echo isset($review['review']) ? sanitize($review['review']) : get_phrase('customer_has_not_provided_yet'); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="text-center">
                                        <img src="<?php echo base_url('assets/backend/img/review.png'); ?>" class="review-placeholder">
                                        <h6><?php echo get_phrase('please_wait', true); ?>, <strong><?php echo get_phrase('customer_can_write_a_review_after_delivering_the_order'); ?>.</strong></h6>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>