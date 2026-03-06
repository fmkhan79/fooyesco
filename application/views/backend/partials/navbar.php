<nav class="main-header navbar navbar-expand navbar-white navbar-light <?php if ($page_name == 'pos/index') echo 'd-none'; ?>">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item mt-1 d-sm-inline-block">
      <a href="<?php echo site_url(); ?>" class="btn btn-sm btn-primary" role="button"><i class="far fa-paper-plane"></i> <?php echo get_phrase('view_website'); ?></a>
    </li>
    <?php if ($this->session->userdata('user_role') == "customer") : ?>
      <li class="nav-item mt-1 d-sm-inline-block ml-1">
      <a href="<?php echo site_url('site/restaurant/chilli-hut-march/3'); ?>" class="btn btn-sm btn-secondary" role="button"><i class="fas fa-shopping-cart"></i> <?php echo get_phrase('view_cart'); ?></a>      </li>
    <?php endif; ?>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <?php if ($this->session->userdata('user_role') == "customer" || $this->session->userdata('user_role') == "owner") : ?>
      <?php if (is_restaurant_owner($this->session->userdata('user_id'))) : ?>
        <li class="nav-item mt-1 d-sm-inline-block mr-1">
          <?php if ($this->session->userdata('user_role') == "customer") : ?>
            <a href="<?php echo site_url('auth/switch_role'); ?>" class="btn btn-sm btn-success bg-gradient-olive role-switcher" role="button" data-toggle="tooltip" data-placement="Bottom" title="<?php echo get_phrase('a_customer_can_be_a_restaurant_owner'); ?>">
              <i class="fas fa-user-tie"></i> <?php echo get_phrase('switch_to_restaurant_owner', true); ?>
            </a>
          <?php elseif ($this->session->userdata('user_role') == "owner") : ?>
            <a href="<?php echo site_url('auth/switch_role'); ?>" class="btn btn-sm btn-success bg-gradient-olive role-switcher" role="button" data-toggle="tooltip" data-placement="Bottom" title="<?php echo get_phrase('a_restaurant_owner_can_also_have_all_the_facilities_of_a_customer'); ?>">
              <i class="fas fa-user-alt"></i> <?php echo get_phrase('switch_to_customer', true); ?>
            </a>
          <?php endif; ?>
        </li>
      <?php endif; ?>
    <?php endif; ?>
    <?php if ($this->session->userdata('user_role') == 'admin' || $this->session->userdata('user_role') == "owner") : ?>
      <?php
      $pending_orders = $this->order_model->get_number_of_orders('pending');
      $pending_restaurants = count($this->restaurant_model->get_all_pending());
      $pending_drivers = count($this->driver_model->get_pending_drivers());
      if ($this->session->userdata('user_role') == 'admin') {
        $pending_staff = $pending_orders + $pending_restaurants + $pending_drivers;
      } elseif ($this->session->userdata('user_role') == 'owner') {
        $pending_staff = $pending_orders;
      }
      ?>
      <li class="nav-item dropdown mr-3">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><?php echo sanitize($pending_staff); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?php echo get_phrase('pending_notification') ?></span>
          <div class="dropdown-divider"></div>
          <a href="<?php echo site_url('orders/today'); ?>" class="dropdown-item">
            <i class="fas fa-pizza-slice mr-2"></i> <span id="number-of-pending-orders-in-navbar"><?php echo sanitize($pending_orders); ?></span> <?php echo get_phrase('pending_orders'); ?>
          </a>
          <?php if ($this->session->userdata('user_role') == 'admin') : ?>
            <div class="dropdown-divider"></div>
            <a href="<?php echo site_url('restaurant/pending'); ?>" class="dropdown-item">
              <i class="fas fa-utensils mr-2"></i> <?php echo sanitize($pending_restaurants) . ' ' . get_phrase('pending_restaurants'); ?>
            </a>
            <div class="dropdown-divider"></div>
            <a href="<?php echo site_url('driver?status=pending'); ?>" class="dropdown-item">
              <i class="fas fa-biking mr-2"></i> <?php echo sanitize($pending_drivers) . ' ' . get_phrase('pending_drivers'); ?>
            </a>
          <?php endif; ?>
        </div>
      </li>
    <?php endif; ?>

    <li class="nav-item dropdown">
      <a href="javascript:void(0)" class="btn btn-default" data-toggle="dropdown">
        <i class="fas fa-lg fa-user-circle"></i>
      </a>
      <div class="dropdown-menu dropdown-menu dropdown-menu-right">
        <span class="dropdown-item dropdown-header"><?php echo get_phrase('welcome'); ?>, <?php echo ucwords($this->session->userdata('user_role')); ?></span>
        <a href="<?php echo site_url('settings/profile'); ?>" class="dropdown-item">
          <?php echo get_phrase('manage_profile'); ?>
        </a>
        <!-- <.?php if ($this->session->userdata('user_role') == "admin") : ?> -->
        <?php if (false) : ?>
          <a href="<?php echo site_url('settings/system'); ?>" class="dropdown-item">
            <?php echo get_phrase('system_settings'); ?>
          </a>
          <a href="<?php echo site_url('settings/website'); ?>" class="dropdown-item">
            <?php echo get_phrase('website_settings'); ?>
          </a>
        <?php endif; ?>
        <div class="dropdown-divider"></div>
        <a href="<?php echo site_url('logout'); ?>" class="dropdown-item">
          <i class="fas fa-sign-out-alt"></i> <?php echo get_phrase('logout'); ?>
        </a>
      </div>
    </li>
  </ul>
</nav>

<script>
let ShowTest = false;

/* =======================
   NEW ORDER CHECK (OLD)
======================= */

function showpopup() {
    var urls;
    const check = location.origin;
    if (check == "http://localhost") {
        urls = '/fooyesco/orders/';
    } else {
        urls = '/orders/';
    }

    $.ajax({
        url: urls + '/check_new_order',
        method: 'GET',
        success: function (data) {
            if (data.length > 0) {
                showNewOrderNotification(data);
            }
        },
        error: function () {
            console.error('Error fetching new orders.');
        }
    });
}


document.addEventListener('DOMContentLoaded', function () {
    showpopup();
    checkCustomerCancelOrder(); // 👈 NEW
}, false);

setInterval(function () {
    showpopup();
}, 8000);

/* =======================
   CUSTOMER CANCEL CHECK (NEW)
======================= */

setInterval(function () {
    checkCustomerCancelOrder();
}, 7000);

function checkCustomerCancelOrder() {

    var urls;
    const check = location.origin;
    if (check == "http://localhost") {
        urls = '/fooyesco/orders/';
    } else {
        urls = '/orders/';
    }

    $.ajax({
        url: urls + '/check_customer_cancel_order',
        method: 'GET',
        success: function (data) {

            if (data.length > 0) {
                const obj = JSON.parse(data);

                if (obj.customer_cancel == 1) {
                    showCustomerCancelPopup(obj);
                }
            }
        },
        error: function () {
            console.error('Error checking customer cancel order.');
        }
    });
}

/* =======================
   CUSTOMER CANCEL POPUP
======================= */

function showCustomerCancelPopup(obj) {

    // sound init
    let cancelnotificationSound = new Audio('<?php echo base_url('assets/auth/audio/foodpanda.mp3'); ?>');
    cancelnotificationSound.loop = true;
    cancelnotificationSound.play();

    Swal.fire({
        title: "Order Cancelled!",
        html:
            "Order ID: " + obj.id +
            " has been cancelled by customer.<br>" +
            "Total Amount: £" + obj.grand_total +
            "<br> Customer Name: " + JSON.parse(obj.billing).first_name,
        icon: "warning",

        confirmButtonText: "View Order",
        cancelButtonText: "Acknowledge",
        showCancelButton: true,

        allowOutsideClick: false
    }).then((result) => {

        // stop sound
        cancelnotificationSound.pause();
        cancelnotificationSound.currentTime = 0;

        // View Order clicked
        if (result.isConfirmed) {
            resetCustomerCancel(obj.id);
            window.location.href = "orders/details/" + obj.code;
        }

        // Acknowledge clicked
        if (result.dismiss === Swal.DismissReason.cancel) {
            resetCustomerCancel(obj.id);
        }
    });
}


/* =======================
   RESET CUSTOMER CANCEL
======================= */

function resetCustomerCancel(orderId) {

    var urls;
    const check = location.origin;
    if (check == "http://localhost") {
        urls = '/fooyesco/orders/';
    } else {
        urls = '/orders/';
    }

    $.ajax({
        url: urls + '/reset_customer_cancel',
        method: 'POST',
        data: { order_id: orderId },
        success: function () {
            console.log('Customer cancel reset successfully');
        },
        error: function () {
            console.error('Error resetting customer cancel.');
        }
    });
}

/* =======================
   NEW ORDER POPUP (OLD)
======================= */

function showNewOrderNotification(data) {

    const obj = JSON.parse(data);
       const name = JSON.parse(obj.billing).last_name;


    if (name == "test" && ShowTest == false) {
        return;
    }

    const grandTotal = parseFloat(obj.grand_total) || 0;
    const deliveryCharge = parseFloat(obj.total_delivery_charge) || 0;
    const total = (grandTotal + deliveryCharge).toFixed(2);
    const add = JSON.parse(obj.address);

    const notificationSound = new Audio('<?php echo base_url('assets/auth/audio/foodpanda.mp3'); ?>');
    notificationSound.loop = true;
    notificationSound.play();

    let text;
    if (obj.order_type == "delivery") {
        text = "DELIVERY | Order ID: " + obj.id + " | Total Amount: " + total +
            " | Address: " + add.address;
    } else {
        text = "COLLECTION | Order ID: " + obj.id + " | Total Amount: £" + obj.grand_total;
    }

    Swal.fire({
        title: "New Order Received!",
        text: text,
        icon: "success",
        showCancelButton: true,
        confirmButtonText: "Accept Order",
        cancelButtonText: "Reject Order",
        allowOutsideClick: false,
    }).then((result) => {

        notificationSound.pause();
        notificationSound.currentTime = 0;

        if (result.isConfirmed) {
            updateOrderReadStatus(obj.id, obj.code);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            cancelOrderAndMarkAsRead(obj.id, obj.code);
        }
    });
}

/* =======================
   ACCEPT ORDER
======================= */

function updateOrderReadStatus(orderId, code) {

    var urls;
    const check = location.origin;
    if (check == "http://localhost") {
        urls = '/fooyesco/orders/';
    } else {
        urls = '/orders/';
    }

    $.ajax({
        url: urls + '/mark_order_as_read/',
        method: 'POST',
        data: { order_id: orderId },
        success: function () {

            $.ajax({
                url: urls + '/process/' + code + "/approved",
                method: 'POST',
                success: function () {

                    const printUrl = '<?php echo base_url('orders/print_recipt/'); ?>' + code;
                    window.open(printUrl, '_blank', 'width=1,height=1');
                }
            });
        }
    });
}

/* =======================
   REJECT ORDER
======================= */

function cancelOrderAndMarkAsRead(orderId, code) {

    var urls;
    const check = location.origin;
    if (check == "http://localhost") {
        urls = '/fooyesco/orders/';
    } else {
        urls = '/orders/';
    }

    $.ajax({
        url: urls + '/mark_order_as_read/',
        method: 'POST',
        data: { order_id: orderId },
        success: function () {

            $.ajax({
                url: urls + '/cancel/' + code,
                method: 'POST',
                success: function () {

                    Swal.fire({
                        title: 'Order Rejected!',
                        text: 'The order has been canceled.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
}
</script>

