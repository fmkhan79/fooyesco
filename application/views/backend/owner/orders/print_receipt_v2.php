<?php


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt v2.0.0</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <style>
        * {
            font-family: "sans-serif", sans-serif;
            font-size: 18px;
        }

        <?php if(!isset($_GET["s"])): ?>
        body {
            overflow: hidden;
        }
        <?php endif; ?>

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

        .order-url {
            text-align: center;
        }

        .order-url strong {
            font-size: 14px !important;
            font-weight: 800;
        }

        .order-url small {
            font-size: 16px !important;
        }

        .price-right {
            float: right;
            /* Moves price to the right side */
        }

        .line-item {
            width: 100%;
        }
    </style>
</head>

<body>


<?php
if(isset($_GET["s"])) {
    
// Get current URI
$uri = $_SERVER['REQUEST_URI'];

// Break URI into parts
$segments = explode('/', trim($uri, '/'));

// Last segment is order code
$order_code = end($segments);

// Build redirect URL (CHANGE IF NEEDED)
$redirect_url = base_url('orders/details/' . $order_code);
?>
<a href="<?php echo $redirect_url; ?>" style="    display: flex;
    justify-content: center;
    margin-bottom: 20px;
    font-size: x-large;
    font-weight: 700;"
     class="btn btn-danger">
    ✕
</a>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/global/toastr/toastr.css') ?>">

    

<?php } ?>

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
        } else {
            // echo "<h3>POS ORDER</h3>";
            echo "<br>";
            echo "<h3 style='margin:0px;'>" . sanitize($customer_name) . "</h3>";
            echo "<h3 style='margin:0px;'>" . sanitize($billing_phone) . "</h3>";
            echo "<br>";
            //   echo "<br>";

        }
        ?>

        <div id="ordered_items">
            <?php foreach ($ordered_items as $ordered_item) : ?>

                <?php
                $ordered_item = is_array($ordered_item) ? $ordered_item : (array)$ordered_item;

                $restaurant_details = $this->restaurant_model->get_by_id($ordered_item['restaurant_id'] ?? 0);
                $menu_details       = $this->menu_model->get_by_id($ordered_item['menu_id'] ?? 0);

                $qty        = floatval($ordered_item['quantity'] ?? 0);
                $item_total = floatval($ordered_item['total'] ?? 0.0);

                $total_items  += $qty;
                $total_amount += $item_total;

                $addonHTML = "";

               
                ?>

                <hr style="margin-top: 20px;">

                <ul class="line-item font-weight-bold">
                    <li>
                        <?= intval($qty) . "x " . html_entity_decode(sanitize($menu_details['name'] ?? '')) ?>
                    </li>
                    <li>
                        <?= currency(number_format($item_total, 2)) ?>
                    </li>
                </ul>

                <?php if (!empty($ordered_item["variant_id"])): ?>
                    <ul class="line-item">
                        <li>
                            <?php
                            $variant = $this->menu_model->get_variant_detail($ordered_item["variant_id"]);
                            echo "Selected: " . html_entity_decode(sanitize($variant[0]["name"] ?? ''), ENT_QUOTES);
                            ?>
                        </li>
                    </ul>
                    <ul>
                        <?= $ordered_item["html_output_for_recipts"];?>
                    </ul>
                    
                <?php endif; ?>

                <?php if (!empty($addonHTML)) echo $addonHTML; ?>

            <?php endforeach; ?>

        </div>

        <hr>

        <div class="did mt-3 font-weight-bold text-uppercase">
            <span>Subtotal</span>
            <span><?php echo currency(number_format(floatval($order_details['total_menu_price'] ?? $total_amount), 2)); ?></span>
        </div>

        <?php
        $order_url = strtolower($order_details['order_url'] ?? '');
        $isFooyes = (strpos($order_url, 'fooyes') !== false);
        $res_discount  = 0;
        $pick_discount = 0;
        $pos_discount  = floatval($restaurant_details['pos_discount'] ?? 0);

        if ($isFooyes) {
            // Fooyes order
            $res_discount  = floatval($restaurant_details['res_discount'] ?? 0);
            $pick_discount = floatval($restaurant_details['pick_discount'] ?? 0);
        } else {
            // Standalone order
            $res_discount  = floatval($restaurant_details['standalone_res_discount'] ?? 0);
            $pick_discount = floatval($restaurant_details['standalone_pick_discount'] ?? 0);
        }



        // Determine which discount to show
        if (!empty($order_details['promo_code'])) { ?>
            <div class="did mt-3">
                <span><?php echo sanitize($order_details['promo_discount'] ?? 0); ?>% PROMO DISCOUNT</span>

            <?php } elseif ($order_type === "pickup") { ?>
                <div class="did mt-3">
                    <span><?php echo sanitize($pick_discount); ?>% ONLINE DISCOUNT</span>
                    <span>

                    <?php } elseif ($order_type === "pos") { ?>
                        <div class="did mt-3">
                            <span><?php echo sanitize($pos_discount); ?>% POS DISCOUNT</span>
                            <span>

                            <?php } else { ?>
                                <div class="did mt-3">
                                    <span><?php echo sanitize($res_discount); ?>% ONLINE DISCOUNT</span>
                                    <span>
                                    <?php } ?>


                                    <?php
                                    $final_discount = 0;

                                    if (!empty($order_details['promo_code'])) {
                                        $final_discount = floatval($order_details['promo_discount'] ?? 0);
                                    } elseif ($order_type === "pickup") {
                                        $final_discount = $pick_discount;   // already domain-aware
                                    } elseif ($order_type === "pos") {
                                        $final_discount = $pos_discount;
                                    } else {
                                        $final_discount = $res_discount;    // already domain-aware
                                    }


                                    $total_menu_price = floatval($order_details['total_menu_price'] ?? $total_amount);
                                    $discount_amount_show = $total_menu_price * ($final_discount / 100);
                                    $grand_total = floatval($order_details['grand_total'] ?? ($total_menu_price - $discount_amount_show));
                                    $total_delivery_charge = floatval($order_details['total_delivery_charge'] ?? 0.0);


                                    echo "-" . currency(number_format($discount_amount_show, 2));
                                    ?>
                                    </span>
                                </div>

                                <?php if (!empty($order_details['is_online_discount']) || $order_details['is_online_discount'] === 0) {
                                    $online_discount_amount_show = $total_menu_price * ($is_online_discount / 100.0);
                                ?>

                                    <div class="did mt-3">

                                        <span><?php echo sanitize($order_details['is_online_discount']); ?>% ONLINE DISCOUNT</span>
                                        <span><?php echo "-" . currency(number_format($online_discount_amount_show, 2)); ?></span>
                                    </div>
                                <?php } ?>



                                <?php if ($order_type != "pos") {
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
                                    <?php if ($order_type == "pos") { ?>

                                        <span><?php echo currency(number_format($grand_total, 2)); ?></span>

                                    <?php } else { ?>
                                        <span><?php echo currency(number_format($grand_total, 2)); ?></span>
                                    <?php } ?>
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
                                    } elseif ($payment_method === "cash") {
                                        echo "<h3><b>Payment Via Cash</b></h3>";
                                    } elseif ($payment_method === "card") {
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

                                <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
                                <script>
                                    // window.onload = function() {
                                    //     const socket = new WebSocket("ws://localhost:8765");

                                    //     socket.onopen = () => {
                                    //         const receiptDiv = document.querySelector('.receipt');

                                    //         html2canvas(receiptDiv, {
                                    //             scale: 4, // Higher scale = sharper image
                                    //             useCORS: true
                                    //         }).then(canvas => {
                                    //             const imgData = canvas.toDataURL("image/png");
                                    //             const base64Image = imgData.split(',')[1]; // Remove prefix

                                    //             socket.send(base64Image);
                                    //             console.log("Ã°Å¸â€œÂ¤ Image of .receipt sent to server.");
                                    //             // window.close();
                                    //         });
                                    //     };

                                    //     socket.onmessage = (event) => {
                                    //         console.log("Ã°Å¸â€œÂ¥ Server:", event.data);
                                    //     };
                                    // };
                                    window.onload = function() {
                                        const socket = new WebSocket("ws://localhost:8765");

                                        socket.onopen = () => {
                                            const receiptDiv = document.querySelector('.receipt');

                                            html2canvas(receiptDiv, {
                                                scale: 4,
                                                useCORS: true
                                            }).then(canvas => {
                                                const imgData = canvas.toDataURL("image/png");
                                                const base64Image = imgData.split(',')[1];

                                                // Split into chunks
                                                const chunkSize = 4000;
                                                const totalChunks = Math.ceil(base64Image.length / chunkSize);

                                                for (let i = 0; i < totalChunks; i++) {
                                                    const chunk = base64Image.slice(i * chunkSize, (i + 1) * chunkSize);
                                                    socket.send(JSON.stringify({
                                                        type: "chunk",
                                                        index: i,
                                                        total: totalChunks,
                                                        data: chunk
                                                    }));
                                                }

                                                console.log(`Ã°Å¸â€œÂ¤ Sent ${totalChunks} chunks.`);

                                                setTimeout(() => {
                                                    window.close();
                                                }, 3000);
                                            });
                                        };

                                        socket.onmessage = (event) => {
                                            console.log("Ã°Å¸â€œÂ¥ Server:", event.data);
                                            window.close();
                                        };
                                    };
                                </script>

    
	<script src="<?php echo base_url('assets/auth/vendor/jquery/jquery-3.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/global/toastr/toastr.min.js'); ?>"></script>

<?php
if(isset($_GET["s"]) && isset($_GET["key"])) {
    echo "<script>toastr.success('Order Accepted');</script>";
}
?>
</body>

</html>