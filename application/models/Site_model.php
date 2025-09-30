<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 07 - July - 2020
 * Author : TheDevs
 * Settings model handles all the database queries of settings related data
 */

class Site_model extends Base_model
{
    public function check_host(){
        $host = get_subdomain();
        
        if($host === 'fooyes' || $host === 'staging')
            return true;

        return false;
    }
}