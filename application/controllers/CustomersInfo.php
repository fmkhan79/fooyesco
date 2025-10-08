<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 09 - June - 2020
 * Author : TheDevs
 * cuisine Controller controlls the Restaurant types
 */

include 'Authorization.php';

class CustomersInfo extends Authorization
{
    /**
     * CONSTRUCTOR CHECKS IF REQUIRED USER IS LOGGED IN
     */
    public function __construct()
    {
        parent::__construct();
        authorization(['admin', 'owner'], true);
    }

    // index function responsible for showing the index page.
    public function index()
    {
        $restaurant_id = $this->input->get('restaurant_id');
        $restaurant_id = sanitize($restaurant_id ?? 'all');

        $page_data['restaurant_id'] = $restaurant_id;
        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        $page_data['page_title'] = site_phrase("promotions", true);
        $page_data['page_name'] = 'customers_info/index';
        $page_data['customers'] = $this->order_model->get_all_orders_for_customer_details($restaurant_id);

        $this->load->view('backend/index', $page_data); // This loads views/backend/customers_info/index.php
    }

    // public function send_message()
    // {
    //     $send_email = $this->input->post('send_email') ? true : false;
    //     $send_sms = $this->input->post('send_sms') ? true : false;
    //     $discount = $this->input->post('discount');
    //     $message = $this->input->post('message');
    //     $customerDataJson = $this->input->post('selected_customers_data');

    //     $customers = json_decode($customerDataJson, true);

    //     if (!$customers || empty($message)) {
    //         $this->session->set_flashdata('error', 'No customer selected or message is empty.');
    //         redirect('customers-info/index');
    //     }

    //     $this->load->model('Promo_model');

    //     foreach ($customers as $cust) {
    //         if ($send_email) {
    //             $code = $this->Promo_model->generate_unique_promo_code();
    //             $this->db->insert('promo_codes', [
    //                 'offer_code' => $code,
    //                 'discount' => $discount,
    //             ]);
    //             $personalMessage = str_replace(
    //                 ['{customer_name}', '{promo_code}', '{discount}'],
    //                 [$cust['name'],$code, $discount],
    //                 $message
    //             );

    //             // Send email logic
    //             $mailData = [
    //                 'message_body' => $personalMessage,
    //                 'customer' => $cust
    //             ];
    //             $subject = 'New Promotion update at ' . $cust['restaurant'] . ' from Fooyes';
    //             $to = $cust['email'];
    //             $this->email_model->send_mail_using_php_mailer($mailData, $subject, $to, false, false, false, true);
    //         }
    //     }

    //     redirect(site_url('customers-info/index'));
    // }

     public function send_message()
    {
        $send_email = $this->input->post('send_email') ? true : false;
        $send_sms = $this->input->post('send_sms') ? true : false;
        $selected_discount = $this->input->post('discount_option');
        $discount = $this->input->post('discount');
        $message = $this->input->post('message');
        $customerDataJson = $this->input->post('selected_customers_data');
        $selectedDaysJson = $this->input->post('selected_days');
        $selectedDays     = json_decode($selectedDaysJson, true);

        $customers = json_decode($customerDataJson, true);
        $url = $this->input->post('url');
        if (!$customers || empty($message)) {
            $this->session->set_flashdata('error', 'No customer selected or message is empty.');
            redirect('customers-info/index');
        }

        $this->load->model('Promo_model');

        // Our Twilio credentials
        $this->load->model('admin_setting');
        $twilio = $this->admin_setting->get_twilio_credentials();

        $sid = $twilio->twilio_sid;
        $token  = $twilio->twilio_token;
        $twilio_number = $twilio->twilio_phone;
   
        foreach ($customers as $cust) {
            // Generate promo code
            $code = $this->Promo_model->generate_unique_promo_code();

            $promoData = [
                'offer_code' => $code,
                'discount'   => $discount,
                'restaurant_id'   => $cust['restaurant_id'],
                'monday'     => in_array('monday', $selectedDays) ? 1 : 0,
                'tuesday'    => in_array('tuesday', $selectedDays) ? 1 : 0,
                'wednesday'  => in_array('wednesday', $selectedDays) ? 1 : 0,
                'thursday'   => in_array('thursday', $selectedDays) ? 1 : 0,
                'friday'     => in_array('friday', $selectedDays) ? 1 : 0,
                'saturday'   => in_array('saturday', $selectedDays) ? 1 : 0,
                'sunday'     => in_array('sunday', $selectedDays) ? 1 : 0,
                'add_on_by_default' => $selected_discount == 'default' ? 1 : 0,
                'only_promo' => $selected_discount == 'promo' ? 1 : 0,
                'url' =>  $url
            ];

            $this->db->insert('promo_codes', $promoData);

            // $daysText = implode(', ', array_map('ucfirst', $selectedDays));

            $daysText = '';
            if (count($selectedDays) === 7) {
                $daysText = "Any day";
            } else {
                $daysText = implode(', ', array_map('ucfirst', $selectedDays));
            }
            

 $message = str_replace(
    '{discount}', 
    '{discount}%', 
    $message
);

if ($send_sms) {
     $personalMessage = str_replace(
    ['{customer_name}', '{discount}', '{valid_days}', '{promo_code}'],
    [$cust['name'], $discount, $daysText, $code],
    $message
);
}

if ($send_email) {
      $personalMessage = str_replace(
    ['{customer_name}', '{discount}', '{valid_days}'],
    [$cust['name'], $discount, $daysText],
    $message
);
}
//             // Replace placeholders
//   $personalMessage = str_replace(
//     ['{customer_name}', '{discount}', '{valid_days}', '{promo_code}'],
//     [$cust['name'], $discount, $daysText, $code],
//     $message
// );
            $formattedPhone = preg_replace('/^0/', '+44', $cust['phone']);

            // Send Email
            if ($send_email) {
               $mailData = [
    'message_body' => $personalMessage,
    'promo_code'   => $code,
    'customer'     => $cust,
    'discount'     => $discount,
    'valid_days'   => $daysText,
    'url' => $url
];

                $subject = 'Your special offer from ' . $cust['restaurant'];
                $to = $cust['email'];
                $this->email_model->send_mail_using_php_mailer($mailData, $subject, $to, false, false, false, true);
            }
// print_r($personalMessage);
// die();
                        // Send SMS using Twilio via cURL
                         // Send SMS using Twilio via cURL
                        if ($send_sms && !empty($cust['phone'])) {
                            $url = 'https://api.twilio.com/2010-04-01/Accounts/' . $sid . '/Messages.json';

                            $data = http_build_query([
                                'From' => "Fooyes",
                                'To'   => $formattedPhone, 
                                'Body' => $personalMessage,
                                
                            ]);
                            
                            $ch = curl_init();

                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_USERPWD, $sid . ':' . $token);

                            $response = curl_exec($ch);

                
                            if (curl_errno($ch)) {
                                log_message('error', 'Twilio SMS CURL Error: ' . curl_error($ch));
                            } else {
                                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                if ($httpCode >= 400) {
                                    log_message('error', 'Twilio SMS failed. Response: ' . $response);
                                }
                            }

                            curl_close($ch);
                        }

        }

        redirect(site_url('customers-info/index'));
    }


    public function special_promo()
    {
        $page_data['page_title'] = site_phrase("special_promo", true);
        $page_data['page_name'] = 'special_promo/index';

        $this->load->view('backend/index', $page_data);
    }

    public function special_promo_create() {
        // Get form inputs
        $code              = $this->input->post('offer_code', TRUE);
        $discount          = $this->input->post('discount', TRUE);
        $selectedDaysJson = $this->input->post('selected_days');
        $selectedDays     = json_decode($selectedDaysJson, true); // yeh array aana chahiye
        $selected_discount = $this->input->post('discount_option', TRUE);

        // Proper promoData (table me agar days aur flags chahiye ho to)
        $promoData = [
            'offer_code' => $code,
            'discount'   => $discount,
            'monday'     => in_array('monday', $selectedDays) ? 1 : 0,
            'tuesday'    => in_array('tuesday', $selectedDays) ? 1 : 0,
            'wednesday'  => in_array('wednesday', $selectedDays) ? 1 : 0,
            'thursday'   => in_array('thursday', $selectedDays) ? 1 : 0,
            'friday'     => in_array('friday', $selectedDays) ? 1 : 0,
            'saturday'   => in_array('saturday', $selectedDays) ? 1 : 0,
            'sunday'     => in_array('sunday', $selectedDays) ? 1 : 0,
            'add_on_by_default' => ($selected_discount == 'default') ? 1 : 0,
            'only_promo'        => ($selected_discount == 'promo') ? 1 : 0,
            'is_special' => true
        ];

            
        // Insert data into the database
        $result = $this->db->insert('promo_codes', $promoData);

        if ($result) {
            $this->session->set_flashdata('success', 'Special promo code created successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to create special promo code.');
        }

        redirect('customers-info/special_promo');
    }

}
