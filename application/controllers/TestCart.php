<?php
defined('BASEPATH') or exit('No direct script access allowed');
include 'Base.php';

class Testcart extends Base {

    public function send() {
        // Set timezone to Europe/London
        $checking = new DateTime('now', new DateTimeZone('Europe/London'));

        $dt = new DateTime('now', new DateTimeZone('Europe/London'));
        $dt->modify('-6 hours');
        $time_limit = $dt->format('Y-m-d H:i:s');

            
        // Optional: Log or echo the time limit for debugging
        // echo "Cutoff Time (London): " . $time_limit;

        $abandoned_carts = $this->db->where('order_placed', 0)
            ->where('visited_at <', $time_limit)
            ->get('cart_visits')
            ->result();

        if (empty($abandoned_carts)) {
            echo "No abandoned carts found.";
            return;
        }

        $message = "Abandoned Cart Report\n\n";
        echo "Time: " . htmlspecialchars($checking->format('Y-m-d H:i:s'));

        $abandoned_count = 0;
        $numbering = 1; 

        foreach ($abandoned_carts as $cart) {
            if ($cart->info_add == 0 && $cart->order_placed == 0) {
                $time_limit;
                $message .= "{$numbering}. Added to cart only.\n";
                $abandoned_count++;
                $numbering++;
            } elseif ($cart->info_add == 1 && $cart->order_placed == 0) {
                $message .= "{$numbering}. {$cart->user_address} - Entered address but didn't place the order.\n";
                $abandoned_count++;
                $numbering++;
                $time_limit;

            }

        }

        if ($abandoned_count > 0) {
            $message .= "\nTotal Abandoned Carts: {$abandoned_count}";

            // Load PHPMailer
            $this->load->library('phpmailer_lib');
            $mail = $this->phpmailer_lib->load();

            // SMTP config
            $mail->isSMTP();
            $mail->Host       = 'mail.fooyes.co.uk';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'no-reply@fooyes.co.uk';
            $mail->Password   = '^X{zK)uB%XrS';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('no-reply@fooyes.co.uk', 'Fooyes');
            $mail->addAddress('sabihkhan420@gmail.com');
            $mail->Subject = 'Abandoned Cart Summary (Manual Test)';
            $mail->Body    = $message;
     
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Email Sent Successfully!';
            }
        } else {
            $message = "No Abandoned Carts Found. ";

            // Load PHPMailer
            $this->load->library('phpmailer_lib');
            $mail = $this->phpmailer_lib->load();

            // SMTP config
            $mail->isSMTP();
            $mail->Host       = 'mail.fooyes.co.uk';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'no-reply@fooyes.co.uk';
            $mail->Password   = '^X{zK)uB%XrS';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('no-reply@fooyes.co.uk', 'Fooyes');
            $mail->addAddress('website25developer@gmail.com');
            $mail->Subject = 'Abandoned Cart Summary (Manual Test)';
            $mail->Body    = $message;
     
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        }
    }
}
