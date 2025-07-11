<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Thank You for Contacting Us</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
      color: #191919;
    }

    a {
      color: #f54748 !important;
      text-decoration: none;
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
      text-align: center !important;
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
        <h1>Thank You <?= $name ?>!</h1>
    </div>
    <div class="header">
      <a href="https://fooyes.co.uk/">
        <img src="https://fooyes.co.uk/uploads/system/VJMkY4SgTdEnL35HtR9G.jpg" alt="Fooyes Logo" style="width:80px; height:auto; margin-top:5px;">
      </a>
    </div>

    <div class="info">
      <p>We have received your message and our team will get back to you shortly.</p>
      <p>Your query is important to us, and we aim to respond within <span class="highlight">24 hours</span>.</p>
      <p>For urgent assistance, feel free to contact us.</p>
      <p>Meanwhile, you can explore our <a href="https://fooyes.co.uk/">website</a> for the latest updates and offers.</p>
    </div>

    <div class="footer">
      &copy; 2025 <a href="https://fooyes.co.uk/">Fooyes</a>. All rights reserved.
    </div>
  </div>
</body>
</html>
