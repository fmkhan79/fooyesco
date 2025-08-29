<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - July - 2020
 * Author : TheDevs
 * Cart model handles all the database queries of Cart
 */

class Adminsetting_model extends Base_model
{

    public function get_twilio_credentials(){
        return $this->db->get('admin_settings')->row();
    }
    
}