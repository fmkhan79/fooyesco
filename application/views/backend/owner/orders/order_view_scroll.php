<?php

// print_r($order_details['address']);
// die();
?>
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

        body {
            overflow: hidden;
        }

        .receipt {
            width: 270px;
            margin: auto;
            /* padding: 20px; */
        }

        .receipt h6 {
            text-align: center;
        }

        .receipt .line-item,
        .receipt .total,
        .did {
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

        h1,
        h2,
        h3 {
            font-size: 20px;
            /* Increase heading sizes */
        }

        h3 {
            font-size: 22px;
            margin: 0px;
        }

        h2 {
            font-size: 24px;
        }

        h4 {
            margin: 0px;
        }

        .order-details-summary {
            margin-top: 0px;
            text-align: left;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        hr {
            border-top: 2px dotted #000;

        }

        .img-qr {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
            /* optional spacing */
        }
        .order-url{
            text-align: center;
        }
        .order-url strong{
            font-size: 14px !important;
            font-weight: 800;
        }
        .order-url small{
            font-size: 16px !important;
        }
        /* Screen view only */
.order-scroll-wrapper {
    max-height: 90vh;
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: 10px;
}

/* Print view - DO NOT SCROLL */
@media print {
    .order-scroll-wrapper {
        max-height: none;
        overflow: visible;
    }
}

    </style>
</head>

<body>

<?php
// --- SAFETY / NORMALIZATION ---
if (!is_array($order_details)) {
    if (is_string($order_details)) {
        $order_details = json_decode($order_details, true) ?: [];
    } else {
        $order_details = (array) $order_details;
    }
}

// Decode address safely
$address = [];
if (!empty($order_details['address'])) {
    $address = json_decode($order_details['address'], true);
    if (!is_array($address)) $address = [];
}

// Decode billing safely
$billing = [];
if (!empty($order_details['billing'])) {
    $billing = json_decode($order_details['billing'], true);
    if (!is_array($billing)) $billing = [];
}

// Ensure ordered_items exists
$ordered_items = $ordered_items ?? [];
if (!is_array($ordered_items)) $ordered_items = [];

// Ensure payment exists
$payment = $payment ?? [];

// Initialize counters
$total_items  = 0;
$total_amount = 0.0;

// Prepare formatted address
$formattedAddress = '';
if (!empty($address['flat'])) {
    $formattedAddress .= sanitize($address['flat']) . ', ';
}
if (!empty($address['address'])) {
    $cleanAddress = str_replace(', UK', '', $address['address']);
    $formattedAddress .= sanitize($cleanAddress) . ', ';
}
if (!empty($address['postcode'])) {
    $formattedAddress .= sanitize($address['postcode']);
}
$finalAddress = rtrim($formattedAddress, ', ');

// Safe short variables
$daily_no      = $order_details['daily_order_number'] ?? '';
$customer_name = $order_details['customer_name'] ?? '';
$order_type    = $order_details['order_type'] ?? '';
$billing_phone = $billing['phone_mobile'] ?? '';

// Ensure restaurant_details is available after loop (fallback)
$restaurant_details = [];

// --- HTML output ---
?>

<?php
// Get current URI
$uri = $_SERVER['REQUEST_URI'];

// Break URI into parts
$segments = explode('/', trim($uri, '/'));

// Last segment is order code
$order_code = end($segments);

// Build redirect URL (CHANGE IF NEEDED)
$redirect_url = base_url('orders/details/' . $order_code);
// Example alternatives:
// $redirect_url = base_url('orders');
// $redirect_url = base_url('orders/view/' . $order_code);
?>
<a href="<?php echo $redirect_url; ?>" style="    display: flex;
    justify-content: center;
    margin-bottom: 20px;
    font-size: x-large;
    font-weight: 700;"
     class="btn btn-danger">
    ✕
</a>


<div class="order-scroll-wrapper">

<div class="receipt">

    <center>
        <h3 style="margin:0px;"><?php echo sanitize($daily_no); ?></h3>
    </center>

    <img class="img-qr" width="100px" height="100px" style="float: right;"
         src="<?php echo base_url('assets/frontend/default/images/ilove.png'); ?>" />

    <?php
    if ($order_type === "delivery") {
        echo "<h3>DELIVERY</h3>";
        echo "<h3 style='margin:0px;'>" . sanitize($customer_name) . "</h3>";
        echo "<h3 style='margin:0px;'>" . sanitize($billing_phone) . "</h3>";
        echo "<h4 style='margin:0px;'>" . sanitize($finalAddress) . "</h4>";
    } elseif ($order_type === "pickup") {
        echo "<h3>Collection</h3>";
        echo "<h3 style='margin:0px;'>" . sanitize($customer_name) . "</h3>";
        echo "<h3 style='margin:0px;'>" . sanitize($billing_phone) . "</h3>";
    }
    else{
        // echo "<h3>POS ORDER</h3>";
        echo "<br>";
        echo "<h3 style='margin:0px;'>" . sanitize($customer_name) . "</h3>";
        echo "<h3 style='margin:0px;'>" . sanitize($billing_phone) . "</h3>";
        echo "<br>";
        //   echo "<br>";

    }
    ?>

    <div id="ordered_items">
        <?php
        foreach ($ordered_items as $ordered_item) :
            // defensive checks
            $ordered_item = is_array($ordered_item) ? $ordered_item : (array) $ordered_item;
            $restaurant_details = $this->restaurant_model->get_by_id($ordered_item['restaurant_id'] ?? 0);
            $menu_details = $this->menu_model->get_by_id($ordered_item['menu_id'] ?? 0);

            $qty = floatval($ordered_item['quantity'] ?? 0);
            $item_total = floatval($ordered_item['total'] ?? 0.0);

            $total_items += $qty;
            $total_amount += $item_total;

            $addonHTML = "";

            if (!empty($ordered_item["addons"]) && $ordered_item["addons"] !== "[]") {
                $addons = json_decode($ordered_item["addons"], true);
                // print_r($addons);
                if (is_array($addons) && count($addons) > 0) {
                   if (is_array($addons) && isset($addons[0]) && is_string($addons[0])) {
                $addonHTML = formatPizzaDealReceiptAddons(
                    $addons,
                    $menu_details['name'] ?? ''
                );
            }

              else if (isset($addons[0]) && is_array($addons[0]) && isset($addons[0]['subVariantId'])) {

    $pizza1 = [];
    $pizza2 = [];
    $extras = [];

    foreach ($addons as $addon) {

        if (empty($addon['itemId'])) continue;

        $item = $this->menu_model->get_addon_item_detail($addon['itemId']);
        if (empty($item)) continue;

        $variantName = $item['variantName'] ?? '';
        $subOptionName = $item['subOptionName'] ?? '';

        if (stripos($variantName, 'Pizza 1') !== false) {
            $pizza1[] = $subOptionName;
        }
        elseif (stripos($variantName, 'Pizza 2') !== false) {
            $pizza2[] = $subOptionName;
        }
        else {
            $extras[] = $subOptionName;
        }
    }

    ob_start();
    ?>

    <?php if (!empty($pizza1)): ?>
        <ul class="options-list">
            <li><strong>Pizza 1</strong></li>
            <?php foreach ($pizza1 as $p): ?>
                <li>• <?= html_entity_decode(sanitize($p)) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($pizza2)): ?>
        <ul class="options-list">
            <li><strong>Pizza 2</strong></li>
            <?php foreach ($pizza2 as $p): ?>
                <li>• <?= html_entity_decode(sanitize($p)) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($extras)): ?>
        <ul class="options-list">
            <li><strong>Extras</strong></li>
            <?php foreach ($extras as $p): ?>
                <li>• <?= html_entity_decode(sanitize($p)) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php
    $addonHTML = ob_get_clean();
}

                }
            }
        ?>
            <hr style="margin-top: 20px;">
            <ul class="line-item font-weight-bold">
                <li><?php echo intval($qty) . "x " . html_entity_decode(sanitize($menu_details['name'] ?? '')); ?></li>
                <li><?php echo currency(number_format(floatval($item_total), 2)); ?></li>
            </ul>

            <?php if (!empty($ordered_item["variant_id"]) && $ordered_item["variant_id"] != 0) { ?>
                <ul class="line-item">
                    <li>
                        <?php
                        $variant = $this->menu_model->get_variant_detail($ordered_item["variant_id"]);
                        echo "Selected: " . html_entity_decode(sanitize($variant[0]["name"] ?? ''), ENT_QUOTES);
                        ?>
                    </li>
                </ul>
            <?php } ?>

            <?php
            if (!empty($addonHTML)) {
                echo $addonHTML;
            }
            ?>
        <?php endforeach; ?>
    </div>

    <hr>

    <div class="did mt-3 font-weight-bold text-uppercase">
        <span>Subtotal</span>
        <span><?php echo currency(number_format(floatval($order_details['total_menu_price'] ?? $total_amount), 2)); ?></span>
    </div>

    <?php
    // Ensure we have restaurant discounts available

    $res_discount = floatval($restaurant_details['res_discount'] ?? 0);
    $pick_discount = floatval($restaurant_details['pick_discount'] ?? 0);
    $pos_discount = floatval($restaurant_details['pos_discount'] ?? 0);

    // Determine which discount to show
    if (!empty($order_details['promo_code'])) { ?>
        <div class="did mt-3">
            <span><?php echo sanitize($order_details['promo_discount'] ?? 0); ?>% PROMO DISCOUNT</span>
    <?php } elseif ($order_type === "pickup") { ?>
        <div class="did mt-3">
            <span><?php echo sanitize($pick_discount); ?>% ONLINE DISCOUNT</span>
            <span>
    <?php } elseif($order_type == "pos") { ?>
        <div class="did mt-3">
            <span><?php echo sanitize($pos_discount); ?>% POS DISCOUNT</span>
            <span>
    <?php } else { ?>
        <div class="did mt-3">
            <span><?php echo sanitize($res_discount); ?>% ONLINE DISCOUNT</span>
            <span>
    <?php } ?>

    <?php
    // calculate discount percentages and amounts
    $res_discount = floatval($restaurant_details['res_discount'] ?? 0);
    if ($order_type === "pickup") {
        $res_discount = floatval($restaurant_details['pick_discount'] ?? $res_discount);
    }
    if (!empty($order_details['promo_code'])) {
        $res_discount = floatval($order_details['promo_discount'] ?? $res_discount);
    }

    if($order_type == "pos"){
        $res_discount = floatval($pos_discount);
    }
    // if($order_T)

    $total_menu_price = floatval($order_details['total_menu_price'] ?? $total_amount);
    $discount_amount_show = $total_menu_price * ($res_discount / 100.0);

    // sanitize grand total and delivery charge;
    $grand_total = floatval($order_details['grand_total'] ?? ($total_menu_price - $discount_amount_show));
    $total_delivery_charge = floatval($order_details['total_delivery_charge'] ?? 0.0);

    echo "-" . currency(number_format($discount_amount_show, 2));
    ?>
            </span>
        </div>
    <?php if (!empty($order_details['is_online_discount'])) { 
        $is_online_discount = floatval($order_details['is_online_discount']);
        $online_discount_amount_show = $total_menu_price * ($is_online_discount / 100.0);
    ?>
        <div class="did mt-3">
            <span><?php echo sanitize($order_details['is_online_discount']); ?>% ONLINE DISCOUNT</span>
            <span><?php echo "-" . currency(number_format($online_discount_amount_show, 2)); ?></span>
        </div>
    <?php } ?>
 
    
  
        <?php if($order_type != "pos"){ 
                    ?>
    <div class="did mt-3">
        
        <span>1X CARRY BAG</span>
        <span><?php echo currency(number_format(0.10, 2)); ?></span>
    </div>

    <div class="did mt-3 text-uppercase">
        <span>Service Charge</span>
        <span><?php echo currency(number_format($this->cart_model->get_service_amount(), 2)); ?></span>
    </div>
    <?php
        } ?>
    <?php if ($order_type === "delivery") { 
        if ($total_delivery_charge > 0) { ?>
            <div class="did mt-3 text-uppercase">
                <span>Delivery Charge</span>
                <span><?php echo currency(number_format($total_delivery_charge, 2)); ?></span>
            </div>
        <?php } else { ?>
            <div class="did mt-3">
                <span style="font-size:20px">Delivery Charges</span>
                <span style="font-size:17px">Free Delivery</span>
            </div>
        <?php }
    } ?>

    <div class="did mt-3 font-weight-bold">
        <span>TOTAL (<?php echo intval($total_items); ?> Items)</span>
        <?php if($order_type == "pos"){?>

        <span><?php echo currency(number_format($grand_total, 2)); ?></span>

        <?php }else {?>
                 <span><?php echo currency(number_format($grand_total, 2)); ?></span>
        <?php }?>
    </div>

    <hr>

    <div class="order-details-summary">
        <h4>Order Time: <?php echo date("H:i:s", intval($order_details['order_placed_at'] ?? time())); ?></h4>
    </div>

    <hr>

    <div class="did mt-3">
        <div class="order-detail-restaurant-name">
            <?php echo get_phrase('restaurant') . ': ' . sanitize($restaurant_details['name'] ?? ''); ?>
        </div>
    </div>

    <?php
    echo "<hr>";
    echo "<left>";
    $payment_method = $payment['payment_method'] ?? '';
    if ($order_type === "delivery") {
        if ($payment_method === "cash_on_delivery") {
            echo "<h3><b>CASH ON DELIVERY</b></h3>";
        } elseif ($payment_method === "stripe") {
            echo "<h3><b>PAID VIA CARD</b></h3>";
        }
    } else {
        if ($payment_method === "cash_on_collection") {
            echo "<h3><b>CASH ON COLLECTION</b></h3>";
        } elseif ($payment_method === "stripe") {
            echo "<h3><b>PAID VIA CARD (COLLECTION)</b></h3>";
        }elseif ($payment_method === "cash") {
            echo "<h3><b>Payment Via Cash</b></h3>";
        }elseif ($payment_method === "card") {
            echo "<h3><b>Payment Via Card</b></h3>";
        }
    
    }
    echo "</left>";
    ?>

    <?php if (!empty($address['instructions'])) : ?>
        <hr>
        <div class="row mt-2">
            <div class="col note" style="font-size: 18px;">
                <h3>Note: <?php echo sanitize($address['instructions']); ?></h3>
            </div>
        </div>
    <?php endif; ?>

         </div>
    </div>
</body>

</html>

