<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 22 - August - 2020
 * Author : TheDevs
 * Orders Controller controlls the task for orders
 */

include 'Authorization.php';
class Orders extends Authorization
{
    /**
     * CONSTRUCTOR CHECKS IF REQUIRED USER IS LOGGED IN
     */
    public function __construct()
    {
        parent::__construct();
        authorization(['admin', 'owner', 'customer', 'driver', 'cook'], true);
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

        $page_data['page_name'] = 'orders/index';
        $page_data['order_type'] = 'all';
        $page_data['page_title'] = get_phrase("all_orders");
        $page_data['orders'] = $this->order_model->filter();
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

        $page_data['page_name'] = 'orders/index';
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

    // ASSIGN A DRIVER TO AN ORDER
    public function assign_driver()
    {
        authorization(['admin'], true);
        $this->order_model->assign_driver();
    }

    public function check_new_order()
    {
        // print_r("test");
        // $this->load->model('order_model');
        $user_id = $this->session->userdata("user_id");
        
        $this->db->from('restaurants');
        $this->db->where('owner_id' , $user_id);

        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            $restaurant_id = $row['id']; 
        }

        $this->db->from('orders');
        // print_r($restaurant_id);
        $this->db->where('restaurant_id', $restaurant_id);
        $this->db->where('read_status', 0);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $_query = $this->db->get();

        if ($_query->num_rows() > 0)
        {
            $check = $_query->row_array();
            echo json_encode($check);
        }
        // die();
        // get user_id 
        // check table of restuarant where owner_id = user_id 
        // get restuarnat id. 
        
        // Sample 6

        // Check tbl order_detail
        // where resturant_id = sample (6)
        
        

    }

    public function mark_order_as_read()
    {
        $order_id = $this->input->post('order_id');

        if ($order_id) {
            $this->db->set('read_status', 1); // Assuming 'read_status' is the field name in the 'orders' table
            $this->db->where('id', $order_id);
            $this->db->update('orders');
    
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid order ID']);
        }
    }
    
    // WRITE A NOTE
    public function add_note()
    {
        authorization(['driver'], true);
        $response = $this->order_model->add_note();
        if ($response) {
            success(get_phrase('note_added_successfully'), site_url('orders/today'));
        } else {
            error(get_phrase('invalid_order_code'), site_url('orders/today'));
        }
    }

    // CANCEL AN ORDER. BEFORE CANCELING AN ORDER MAKE SURE TO CHECK THE CUSTOMER ID AND THE ORDER STATUS
    public function cancel($order_code)
    {
        authorization(['admin', 'driver', 'cook', 'owner'], true);
        $is_valid = $this->order_model->is_valid($order_code);
        if (!$is_valid) {
            error(get_phrase('nothing_found'), site_url('orders'));
        }

        $response = $this->order_model->cancel($order_code);
        if ($response) {
            success(get_phrase('order_canceled_successfully'), site_url('orders/details/' . $order_code));
        } else {
            error(get_phrase('the_order_can_not_be_canceled'), site_url('orders/details/' . $order_code));
        }
    }

    // LIVE ORDERS FOR TODAY
    public function live($response = false)
    {
        
        $page_data['page_name'] = 'orders/index';
        $page_data['order_type'] = 'live';
        $page_data['page_title'] = get_phrase("live_orders");
        $page_data['orders'] = $this->order_model->get_live_orders();
        if ($response == 'data') {
            echo json_encode($page_data['orders']);
        } elseif ($response == 'view') {
            $this->load->view('backend/' . $this->logged_in_user_role . '/orders/live-data', $page_data);
        } else {
            $this->load->view('backend/index', $page_data);
        }
    }
  

    // SENDING ORDER PLACING MAILS FROM THIS FUNCTION
    public function order_placing_mail($order_code)
    {
        // print_r($order_code);
        // print_r("easd");
        $this->order_model->order_placing_mail($order_code);
        // $this->session->sess_destroy();
    }


    public function print_recipt($order_code)
    {
        // Fetch order details based on the order code
        $order_details = $this->order_model->get_by_code($order_code);
        $payment       = $this->order_model->get_order_payment($order_code);
        
        if (!$order_details) {
            show_404(); // If no order found, show 404 page
        }
    
        // Load necessary models
        $ordered_items = $this->order_model->details($order_code);
    
        // Prepare data for the view
        $data['order_details'] = $order_details;
        $data['ordered_items'] = $ordered_items;
        $data['payment']       = $payment;
        // Load the view for printing
        $this->load->view('backend/owner/orders/print_receipt', $data);
    }



    public function delete_session() {
    // echo "das";
        print_r($this->session('user_data'));
    }
    // GET NUMBER OF ORDERS SPECIALLY FOR AJAX CALLS
    public function get_number_of_orders($phase)
    {
        echo $this->order_model->get_number_of_orders($phase);
    }

    public function get_number_of_todays_pending_orders()
    {
        echo $this->order_model->get_number_of_todays_pending_orders();
    }

    public function delete_cookies_and_session() {
        // Delete specific cookies
        
        delete_cookie('__stripe_mid');
        delete_cookie('__stripe_sid');
        delete_cookie('ci_session');

        // Destroy the session
        $session->destroy();
      

        // Optionally return a response
        echo json_encode(['status' => 'success']);
    }

}

/* End of file Orders.php */