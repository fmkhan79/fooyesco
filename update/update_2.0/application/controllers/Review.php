<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 22 - August - 2020
 * Author : TheDevs
 * Review Controller controlls the task for review and ratings
 */

include 'Authorization.php';
class Review extends Authorization
{
    // index function responsible for showing the index page.
    function index()
    {
        authorization(['customer', 'owner'], true);
        $page_data['page_name']  = 'review/index';
        $page_data['page_title'] = get_phrase("your_reviews", true);
        $page_data['reviews'] = $this->review_model->get_by_customer_id($this->session->userdata('user_id'));
        $this->session->set_flashdata('review_tab', true);
        $this->load->view('backend/index', $page_data);
    }
    //Update one item
    public function update()
    {
        authorization(['customer'], true);
        $response = $this->review_model->update();
        $this->session->set_flashdata('review_tab', true);
        if (!$response) {
            error(get_phrase('some_error_occurred'), site_url('orders'));
        }
        success(get_phrase('thanks_for_your_review'), site_url('orders/details/' . $response['order_code']));
    }
}

/* End of file Orders.php */