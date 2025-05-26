<?php
defined('BASEPATH') or exit('No direct script access allowed');


include 'Authorization.php';

class User extends Authorization
{
        public function __construct()
    {
        parent::__construct();
        authorization(['admin'], true);
    }

    function index(){
        $this->load->model('user_model');

     $page_data['page_name']   = 'users/index';
    //  print_r($page_data);
    $page_data['users'] = $this->user_model->get_admin_customer_owner_users();

     $page_data['page_title']  = get_phrase("users");
        $this->load->view('backend/index',  $page_data);



    }



}