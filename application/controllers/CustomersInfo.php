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
        $this->load->model("customer_model");
            
        $page_data['page_name'] = 'customers_info/index';
        $page_data['page_title'] = site_phrase("customers_information", true);
        $page_data['customers'] = $this->customer_model->get_approved_customers();
        
        // print_r($page_data['customers']);
        // die();
        $this->load->view('backend/index', $page_data);
    }

}
