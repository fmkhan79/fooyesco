<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <style>
    
    *{
      font-family: "sans-serif" , sans-serif;

    }
        .receipt {
      width: 270px;
      margin: auto;
      padding: 20px;
    }
    .receipt h6 {
      text-align: center;
    }
    .receipt .line-item, .receipt .total , .did {
      display: flex;
      justify-content: space-between;
    }
    .receipt .line-item {
      border-bottom: 1px dashed #ddd;
      padding: 5px 0;
    }
    .receipt .total {
      font-weight: bold;
    }
    .mt-3{
        margin-top:10px;
    }
    </style>
</head>
<body>
    <?php
    // print_r($order_details); 
    $address = json_decode($order_details["address"],true); 
    $billing = json_decode($order_details["billing"],true); 

    // print_r($ordered_items);
    ?>
<div class="receipt">
    <center>
        <h2><?php echo $order_details['id']; ?></h2>
    </center>
    <?php //print_r($order_details)?>
    <?php

        if($order_details['order_type'] == "delivery"){
            echo "<h3>DELIVERY</h3>";
        }

        echo "<h3 style='margin:0px;'>".$order_details["customer_name"]."</h3>";

    ?>
    <?php  
        if($order_details['order_type'] != "pickup"){
    ?>
  <h3 style="margin-top:0px;"><?= $address["additional_address"] . ", " . $address["street"] ?></h3>
  <h3 style='margin:0px;'><?= $billing["phone_mobile"] ?></h3>
    <?php } ?>
  <!-- <p><strong>Order #:</strong> </p> -->
  <p style="margin:0px;"><?php echo date("Y-m-d H:i:s", $order_details['order_placed_at']); ?></p>
  <div class="did">
  <h4>Ordered Items:</h4>
  <h4>Price Items:</h4>
</div>
  <hr>
  <div id="ordered_items">
        <?php foreach ($ordered_items as $ordered_item) : 
            $restaurant_details = $this->restaurant_model->get_by_id($ordered_item['restaurant_id']);
            $menu_details = $this->menu_model->get_by_id($ordered_item['menu_id']); ?>
                <div class="line-item">
                <span><?php echo $ordered_item['quantity'] . "x " . sanitize($menu_details['name']); ?></span>
                <span><?php echo currency(sanitize($ordered_item['total'])); ?></span>
                </div>
              
                <?php endforeach; ?>
              
            </div>
         
            <!-- <hr>/ -->
                <div class="did">
                <!-- <span><?php //echo get_phrase('quantity') ?></span> -->
                <!-- <span><?php //echo sanitize($ordered_item['quantity']); ?></span> -->
                </div>
                <hr>
                <div class="did mt-3">
                <span>Subtotal</span>
                <span><?php echo currency(sanitize($ordered_item['total'])); ?></span>
                </div>
                <hr>
                <?php if($order_details['total_delivery_charge'] != "") { ?>
                    <div class="did mt-3">
                        <span>Delivery Charges</span>
                        <span><?php echo currency(sanitize($order_details['total_delivery_charge'])); ?></span>
                    </div>
                <?php } ?>
                <?php if($order_details['total_vat_amount'] != "") { ?>
                    <div class="did mt-3">
                        <span>VAT Charges</span>
                        <span><?php echo currency(sanitize($order_details['total_vat_amount'])); ?></span>
                    </div>
                <?php } ?>

                <div class="did mt-3">
                        <span>Service Charges</span>
                        <span><?php echo currency(0.25); ?></span>
                </div>
                <hr>
                <div class="did mt-3">
                <span><b>Total</b></span>
                <span><?php echo currency(sanitize($order_details['grand_total'])); ?></span>
                </div>
                <hr>
                <div class="did mt-3">
                   
                    <div class="order-detail-restaurant-name">
                        <?php echo get_phrase('restaurant') . ': ' . sanitize($restaurant_details['name']); ?>
                    </div>
                </div>
            </div>
            <?php if (!empty($ordered_item['note'])) : ?>
                <div class="row mt-2">
                    <div class="col note">
                        <span class="text-danger"><?php echo get_phrase('note'); ?> :</span> <?php echo sanitize($ordered_item['note']); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- <hr> -->
     
    </div>






 
<!-- <div class="receipt">
    <h2>De</h2>
    <p><strong>Order Code:</strong> <?php //echo sanitize($order_details['code']); ?></p>
    <p><strong>Date:</strong> <?php //echo date('Y-m-d', strtotime($order_details['created_at'])); ?></p>
    
    <h4>Ordered Items:</h4>
    <div id="ordered_items">
        <?php //foreach ($ordered_items as $ordered_item) : 
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
                <div class="col-md-3">
                    <div class="order-detail-menu-unit-price mt-2">
                        <?php echo get_phrase('unit_price') . ': ' . currency(get_menu_price($ordered_item['menu_id'], $ordered_item['servings'])); ?>
                    </div>
                    <div class="order-detail-menu-quantity mt-0">
                        <?php echo get_phrase('quantity') . ': ' . sanitize($ordered_item['quantity']); ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="order-detail-menu-sub-total float-sm-right">
                        <?php echo get_phrase('total') . ': ' . currency(sanitize($ordered_item['total'])); ?>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($ordered_item['note'])) : ?>
                <div class="row mt-2">
                    <div class="col note">
                        <span class="text-danger"><?php echo get_phrase('note'); ?> :</span> <?php echo sanitize($ordered_item['note']); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <hr>
        <?php //endforeach; ?>
    </div>
    
    <div class="text-right">
        <h5>Total Amount: <?php //echo currency(sanitize($order_details['total_amount'])); ?></h5>
    </div>
</div>  -->

    <?php 
        echo "<hr>";
        echo "<center>";
        if($order_details["order_type"] == "delivery") { 
            if($payment["payment_method"] == "cash_on_delivery"){
                echo "<h3><b>CASH ON DELIVERY</b></h3>";
            }
            if($payment["payment_method"] == "stripe"){
                echo "<h3><b>PAID VIA CARD</b></h3>";
            }
        } else { 
            if($payment["payment_method"] == "cash_on_delivery"){
                echo "<h3><b>CASH ON COLLECTION</b></h3>";
            }else if($payment["payment_method"] == "stripe"){
                echo "<h3><b>PAID VIA CARD (COLLECTION)</b></h3>"; 
            }
        }
        echo "</center>";
        echo "<hr>";

    ?>

<script>
    window.print();
    window.onafterprint = function(){
        history.back();
   
    }

</script>

</body>
</html>
