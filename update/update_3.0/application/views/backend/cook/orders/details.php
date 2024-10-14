<!-- Content Header -->
<?php include 'header.php'; ?>
<!-- /.content-header -->
<?php
$customer_details = $this->customer_model->get_by_id(sanitize($order_data['customer_id']));
$payment_data = $this->payment_model->get_payment_data_by_order_code($order_code);
$restaurant_id = $ordered_items[0]['restaurant_id'];
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
                     <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#ordered_items" data-toggle="tab"><?php echo get_phrase('ordered_items'); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab"><?php echo get_phrase('Activity'); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="#rating_and_review" data-toggle="tab"><?php echo get_phrase('rating_and_review'); ?></a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="ordered_items">
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
                            <div class="tab-pane" id="activity">
                                <!-- The timeline -->
                                <div class="timeline timeline-inverse">

                                    <?php if ($order_data['order_type'] == "delivery" && $this->session->userdata('user_role') == "cook") : ?>
                                        <div class="alert alert-warning lighten-warning alert-dismissible">
                                            <?php echo get_phrase('at_first_assign_a_driver'); ?> : <strong><a href="#assign_driver" class="text-warning text-dec-none"><?php echo get_phrase('click_here'); ?></a></strong>
                                        </div>
                                    <?php endif; ?>
                                    <div class="alert alert-info lighten-info alert-dismissible">
                                        <?php echo get_phrase('order_status'); ?> : <strong><?php echo get_phrase(sanitize($order_data['order_status'])); ?></strong>
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
                                    <?php if ($order_data['order_type'] == "delivery") : ?>
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
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="rating_and_review">
                                <?php if ($order_data['order_status'] == "delivered") : ?>
                                    <?php $restaurant_ids = $this->order_model->get_restaurant_ids(sanitize($order_code));
                                    foreach ($restaurant_ids as $restaurant_id) :
                                        $restaurant_details = $this->restaurant_model->get_by_id(sanitize($restaurant_id));
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
                                                            <?php for ($i = 1; $i <= sanitize(5 - $review['rating']); $i++) : ?>
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
                                <b><?php echo get_phrase('total_food_price'); ?>: </b> <a class="float-right"><?php echo currency(sanitize($order_data['total_menu_price'])); ?></a>
                            </li>
                            <li class="list-group-item">
                                <b> <?php echo get_delivery_settings('vat'); ?>% Tax: </b> <a class="float-right"><?php echo currency(sanitize($order_data['total_vat_amount'])); ?></a>
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
                                    <?php if ($payment_data['amount_to_pay'] == $payment_data['amount_paid']) : ?>
                                        <span class="badge badge-success lighten-success"><?php echo get_phrase(sanitize('paid')); ?></span>
                                    <?php else : ?>
                                        <span class="badge badge-danger lighten-danger"><?php echo get_phrase(sanitize('unpaid')); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('payment_method'); ?>: </b>
                                <a class="float-right">
                                    <strong>
                                        <?php echo ucfirst(str_replace('_', ' ', sanitize($payment_data['payment_method']))); ?>
                                    </strong>
                                </a>
                            </li>
                            <li class="list-group-item border-bottom-0">
                                <b><?php echo get_phrase('order_type'); ?>: </b>
                                <a class="float-right">
                                    <span class="badge badge-primary lighten-primary"><?php echo get_phrase(sanitize($order_data['order_type'])); ?></span>
                                </a>
                            </li>
                            <?php if ($order_data['order_status'] == "approved") : ?>
                                <li class="list-group-item border-bottom-0 text-center">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($order_data['code']) . '/preparing'); ?>')"><b> <i class="fas fa-times-rectangle"></i> <?php echo get_phrase('preparing'); ?></b></a>
                                    <small class="text-muted"><?php echo get_phrase('update_order_status_to'); ?> <strong><?php echo get_phrase('preparing'); ?></strong></small>
                                </li>
                            <?php elseif ($order_data['order_status'] == "preparing") : ?>
                                <li class="list-group-item border-bottom-0 text-center">
                                    <a href="javascript:void(0)" class="btn btn-danger btn-block bg-maroon" onclick="confirm_modal('<?php echo site_url('orders/process/' . sanitize($order_data['code']) . '/prepared'); ?>')"><b> <i class="fas fa-times-rectangle"></i> <?php echo get_phrase('prepared'); ?></b></a>
                                    <small class="text-muted"><?php echo get_phrase('update_order_status_to'); ?> <strong><?php echo get_phrase('prepared'); ?></strong></small>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
     <div class="row">
      <div class="col-md-3">
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
                        <a href="tel:<?php echo sanitize($customer_details['phone']); ?>" class="btn btn-primary btn-block"><b> <i class="fas fa-phone-alt"></i> <?php echo get_phrase('call_customer'); ?></b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
      </div>
      <div class="col-md-3">
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
      </div>
      <div class="col-md-3">
                <?php if ($order_data['order_type'] == "delivery") : ?>
                    <!-- About Driver Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo get_phrase('assigned_driver', true); ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body box-profile" id="assign_driver">
                            <?php if (!$order_data['driver_id']) : ?>
                                <form action="<?php echo site_url('orders/assign_driver'); ?>" method="POST">
                                    <?php $drivers = $this->driver_model->get_approved_drivers_by_restaurant_id($restaurant_id); ?>
                                    <input type="hidden" name="order_code" value="<?php echo sanitize($order_code); ?>">
                                    <div class="form-group">
                                        <label><?php echo get_phrase('driver'); ?> <span class='text-danger'>*</span></label>
                                        <select class="form-control select2" name="driver_id" id="driver_id">
                                            <option value=""><?php echo get_phrase('choose_a_driver'); ?></option>
                                            <?php foreach ($drivers as $key => $driver) : ?>
                                                <option value="<?php echo sanitize($driver['id']); ?>"><?php echo sanitize($driver['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block"><b><?php echo get_phrase('assign_driver'); ?></b></button>
                                </form>
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
      </div>
      <div class="col-md-3">
                    <!-- EDITING ASSIGNED DRIVER -->
                    <?php if ($order_data['driver_id']) : ?>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo get_phrase('assign_another_driver', true); ?></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body box-profile" id="assign_driver">
                                <form action="<?php echo site_url('orders/assign_driver'); ?>" method="POST">
                                    <?php $drivers = $this->driver_model->get_approved_drivers(); ?>
                                    <input type="hidden" name="order_code" value="<?php echo sanitize($order_code); ?>">
                                    <div class="form-group">
                                        <label><?php echo get_phrase('driver'); ?> <span class='text-danger'>*</span></label>
                                        <select class="form-control select2" name="driver_id" id="driver_id">
                                            <option value=""><?php echo get_phrase('choose_a_driver'); ?></option>
                                            <?php foreach ($drivers as $key => $driver) : ?>
                                                <option value="<?php echo sanitize($driver['id']); ?>"><?php echo sanitize($driver['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block"><b><?php echo get_phrase('assign_driver'); ?></b></button>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    <?php endif; ?>
                    <!-- /.card -->
                <?php endif; ?>
            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>