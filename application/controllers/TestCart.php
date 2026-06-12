<?php
defined('BASEPATH') or exit('No direct script access allowed');
include 'Base.php';

class Testcart extends Base {

   public function send() {
    // Hardcoded restaurant ID for testing purposes
    $restaurant_id = 3;

    // Get restaurant info
    $restaurant = $this->db->get_where('restaurants', ['id' => $restaurant_id])->row_array();

    if (!$restaurant || empty($restaurant['email'])) {
        log_message('error', "Restaurant not found or main email missing for ID: {$restaurant_id}");
        echo "Restaurant email not found.";
        return;
    }

    $owner_email = $restaurant['email']; // main restaurant email
    $extra_email = $restaurant['abandoned_cart_email']; // custom abandoned cart email

    // Set timezone to Europe/London
    $now = new DateTime('now', new DateTimeZone('Europe/London'));
    $today = $now->format('Y-m-d'); 
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

        $user_agent = $cart->user_agent ?? '';
        $ip_address = $cart->ip_address ?? '';
        $phone_mobile = $cart->phone_mobile ?? '';
        $name_add = $cart->name_add ?? '';
        $email_add = $cart->email_add ?? '';
        $click = $cart->click ?? 0;
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

    // ✅ Main restaurant email
    $mail->addAddress($owner_email);

    // ✅ Extra abandoned cart email if set
    if (!empty($extra_email) && $extra_email != $owner_email) {
        $mail->addAddress($extra_email);
    }

    // ✅ Always send to fooyesuk@gmail.com too
    $mail->addAddress('fooyesuk@gmail.com');

    // ✅ BCC developer
    $mail->addBCC('website25developer@gmail.com');

    $mail->Subject = 'Abandoned Cart Summary';
    $mail->Body    = $message;

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        log_message('error', "Failed to send abandoned cart email to {$owner_email}. Mailer Error: " . $mail->ErrorInfo);
    } else {
        echo 'Email Sent Successfully!';
        log_message('info', "Abandoned cart email sent to {$owner_email}" . (!empty($extra_email) ? " and {$extra_email}" : "") . " and fooyesuk@gmail.com");
    }
}

  public function team_missed_order_notification() {

    // Get all restaurants
    $restaurants = $this->db->get('restaurants')->result_array();

    foreach ($restaurants as $restaurant) {

        $user_id = $restaurant['id'];

        // Get missed orders for this restaurant
        $this->db->from('orders');
        $this->db->where('no_response', 1);
        $this->db->where('restaurant_id', $user_id);
        $this->db->order_by('id', 'DESC');

        $orders = $this->db->get()->result_array();

        if (empty($orders)) {
            continue; // skip if no orders
        }

        $owner_email = $restaurant['email'];
        $extra_email = $restaurant['missed_order_email'];

        // Get owner info
        $owner = $this->db->get_where('users', ['id' => $user_id])->row_array();

        if (!$owner) {
            continue;
        }

        // fallback email
        if (empty($owner_email) && !empty($owner['email'])) {
            $owner_email = $owner['email'];
        }

        $order_list = [];
        $order_codes = [];

        foreach ($orders as $order) {

            $billing_data = json_decode($order['billing'], true);

            if ($order["order_type"] == "pos") continue;
            if (!$billing_data || empty($billing_data['first_name'])) continue;

            if (strtolower(trim($billing_data['first_name'])) == 'test') continue;
            if (strtolower(trim($billing_data['last_name'])) == 'test') continue;

            $code = $order['code'];
            $order_codes[] = $code;

            $customer_name = ucfirst($billing_data['first_name']) . ' ' . ucfirst($billing_data['last_name']);
            $customer_phone = $billing_data['phone_mobile'];

            $base_url = !empty($_SERVER['HTTP_HOST']) 
            ? (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']
            : 'https://fooyes.co.uk'; // fallback for cron

            $accept_url = $base_url . "/orders/view_mail/{$order['code']}/?s=1&key={$order['secret_mail_accept']}";
            
            $order_list[] = "
            <div style='font-family: Arial, sans-serif; background-color: #f9f9f9; border: 1px solid #e0e0e0; border-left: 4px solid #4CAF50; border-radius: 8px; padding: 16px 20px; margin-bottom: 16px; max-width: 520px;'>
            
            <p style='margin: 0 0 6px 0; font-size: 16px; color: #333;'>
                🛒 Order <strong style='color: #2c2c2c;'>#{$code}</strong>
            </p>

            <p style='margin: 4px 0; font-size: 14px; color: #555;'>
                👤 Customer: <strong>{$customer_name}</strong>
            </p>

            <p style='margin: 4px 0; font-size: 14px; color: #555;'>
                📞 Phone: <strong>{$customer_phone}</strong>
            </p>

            <p style='margin: 4px 0 14px 0; font-size: 14px; color: #555;'>
                💰 Total: <strong style='color: #2e7d32;'>{$order['grand_total']}€</strong>
            </p>

            <a href='{$accept_url}' style='display: inline-block; background-color: #4CAF50; color: #ffffff; text-decoration: none; padding: 9px 20px; border-radius: 5px; font-size: 14px; font-weight: bold;'>
                ✅ Accept/View Order
            </a>

            </div>";
            
        }
        

        if (empty($order_list)) {
            continue;
        }


        $order_list_html = implode('', $order_list);

        // Email content
        $subject = "Missed Orders Notification";
        $message = "Dear {$owner['name']},<br><br>";
        $message .= "You missed the following orders:<br><br>";
        $message .= $order_list_html;
        $message .= "<br>Please check your dashboard.<br><br>Regards,<br>Fooyes Team";

        // PHPMailer
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        $mail->isSMTP();
        $mail->Host       = 'mail.fooyes.co.uk';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@fooyes.co.uk';
        $mail->Password   = 'hYEjNhb@[w&T7fRg';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('support@fooyes.co.uk', 'Fooyes');

        if (!empty($owner_email)) {
            // $mail->addAddress($owner_email);
        }

        $mail->addAddress('website25developer@gmail.com');
        $mail->addAddress('fooyesuk@gmail.com');

        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        if ($mail->send()) {
            log_message('info', "Missed orders email sent to {$owner_email} (Restaurant ID: {$user_id})");
        } else {
            log_message('error', "Mailer Error for restaurant {$user_id}: " . $mail->ErrorInfo);
        }
    }

    echo "Process completed for all restaurants.";
}



  public function missedresponsenoti() {
    
    $this->team_missed_order_notification();
    
    // Get all restaurants
    $restaurants = $this->db->get('restaurants')->result_array();

    foreach ($restaurants as $restaurant) {

        $user_id = $restaurant['id'];

        // Get missed orders for this restaurant
        $this->db->from('orders');
        $this->db->where('missed_order_email_count_left >', 0);
        $this->db->where('no_response', 1);
        $this->db->where('restaurant_id', $user_id);
        $this->db->order_by('id', 'DESC');

        $orders = $this->db->get()->result_array();

        if (empty($orders)) {
            continue; // skip if no orders
        }

        $owner_email = $restaurant['email'];
        $extra_email = $restaurant['missed_order_email'];

        // Get owner info
        $owner = $this->db->get_where('users', ['id' => $user_id])->row_array();

        if (!$owner) {
            continue;
        }

        // fallback email
        if (empty($owner_email) && !empty($owner['email'])) {
            $owner_email = $owner['email'];
        }

        $order_list = [];
        $order_codes = [];

        foreach ($orders as $order) {

            $billing_data = json_decode($order['billing'], true);

            if ($order["order_type"] == "pos") continue;
            if (!$billing_data || empty($billing_data['first_name'])) continue;

            if (strtolower(trim($billing_data['first_name'])) == 'test') continue;
            if (strtolower(trim($billing_data['last_name'])) == 'test') continue;

            $code = $order['code'];
            $order_codes[] = $code;

            $customer_name = ucfirst($billing_data['first_name']) . ' ' . ucfirst($billing_data['last_name']);
            $customer_phone = $billing_data['phone_mobile'];

            $base_url = !empty($_SERVER['HTTP_HOST']) 
            ? (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']
            : 'https://fooyes.co.uk'; // fallback for cron

            $accept_url = $base_url . "/orders/view_mail/{$order['code']}/?s=1&key={$order['secret_mail_accept']}";
            
            $order_list[] = "
            <div style='font-family: Arial, sans-serif; background-color: #f9f9f9; border: 1px solid #e0e0e0; border-left: 4px solid #4CAF50; border-radius: 8px; padding: 16px 20px; margin-bottom: 16px; max-width: 520px;'>
            
            <p style='margin: 0 0 6px 0; font-size: 16px; color: #333;'>
                🛒 Order <strong style='color: #2c2c2c;'>#{$code}</strong>
            </p>

            <p style='margin: 4px 0; font-size: 14px; color: #555;'>
                👤 Customer: <strong>{$customer_name}</strong>
            </p>

            <p style='margin: 4px 0; font-size: 14px; color: #555;'>
                📞 Phone: <strong>{$customer_phone}</strong>
            </p>

            <p style='margin: 4px 0 14px 0; font-size: 14px; color: #555;'>
                💰 Total: <strong style='color: #2e7d32;'>{$order['grand_total']}€</strong>
            </p>

            <a href='{$accept_url}' style='display: inline-block; background-color: #4CAF50; color: #ffffff; text-decoration: none; padding: 9px 20px; border-radius: 5px; font-size: 14px; font-weight: bold;'>
                ✅ Accept/View Order
            </a>

            </div>";

            $this->db->where('id', $order['id']);
            $this->db->where('missed_order_email_count_left >', 0);
            $this->db->set('missed_order_email_count_left', 'missed_order_email_count_left - 1', false);
            $this->db->update('orders');
            
        }
        

        if (empty($order_list)) {
            continue;
        }


        $order_list_html = implode('', $order_list);

        // Email content
        $subject = "Missed Orders Notification";
        $message = "Dear {$owner['name']},<br><br>";
        $message .= "You missed the following orders:<br><br>";
        $message .= $order_list_html;
        $message .= "<br>Please check your dashboard.<br><br>Regards,<br>Fooyes Team";

        // PHPMailer
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        $mail->isSMTP();
        $mail->Host       = 'mail.fooyes.co.uk';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@fooyes.co.uk';
        $mail->Password   = 'hYEjNhb@[w&T7fRg';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('support@fooyes.co.uk', 'Fooyes');

        if (!empty($owner_email)) {
            // $mail->addAddress($owner_email);
        }

        if (!empty($extra_email) && $extra_email != $owner_email) {
            $mail->addAddress($extra_email);
        }
        $mail->addBCC('website25developer@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        if ($mail->send()) {
            log_message('info', "Missed orders email sent to {$owner_email} (Restaurant ID: {$user_id})");
        } else {
            log_message('error', "Mailer Error for restaurant {$user_id}: " . $mail->ErrorInfo);
        }
    }

    echo "Process completed for all restaurants.";
}

}