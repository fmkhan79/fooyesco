<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - July - 2020
 * Author : TheDevs
 * Cart model handles all the database queries of Cart
 */

class Promo_model extends Base_model
{
    public function get_valid_promo($code)
    {

        return $this->db
            ->where('offer_code', $code)
            ->where('is_used', 0)
            ->get('promo_codes')
            ->row_array(); // returns full row or null
    }

    public function generate_unique_promo_code($length = 8)
    {
        do {
            $code = strtoupper(bin2hex(random_bytes($length / 2))); // e.g. FG52Y96X
            $exists = $this->db->where('offer_code', $code)->get('promo_codes')->num_rows() > 0;
        } while ($exists);

        return $code;
    }

    public function update_promo_status($offer_code)
    {
        $promo = $this->db->get_where('promo_codes', ['offer_code' => $offer_code])->row();
        $user_id = $this->session->userdata('user_id');

        log_message('debug', 'Updating promo: ' . $offer_code . ' for user: ' . $user_id);

        if ($promo) {
            $this->db->where('offer_code', $offer_code);
            $this->db->update('promo_codes', [
                'is_used' => 1,
                'user_id' => $user_id
            ]);

            $user_promo = $this->session->userdata('applied_promo');
            $this->session->set_userdata('user_promo', $user_promo);
            $this->session->set_userdata('applied_promo', '');


            log_message('debug', 'Promo updated successfully');
        } else {
            log_message('error', 'Promo not found for offer_code: ' . $offer_code);
        }
    }
}
