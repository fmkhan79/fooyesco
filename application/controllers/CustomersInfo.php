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

    public function send_message()
    {
        $send_email = $this->input->post('send_email') ? true : false;
        $send_sms = $this->input->post('send_sms') ? true : false;
        $message = $this->input->post('message');
        $customerDataJson = $this->input->post('selected_customers_data');

        $customers = json_decode($customerDataJson, true);

        if (!$customers || empty($message)) {
            $this->session->set_flashdata('error', 'No customer selected or message is empty.');
            redirect('customers-info/index');
        }

        foreach ($customers as $cust) {
            if ($send_email) {
                // Send email logic
                $mailData = [
                    'message_body' => $message,
                    'customer' => $cust
                ];
                $subject = 'New Promotion update at '. $cust['restaurant'] .' from Fooyes';
                $to = $cust['email'];
                $this->email_model->send_mail_using_php_mailer($mailData, $subject, $to, false, false, false, true);
            }
        }

        redirect(site_url('customers-info/index'));
    }
}
