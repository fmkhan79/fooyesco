<?php
defined('BASEPATH') or exit('No direct script access allowed');
include 'Base.php';

class Testcart extends Base {

    public function send() {
        // Set timezone to Europe/London
        $now = new DateTime('now', new DateTimeZone('Europe/London'));
        $today = $now->format('Y-m-d'); // e.g. 2025-04-17
        $start_of_day = $today . ' 00:00:00';
        $end_of_day = $today . ' 23:59:59';

        // Fetch abandoned carts visited today only
        $abandoned_carts = $this->db->where('order_placed', 0)
            ->where('visited_at >=', $start_of_day)
            ->where('visited_at <=', $end_of_day)
            ->get('cart_visits')
            ->result();

        $message = "Abandoned Cart Report\n\n";
        $message .= "Date: " . $now->format('Y-m-d H:i:s') . "\n\n";

        $abandoned_count = 0;
        $numbering = 1;

        foreach ($abandoned_carts as $cart) {
            $visitedAt = new DateTime($cart->visited_at, new DateTimeZone('UTC'));
            $visitedAt->setTimezone(new DateTimeZone('Europe/London'));
            $visitedTime = $visitedAt->format('Y-m-d H:i:s');
        
            // Get user agent and IP address
            $user_agent = $cart->user_agent; // Assuming 'user_agent' column exists
            $ip_address = $cart->ip_address; // Assuming 'ip_address' column exists

            if ($cart->info_add == 0 && $cart->order_placed == 0) {
                $message .= "{$numbering}. Added to cart only — Visited at: {$visitedTime}\n";
                $message .= "   User Agent: {$user_agent}\n";
                $message .= "   IP Address: {$ip_address}\n";
            } elseif ($cart->info_add == 1 && $cart->order_placed == 0) {
                $message .= "{$numbering}. {$cart->user_address} — Entered address but didn't place the order — Visited at: {$visitedTime}\n";
                $message .= "   User Agent: {$user_agent}\n";
                $message .= "   IP Address: {$ip_address}\n";
            }
            $abandoned_count++;
            $numbering++;
        }
        
        if ($abandoned_count == 0) {
            $message .= "No Abandoned Carts Found Today.";
        } else {
            $message .= "\nTotal Abandoned Carts: {$abandoned_count}";
        }

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
        $mail->addAddress('fmkhan79@gmail.com');
        $mail->addAddress('fooyesuk@gmail.com');
        $mail->addAddress('website25developer@gmail.com');

        $mail->Subject = 'Abandoned Cart Summary (Manual Test)';
        $mail->Body    = $message;

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Email Sent Successfully!';
        }
    }
}
