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
        
        // print_r($abandoned_carts);
        // die();
 
        foreach ($abandoned_carts as $cart) {
            $visitedAt = new DateTime($cart->visited_at, new DateTimeZone('UTC'));
            $visitedAt->setTimezone(new DateTimeZone('Europe/London'));
            $visitedTime = $visitedAt->format('Y-m-d H:i:s');
          
            // Get user agent and IP address
            $user_agent = $cart->user_agent; // Assuming 'user_agent' column exists
            $ip_address = $cart->ip_address; // Assuming 'ip_address' column exists
            $phone_mobile = $cart->phone_mobile;
            $name_add = $cart->name_add;
            $email_add = $cart->email_add;
            $click = $cart->click;
            $click_message = $click == 1 ? 'Yes' : 'No';
            if ($cart->info_add == 0 && $cart->order_placed == 0) {
                $message .= "{$numbering}. Added to cart only — Visited at: {$visitedTime}\n";
                $message .= "   User Agent: {$user_agent}\n";
                $message .= "   IP Address: {$ip_address}\n";
                $message .= "   Click on Checkout: {$click_message}\n";
            } elseif ($cart->info_add == 1 && $cart->order_placed == 0) {
                $message .= "{$numbering}. {$cart->user_address} — Entered address but didn't place the order — Visited at: {$visitedTime}\n";
                $message .= "   Name: {$name_add}\n";
                $message .= "   Phone Number: {$phone_mobile}\n";
                $message .= "   Email: {$email_add}\n";                 
                $message .= "   User Agent: {$user_agent}\n";
                $message .= "   IP Address: {$ip_address}\n";
                $message .= "   Click on Checkout: {$click_message}\n";
                
            }
            $abandoned_count++;
            $numbering++;
        }
        
        if ($abandoned_count == 0) {
            $message .= "No Abandoned Carts Found Today.";
        } else {
            $message .= "\nTotal Abandoned Carts: {$abandoned_count}";
        }
// die();
        // Load PHPMailer
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        // SMTP config
        $mail->isSMTP();
        $mail->Host       = 'mail.fooyes.co.uk';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@fooyes.co.uk';
        $mail->Password   = 'hYEjNhb@[w&T7fRg';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('support@fooyes.co.uk', 'Fooyes');
        // $mail->addAddress('fmkhan79@gmail.com');
        $mail->addAddress('fooyesuk@gmail.com');
        // $mail->addBCC('fooyesuk@gmail.com');  
        $mail->addAddress('website25developer@gmail.com');

        $mail->Subject = 'Abandoned Cart Summary';
        $mail->Body    = $message;

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Email Sent Successfully!';
        }
    }
    

public function missedresponsenoti() {
    // Hardcoded user_id for testing purposes
    $user_id = 3;   

    // Get all orders with no response = 1
    $this->db->from('orders');
    $this->db->where('no_response', 1);
    $this->db->order_by('id', 'DESC');
    $orders = $this->db->get()->result_array();

    if (!empty($orders)) {
        // Get user (owner) info
        $owner = $this->db->get_where('users', ['id' => $user_id])->row_array();
        
        if ($owner && !empty($owner['email'])) {
            $owner_email = $owner['email'];

            // Prepare order list
            $order_codes = array_column($orders, 'code');
            $order_list = '';

            foreach ($orders as $order) {
                $billing_data = json_decode($order['billing'], true);

                if($order["order_type"] == "pos"){
                    continue;
                }
                if (!$billing_data || empty($billing_data['first_name'])) {
                    continue;
                }

                $customer_first_name = trim(strtolower($billing_data['first_name']));

                if ($customer_first_name === 'test') {
                    continue;
                }

                  $customer_last_name = trim(strtolower($billing_data['last_name']));

                if ($customer_last_name === 'test') {
                    continue;
                }

                $code = $order['code'];
                $grand_total_amount = $order['grand_total'];
                $customer_last_name = trim($billing_data['last_name']);
                $customer_name = ucfirst($billing_data['first_name']) . ' ' . ucfirst($customer_last_name);
                $customer_phone = $billing_data['phone_mobile'];

                // Append order details to the list
                $order_list .= "- Order <strong>#" . htmlspecialchars($code) . "</strong><br>";
                $order_list .= "&nbsp;&nbsp;&nbsp; Customer: <strong>" . htmlspecialchars($customer_name) . "</strong><br>";
                $order_list .= "&nbsp;&nbsp;&nbsp; Phone: <strong>" . htmlspecialchars($customer_phone) . "</strong><br>";
                $order_list .= "&nbsp;&nbsp;&nbsp; Total Order Amount: <strong>" . htmlspecialchars($grand_total_amount) . "€</strong><br><br>";
            }

            if (empty(trim($order_list))) {
                log_message('info', 'No missed orders to notify (only test customers). Email not sent.');
                echo 'No real missed orders found. Email not sent.';
                return; // exit before sending any email
            }

            
            // Prepare email content
            $subject = "Missed Orders Notification";
            $message = "Dear Restaurant Owner " . htmlspecialchars($owner['name']) . ",<br><br>";
            $message .= "You missed the following orders:<br><br>";
            $message .= $order_list;
            $message .= "<br>Please check your orders dashboard.<br><br>";
            $message .= "Regards,<br>Fooyes Team";

            // === Send Email using PHPMailer ===
            $this->load->library('phpmailer_lib');
            $mail = $this->phpmailer_lib->load();

            // SMTP config
            $mail->isSMTP();
            $mail->Host       = 'mail.fooyes.co.uk';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'support@fooyes.co.uk';
            $mail->Password   = 'hYEjNhb@[w&T7fRg';  
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            // Set sender info
            $mail->setFrom('support@fooyes.co.uk', 'Fooyes');

            // Add the restaurant owner email as the recipient
            $mail->addAddress($owner_email);
            // Add BCC to developer
            $mail->addBCC('website25developer@gmail.com');

            // Email body settings
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            // Send email and log the result
            if ($mail->send()) {
                echo 'Email Sent Successfully!';
                log_message('info', "Missed orders email sent to {$owner_email} for orders: " . implode(', ', $order_codes));
            } else {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                log_message('error', "Failed to send missed orders email to {$owner_email}. Mailer Error: " . $mail->ErrorInfo);
            }
        }
    }
}


    
}
