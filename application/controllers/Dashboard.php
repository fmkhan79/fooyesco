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
    
    
    public function check_new_order()
    {
        // print_r("test");
        // $this->load->model('order_model');
        $user_id = $this->session->userdata("user_id");
        
        $this->db->from('restaurants');
        $this->db->where('owner_id' , $user_id);

        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            $restaurant_id = $row['id']; 
        }

        $this->db->from('orders');
        // print_r($restaurant_id);
        $this->db->where('restaurant_id', $restaurant_id);
        $this->db->where('read_status', 0);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $_query = $this->db->get();

        if ($_query->num_rows() > 0)
        {
            $check = $_query->row_array();
            echo json_encode($check);
        }
        // die();
        // get user_id 
        // check table of restuarant where owner_id = user_id 
        // get restuarnat id. 
        
        // Sample 6

        // Check tbl order_detail
        // where resturant_id = sample (6)
        
        

    }

    public function mark_order_as_read()
    {
        $order_id = $this->input->post('order_id');

        if ($order_id) {
            $this->db->set('read_status', 1); // Assuming 'read_status' is the field name in the 'orders' table
            $this->db->where('id', $order_id);
            $this->db->update('orders');
    
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid order ID']);
        }
    }
    

        function index()
        {
            
            if ($this->logged_in_user_role == "customer" || $this->logged_in_user_role == "driver" || $this->logged_in_user_role == "cook" || $this->logged_in_user_role == "owner" || $this->logged_in_user_role =="admin" || $this->logged_in_user_role == "restaurants") {

                $page_data['page_name'] = 'dashboard/index';
                $page_data['page_title'] = ucfirst($this->session->userdata('user_role')) . " " . get_phrase("dashboard");
                $this->load->view('backend/index', $page_data);
            }else
            {
                
                redirect('auth');
        
            }
        }
    }
