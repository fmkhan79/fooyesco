<?php
$host = $_SERVER['HTTP_HOST'];

/* ===============================
   GET CUSTOMER DETAILS
================================ */
$extCust = (int) ($message['customer_id'] ?? 0);
$customer_details = $this->customer_model->get_by_id($extCust);

/* ===============================
   LOAD REQUIRED MODELS
================================ */
$this->load->model('order_model');
$this->load->model('restaurant_model');
$this->load->model('menu_model');
$this->load->model('cart_model');

/* ===============================
   ORDERED ITEMS
================================ */
$ordered_items = $this->order_model->details($message['code']);
$restaurant_details = $this->restaurant_model->get_by_id($ordered_items[0]['restaurant_id']);

/* ===============================
   PROMO / DISCOUNT
================================ */
$appliedPromo = $this->session->userdata('user_promo');

// promo discount safe
  $order_url = strtolower($message['order_url'] ?? '');
        $isFooyes = (strpos($order_url, 'fooyes') !== false);
        
        if($isFooyes){
if (!empty($message['promo_discount'])) {
    // remove "%" or other chars
    $cleanPromo = preg_replace('/[^0-9.]/', '', $message['promo_discount']);
    $res_discount = ($cleanPromo !== "") ? floatval($cleanPromo) : 0;
} else {
    // default discount
    $res_discount = ($message["order_type"] == "pickup") ? 25 : 20;
}
        }else{
            if (!empty($message['promo_discount'])) {
    // remove "%" or other chars
    $cleanPromo = preg_replace('/[^0-9.]/', '', $message['promo_discount']);
    $res_discount = ($cleanPromo !== "") ? floatval($cleanPromo) : 0;
} else {
    // default discount
    $res_discount = ($message["order_type"] == "pickup") ? 0 : 0;
}

        }

/* ===============================
   SAFE CALCULATIONS
================================ */

// subtotal: remove currency symbols, commas, spaces
$subtotal = floatval(preg_replace('/[^0-9.]/', '', ($message['total_menu_price'] ?? 0)));

// service charge
$service_charge = floatval($this->cart_model->get_service_amount() ?? 0);

// delivery charge (skip for pickup)
$delivery_charge = ($message['order_type'] == 'pickup')
    ? 0
    : floatval(preg_replace('/[^0-9.]/', '', ($message['total_delivery_charge'] ?? 0)));

// fixed bag charge
$bag_charge = 0.10;

// discount amount
$discount_amount = floatval(($subtotal * $res_discount) / 100);

/* ===============================
   GRAND TOTAL (SAFE)
================================ */
$grand_total = (
    floatval($subtotal) +
    floatval($service_charge) +
    floatval($delivery_charge) +
    floatval($bag_charge)
) - floatval($discount_amount);

/* ===============================
   CUSTOMER ADDRESS (SAFE)
================================ */
$decoded_address = json_decode($message['address'] ?? "", true) ?? [];

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
         body {
      font-family: "Poppins", sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
      color: #191919;
    }

    a{
        color: #f54748 !important;
        text-decoration: none;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      border: 1px solid #ddd;
    }

    .header {
      padding: 20px;
      text-align: center;
    }

    .header h1 {
      color: #191919;
      margin-bottom: 10px;
      font-size: 24px;
    }

    .header span.highlight {
      background: #fdc55e;
      color: #ffffff;
      padding: 2px 5px;
      border-radius: 3px;
    }

    .info {
      padding: 0 20px 20px;
      font-size: 14px;
      line-height: 1.6;
      font-weight: bold;
    }

    .info a {
      color: #f54748;
      text-decoration: none;
      font-weight: bold;
    }

    .summary-header {
      background: #f54748;
      color: #ffffff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      font-weight: bold;
      font-size: 14px;
      column-gap: 30px; /* added space between ORDER SUMMARY and Order ID */
      flex-wrap: wrap;
    }

    .details {
      padding: 20px;
      font-size: 14px;
    }

    .addresses {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      flex-wrap: wrap;
    }

    .addresses p {
      flex: 1 1 45%;
      margin: 0;
    }

    .order-items,
    .totals {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      word-break: break-word;
    }

    .order-items td,
    .totals td {
      padding: 8px 0;
      border-bottom: 1px solid #eee;
    }

    .order-items td:last-child,
    .totals td:last-child {
      text-align: right;
    }

    .totals td strong {
      font-size: 18px;
      color: #f54748;
    }

    .footer {
      text-align: center;
      padding: 20px;
      font-size: 12px;
      color: #999;
    }

    @media only screen and (max-width: 600px) {
      .container {
        width: 90%;
      }

      .header h1 {
        font-size: 20px;
      }

      .info {
        font-size: 13px;
        padding: 0 15px 15px;
      }

      .summary-header {
        font-size: 13px;
        flex-direction: column;
        align-items: flex-start;
        padding: 10px 15px;
      }

      .details {
        padding: 15px;
        font-size: 13px;
      }

      .addresses {
        flex-direction: column;
        gap: 10px;
      }

      .totals td strong {
        font-size: 16px;
      }
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Hello <?= sanitize($customer_details['name']) ?>! <?= sanitize($subject) ?></h1>
            <a href="https://fooyes.co.uk/">
            <img src="https://fooyes.co.uk/uploads/system/VJMkY4SgTdEnL35HtR9G.jpg" alt="Fooyes Logo" style="width:80px; height:auto; margin-top:5px;">
            </a>
        </div>

        <div class="info">
            <p>Thank you for choosing Fooyes! Your <span class="highlight">order</span> has been successfully placed and forwarded to our kitchen team. If you need to make any changes to your <span class="highlight">order</span>, please contact takeaway/restaurant directly at <a href="tel:<?= sanitize($restaurant_details['phone']) ?>"><?= sanitize($restaurant_details['phone']) ?></a>.</p>
            <p>For non delivery issues please call or drop us a message as soon as you can on this number <a href="tel:07438797814">07438797814</a></p>
            <p>Kindly ensure that any modifications or cancellations are requested within 5 minutes of placing your <span class="highlight">order</span> to avoid delays.</p>
        </div>

        <div class="summary-header">
            <div>ORDER SUMMARY</div>
            <div>Order ID: <strong><?= sanitize($message['code']) ?></strong></div>
        </div>

        <div class="details">
            <p><strong>From:</strong><br>
                <?= sanitize($restaurant_details['name']) ?>,<br>
                <?= sanitize($restaurant_details['address']) ?>
            </p>
            <?php if (!empty($decoded_address)) { ?>
                <p><strong>Delivered to:</strong><br>
                    <?= sanitize($decoded_address['number'] ?? '') ?>
                    <?= sanitize($decoded_address['street'] ?? '') ?><br>
                    <?= sanitize($decoded_address['address'] ?? '') ?><br>
                    <?= sanitize($decoded_address['zip_code'] ?? '') ?>
                    <?= sanitize($decoded_address['city'] ?? '') ?><br>
                </p>
            <?php } ?>
<table class="order-items">
<?php foreach ($ordered_items as $ordered_item): ?>

<?php
$menu_details = $this->menu_model->get_by_id($ordered_item['menu_id']);
$addonHTML = "";

if (!empty($ordered_item["addons"]) && $ordered_item["addons"] !== "[]") {

    $addons = json_decode($ordered_item["addons"], true);

    if (is_array($addons) && count($addons) > 0) {

        if (isset($addons[0]) && is_string($addons[0])) {

            $addonHTML = '<ul class="line-item"><li>' .
                implode(", ", array_map('sanitize', $addons)) .
                '</li></ul>';

        }

        else if (isset($addons[0]) && is_array($addons[0]) && isset($addons[0]['subVariantId'])) {

            $pizzas = [];
            $freeItems = [];
            $currentPizza = null;

            foreach ($addons as $addon) {

                if (empty($addon['itemId'])) continue;

                $item = $this->menu_model->get_addon_item_detail($addon['itemId']);
                if (empty($item)) continue;

                $variantName   = $item['variantName'] ?? '';
                $subOptionName = $item['subOptionName'] ?? '';

                $label = sanitize($subOptionName);

                // Free items
                if (stripos($variantName, 'Free Items') !== false) {

                    $freeItems[] = $label;

                }

                // Pizza number
                elseif (preg_match('/Pizza\s*(\d+)/i', $variantName, $matches)) {

                    $currentPizza = $matches[1];
                    $pizzas[$currentPizza][] = $label;

                }

                // Pizza options
                elseif (
                    stripos($variantName, 'Base') !== false ||
                    stripos($variantName, 'Crust') !== false ||
                    stripos($variantName, 'Toppings') !== false
                ) {

                    if ($currentPizza !== null) {
                        $pizzas[$currentPizza][] = $label;
                    }

                }
            }

            ob_start();
?>

<?php if (!empty($pizzas)): ?>
<?php foreach ($pizzas as $number => $items): ?>
<ul class="line-item">
<li><strong>Pizza <?= $number ?></strong></li>
<?php foreach ($items as $p): ?>
<li><?= $p ?></li>
<?php endforeach; ?>
</ul>
<?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($freeItems)): ?>
<ul class="line-item">
<li><strong>Extras</strong></li>
<?php foreach ($freeItems as $item): ?>
<li><?= $item ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php
            $addonHTML = ob_get_clean();
            // dd($addonHTML);
        }
    }
}
?>

<tr>
<td>
<?= (int)$ordered_item['quantity'] ?> x <?= sanitize($menu_details['name']) ?>

<?php if (!empty($addonHTML)): ?>
<br>
<?= $addonHTML ?>
<?php endif; ?>

</td>

<td>
<?= currency(number_format((float)$ordered_item['total'], 2)) ?>
</td>
</tr>

<?php if (!empty($ordered_item["variant_id"])): ?>
<tr>
<td>
Selected:
<?= sanitize($this->menu_model->get_variant_detail($ordered_item["variant_id"])[0]["name"]) ?>
</td>
<td></td>
</tr>
<?php endif; ?>

<?php endforeach; ?>
</table>
            <table class="totals">
                <tr>
                    <td><strong>Subtotal</strong></td>
                    <td><?= currency(number_format((float)$subtotal, 2)) ?></td>
                </tr>
                <tr>
                    <td>Service Charge</td>
                    <td><?= currency(number_format((float)$service_charge, 2)) ?></td>
                </tr>
                <tr>
                    <td>Bag Charges</td>
                    <td>£0.10</td>
                </tr>
                <?php if($delivery_charge != 0){ ?>
                <tr>
                    <td>Delivery Charge</td>
                    <td><?= currency(number_format((float)$delivery_charge, 2)) ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td>
<?php 
$order_url = strtolower($message['order_url'] ?? '');
$isFooyes = (strpos($order_url, 'fooyes') !== false);

if ($isFooyes) {

    if (!empty($message['promo_discount'])) {
        echo sanitize($message['promo_discount']) . "% PROMO DISCOUNT";
    } elseif ($message["order_type"] == "pickup") {
        echo "25% ONLINE DISCOUNT";
    } elseif ($message['order_type'] == "delivery") {
        echo "20% ONLINE DISCOUNT";
    } else {
        echo "90% ONLINE DISCOUNT";
    }

} else {

    if (!empty($message['promo_discount'])) {
        echo sanitize($message['promo_discount']) . "% PROMO DISCOUNT";
    } elseif ($message["order_type"] == "pickup") {
        echo "0% ONLINE DISCOUNT";
    } elseif ($message['order_type'] == "delivery") {
        echo "0% ONLINE DISCOUNT";
    } else {
        echo "0% ONLINE DISCOUNT";
    }

}
?>
</td>

                    <td>- <?= currency(number_format((float)$discount_amount, 2)) ?></td>
                </tr>

                <?php if($message['is_online_discount'] != null): ?>
                <tr>
                    <td><?= sanitize($message['is_online_discount']) ?>% ONLINE DISCOUNT</td>
                    <td>- <?php
                        $getOnlineDisc = (float)$message['is_online_discount'];
                        $is_online_discount = ($subtotal * $getOnlineDisc) / 100;
                        echo currency(number_format($is_online_discount, 2));
                    ?></td>
                </tr>
                <?php endif; ?>

                <tr>
                    <td><strong>Total</strong> (<?= (int)$total_items ?> Items)</td>
                    <td><strong><?= currency((float)$message['grand_total']) ?></strong></td>
                </tr>
            </table>
        </div>
        <div style="text-align: center; margin: 20px 0;">
            <strong style="color: #f54748;">You can only cancel your order in the next 5 minutes</strong>
                </div>
                <div style="text-align: center; margin: 30px 0;">
  <a href="<?php echo site_url('cart/cancel_order_frontend/' . sanitize($message['code'])); ?>"
     style="
        background:#ffffff;
        padding:12px 25px;
        font-size:16px;
        font-weight:bold;
        text-decoration:none;
        border-radius:6px;
        display:inline-block;
        border:2px solid #f54748;
        color:#f54748;
     "
     onclick="return confirm('Are you sure you want to cancel this order?');">
     Cancel Your Order
  </a>
</div>


        <div class="footer">
            &copy; 2025 
            <a class="float-right" target="_blank"
            <?php 
                if ($host == 'www.fooyes.local' || $host == 'www.chillihutmarch.fooyes.local') {
                    echo 'href="http://' . sanitize($message['order_url']) . '"';
                } else {
                    echo 'href="https://' . sanitize($message['order_url']) . '"';
                }
            ?>>
                <?= sanitize($message['order_url']) ?>
            </a>.
        </div>
    </div>
</body>
</html>
