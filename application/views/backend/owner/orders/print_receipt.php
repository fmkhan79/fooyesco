<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <style>
        * {
            font-family: "sans-serif", sans-serif;
            font-size: 18px;
        }
        .receipt {
            width: 270px;
            margin: auto;
            /* padding: 20px; */
        }
        .receipt h6 {
            text-align: center;
        }
        .receipt .line-item, .receipt .total, .did {
            display: flex;
            justify-content: space-between;
            list-style: none;
            padding: 0px;
            margin: 10px 0px; 
        }
        .receipt .total {
            font-weight: bold;
        }
        .mt-3 {
            margin-top: 10px;
        }
        h1, h2, h3 {
            font-size: 20px; /* Increase heading sizes */
        }
        h3 {
            font-size: 22px;
            margin:0px;
        }
        h2 {
            font-size: 24px;
        }
        h4{
            margin:0px;
        }
        .order-details-summary {
            margin-top: 0px;
            text-align: left;
        }
        .font-weight-bold{
            font-weight: bold;
        }
        .text-uppercase{
            text-transform: uppercase;
        }
        hr {
        border-top:2px dotted #000;

}
    </style>
</head>
<body>
    <?php
    // print_r($order_details); 
    $address = json_decode($order_details["address"],true); 

    // print_r($address);

    $billing = json_decode($order_details["billing"],true); 

    // print_r($ordered_items);
    ?>

    <div class="receipt">
        <center>
        <h2><?php echo $daily_order_number; ?></h2>
        </center>

        <?php 
        if($order_details['order_type'] == "delivery") {
            echo "<h3>DELIVERY</h3>";
        }

        echo "<h3 style='margin:0px;'>".$order_details["customer_name"]."</h3>";
        ?>
        
        <?php  
        if($order_details['order_type'] != "pickup") {

            // print_r($order_details['total_menu_price']);
        ?>
            <h3 style="margin:0px;"><?= $address["additional_address"] . ", " . $address["street"] ?></h3>
            <h3 style='margin:0px;'><?= $billing["phone_mobile"] ?></h3>
        <?php } ?>

        <!-- <p style="margin:0px;"><?php echo date("Y-m-d H:i:s", $order_details['order_placed_at']); ?></p> -->
        <!-- <div class="did">
            <h4>Ordered Items:</h4>
            <h4 class="">Price Items:</h4>
        </div>
        <hr> -->
        <div id="ordered_items">
            <?php 
            $total_items = 0; // Variable to count total ordered items
            $total_amount = 0; // Variable to sum total amount
            foreach ($ordered_items as $ordered_item) : 
                $restaurant_details = $this->restaurant_model->get_by_id($ordered_item['restaurant_id']);
                // print_r($restaurant_details);
                $menu_details = $this->menu_model->get_by_id($ordered_item['menu_id']); 
                $total_items += $ordered_item['quantity']; // Count ordered items
                $total_amount += $ordered_item['total']; // Sum total amount
                $addonHTML = "";
                
                if($ordered_item["addons"] != "[]"){
                
                    $groupedAddons = [];
                    $addons = json_decode($ordered_item["addons"], true);

                    foreach ($addons as $addon) {
    
                        $subVariantId = $addon['subVariantId'];
                        $itemId = $addon['itemId'];

                    
                        if (!isset($groupedAddons[$subVariantId])) {
                            $groupedAddons[$subVariantId] = [];
                        }
                        $groupedAddons[$subVariantId][] = $itemId;
                    }
                    $addonHTML = $this->menu_model->addons_grouped_data($groupedAddons);
                }
            ?>
            <hr>
                <ul class="line-item font-weight-bold">
                    <li><?php echo $ordered_item['quantity'] . "x " . html_entity_decode(sanitize($menu_details['name'])); ?></li>
                    <li><?php echo currency(number_format(sanitize($ordered_item['total']), 2)); ?></li>  
                </ul>
                
                    <?php 
                    if($ordered_item["variant_id"] != null && $ordered_item["variant_id"] != 0){?>
                    <ul class="line-item">
                        <li>
                            <?php
                                    echo "Selected: " . $this->menu_model->get_variant_detail($ordered_item["variant_id"])[0]["name"];   
                            ?>
                        </li>
                    </ul>
                    <?php } 
                    if($addonHTML != ""){
                        echo $addonHTML;
                    }
                    ?>
                </li>
                               
                </ul>
            <?php endforeach; ?>
        </div>
        <hr>
        <div class="did mt-3 font-weight-bold text-uppercase">
            <span>Subtotal</span>
            <span><?php echo currency(number_format(sanitize($order_details['total_menu_price']), 2)); ?></span>
        </div>
        <?php if($order_details["order_type"] == "pickup"){ ?>
 <div class="did mt-3">
 <span>25% ONLINE DISCOUNT</span>
 <span>
    <?php } else { ?>
 <div class="did mt-3">
 <span>20% ONLINE DISCOUNT</span>
 <span>
        
     <?php } ?>
    
       
     <?php 
    $res_discount = $restaurant_details['res_discount'];

    // Check if the order type is 'pickup' and adjust the discount accordingly
    if ($order_details["order_type"] == "pickup") {
        $res_discount = 25;  // Set discount to 25% if order type is pickup
    }

    // Calculate the discount amount to show
    // print_r($order_details['total_menu_price']);
    $discount_amount_show =  $order_details['total_menu_price'] * ($res_discount / 100);
    // print_r($order_details['grand_total']);
    // Sanitize the grand total and delivery charge
    $grand_total = sanitize($order_details['grand_total']);
    $total_delivery_charge = sanitize($order_details['total_delivery_charge']);
    
    // Calculate the discount amount
    $discount_amount = ($grand_total * $res_discount) / 100;
    
    // Output the discount amount formatted with currency symbol
    // print_r($res_discount);
    echo currency(number_format("-".$discount_amount_show, 2));

?>
    
</span>
        </div>

   <div class="did mt-3">
   <span>1X CARRY BAG</span>
  <span>£0.10</span>
</div>

        <!-- <?php if($order_details['total_vat_amount'] != "") { ?>
            <div class="did mt-3">
                <span>VAT Charges</span> 
                <span><?php echo currency(number_format(sanitize($order_details['total_vat_amount']), 2)); ?></span>

            </div>
        <?php } ?> -->
        <div class="did mt-3 text-uppercase">
            <span>Service Charge</span>
            <span>                
            <?php echo currency($this->cart_model->get_service_amount()); ?></span>
        </div>
        <?php if($order_details["order_type"] == "delivery") {?>
        <?php if($order_details['total_delivery_charge'] != "") { ?>
            <div class="did mt-3 text-uppercase">
                <span>Delivery Charge</span>
                <span><?php echo currency(sanitize($order_details['total_delivery_charge']), 2); ?></span>

            </div>
        <?php } 
        } else { ?>
           <?php if($order_details["order_type"] == "delivery") {?>
        <div class="did mt-3">
                <span style="font-size:20px">Delivery Charges</span>
                <span style="font-size:17px">Free Delivery</span>

            </div>
            <?php } ?>

   <?php } ?>
        <div class="did mt-3 font-weight-bold">
            <span>TOTAL (<?php echo $total_items; ?> Items)</span>
            <span>
    <?php  
        echo currency(number_format($grand_total, 2));
    ?> 
</span>
                 
            </div>
        <hr>
        <div class="order-details-summary">
            <!-- <h4>Total Items: <?php echo $total_items; ?> </h4> Display total items -->
            <h4>Order Time: <?php echo date("H:i:s", $order_details['order_placed_at']); ?> </h4> <!-- Display order time -->
        </div>
        <hr>    

      

        <div class="did mt-3">
            <div class="order-detail-restaurant-name">
                <?php echo get_phrase('restaurant') . ': ' . sanitize($restaurant_details['name']); ?>
            </div>
        </div>
        
       
        <?php 
        echo "<hr>";
        echo "<left>";
        if($order_details["order_type"] == "delivery") { 
            if($payment["payment_method"] == "cash_on_delivery") {
                echo "<h3><b>CASH ON DELIVERY</b></h3>";
            }
            if($payment["payment_method"] == "stripe") {
                echo "<h3><b>PAID VIA CARD</b></h3>";
            }
        } else { 
            if($payment["payment_method"] == "cash_on_delivery") {
                echo "<h3><b>CASH ON COLLECTION</b></h3>";
            } else if($payment["payment_method"] == "stripe") {
                echo "<h3><b>PAID VIA CARD (COLLECTION)</b></h3>"; 
            }
        }
        echo "</left>";
        echo "<hr>";
        ?>
          <?php if (!empty($address['number'])) : ?>
            <div class="row mt-2">
                <div class="col note" style="font-size: 18px;">
                    <span class="text-danger">Note:</span> <?php echo sanitize($address['number']); ?>
                </div>
            </div>
        <?php endif; ?>


    <script>
    window.print();
    setTimeout(() => {
        history.back();
    }, 1000); 
    </script>
</body>
</html>