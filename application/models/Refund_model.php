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
        $this->db->order_by('refund_requests.requestedAt', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }


    public function get_order_details_for_request_refund($order_code)
    {
        $host = $_SERVER['HTTP_HOST'];

        $order = $this->db->get_where('orders', ['code' => $order_code])->row();

        $restaurant_id = $order->restaurant_id;
        $refund_amount = $order->commission_paid;

        $refundData = [
            'order_code'     => $order_code,
            'restaurant_id'  => $restaurant_id,
            'refund_amount'  => $refund_amount
        ];

        $restaurant = $this->db->get_where('restaurants', ['id' => $restaurant_id])->row();
        $restaurant_name = $restaurant ? $restaurant->name : 'Unknown';

        $inserted=$this->db->insert('refund_requests', $refundData);

        if ($inserted) {
            $mailData = [
                'order_code'      => $order_code,
                'refund_amount'   => $refund_amount,
                'restaurant_name' => $restaurant_name
            ];
            $subject = 'New refund request for ' . $order_code . ' from ' . $restaurant_name;


            if ($host === 'fooyes.co.uk') {
                $to = 'fooyesuk@gmail.com';
            }else{
                $to = 'website25developer@gmail.com';
            }
            $this->email_model->send_mail_using_php_mailer($mailData, $subject, $to, false, false, true);
        } else {
            log_message('error', 'Refund request insert failed for order: ' . $order_code);
        }
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

    // RESTAURANT-SCOPED LIST FOR THE DESKTOP APP API. get_all_refund_requests()
    // above returns every restaurant's requests — not safe to expose through a
    // single-restaurant token.
    public function api_get_by_restaurant($restaurant_id)
    {
        $this->db->where('restaurant_id', $restaurant_id);
        $this->db->order_by('requestedAt', 'DESC');
        return $this->db->get('refund_requests')->result_array();
    }

    // For the order detail popup: does a refund request already exist for
    // this order, and what's its status? Mirrors owner_report.php's
    // canRequestRefund/isRefundPending/isRefundAccepted/isRefundRejected.
    public function api_get_status_for_order($order_code)
    {
        $row = $this->db->get_where('refund_requests', ['order_code' => $order_code])->row_array();
        if (!$row) return null;

        return [
            'status' => (int) $row['status'], // 0 pending, 1 accepted, 2 rejected
            'requested_at' => $row['requestedAt'],
        ];
    }

    // OWNER-INITIATED REQUEST — restaurant-scoped wrapper around
    // get_order_details_for_request_refund() above. Verifies the order
    // belongs to the calling restaurant and is actually eligible (mirrors
    // owner_report.php's canRequestRefund: unpaid, no existing request)
    // before creating it.
    public function api_request_refund($order_code, $restaurant_id)
    {
        $order = $this->db->get_where('orders', ['code' => $order_code, 'restaurant_id' => $restaurant_id])->row_array();
        if (!$order) {
            return ['ok' => false, 'message' => 'Order not found.'];
        }
        if ((string) $order['is_status'] !== '0') {
            return ['ok' => false, 'message' => 'Only unpaid orders are eligible for a refund request.'];
        }

        $existing = $this->db->where('order_code', $order_code)->count_all_results('refund_requests');
        if ($existing > 0) {
            return ['ok' => false, 'message' => 'A refund request already exists for this order.'];
        }

        $this->get_order_details_for_request_refund($order_code);

        $created = $this->db->where('order_code', $order_code)->count_all_results('refund_requests') > 0;
        return $created
            ? ['ok' => true]
            : ['ok' => false, 'message' => 'Could not create refund request.'];
    }
}
