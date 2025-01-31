<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 09 - June - 2020
 * Author : TheDevs
 * Dashboard Controller controlls the dashoard
 */

include 'Authorization.php';

class Dashboard extends Authorization
{
    function index()
    {
        // CHECK IF THE LOGGED IN USER ROLE IS DRIVER, REDIRECT HIM TO TODAY
        if ($this->logged_in_user_role == "driver" || $this->logged_in_user_role == "cook" || $this->logged_in_user_role == "owner" || $this->logged_in_user_role =="admin" || $this->logged_in_user_role == "restaurants") {

            $page_data['page_name'] = 'dashboard/index';
            $page_data['page_title'] = ucfirst($this->session->userdata('user_role')) . " " . get_phrase("dashboard");
            $this->load->view('backend/index', $page_data);
        }else
        {
            
		$this->load->view('auth/login');
     
         }

  
    }
}
