<!-- Info boxes -->
<div class="row">
    <!-- TILE 1 STARTS -->
    <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-lightblue">
            <i class="fas fa-hamburger"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">
                <small class="text-muted"><?php echo get_phrase('total'); ?>
                    <small>(<?php echo get_phrase('by_now'); ?>)</small>
                </small>
            </span>
            <span class="progress-description">
                <?php echo get_phrase('order_placed', true); ?>
            </span>
            <span class="info-box-number">
                <?php 
                    // Get the number of orders based on the selected restaurant
                    $order_count = $this->order_model->get_number_of_orders(null, $order_status, $restaurant_id);
                    echo sanitize($order_count);
                ?>
            </span>
        </div>
    </div>
</div>

    <!-- TILE 1 ENDS -->

    <!-- TILE 2 STARTS -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-stroopwafel"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><small class="text-muted"><?php echo get_phrase('total'); ?> <small>(<?php echo get_phrase('by_now'); ?>)</small></small></span>
                <span class="progress-description">
                    <?php echo get_phrase('order_processed', true); ?>
                </span>
                <span class="info-box-number">
                  <span class="info-box-number">
                <?php 
                 $order_count = $this->order_model->get_number_of_orders(null, 'processed', $restaurant_id); 
                 echo sanitize($order_count); 
                    ?>
                </span>

                    </span>
            </div>
        </div>
    </div>
    <!-- TILE 2 ENDS -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <!-- TILE 3 STARTS -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-truck-loading"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><small class="text-muted"><?php echo get_phrase('total'); ?> <small>(<?php echo get_phrase('by_now'); ?>)</small></small></span>
                <span class="progress-description">
                    <?php echo get_phrase('order_delivered', true); ?>
                </span>
                <span class="info-box-number">
                    <?php echo sanitize($this->order_model->get_number_of_orders(null, 'delivered', $restaurant_id)); ?>
                    
                </span>
            </div>
        </div>
    </div>
    <!-- TILE 3 ENDS -->

    <!-- TILE 4 STARTS -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-gradient-warning"><i class="fas fa-exclamation-triangle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><small class="text-muted"><?php echo get_phrase('total'); ?> <small>(<?php echo get_phrase('by_now'); ?>)</small></small></span>
                <span class="progress-description">
                    <?php echo get_phrase('order_canceled', true); ?>
                </span>
                <span class="info-box-number">
                <?php 
                    // Fetch and display the canceled orders count based on selected restaurant
                    echo sanitize($this->order_model->get_number_of_orders(null, 'canceled', $restaurant_id)); 
                ?>
                </span>
            </div>
        </div>
    </div>
    <!-- TILE 4 ENDS -->
</div>

<div class="row">
    <!-- TILE 5 STARTS -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-gradient-olive"><i class="fas fa-coins"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><small class="text-muted"><?php echo get_phrase('total'); ?><small>(<?php echo get_phrase('by_now'); ?>)</small></small></span>
                <span class="progress-description">
                    <?php echo get_phrase('revenue', true); ?>
                </span>
                <span class="info-box-number">
                    <?php
                    // Fetch and display the total revenue based on selected restaurant
                    echo  "£" . number_format((float) $this->order_model->get_total_revenue(null, $restaurant_id), 2, '.', '');
                    ?>
                                  </span>
            </div>
        </div>
    </div>
    <!-- TILE 5 ENDS -->

    <!-- TILE 6 STARTS -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-gray-dark"><i class="fas fa-money-check-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><small class="text-muted"><?php echo get_phrase('total'); ?><small>(<?php echo get_phrase('by_now'); ?>)</small></small></span>
                <span class="progress-description">
                    <?php echo get_phrase('payments_in_stripe', true); ?>
                </span>
                <span class="info-box-number">
                     <?php 
                    // Fetch and display the canceled orders count based on selected restaurant
                    echo "£" . number_format((float) $this->order_model->get_stripe_payment_sum(null, $restaurant_id), 2, '.', ''); 
                ?>

                </span>
            </div>
        </div>
    </div>
    <!-- TILE 6 ENDS -->

    <!-- TILE 7 STARTS -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-gradient-maroon"><i class="fas fa-hand-holding-usd"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><small class="text-muted"><?php echo get_phrase('total'); ?><small>(<?php echo get_phrase('by_now'); ?>)</small ?></small></span>
                <span class="progress-description">
                    <?php echo get_phrase('cash_payments', true); ?>
                </span>
                <span class="info-box-number">

                <?php 
                    // Fetch and display the canceled orders count based on selected restaurant
                    echo "£" . number_format((float) $this->order_model->get_cash_on_delivery_payment_sum(null, $restaurant_id), 2, '.', ''); 
                ?>
               

                </span>
            </div>
        </div>
    </div>
    <!-- TILE 7 ENDS -->

    <!-- TILE 8 STARTS -->
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-gradient-gray"><i class="fas fa-utensils"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><small class="text-muted"><?php echo get_phrase('total'); ?><small>(<?php echo get_phrase('by_now'); ?>)</small></small></span>
                <span class="progress-description">
                    <?php echo get_phrase('Amount_to_be_paid', true); ?>
                </span>
                <span class="info-box-number">
                    <?php 
                    
                echo "£" . number_format((float) $this->order_model->total_comission_sum($restaurant_id), 2, '.', '');
                    
                    ?>
                </span>
            </div>
        </div>
    </div>
    <!-- TILE 8 ENDS -->
</div>
<!-- /.row --> 