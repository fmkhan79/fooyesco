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
    public function check_promo() {
        $promo_code = $this->input->post('promo_code');

            $this->load->model('Promo_model');

            $promo = $this->Promo_model->get_valid_promo($promo_code);
            
        if ($promo) {
            $this->session->set_userdata('applied_promo', $promo);
            echo json_encode([
                'success' => true,
                'data' => $promo
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid or already used promo code.'
            ]);
        }
    }

    public function remove_promo()
    {
        $this->session->unset_userdata('applied_promo');

        echo json_encode([
            'success' => true,
            'message' => 'Promo code removed successfully.'
        ]);
    }


}