<nav class="main-header navbar navbar-expand navbar-white navbar-light">
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
        <a href="<?php echo site_url('cart'); ?>" class="btn btn-sm btn-secondary" role="button"><i class="fas fa-shopping-cart"></i> <?php echo get_phrase('view_cart'); ?></a>
      </li>
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
    setInterval(function() {
        $.ajax({
<<<<<<< Updated upstream
            url: 'orders/check_new_order/',
=======
        url: window.location.origin + '/fooyesco/orders/check_new_order/',  // Dynamically resolve the absolute URL
>>>>>>> Stashed changes
            method: 'GET',
            success: function(data) {
                if (data.length > 0) {
                    // Update the dashboard with the new orders
                    showNewOrderNotification(data);
                }
            },
            error: function() {
                console.error('Error fetching new orders.');
            }
        });
    }, 8000);

    function showNewOrderNotification(data) {
        const obj = JSON.parse(data);
        const add = JSON.parse(obj.address);

        const notificationSound = new Audio('<?php echo base_url('assets/auth/audio/foodpanda.mp3'); ?>'); 
        notificationSound.play();
        let text;
        if(obj.order_type == "delivery"){
            text = "DELIVERY | Order ID: " + obj.id + " | Total Amount: " + obj.grand_total +
                " | Address: " + add.additional_address;
        } else if(obj.order_type == "pickup"){
            text = "COLLECTION | Order ID: " + obj.id + " | Total Amount: " + obj.grand_total; 
        }

        Swal.fire({
            title: "New Order Received!",
            text: text,
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Accept Order ",
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

    function updateOrderReadStatus(orderId, code) {
        $.ajax({
            url: 'orders/mark_order_as_read/',
            method: 'POST',
            data: { order_id: orderId },
            success: function(response) {
                $.ajax({
                    url: 'orders/process/'+code+"/approved",
                    method: 'POST',
                    data: { order_id: orderId },
                    success: function(response) {
                        window.location.href = "orders/print_recipt/" + code;
                        console.log('Order marked as read successfully');
                    },
                    error: function() {
                        console.error('Error marking order as read.');
                    }
                });
            },
            error: function() {
                console.error('Error marking order as read.');
            }
        });
    }

    function cancelOrderAndMarkAsRead(orderId, code) {

      $.ajax({
            url: 'orders/mark_order_as_read/',
            method: 'POST',
            data: { order_id: orderId },
            success: function(response) {
                // Now cancel the order
                $.ajax({
                    url: 'orders/cancel/' + code,
                    method: 'POST',
                    data: { order_id: orderId },
                    success: function(response) {
                        Swal.fire({
                            title: 'Order Rejected!',
                            text: 'The order has been canceled.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.log('Order canceled successfully');
                    },
                    error: function() {
                        console.error('Error canceling the order.');
                    }
                });
            },
            error: function() {
                console.error('Error marking order as read.');
            }
        });
    }
</script>
