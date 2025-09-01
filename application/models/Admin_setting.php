<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - July - 2020
 * Author : TheDevs
 * Cart model handles all the database queries of Cart
 */

class Admin_setting extends Base_model
{
    public function get_twilio_credentials(){
        return $this->db
            ->order_by('id', 'DESC') 
            ->limit(1)
            ->get('admin_settings')
            ->row();
    }
}
