<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Refund_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "refund_requests";
    }

    public function get_all_refund_requests()
    {
        $this->db->select('refund_requests.*, restaurants.name as restaurant_name');
        $this->db->from('refund_requests');
        $this->db->join('restaurants', 'refund_requests.restaurant_id = restaurants.id', 'left');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }


    public function get_order_details_for_request_refund($order_code)
    {
        $order = $this->db->get_where('orders', ['code' => $order_code])->row();
        
        $restaurant_id = $order->restaurant_id;
        $refund_amount = $order->commission_paid;

        $refundData = [
            'order_code'     => $order_code,
            'restaurant_id'  => $restaurant_id,
            'refund_amount'  => $refund_amount
        ];

        $this->db->insert('refund_requests', $refundData);
    }

    public function get_refund_requests_data_by_order_code($order_code)
    {
        $refund_request_data = $this->db->get_where('refund_requests', array('order_code' => $order_code))->row_array();
        return $refund_request_data;
    }

    public function accepted_refund_request_by_order_code($order_code)
    {
        $request = $this->db->get_where('refund_requests', ['order_code' => $order_code])->row();

        if ($request) {
            $this->load->model('order_model');
            $this->order_model->mark_as_refund($order_code);
            
            $this->db->where('order_code', $request->order_code);
            $this->db->update('refund_requests', [
                'status' => 1,
                'acceptedAt' => date('Y-m-d H:i:s')
            ]);

            return true;
        }

        return false;
    }
    
    public function rejected_refund_request_by_order_code($order_code)
    {
        $request = $this->db->get_where('refund_requests', ['order_code' => $order_code])->row();

        if ($request) {
            $this->db->where('order_code', $request->order_code);
            $this->db->update('refund_requests', [
                'status' => 2,
                'rejectedAt' => date('Y-m-d H:i:s')
            ]);
            return true;
        }

        return false;
    }

    public function get_all_pending_requests()
    {
        $this->db->where('status', 0);
        return $this->db->count_all_results('refund_requests');
    }


}
