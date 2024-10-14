<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 21 - November - 2020
 * Author : TheDevs
 * Checkout Controller controlls the task for checking out
 */

include 'Base.php';
class Checkout extends Base
{

    function  __construct()
    {
        parent::__construct();
        authorization(['customer', 'owner'], true);
    }

    // index function responsible for showing the CHECKOUT PAGE
    function index()
    {
        // CHECK IF THE DELIVERY ADDRESS IS EMPTY OR NOT
        $address_id = sanitize($this->input->get('address_number'));
        $this->check_address_validity($address_id);

        $page_data['page_name']  = 'checkout/index';
        $page_data['page_title'] = site_phrase("checkout", true);
        $this->load->view(frontend('index'), $page_data);
    }

    // AFTER CONFIRMING THE ORDER AS CASH ON DELIVERY IT WILL BE CALLED
    public function cash_on_delivery()
    {
        // CHECK IF THE DELIVERY ADDRESS IS EMPTY OR NOT
        $address_id = sanitize($this->input->post('address_number'));
        $this->check_address_validity($address_id);

        $response = $this->checkout_model->cash_on_delivery();
        if ($response) {
            $this->session->set_flashdata('confirm_order', true);
            success(site_phrase('order_submitted_successfully'), site_url('cart'));
        } else {
            error(site_phrase('an_error_occurred'), site_url('cart'));
        }
    }

    // PAY WITH PAYPAL FUNCTION
    public function pay_with_paypal()
    {
        $restaurant_ids = $this->cart_model->get_restaurant_ids();

        // CHECK IF THE DELIVERY ADDRESS IS EMPTY OR NOT
        $address_id = sanitize($this->input->post('address_number'));
        $this->check_address_validity($address_id);

        if ($restaurant_ids && count($restaurant_ids) > 0) {
            if ($this->cart_model->get_grand_total() > 0) {
                $page_data['user_details'] = $this->user_model->get_user_by_id($this->session->userdata('user_id'));
                $page_data['amount_to_pay'] = $this->cart_model->get_grand_total();
                $page_data['address_number'] = $address_id;
                $page_data['page_name']  = 'checkout/paypal/paypal';
                $page_data['page_title']  = site_phrase("pay_with_paypal", true);
                $this->load->view(frontend('checkout/paypal/paypal'), $page_data);
            } else {
                error(site_phrase("not_enough_amount_to_checkout"), site_url('cart'));
            }
        } else {
            error(site_phrase("you_do_not_have_anything_to_checkout"), site_url('cart'));
        }
    }

    // AFTER PAYING VIA PAYPAL, REDIRECT TO THIS FUNCTION
    public function paypal_payment($amount_paid, $address_id, $paymentID, $paymentToken, $payerID)
    {
        // CHECK IF THE DELIVERY ADDRESS IS EMPTY OR NOT
        $this->check_address_validity($address_id);

        $response = $this->checkout_model->paypal_payment($paymentID);
        if ($response) {
            $confirmation_response = $this->checkout_model->paid_with_paypal($amount_paid, $address_id, $paymentID, $paymentToken, $payerID);
            if ($confirmation_response) {
                $this->session->set_flashdata('confirm_order', true);
                success(site_phrase('order_submitted_successfully'), site_url('cart'));
            } else {
                error(site_phrase('an_error_occurred'), site_url('cart'));
            }
        } else {
            error(site_phrase('an_error_occurred'), site_url('cart'));
        }
    }

    // PAY WITH STRIPE FUNCTION
    public function pay_with_stripe($address_id)
    {
        // CHECK IF THE DELIVERY ADDRESS IS EMPTY OR NOT
        $this->check_address_validity($address_id);

        //checking price
        $page_data['user_details']  = $this->user_model->get_user_by_id($this->session->userdata('user_id'));
        $page_data['amount_to_pay'] = $this->cart_model->get_grand_total();
        $page_data['address_id'] = $address_id;
        $this->load->view(frontend('checkout/stripe/stripe_checkout'), $page_data);
    }

    // AFTER PAYING VIA STRIPE, REDIRECT TO THIS FUNCTION
    public function stripe_payment($address_id, $session_id)
    {
        // CHECK IF THE DELIVERY ADDRESS IS EMPTY OR NOT
        $this->check_address_validity($address_id);

        //THIS IS HOW I CHECKED THE STRIPE PAYMENT STATUS
        $response = $this->checkout_model->stripe_payment($session_id);
        if ($response['payment_status'] === 'succeeded') {
            $confirmation_response = $this->checkout_model->paid_with_stripe($address_id, $response);
            if ($confirmation_response) {
                $this->session->set_flashdata('confirm_order', true);
                success(site_phrase('order_submitted_successfully'), site_url('cart'));
            } else {
                error(site_phrase('an_error_occurred'), site_url('cart'));
            }
        } else {
            error($response['status_msg'], site_url('cart'));
        }
    }

    // CHECK THE ADDRESS ID
    public function check_address_validity($address_id = "")
    {
        if (empty($address_id)) {
            error(site_phrase("delivery_address_not_found"), site_url('cart'));
        }
        $customer_details = $this->customer_model->get_by_id($this->session->userdata('user_id'));

        if (empty($customer_details["address_" . $address_id])) {
            error(site_phrase("delivery_address_not_found"), site_url('cart'));
        }
    }
}
