<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - July - 2020
 * Author : TheDevs
 * Cart Controller controlls the task for a Cart
 */

include 'Base.php';
class Cart extends Base
{

    function check_customer_login()
    {
        if (!$this->session->userdata('customer_login') && !$this->session->userdata('owner_login')) {
            return false;
        }
        return true;
    }
    // index function responsible for showing the index page.
    function index()
    {
        $page_data['page_name']  = 'cart/index';
        $page_data['page_title'] = get_phrase("your_cart", true);
        $this->load->view(frontend('index'), $page_data);
    }

    // add_to_cart method add items to the cart
    function add_to_cart()
    {
        if (!$this->check_customer_login()) {
            echo "false";
            return false;
        }
        $this->cart_model->add_to_cart();
        echo sanitize($this->cart_model->total_cart_items());
        return true;
    }

    // Update method is responsible for Updating the restaurant types
    function update_cart()
    {
        if (!$this->check_customer_login()) {
            echo "false";
            return false;
        }
        $this->cart_model->update_cart();
        echo sanitize($this->cart_model->total_cart_items());
        return true;
    }

    // Delete method is responsible for storing data
    function delete($id)
    {
        $response = $this->cart_model->delete($id);
        if ($response) {
            success(get_phrase('item_deleted_successfully'), site_url('cart'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('cart'));
        }
    }
}
