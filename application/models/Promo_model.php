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
}