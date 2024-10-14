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
        authorization(['admin', 'owner', 'customer', 'driver'], true);
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
        authorization(['admin', 'driver'], true);
        $this->order_model->process($order_code, $phase);
    }

    // ASSIGN A DRIVER TO AN ORDER
    public function assign_driver()
    {
        authorization(['admin'], true);
        $this->order_model->assign_driver();
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
        authorization(['admin', 'customer'], true);
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

    public function update_order() {
        $orders = $this->db->get('orders')->result_array();
        foreach ($orders as $order) {
            $updater['order_code'] = $order['code'];
            $updater['amount_to_pay'] = $order['grand_total'];
            $updater['payment_method'] = 'cash_on_delivery';
            $updater['created_at'] = $order['order_placed_at'];
            $updater['data'] = json_encode([]);
            if($order['order_status'] == "delivered"){
                $updater['amount_paid'] = $order['grand_total'];
            }else{
                $updater['amount_paid'] = 0;
            }
            $this->db->insert('payment', $updater);
        }
    }
}

/* End of file Orders.php */