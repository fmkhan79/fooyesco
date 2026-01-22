<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Order Canceled Successfully</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
      color: #191919;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      border: 1px solid #ddd;
    }

    .summary-header {
      background: #f54748;
      color: #ffffff;
      text-align: center !important;
      padding: 10px 20px;
      font-weight: bold;
      font-size: 14px;
    }

    .header {
      padding: 20px;
      text-align: center;
    }

    .header h1 {
      color: #191919;
      margin-bottom: 10px;
      font-size: 22px;
    }

    .info {
      padding: 0 20px 20px;
      font-size: 14px;
      line-height: 1.6;
      text-align: center;
    }

    .info strong {
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
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="summary-header">
      Order Successfully Canceled
    </div>

    <div class="header">
      <h1>Hi <?= $message['customer_name'] ?? 'Customer' ?></h1>
    </div>

    <div class="info">
      <p><strong>Order Code:</strong> <?= $message['order_code'] ?></p>
      <p><strong>Order Date:</strong> <?= date('d M Y, h:i A', strtotime($message['order_date'])) ?></p>
        <p><strong>Total Amount:</strong> £<?= $message['total_amount'] ?? '0.00' ?></p>

      <p>Your order has been <strong>successfully canceled</strong>.  
      If any payment was made, the refund (if applicable) will be processed shortly.</p>
    </div>

    <div class="footer">
      &copy; 2025 <a href="https://fooyes.co.uk/">Fooyes</a>. All rights reserved.
    </div>
  </div>
</body>
</html>
