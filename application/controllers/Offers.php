<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 22 - August - 2020
 * Author : TheDevs
 * Offers Controller controlls the task for orders
 */

include 'Authorization.php';
class Offers extends Authorization
{
    /**
     * CONSTRUCTOR CHECKS IF REQUIRED USER IS LOGGED IN
     */
    public function __construct()
    {
        parent::__construct();
        // authorization(['admin', 'owner', 'customer', 'driver', 'cook'], true);
    }

    /**
     * index function responsible for showing the index page of order
     *
     * @return void
     */
    public function index()
    {
        $page_data['restaurant_id'] = isset($_GET['restaurant_id']) ? sanitize($_GET['restaurant_id']) : "all";
        $page_data['customer_id'] = isset($_GET['customer_id']) ? sanitize($_GET['customer_id']) : "all";
        $page_data['driver_id'] = isset($_GET['driver_id']) ? sanitize($_GET['driver_id']) : "all";
        $page_data['status'] = isset($_GET['status']) ? sanitize($_GET['status']) : "all";

        if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
            $date_range                   = sanitize($this->input->get('date_range'));
            $date_range                   = explode(" - ", $date_range);
            $page_data['starting_timestamp'] = strtotime($date_range[0] . ' 00:00:00');
            $page_data['ending_timestamp']   = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $first_day_of_month = "1 " . date("M") . " " . date("Y") . ' 00:00:00';
            $last_day_of_month = date("t") . " " . date("M") . " " . date("Y") . ' 23:59:59';
            $page_data['starting_timestamp']   = strtotime($first_day_of_month);
            $page_data['ending_timestamp']     = strtotime($last_day_of_month);
        }

        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        $page_data['customers'] = $this->customer_model->get_approved_customers();
        $page_data['drivers'] = $this->driver_model->get_approved_drivers();

        $page_data['page_name'] = 'offers/index';
        $page_data['order_type'] = 'all';
        $page_data['page_title'] = 'Offers';
        $page_data['orders'] = $this->offer_model->filter();
        $this->load->view('backend/index', $page_data);
    }

    // TODAYS ORDERS
    public function today()
    {
        $page_data['restaurant_id'] = isset($_GET['restaurant_id']) ? sanitize($_GET['restaurant_id']) : "all";
        $page_data['customer_id'] = isset($_GET['customer_id']) ? sanitize($_GET['customer_id']) : "all";
        $page_data['driver_id'] = isset($_GET['driver_id']) ? sanitize($_GET['driver_id']) : "all";
        $page_data['status'] = isset($_GET['status']) ? sanitize($_GET['status']) : "all";

        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        $page_data['customers'] = $this->customer_model->get_approved_customers();
        $page_data['drivers'] = $this->driver_model->get_approved_drivers();

        $page_data['page_name'] = 'offers/index';
        $page_data['order_type'] = 'today';
        $page_data['page_title'] = get_phrase("todays_orders");
        $page_data['orders'] = $this->order_model->get_todays_orders();
        $this->load->view('backend/index', $page_data);
    }

    // GET DETAILS OF AN ORDER
    public function details($order_code)
    {
        if (!$this->order_model->is_valid($order_code)) {
            error(get_phrase('invalid_order'), site_url('orders'));
        }

        $page_data['page_name'] = 'orders/details';
        $page_data['page_title'] = get_phrase("order_details");
        $page_data['order_code'] = $order_code;
        $page_data['order_data'] = $this->order_model->get_by_code($order_code);
        $page_data['ordered_items'] = $this->order_model->details($order_code);
        $this->load->view('backend/index', $page_data);
    }

    public function banner(){



        // Check if it's a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        


        // Get form data
        $heading = $this->input->post('heading');
        $description = $this->input->post('description');
        $ctaLink = $this->input->post('ctaLink');

        // Save the form data to the database
        $this->order_model->saveSettings('heading', $heading);
        $this->order_model->saveSettings('description', $description);
        $this->order_model->saveSettings('ctaLink', $ctaLink);

    }

        // Get saved settings
        $heading = $this->order_model->getSetting('heading');
        $description = $this->order_model->getSetting('description');
        $ctaLink = $this->order_model->getSetting('ctaLink');

        // Pass data to the view
        $page_data['heading'] = $heading;
        $page_data['description'] = $description;
        $page_data['ctaLink'] = $ctaLink;
        
        $page_data['page_name'] = 'offers/banner';
        $page_data['page_title'] = "Offer Banner";
        $this->load->view('backend/index', $page_data);
        
    }




    public function checkUniquePromoCode() {
        $promoCode = $this->input->post('promo_code');
        
        // Load the model
        $this->load->model('Offer_model');

        // Check uniqueness in the model
        $isUnique = $this->Offer_model->isUniquePromoCode($promoCode);

        // Send response to the client
        echo json_encode(['isUnique' => $isUnique]);
    }


    public function save_offer() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            
            // Get form data
            $data = array(
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'monday' => $this->input->post('active_days') ? in_array('monday', $this->input->post('active_days')) : 0,
                'tuesday' => $this->input->post('active_days') ? in_array('tuesday', $this->input->post('active_days')) : 0,
                'wednesday' => $this->input->post('active_days') ? in_array('wednesday', $this->input->post('active_days')) : 0,
                'thursday' => $this->input->post('active_days') ? in_array('thursday', $this->input->post('active_days')) : 0,
                'friday' => $this->input->post('active_days') ? in_array('friday', $this->input->post('active_days')) : 0,
                'saturday' => $this->input->post('active_days') ? in_array('saturday', $this->input->post('active_days')) : 0,
                'sunday' => $this->input->post('active_days') ? in_array('sunday', $this->input->post('active_days')) : 0,
                'discount_percentage' => $this->input->post('discount_percentage'),
                'amount_limit' => $this->input->post('amount_limit'),
                'promo_code' => $this->input->post('promo_code'),
                'title' => $this->input->post('title'),
                'title' => $this->input->post('title'),
            );

            // Save the offer data to the database
          
            $this->offer_model->save_offer($data);

            // Redirect to a success page or any other page
            redirect('offers');
        } else {
            // Handle non-POST requests, maybe show an error page
            show_error('Invalid request method.');
        }
    }

    function delete($id)
    {
        $response = $this->offer_model->delete_offer($id);
        if ($response) {
            success(get_phrase('offer_deleted_successfully'), site_url('offers'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('offers'));
        }
    }

    // PROCESSING ORDERS MAKE SURE THAT THE USER IS ADMIN
    public function process($order_code, $phase)
    {
        if (can_process_order()) {
            authorization(['admin', 'driver', 'cook', 'owner'], true);
        } else {
            authorization(['admin', 'driver', 'cook'], true);
        }

        $this->order_model->process($order_code, $phase);
    }



    

   

    // // LIVE ORDERS FOR TODAY
    // public function live($response = false)
    // {
    //     $page_data['page_name'] = 'orders/index';
    //     $page_data['order_type'] = 'live';
    //     $page_data['page_title'] = get_phrase("live_orders");
    //     $page_data['orders'] = $this->order_model->get_live_orders();
    //     if ($response == 'data') {
    //         echo json_encode($page_data['orders']);
    //     } elseif ($response == 'view') {
    //         $this->load->view('backend/' . $this->logged_in_user_role . '/orders/live-data', $page_data);
    //     } else {
    //         $this->load->view('backend/index', $page_data);
    //     }
    // }

   

    // GET NUMBER OF ORDERS SPECIALLY FOR AJAX CALLS
    public function get_number_of_orders($phase)
    {
        echo $this->order_model->get_number_of_orders($phase);
    }

   
}

/* End of file Offer.php */