<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 09 - July - 2020
 * Author : TheDevs
 * Customer Controller controlls the The Customers
 */

include 'Authorization.php';

class Customer extends Authorization
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
    function index()
    {
        $page_data['status'] = isset($_GET['status']) ? sanitize($_GET['status']) : "approved";
        $page_data['page_name'] = 'customer/index';
        $page_data['page_title'] = get_phrase("customers");

        /**PAGINATION STARTS**/
        $customers = ($page_data['status'] == 'approved') ? $this->customer_model->get_approved_customers() : $this->customer_model->get_pending_customers();
        $total_rows = count($customers);
        $page_size = 12;
        $config = pagintaion($total_rows, $page_size, site_url('customer'));
        $current_page = sanitize($this->input->get('page', 0));
        $this->pagination->initialize($config);
        $conditions = array(
            'role_id' => [2, 3],
            'status'  => ($page_data['status'] == 'approved') ? 1 : 0
        );
        $page_data['customers'] = $this->customer_model->merger($this->customer_model->paginate($page_size, $current_page, $conditions, "id", "asc"));
        /**PAGINATION ENDS**/

        $this->load->view('backend/index', $page_data);
    }

    // create function is responsible for showing customer adding view
    function create()
    {
        authorization(['admin'], true);
        $page_data['page_name'] = 'customer/create';
        $page_data['page_title'] = get_phrase("add_new_customer");
        $this->load->view('backend/index', $page_data);
    }

    // store function is responsible for storing customer's data
    function store()
    {
        authorization(['admin'], true);
        $response = $this->customer_model->store_customer();
        if ($response) {
            success(get_phrase('customer_added_successfully'), site_url('customer'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('customer'));
        }
    }

    // profile function is responsible for showing the profile page of a customer
    function profile($id, $active_tab = "activity")
    {
        $page_data['page_name'] = 'customer/profile';
        $page_data['tab'] = $active_tab;
        $page_data['page_title'] = get_phrase("customer_profile");
        $page_data['customer'] = $this->customer_model->get_by_id($id);
        $this->load->view('backend/index', $page_data);
    }

    // Update function is responsible for updating the profile data of a customer
    function update()
    {
        authorization(['admin'], true);
        $response = $this->customer_model->update_customer();
        if ($response) {
            success(get_phrase('customer_updated_successfully'), site_url('customer'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('customer'));
        }
    }

    // Delete function is responsible for deleting the profile data of a customer
    function delete($id)
    {
        authorization(['admin'], true);
        $response = $this->customer_model->delete_customer($id);
        if ($response) {
            success(get_phrase('customer_delete_successfully'), site_url('customer'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('customer'));
        }
    }

    // UPDATE CUSTOMER STATUS
    function update_status($id)
    {
        authorization(['admin'], true);
        $response = $this->customer_model->update_customer_status($id);
        if ($response) {
            success(get_phrase('customer_updated_successfully'), site_url('customer/profile/' . $id));
        } else {
            error(get_phrase('an_error_occurred'), site_url('customer'));
        }
    }
}

/* End of file Customer.php */
