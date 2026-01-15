<!-- Content Header -->
<?php include 'header.php'; ?>
<!-- /.content-header -->
<?php
$customer_details = $this->customer_model->get_by_id(sanitize($order_data['customer_id']));
$payment_data = $this->payment_model->get_payment_data_by_order_code($order_code);
$restaurant_details = $this->restaurant_model->get_by_id($order_data['restaurant_id']);
$res_discount = $restaurant_details['res_discount'];
if ($order_data["order_type"] == "pickup") {
    $res_discount = $restaurant_details['pick_discount']; 
}

$host = $_SERVER['HTTP_HOST'];
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
                            <?php 
                                if($order_data['is_online_discount'] != null):
                            ?>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('online_discount'); ?>: </b> <a class="float-right"><?php echo sanitize($order_data['is_online_discount']); ?>%</a>
                            </li>
                             <?php 
                                endif;
                             if ($order_data['promo_code'] != null) {
                                    $res_discount = $order_data['promo_discount'];
                                ?>
                                    <li class="list-group-item">
                                        <b><?php echo get_phrase('promo_code_discount'); ?>: </b>
                                        <a class="float-right">
                                            <?php echo sanitize($order_data['promo_code']) . ' (' . $order_data['promo_discount'] . '%)'; ?>
                                        </a>
                                    </li>
                                <?php
                                } else {
                                    // Promo code nahi hai to pickup ya online discount show karo
                                    if ($order_data["order_type"] == "pickup") {
                                ?>
                                        <li class="list-group-item">
                                            <b><?php echo get_phrase('online_discount'); ?>: </b>
                                            <a class="float-right"><?php     $res_discount = $restaurant_details['pick_discount']; 
?></a>
                                        </li>
                                <?php
                                    } else {
                                ?>
                                        <li class="list-group-item">
                                            <b><?php echo get_phrase('online_discount'); ?>: </b>
                                            <a class="float-right"><?php $res_discount = $restaurant_details['res_discount'];
?></a>
                                        </li>
                                <?php
                                    }
                                }
                                if ($order_data['order_type'] != "pickup") :
                            ?>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('total_delivery_charge'); ?>: </b> <a class="float-right"><?php echo currency(sanitize($order_data['total_delivery_charge'])); ?></a>
                            </li>
                            <?php endif; ?>
                            <li class="list-group-item">
                                <b><?php echo get_phrase('grand_total'); ?>: </b> <a class="float-right"><?php echo currency(number_format($order_data['grand_total'], 2)); ?></a>
                            
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
                            <?php if ($order_data['order_url'] != null) { ?>
                            <li class="list-group-item border-bottom-0">
                                <b><?php echo get_phrase('order_placed_from'); ?>: </b>
                                <a class="float-right" target="_blank"
                                <?php 
                                    if ($host == 'www.fooyes.local' || $host == 'www.chillihutmarch.fooyes.local') {
                                        echo 'href="http://' . $order_data['order_url'] . '"';
                                    }else{
                                        echo 'href="https://' . $order_data['order_url'] . '"';
                                    }
                                ?>
                                >
                                    <?php echo $order_data['order_url']; ?>
                                </a>
                            </li>
                            <li class="list-group-item border-bottom-0">
                                <b><?php echo get_phrase('User Device'); ?>: </b>
                                <a class="float-right">
                                    <strong>
                        <?php
                        $userAgent = $order_data['user_agent'] ?? '';

                        $browser = 'Unknown';

                        if (strpos($userAgent, 'Chrome') !== false && strpos($userAgent, 'Edg') === false) {
                            $browser = 'Chrome';
                        } elseif (strpos($userAgent, 'Firefox') !== false) {
                            $browser = 'Firefox';
                        } elseif (strpos($userAgent, 'Safari') !== false && strpos($userAgent, 'Chrome') === false) {
                            $browser = 'Safari';
                        } elseif (strpos($userAgent, 'Edg') !== false) {
                            $browser = 'Edge';
                        } elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
                            $browser = 'Opera';
                        }

                        echo $browser;
                        ?>

                                    </strong>
                                </a>
                            </li>
                            <?php } ?>
                            <li class="list-group-item border-bottom-0 text-center">
                                <a href="javascript:void(0)" onclick="openHiddenWindow('<?php echo site_url('orders/print_recipt/' . sanitize($order_data['code'])); ?>'); return false;" class="btn btn-primary btn-block" "><b> <i class="fas fa-times-rectangle"></i> Print</b></a>
                                    </li>
                           <a href="<?php echo site_url('orders/view/' . sanitize($order_data['code'])); ?>"
                               target="_blank"
                                class="btn btn-danger btn-block">
                                <i class="fas fa-eye"></i> See Order
                                </a>

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
                          <div class="tab-pane fade" id="ordered_items">

                                            <?php foreach ($ordered_items as $ordered_item): 
                                                $ordered_item = (array)$ordered_item;

                                                $restaurant = $this->restaurant_model->get_by_id($ordered_item['restaurant_id'] ?? 0);
                                                $menu       = $this->menu_model->get_by_id($ordered_item['menu_id'] ?? 0);

                                                $qty        = intval($ordered_item['quantity'] ?? 1);
                                                $itemTotal  = floatval($ordered_item['total'] ?? 0);
                                            ?>

                                            <div class="card mb-3 shadow-sm">
                                                <div class="card-body">

                                                    <!-- ITEM HEADER -->
                                                    <div class="row align-items-center">
                                                        <div class="col-md-2">
                                                            <img src="<?= base_url('uploads/menu/'.sanitize($menu['thumbnail'] ?? '')) ?>"
                                                                class="img-fluid rounded">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <h5 class="mb-1"><?= sanitize($menu['name'] ?? '') ?></h5>
                                                            <small class="text-muted">
                                                                <?= get_phrase('restaurant') ?>:
                                                                <?= sanitize($restaurant['name'] ?? '') ?>
                                                            </small>
                                                        </div>

                                                        <div class="col-md-4 text-end">
                                                            <span class="badge bg-secondary">
                                                                <?= get_phrase('qty') ?>: <?= $qty ?>
                                                            </span>
                                                            <h5 class="mt-2 text-success">
                                                                <?= currency($itemTotal) ?>
                                                            </h5>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <!-- VARIANT -->
                                                    <?php if (!empty($ordered_item['variant_id'])): 
                                                        $variant = $this->menu_model->get_variant_detail($ordered_item['variant_id']);
                                                    ?>
                                                        <div class="mb-2">
                                                            <strong><?= get_phrase('variant') ?>:</strong>
                                                            <span class="text-muted">
                                                                <?= sanitize($variant[0]['name'] ?? '') ?>
                                                            </span>
                                                        </div>
                                                    <?php endif; ?>

                                                <?php
                                            $addonHTML = "";

                                            if (!empty($ordered_item["addons"]) && $ordered_item["addons"] !== "[]") {

                                                $addons = json_decode($ordered_item["addons"], true);

                                                if (is_array($addons) && count($addons) > 0) {

                                                    // CASE 1: FLAT ARRAY (old format)
                                                    if (isset($addons[0]) && is_string($addons[0])) {

                                                        $addonHTML = '<ul class="list-unstyled ms-3">';
                                                        foreach ($addons as $addonName) {
                                                            $addonHTML .= '<li>+ ' . sanitize($addonName) . '</li>';
                                                        }
                                                        $addonHTML .= '</ul>';
                                                    }

                                                    // CASE 2: NEW FORMAT (subVariantId + itemId)
                                                    else if (isset($addons[0]) && is_array($addons[0]) && isset($addons[0]['subVariantId'])) {

                                                        $groupedAddons = [];

                                                        foreach ($addons as $addon) {
                                                            $subVariantId = $addon['subVariantId'] ?? null;
                                                            $itemId       = $addon['itemId'] ?? null;

                                                            if ($subVariantId === null || $itemId === null) {
                                                                continue;
                                                            }

                                                            if (!isset($groupedAddons[$subVariantId])) {
                                                                $groupedAddons[$subVariantId] = [];
                                                            }

                                                            $groupedAddons[$subVariantId][] = $itemId;
                                                        }

                                                        if (!empty($groupedAddons)) {
                                                            $addonHTML = $this->menu_model->addons_grouped_data($groupedAddons);
                                                        }
                                                    }
                                                }
                                            }
                                            ?>



                                                    <?php if (!empty($addonHTML)): ?>
                                                <div class="mb-2">
                                                    <strong><?= get_phrase('addons') ?>:</strong>
                                                    <?= $addonHTML ?>
                                                </div>
                                            <?php endif; ?>


                                                    <!-- NOTE -->
                                                    <?php if (!empty($ordered_item['note'])): ?>
                                                        <div class="alert alert-warning p-2 mt-2">
                                                            <strong><?= get_phrase('note') ?>:</strong>
                                                            <?= sanitize($ordered_item['note']) ?>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>

                                            <?php endforeach; ?>

                                            </div>
        

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

<script>
function openHiddenWindow(url) {
    const win = window.open(url, '_blank', 'width=1,height=1,left=0,top=0,resizable=no,scrollbars=no');
    if (win) {
        win.blur(); // Focus hata dein
        window.focus(); // Apni window pe wapas aajaye
    } else {
        console.error('Popup blocked! Please allow popups for this website.');
    }
}

</script>