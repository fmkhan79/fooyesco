<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 09 - June - 2020
 * Author : TheDevs
 * cuisine Controller controlls the Restaurant types
 */

include 'Authorization.php';

class RefundRequest extends Authorization
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
        $this->load->model("refund_model");
            
        $page_data['page_name'] = 'refund_request/index';
        $page_data['page_title'] = site_phrase("refund_requests", true);
        $page_data['refund_requests'] = $this->refund_model->get_all_refund_requests();
        
        // print_r($page_data['refund_requests']);
        // die();
        $this->load->view('backend/index', $page_data);
    }

    public function accept_refund_request($order_code)
    {
        $this->load->model("refund_model");

        $result = $this->refund_model->accepted_refund_request_by_order_code($order_code);
        
        if(!$result)
        {
            $this->session->set_flashdata('error', get_phrase('something_went_wrong!'));
            redirect(site_url('refundrequest')); 
        }

        $this->session->set_flashdata('success', get_phrase('refund_request_accepted_successfully!'));
        redirect(site_url('refundrequest'));
    }
    
    public function reject_refund_request($order_code)
    {
        $this->load->model("refund_model");

        $result = $this->refund_model->rejected_refund_request_by_order_code($order_code);
        
        if(!$result)
        {
            $this->session->set_flashdata('error', get_phrase('something_went_wrong!'));
            redirect(site_url('refundrequest')); 
        }

        $this->session->set_flashdata('success', get_phrase('refund_request_rejected_successfully!'));
        redirect(site_url('refundrequest'));
    }

     
    public function request_refund($order_code)
    {
        $this->load->model('refund_model');

        $this->refund_model->get_order_details_for_request_refund($order_code);

        redirect(site_url('report/index'));
    }


}
