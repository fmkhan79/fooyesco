<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - July - 2020
 * Author : TheDevs
 * Cart Controller controlls the task for a Cart
 */

// include 'Authorization.php';
// class PromoCode extends Authorization
// {
//     public function __construct()
//     {
//         parent::__construct();
//         authorization(['admin', 'owner'], true);
//     }

include 'Base.php';
class PromoCode extends Base
{
    public function __construct()
    {
        parent::__construct();
        // authorization(['admin', 'owner'], true);
    }

    // public function index()
    // {

    //     $restaurant_id = $this->input->get('restaurant_id');
    //     $restaurant_id = sanitize($restaurant_id ?? 'all');

    //     $page_data['restaurant_id'] = $restaurant_id;
    //     $page_data['restaurants'] = $this->restaurant_model->get_all_approved();

    //     $page_data['page_title'] = site_phrase("promo_code", true);
    //     $page_data['page_name'] = 'promo_code/index';
    //     $this->load->model('Promo_model');
    //     $page_data['promo_codes'] = $this->Promo_model->get_promo_data($restaurant_id ?? $page_data['restaurants']);
    //     // print_r($page_data['promo_codes']);
    //     // die();
    //     $this->load->view('backend/index', $page_data);
    // }

    public function index()
{
    $restaurant_id = $this->input->get('restaurant_id');
    $restaurant_id = sanitize($restaurant_id ?? 'all');

    $this->load->model('Promo_model');
    $this->load->model('Order_model');
    $this->load->model('restaurant_model');

    // Fetch restaurants
    $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
    $page_data['restaurant_id'] = $restaurant_id;
    $page_data['page_title'] = site_phrase("promo_code", true);
    $page_data['page_name'] = 'promo_code/index';

    // Get promo codes
    if ($restaurant_id === 'all') {
        // Get all promos for this owner’s restaurants
        $restaurant_ids = array_column($page_data['restaurants'], 'id');
        $promo_codes = $this->Promo_model->get_promo_data_for_multiple($restaurant_ids);
    } else {
        $promo_codes = $this->Promo_model->get_promo_data($restaurant_id);
    }

    // Attach related orders to each promo
    foreach ($promo_codes as &$promo) {
        $promo->orders = $this->Order_model->get_orders_by_promo_code($promo->offer_code);
    }

    $page_data['promo_codes'] = $promo_codes;

    $this->load->view('backend/index', $page_data);
}



    // public function check_promo() {
    //     $promo_code = $this->input->post('promo_code');

    //         $this->load->model('Promo_model');

    //         $promo = $this->Promo_model->get_valid_promo($promo_code);
            
    //     if ($promo) {
    //         $this->session->set_userdata('applied_promo', $promo);
    //         echo json_encode([
    //             'success' => true,
    //             'data' => $promo
    //         ]);
    //     } else {
    //         echo json_encode([
    //             'success' => false,
    //             'message' => 'Invalid or already used promo code.'
    //         ]);
    //     }
    // }

    public function check_promo() {
        $promo_code = $this->input->post('promo_code');
        $restaurant_id = $this->input->post('restaurant_id');
        $this->load->model('Promo_model');

        $promo = $this->Promo_model->get_valid_promo($promo_code, $restaurant_id);

        if ($promo) {
            $this->session->set_userdata('applied_promo', $promo);
            echo json_encode([
                'success' => true,
                'data' => $promo
            ]);
        } else {
            $todayName = date('l'); // For message: 'Wednesday', etc.
            echo json_encode([
                'success' => false,
                'message' => "Invalid, already used, or not valid on {$todayName}."
            ]);
        }
    }


    public function remove_promo()
    {
        $this->session->unset_userdata('applied_promo');
        $this->session->set_userdata('is_online_discount_checked', false);

        echo json_encode([
            'success' => true,
            'message' => 'Promo code removed successfully.'
        ]);
    }


}