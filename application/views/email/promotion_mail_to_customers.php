<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Promotion</title>
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
            line-height: 1.7;
            font-weight: normal;
        }

        .info a {
            color: #f54748;
            font-weight: bold;
        }

        .summary-header {
            background: #f54748;
            color: #ffffff;
            padding: 12px 20px;
            font-weight: bold;
            font-size: 16px;
        }

        .details {
            padding: 20px;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999;
        }

        /* Style promo code span */
        .promo-code {
            color: #f54748;
            font-weight: bold;
            font-size: 14px;
        }

        @media only screen and (max-width: 600px) {
            .container { width: 90%; }
            .header h1 { font-size: 20px; }
            .summary-header { font-size: 15px; padding: 10px 15px; }
            .details { padding: 15px; font-size: 13px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Hey <?= sanitize($message['customer']['name']) ?>! 👋</h1>
            <a href="https://fooyes.co.uk/">
                <img src="https://fooyes.co.uk/uploads/system/VJMkY4SgTdEnL35HtR9G.jpg" alt="Fooyes Logo" style="width:80px; height:auto; margin-top:5px;">
            </a>
        </div>
        
        <div class="summary-header">
            Special Offer Just for You!
        </div>

        <div class="info">
            <?php
                // Sanitize original message
                $safeMessage = sanitize($message['message_body']);
                // Replace {promo_code} placeholder with styled promo code
                $styledMessage = str_replace(
                    '{promo_code}',
                    '<span class="promo-code">' . sanitize($message['promo_code']) . '</span>',
                    $safeMessage
                );
            ?>
            <p><?= nl2br($styledMessage) ?></p>
            <p>Visit us today: <a href="https://fooyes.co.uk/">fooyes.co.uk</a></p>
        </div>

        <div class="footer">
            &copy; <?= date('Y') ?> <a href="https://fooyes.co.uk/">Fooyes</a>. All rights reserved.
        </div>
    </div>
</body>
</html>