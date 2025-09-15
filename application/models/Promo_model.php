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
    // public function get_promo_data($restaurant_id = 'all'){
    //     if ($restaurant_id !== 'all') {
    //         $this->db->where('restaurant_id', $restaurant_id);
    //     }

    //     $this->db->order_by('id', 'desc');
    //     $query = $this->db->get('promo_codes');
    //     return $query->result();
    // }

    public function get_promo_data($restaurant_id = 'all'){
        if ($restaurant_id !== 'all') {
            $this->db->where('restaurant_id', $restaurant_id);
        }
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('promo_codes');
        return $query->result();
    }

    public function get_promo_data_for_multiple($restaurant_ids = []){
        if (!empty($restaurant_ids)) {
            $this->db->where_in('restaurant_id', $restaurant_ids);
        }
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('promo_codes');
        return $query->result();
    }


    // public function get_valid_promo($code)
    // {

    //     return $this->db
    //         ->where('offer_code', $code)
    //         ->where('is_used', 0)
    //         ->get('promo_codes')
    //         ->row_array(); // returns full row or null
    // }
    public function get_valid_promo($code, $restaurant_id)
    {
        // Get current day in lowercase, e.g. 'monday', 'tuesday', etc.
        $today = strtolower(date('l'));

        return $this->db
            ->where('offer_code', $code)
            ->where('restaurant_id', $restaurant_id)
            ->where('is_used', 0)
            ->where($today, 1) // column for today's day must be 1 (true)
            ->get('promo_codes')
            ->row_array();
    }

    public function generate_unique_promo_code($length = 4)
    {
        $prefix = "FY";
        do {
            $code = $prefix . strtoupper(bin2hex(random_bytes($length / 2)));
            $exists = $this->db->where('offer_code', $code)->get('promo_codes')->num_rows() > 0;
        } while ($exists);

        return $code;
    }

    public function update_promo_status($offer_code)
    {
        $promo = $this->db->get_where('promo_codes', ['offer_code' => $offer_code])->row();
        
        if((int)$promo->is_special === 1){
            $user_promo = $this->session->userdata('applied_promo');
            $this->session->set_userdata('user_promo', $user_promo);
            $this->session->set_userdata('applied_promo', '');
            $this->session->unset_userdata('is_online_discount_checked');
            $this->session->set_userdata('is_online_discount_checked', false);
            return;
        }

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
            $this->session->unset_userdata('is_online_discount_checked');
            $this->session->set_userdata('is_online_discount_checked', false);



            log_message('debug', 'Promo updated successfully');
        } else {
            log_message('error', 'Promo not found for offer_code: ' . $offer_code);
        }
    }

    public function get_valid_days($id)
    {
        $row = $this->db->where('id', $id)->get('promo_codes')->row();

        if (!$row) {
            return []; 
        }

        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

        $valid_days = [];

        foreach ($days as $day) {
            if (!empty($row->$day) && $row->$day == 1) {
                $valid_days[] = ucfirst($day);
            }
        }
        return $valid_days;
    }

}
