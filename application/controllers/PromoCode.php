<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - July - 2020
 * Author : TheDevs
 * Cart Controller controlls the task for a Cart
 */

include 'Base.php';
class PromoCode extends Base
{
    public function index()
    {

        $page_data['page_title'] = site_phrase("promo_code", true);
        $page_data['page_name'] = 'promo_code/index';
        $this->load->model('Promo_model');
        $page_data['promo_codes'] = $this->Promo_model->get_promo_data();
        // print_r($page_data['promo_codes']);
        // die();
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