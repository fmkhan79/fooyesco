<?php
// Get customer details
$customer_details = $this->customer_model->get_by_id($message['customer_id']);

// Load required models
$this->load->model('order_model');
$this->load->model('restaurant_model');
$this->load->model('menu_model');
$this->load->model('cart_model');

// Get ordered items
$ordered_items = $this->order_model->details($message['code']);

// Get restaurant details (assume same for all items)
$restaurant_details = $this->restaurant_model->get_by_id($ordered_items[0]['restaurant_id']);

$appliedPromo = $this->session->userdata('user_promo');

// Determine discount percentage
if (!empty($appliedPromo['discount']) && is_numeric($appliedPromo['discount'])) {
    $res_discount = $appliedPromo['discount'];
} else {
    if ($message["order_type"] == "pickup") {
        $res_discount = 25;
    } else {
        $res_discount = 20;
    }
}

// Prepare calculations
$subtotal = $message['total_menu_price']; // menu items total
$service_charge = $this->cart_model->get_service_amount(); // static or percentage-based service charge
$delivery_charge = ($message['order_type'] == 'pickup') ? 0 : sanitize($message['total_delivery_charge']);
$bag_charge = 0.10; // fixed charge

$discount_amount = ($subtotal * $res_discount) / 100;

// print_r($subtotal + $service_charge + $delivery_charge + $bag_charge - $discount_amount);
// Step 2: Calculate grand total
$grand_total = ($subtotal + $service_charge + $delivery_charge + $bag_charge) - $discount_amount;
// print_r(currency($grand_total));

$decoded_address = json_decode($message['address'], true);


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
            <p>Thank you for choosing Fooyes! Your <span class="highlight">order</span> has been successfully placed and forwarded to our kitchen team. If you need to make any changes to your <span class="highlight">order</span>, please contact us immediately at <a href="tel:<?= $restaurant_details['phone'] ?>"><?= $restaurant_details['phone'] ?></a>.</p>
            <p>Kindly ensure that any modifications or cancellations are requested within 5 minutes of placing your <span class="highlight">order</span> to avoid delays.</p>
        </div>


        <div class="summary-header">
            <div>ORDER SUMMARY</div>
            <div>Order ID: <strong><?= sanitize($message['code']) ?></strong></div>
        </div>

        <div class="details">
            <p><strong>From:</strong><br>
                <?= $restaurant_details['name'] ?>,<br>
                <?= $restaurant_details['address'] ?>
            </p>
            <?php if (!empty($decoded_address)) { ?>
                <p><strong>Delivered to:</strong><br>
                    <?= sanitize($decoded_address['number'] ?? '') ?>
                    <?= sanitize($decoded_address['street'] ?? '') ?><br>
                    <?= sanitize($decoded_address['address'] ?? '') ?><br>
                    <?= sanitize($decoded_address['zip_code'] ?? '') ?>
                    <?= sanitize($decoded_address['city'] ?? '') ?><br>
                    <?= sanitize($decoded_address['country'] ?? '') ?>
                </p>
            <?php } ?>
            <table class="order-items">
                <?php foreach ($ordered_items as $ordered_item): ?>
                    <?php
                        $menu_details = $this->menu_model->get_by_id($ordered_item['menu_id']);
                        $addonHTML = "";
                        if ($ordered_item["addons"] != "[]") {
                            $groupedAddons = [];
                            $addons = json_decode($ordered_item["addons"], true);
                            foreach ($addons as $addon) {
                                $groupedAddons[$addon['subVariantId']][] = $addon['itemId'];
                            }
                            $addonHTML = $this->menu_model->addons_grouped_data($groupedAddons);
                        }
                    ?>
                    <tr>
                        <td>
                            <?= $ordered_item['quantity'] ?> x <?= html_entity_decode(sanitize($menu_details['name'])) ?>
                            <?php if ($addonHTML): ?>
                                <br><small><?= $addonHTML ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= currency(number_format(sanitize($ordered_item['total']), 2)) ?></td>
                    </tr>
                    <?php if (!empty($ordered_item["variant_id"])): ?>
                        <tr>
                            <td>Selected: <?= $this->menu_model->get_variant_detail($ordered_item["variant_id"])[0]["name"] ?></td>
                            <td></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>

            <table class="totals">
                <tr>
                    <td><strong>Subtotal</strong></td>
                    <td><?= currency(number_format($subtotal, 2)) ?></td>
                </tr>
                <tr>
                    <td>Service Charge</td>
                    <td><?= currency(number_format($service_charge, 2)) ?></td>
                </tr>
                <tr>
                    <td>Bag Charges</td>
                    <td>£0.10</td>
                </tr>
                <?php if($delivery_charge != 0){ ?>
                <tr>
                    <td>Delivery Charge</td>
                    <td><?= currency(number_format($delivery_charge, 2)) ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td>
                        <?= $res_discount ?>% DISCOUNT
                    </td>
                    <td><?= currency("-" . number_format($discount_amount, 2)) ?></td>
                </tr>
                <tr>
                    <td><strong>Total</strong> (<?php echo $total_items; ?> Items)</td>
                    <td><strong><?= currency($grand_total) ?></strong></td>
                </tr>
            </table>
        </div>

        <div class="footer">
            &copy; 2025 <a href="https://fooyes.co.uk/">Fooyes</a>. All rights reserved.
        </div>
    </div>
</body>
</html>
