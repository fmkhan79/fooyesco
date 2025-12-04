<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 21 - August - 2020
 * Author : TheDevs
 * Order model handles all the database queries of Cart
 */

class Order_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "orders";
    }


    public function saveSettings($key, $value)
    {
        // Check if the key already exists in the table
        $existingKey = $this->db->get_where('system_settings', array('key' => $key))->row();

        if ($existingKey) {
            // If key exists, update the corresponding value
            $this->db->where('key', $key);
            $this->db->update('system_settings', array('value' => $value));
        } else {
            // If key does not exist, insert a new row
            $this->db->insert('system_settings', array('key' => $key, 'value' => $value));
        }
    }
    public function getSetting($key)
    {
        // Retrieve the value for the specified key
        $result = $this->db->get_where('system_settings', array('key' => $key))->row();

        // Check if the key exists in the database
        if ($result) {
            return $result->value;
        } else {
            return ''; // Return an empty string or handle it as needed
        }
    }
    /**
     * GET ALL THE ORDERS
     */
    public function get_all()
    {
        $this->db->order_by("id", "desc");
        $obj = $this->db->get($this->table);
        return $this->order_merger($obj);
    }

    /**
     * GET ORDER BY ID
     */
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $obj = $this->db->get($this->table);
        return $this->order_merger($obj, true);
    }

    /**
     * GETTING OREDERS BY CODE
     */
    public function get_by_code($code)
    {
        $this->db->where('code', $code);
        $obj = $this->db->get($this->table);
        return $this->order_merger($obj, true);
    }

    public function get_order_payment($code)
    {
        $this->db->where('order_code', $code);
        $obj = $this->db->get("payment");
        return $this->order_merger($obj, true);
    }

    /**
     * GET ORDER CODE BY RESTAURANT ID OR RESTAURANT ID ARRAY
     * GET ORDERS CODE BY RESTAURANT ID ONLY. YOU CAN PROVIDE RESTAURANT ID AS ARRAY [1,3,4,5].
     * IT WILL RETURN A SIMPLE ARRAY. IT IS NOT AN ASSOCIATIVE ARRAY
     * @param [type] $restaurant_id
     * @return array
     */
    public function get_order_code_by_restaurant_id($restaurant_id)
    {
        $order_codes = [];
        $this->db->select('order_code');
        if (is_array($restaurant_id)) {
            if (count($restaurant_id)) {
                $this->db->where_in('restaurant_id', $restaurant_id);
            } else {
                return array();
            }
        } else {
            $this->db->where('restaurant_id', $restaurant_id);
        }
        $query = $this->db->get('order_details')->result_array();
        foreach ($query as $key => $row) {
            if (!in_array($row['order_code'], $order_codes)) {
                array_push($order_codes, $row['order_code']);
            }
        }
        return $order_codes;
    }
    // GET DATA BY A CONDITION ARRAY
    // public function get_by_condition($conditions = [])
    // {
    //     /**
    //      * THIS LOOP CHECKS IF GIVEN CONDITION HAS ANY EMPTY ARRAY. IF IT DOES IT WILL RETURN EMPTY ARRAY.
    //      */
    //     foreach ($conditions as $key => $value) {
    //         if (is_array($value)) {
    //             if (count($value) == 0) {
    //                 return array();
    //             }
    //         }
    //     }

    //     // foreach ($conditions as $key => $value) {
    //     //     if (!is_null($value)) {
    //     //         if (is_array($value)) {
    //     //             $this->db->where_in($key, $value);
    //     //         } else {
    //     //             $this->db->where($key, $value);
    //     //         }
    //     //     }
    //     // }

    //     // foreach ($conditions as $key => $value) {
    //     //     if (!is_null($value)) {
    //     //         // Custom logic for order_status
    //     //         if ($key === 'order_status') {
    //     //             // assuming 'is_paid' column must be equal to value of order_status

    //     //             if($value === "paid"){
    //     //                 $this->db->where('is_paid', 1);
    //     //             }else{
    //     //                 $this->db->where('is_paid', 0);
    //     //             }

    //     //         } elseif (is_array($value)) {
    //     //             $this->db->where_in($key, $value);
    //     //         } else {
    //     //             $this->db->where($key, $value);
    //     //         }
    //     //     }
    //     // }

    //     $this->db->order_by("id", "desc");
    //     $obj = $this->db->get($this->table);

    //     return $this->order_merger($obj);

    // }

    public function get_by_condition($conditions = [])
    {
        /**
         * THIS LOOP CHECKS IF GIVEN CONDITION HAS ANY EMPTY ARRAY. IF IT DOES IT WILL RETURN EMPTY ARRAY.
         */
       
        foreach ($conditions as $key => $value) {
            // print_r($value);
            if (is_array($value) && count($value) == 0) {
                return array();
            }
        }
        
        

        // Check if 'order_status' is set and has a valid value
        if (isset($conditions['order_status']) && in_array($conditions['order_status'], ['paid', 'unpaid', 'refund'])) {
            foreach ($conditions as $key => $value) {
                if (!is_null($value)) {
                    if ($key === 'order_status') {
                        if ($value === 'unpaid') {
                            $this->db->where('orders.is_status', 0);
                        } elseif ($value === 'paid') {
                            $this->db->where('orders.is_status', 1);
                        } elseif ($value === 'refund') {
                            $this->db->where('orders.is_status', 2);
                        }
                    } elseif (is_array($value)) {
                        $this->db->where_in($key, $value);
                    } else {
                        $this->db->where($key, $value);
                    }
                }
            }
        } else {
           
            foreach ($conditions as $key => $value) {
                if (!is_null($value)) {     
                    if (is_array($value)) {
                        $this->db->where_in($key, $value);
                    } else {
                        $this->db->where($key, $value);
                    }
                }
            }
        }
        // print_r($value);
        // Main where orders are getting fetched. 

        $this->db->order_by("orders.id", "desc");

        $this->db->join('refund_requests', 'refund_requests.order_code = orders.code', 'left');
        $obj = $this->db->get($this->table);

        return $this->order_merger($obj);
    }


    public function newOrder($restaurant_id)
    {


        $thirtyMinutesAgo = date('Y-m-d H:i:s', strtotime('-30 minutes'));

        $this->db->where('restaurant_id', $restaurant_id);
        $this->db->where('created_at >=', $thirtyMinutesAgo); // Check if the order is within the last 30 minutes
        $query = $this->db->get('orders');
        return $query->result();
    }

    // GET TODAYS ORDERS. IT WILL BE DIFFERENT USER WISE
    public function get_todays_orders()
    {
        $dynamic_function_name = "get_todays_orders_as_" . $this->logged_in_user_role;
        return $this->$dynamic_function_name();
    }

    /**
     * THIS FUNCTION IS ONLY APPLICABLE FOR CUSTOMERS ORDERS. IT WILL BE CALLED INTERNALLY
     *
     * @return object
     */
    public function get_todays_orders_as_customer()
    {
        $todays_starting_time = strtotime(date('D, d-M-Y') . ' 00:00:01');
        $todays_ending_time = strtotime(date('D, d-M-Y') . ' 23:59:59');
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where('customer_id', $this->logged_in_user_id);
        $this->db->order_by("id", "desc");
        $obj = $this->db->get('orders');
        return $this->order_merger($obj);
    }

    /**
     * THIS FUNCTION IS ONLY APPLICABLE FOR DRIVERS ORDERS. IT WILL BE CALLED INTERNALLY
     *
     * @return object
     */
    public function get_todays_orders_as_driver()
    {
        $todays_starting_time = strtotime(date('D, d-M-Y') . ' 00:00:01');
        $todays_ending_time = strtotime(date('D, d-M-Y') . ' 23:59:59');

        // PENDING ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where('driver_id', $this->logged_in_user_id);
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'pending');
        $obj = $this->db->get('orders');
        $orders['pending'] = $this->order_merger($obj);

        // APPROVED ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where('driver_id', $this->logged_in_user_id);
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'approved');
        $obj = $this->db->get('orders');
        $orders['approved'] = $this->order_merger($obj);

        // PREPARING
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where('driver_id', $this->logged_in_user_id);
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'preparing');
        $obj = $this->db->get('orders');
        $orders['preparing'] = $this->order_merger($obj);

        // PREPARED ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where('driver_id', $this->logged_in_user_id);
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'prepared');
        $obj = $this->db->get('orders');
        $orders['prepared'] = $this->order_merger($obj);

        // DELIVERED ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where('driver_id', $this->logged_in_user_id);
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'delivered');
        $obj = $this->db->get('orders');
        $orders['delivered'] = $this->order_merger($obj);


        return $orders;
    }

    /**
     * THIS FUNCTION IS ONLY APPLICABLE FOR ADMIN. IT WILL BE CALLED INTERNALLY
     *
     * @return object
     */
    public function get_todays_orders_as_admin()
    {
        $todays_starting_time = strtotime(date('D, d-M-Y') . ' 00:00:01');
        $todays_ending_time = strtotime(date('D, d-M-Y') . ' 23:59:59');

        $conditions['order_placed_at >='] = $todays_starting_time;
        $conditions['order_placed_at <='] = $todays_ending_time;

        // CHECK RESTAURANT SELECTION
        $restaurant_id = nuller(sanitize($this->input->get('restaurant_id')));
        if ($restaurant_id) {
            $conditions['code'] = count($this->get_order_code_by_restaurant_id($restaurant_id)) > 0 ? $this->get_order_code_by_restaurant_id($restaurant_id) : array();
        }

        // CHECK CUSTOMER SELECTION
        $conditions['customer_id'] = nuller(sanitize($this->input->get('customer_id')));

        // CHECK DRIVER SELECTION
        $conditions['driver_id'] = nuller(sanitize($this->input->get('driver_id')));

        // CHECK STATUS SELECTION
        $conditions['order_status'] = nuller(sanitize($this->input->get('status')));

        return $this->get_by_condition($conditions);
    }

    /**
     * THIS FUNCTION IS ONLY APPLICABLE FOR RESTAURANT OWNER. IT WILL BE CALLED INTERNALLY
     *
     * @return object
     */
    public function get_todays_orders_as_owner()
    {
        // AT FIRST CHECK IF THE OWNER HAS ANY RESTAURANT
        $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
        if (count($restaurant_ids)) {
            // CHECK RESTAURANT SELECTION
            $restaurant_id = nuller(sanitize($this->input->get('restaurant_id')));
            if ($restaurant_id && in_array($restaurant_id, $restaurant_ids)) {
                $conditions['code'] = count($this->get_order_code_by_restaurant_id($restaurant_id)) > 0 ? $this->get_order_code_by_restaurant_id($restaurant_id) : array();
            } else {
                $order_codes = $this->get_order_code_by_restaurant_id($restaurant_ids);
                if (count($order_codes)) {
                    $conditions['code'] = $order_codes;
                } else {
                    $conditions['code'] = array();
                }
            }
        } else {
            return array();
        }

        $todays_starting_time = strtotime(date('D, d-M-Y') . ' 00:00:01');
        $todays_ending_time = strtotime(date('D, d-M-Y') . ' 23:59:59');

        $conditions['order_placed_at >='] = $todays_starting_time;
        $conditions['order_placed_at <='] = $todays_ending_time;


        // CHECK CUSTOMER SELECTION
        $conditions['customer_id']     = nuller(sanitize($this->input->get('customer_id')));

        // CHECK DRIVER SELECTION
        $conditions['driver_id']     = nuller(sanitize($this->input->get('driver_id')));

        // CHECK STATUS SELECTION
        $conditions['order_status']     = nuller(sanitize($this->input->get('status')));
        $conditions['order_type']     = nuller(sanitize($this->input->get('pos')));
        // print_r($condtion['order_pos']);
        return $this->get_by_condition($conditions);
    }

    /**
     * THIS FUNCTION IS ONLY APPLICABLE FOR COOK ORDERS. IT WILL BE CALLED INTERNALLY
     *
     * @return object
     */
    public function get_todays_orders_as_cook()
    {
        $todays_starting_time = strtotime(date('D, d-M-Y') . ' 00:00:01');
        $todays_ending_time = strtotime(date('D, d-M-Y') . ' 23:59:59');

        // AT FIRST CHECK IF THE OWNER HAS ANY RESTAURANT
        $restaurant_ids = $this->cook_model->get_restaurant_ids_by_cook_id($this->logged_in_user_id);
        if (count($restaurant_ids)) {
            $order_codes = $this->get_order_code_by_restaurant_id($restaurant_ids);
            if (count($order_codes) == 0) {
                return array('pending' => array(), 'approved' => array(), 'preparing' => array(), 'prepared' => array(), 'delivered' => array());
            }
        } else {
            return array('pending' => array(), 'approved' => array(), 'preparing' => array(), 'prepared' => array(), 'delivered' => array());
        }

        // PENDING ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where_in('code', $order_codes);
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'pending');
        $obj = $this->db->get('orders');
        $orders['pending'] = $this->order_merger($obj);

        // APPROVED ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where_in('code', $order_codes);
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'approved');
        $obj = $this->db->get('orders');
        $orders['approved'] = $this->order_merger($obj);

        // PREPARING
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where_in('code', $order_codes);
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'preparing');
        $obj = $this->db->get('orders');
        $orders['preparing'] = $this->order_merger($obj);

        // PREPARED ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where_in('code', $order_codes);
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'prepared');
        $obj = $this->db->get('orders');
        $orders['prepared'] = $this->order_merger($obj);

        // DELIVERED ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where_in('code', $order_codes);
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'delivered');
        $obj = $this->db->get('orders');
        $orders['delivered'] = $this->order_merger($obj);

        return $orders;
    }

    // GET AN ORDER DETAIL
    public function details($order_code)
    {
        $this->db->where('order_code', $order_code);
        $obj = $this->db->get('order_details');
        return $obj->result_array();
    }

    // ORDER MERGER
    // MERGER FUNCTION IS FOR MERGING NECESSARY DATA
    public function order_merger($query_obj, $is_single_row = false)
    {

        if (!$is_single_row) {
            $orders = $query_obj->result_array();
            foreach ($orders as $key => $order) {
                // print_r($orders);
                // die();


                $orders[$key]['request_refund'] = [
                    'order_code' => $orders[$key]["order_code"],
                    'refund_amount' => $orders[$key]["refund_amount"],
                    'status' => $orders[$key]["status"],
                    'requestedAt' => $orders[$key]["requestedAt"],
                    'acceptedAt' => $orders[$key]["acceptedAt"],
                    'rejectedAt' => $orders[$key]["rejectedAt"]
                ];

                unset($orders[$key]["order_code"]);
                unset($orders[$key]["refund_amount"]);
                unset($orders[$key]["status"]);
                unset($orders[$key]["requestedAt"]);
                unset($orders[$key]["acceptedAt"]);
                unset($orders[$key]["rejectedAt"]);

                $customer_details = $this->customer_model->get_by_id($order['customer_id']);
                if (!empty($order['driver_id'])) {
                    $driver_details = $this->driver_model->get_by_id($order['driver_id']);
                } else {
                    $driver_details = array();
                }

                $orders[$key]['customer_id']  = $customer_details['id'];
                $orders[$key]['customer_name']  = $customer_details['name'];
                $orders[$key]['customer_email']  = $customer_details['email'];
                $orders[$key]['driver_id']  = isset($driver_details['id']) ? $driver_details['id'] : '';
                $orders[$key]['driver_name']  = isset($driver_details['name']) ? $driver_details['name'] : '';
                $orders[$key]['driver_email']  = isset($driver_details['email']) ? $driver_details['email'] : '';
                $orders[$key]['delivery_address']  = isset($customer_details['address_' . $order['customer_address_id']]) ? $customer_details['address_' . $order['customer_address_id']] : '';
            }
            return $orders;
        } else {
            $order = $query_obj->row_array();
            $customer_details = $this->customer_model->get_by_id($order['customer_id']);
            if (!empty($order['driver_id'])) {
                $driver_details = $this->driver_model->get_by_id($order['driver_id']);
            } else {
                $driver_details = array();
            }
            $order['customer_id']  = $customer_details['id'];
            $order['customer_name']  = $customer_details['name'];
            $order['customer_email']  = $customer_details['email'];
            $order['driver_id']  = isset($driver_details['id']) ? $driver_details['id'] : '';
            $order['driver_name']  = isset($driver_details['name']) ? $driver_details['name'] : '';
            $order['driver_email']  = isset($driver_details['email']) ? $driver_details['email'] : '';
            $order['driver_phone']  = isset($driver_details['phone']) ? $driver_details['phone'] : '';
            $order['driver_thumbnail']  = isset($driver_details['thumbnail']) ? $driver_details['thumbnail'] : '';
            $order['delivery_address']  = isset($customer_details['address_' . $order['customer_address_id']]) ? $customer_details['address_' . $order['customer_address_id']] : '';
            return $order;
        }
    }

    /**
     * CONFIRM ORDER FUNCTION
     * 1. FIRST INSERT INTO ORDER TABLE
     * 2. SECOND INSERT INTO ORDER DETAILS TABLE
     * 3. CLEAR THE CART TABLE
     * @return bool
     */
    public function confirm($address_id_arg = "", $order_type)
    {
        $today = date('Y-m-d');

        // Count how many orders have been placed today
        $this->db->where('DATE(created_at)', $today);
        $count = $this->db->count_all_results('orders');

        // New order number for the day
        $daily_order_number = $count + 1;
        $address_id = !empty($address_id_arg) ? $address_id_arg : sanitize($this->input->post('address_number'));

        $data['code'] = "OR-" . strtotime(date('D, d-M-Y H:i:s')) . "-" . $this->session->userdata('user_id');
        $data['customer_id'] = $this->logged_in_user_id;
        $data['customer_address_id'] = $address_id;
        $data['daily_order_number'] = $daily_order_number;

        $data['order_placed_at'] = strtotime(date('D, d-M-Y H:i:s'));
        $data['order_status'] = get_order_settings('auto_approve_order') ? "approved" : "pending";
        $data['total_menu_price'] = $this->cart_model->get_total_menu_price();
        $data['total_delivery_charge'] = $this->cart_model->get_total_delivery_charge();
        $data['total_vat_amount'] = $this->cart_model->get_vat_amount();
        $data['grand_total'] = $this->cart_model->get_grand_total($order_type);

        $cart_items = $this->cart_model->get_all();
        if (!empty($cart_items)) {
            $data['restaurant_id'] = $cart_items[0]['restaurant_id'];
        }
        
      $data['commission_res'] = $this->restaurant_model->commision_check($data['restaurant_id']);
    $commission_value = floatval(preg_replace('/[^0-9.]/', '', $data['commission_res']));
    $data['commission_paid'] = $data['grand_total'] * ($commission_value / 100);


        // log_message('error',  $data['commission_res'] ."lol");
        // print_r($data);
        // die();

        $this->db->insert($this->table, $data);

        $cart_items = $this->cart_model->get_all();

        // print_r($cart_items);
        // die();   

        foreach ($cart_items as $cart_item) {
            $restaurant_ids = $order_details['restaurant_id'];

            $order_details['order_code'] = $data['code'];
            $order_details['menu_id'] = $cart_item['menu_id'];
            $order_details['restaurant_id'] = $cart_item['restaurant_id'];
            $order_details['servings'] = $cart_item['servings'];
            $order_details['quantity'] = $cart_item['quantity'];
            $order_details['total'] = $cart_item['price'];
            $order_details['note'] = $cart_item['note'];
            $order_details['variant_id'] = $cart_item['variant_id'];
            $order_details['addons'] = $cart_item['options_1'];
            $this->db->insert('order_details', $order_details);
        }




        $this->cart_model->clearing_cart();


        // CHECK IF AUTO DRIVER ASSIGNMENT IS ENABLED
        if (get_order_settings('auto_approve_order') && get_order_settings('auto_assign_driver')) {
            $this->driver_model->auto_assign_a_driver($data['code']);
        }

        // SAVING ORDER CODE FOR SENDING MAIL TO USERS
        $this->session->set_flashdata('order_code', $data['code']);
        return $data['code'];
    }


    // CONFIRM POS ORDER FUNCTION
    public function confirm_pos_order($customer_id)
{
    $payment_method = $this->input->post('pay_with'); 
    // print_r($payment_method . "dada");
    

    $today = date('Y-m-d');
    
    // Count POS orders for today
    $this->db->where('DATE(created_at)', $today);
    $count = $this->db->count_all_results('orders');
    $daily_order_number = $count + 1;

    $cart_items = $this->cart_model->get_all_by_pos($customer_id);

        
    if(empty($cart_items)) return false;
    // Calculate totals 
    $total_menu_price = 0;
    foreach($cart_items as $item){
        $total_menu_price += $item['price'];
    }

    $grand_total = $total_menu_price
        + $this->cart_model->get_total_delivery_charge($customer_id)
        + $this->cart_model->get_vat_amount($customer_id)
        + 
        (($total_menu_price * ($this->restaurant_model->get_pos_discount( $cart_items[0]['restaurant_id']) / 100)) * -1)
        +1.10 //later solve service and bag charges for pos only
        ;


    $order_code = "OR-" . strtotime(date('D, d-M-Y H:i:s')) . "-POS";
  
    $data = [
        'code' => $order_code,
        'customer_id' => $customer_id,
        'customer_address_id' => null,
        'daily_order_number' => $daily_order_number,
        'order_placed_at' => strtotime(date('D, d-M-Y H:i:s')),
        'order_status' => 'approved',
        'read_status' => 1,
        'order_type' => 'pos',
        'total_menu_price' => $total_menu_price,
        'total_delivery_charge' => $this->cart_model->get_total_delivery_charge($customer_id),
        'total_vat_amount' => $this->cart_model->get_vat_amount($customer_id),
        'grand_total' => $grand_total,
        'restaurant_id' => $cart_items[0]['restaurant_id'],
    ];

    // Commission
    $data['commission_res'] = $this->restaurant_model->commision_check($data['restaurant_id']);
    $commission_value = floatval(preg_replace('/[^0-9.]/', '', $data['commission_res']));
    $data['commission_paid'] = $grand_total * ($commission_value / 100);

    $this->db->insert('orders', $data);

    // Insert order details
            foreach($cart_items as $cart_item){
                $order_details = [
                    'order_code' => $order_code,
                    'menu_id' => $cart_item['menu_id'],
                    'restaurant_id' => $cart_item['restaurant_id'],
                    'servings' => $cart_item['servings'],
                    'quantity' => $cart_item['quantity'],
                    'total' => $cart_item['price'],
                    'note' => $cart_item['note'],
                    'variant_id' => $cart_item['variant_id'],
                    'addons' => $cart_item['options_1']
                ];
                $this->db->insert('order_details', $order_details);
            }

            // Insert payment once
            $payment_data = [
                'order_code'     => $order_code,
                'amount_to_pay'    => $grand_total,
                'amount_paid'    => $grand_total,
                'payment_method' => $payment_method,     
                'data'           => json_encode([]),
                'created_at'     => strtotime(date('Y-m-d'))
            ];

                    //             echo "<pre>";
                    // print_r($payment_data);
                    // echo "dada";
                    // echo "</pre>";
                    // die();

            $this->db->insert('payment', $payment_data);
    

    // Clear POS cart
    $this->cart_model->clearing_cart_pos($customer_id);

    return $order_code;
}

    // SENDING ORDER PLACING MAILS FROM THIS FUNCTION
    public function order_placing_mail($order_code)
    {
        $order_details = $this->order_model->get_by_code($order_code);
        $payment       = $this->order_model->get_order_payment($order_code);

        
        // Load necessary models
        $ordered_items = $this->order_model->details($order_code);
        // print_r($ordered_items . "Dass");
        // die();
        // Prepare data for the view


        // SENDING MAIL TO CUSTOMER
        $customer_details = $this->user_model->get_user_by_id($this->logged_in_user_id);
        $message  = get_phrase('hello') . ' ' . $customer_details['name'] . ', <br/>';
        $message .= get_phrase('your_order_has_been_placed_successfully') . '.<br/>';
        $message .= get_phrase('the_order_code_is') . ' <b>' . $order_code . '</b>.<br/>';
        $message .= get_phrase('please_track_down_your_order_status_from_the_order_details_page') . '.';
        $this->email_model->order_pacing($customer_details['email'], $message);
        // print_r($customer_details['email'] . "dada");
        // SENDING MAIL TO ADMIN
        $admin_details = $this->user_model->get_admin_details();
        $message  = get_phrase('hello') . ' ' . $admin_details['name'] . ', <br/>';
        $message .= get_phrase('a_new_order_has_been_placed_by_the_customer_name') . ' <b>' . $customer_details['name'] . '</b>.<br/>';
        $message .= get_phrase('the_order_code_is') . ' <b>' . $order_code . '</b>.<br/>';
        $message .= get_phrase('please_check_the_order_as_soon_as_possible_and_process_the_order') . '.';

        $this->email_model->order_pacing($admin_details['email'], $message);

        // PUSH ALL THE RESTAURANT IDS TO THIS ARRAY FOR SENDING MAILS TO THE RESTAURANT OWNERS
        $restaurant_ids = $this->get_restaurant_ids($order_code);
        foreach ($restaurant_ids as $key => $restaurant_id) {
            $restaurant_details = $this->restaurant_model->get_by_id($restaurant_id);
            $message  = get_phrase('hello') . ' ' . $restaurant_details['owner_name'] . ', <br/>';
            $message .= get_phrase('a_new_order_has_been_placed_to_your_restaurant_from') . ' <b>' . $customer_details['name'] . '</b>.<br/>';
            $message .= get_phrase('the_order_code_is') . ' <b>' . $order_code . '</b>.<br/>';
            $message .= get_phrase('please_check_the_order_as_soon_as_possible') . '.';
            $this->email_model->order_pacing($restaurant_details['owner_email'], $message);
        }
    }
    // GET THE RESTAURANT IDS ONLY. THIS FUNCTION WILL RETURN ALL THE INDIVIDUAL RESTAURANT IDS OF THE ORDERED ITEMS
    public function get_restaurant_ids($order_code)
    {
        $restaurant_ids = array();
        $ordered_items = $this->details($order_code);
        foreach ($ordered_items as $ordered_item) {
            if (!in_array($ordered_item['restaurant_id'], $restaurant_ids)) {
                array_push($restaurant_ids, $ordered_item['restaurant_id']);
            }
        }
        return $restaurant_ids;
    }

    // CHECK IF THE ORDER BELONGS TO THE CUSTOMER OR IF THE ORDER CODE IS VALID FOR OTHER USERS
    public function is_valid($order_code)
    {
        if ($this->session->userdata('user_role_id') == 2 && $this->session->userdata('customer_login') == 1) {
            $this->db->where(['customer_id' => $this->logged_in_user_id, 'code' => $order_code]);
            $order_rows = $this->db->get('orders')->num_rows();
        } elseif ($this->session->userdata('user_role_id') == 3 && $this->session->userdata('owner_login') == 1) {
            $owners_approved_restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (count($owners_approved_restaurant_ids) > 0) {
                $this->db->where('order_code', $order_code);
                $this->db->where_in('restaurant_id', $owners_approved_restaurant_ids);
                $order_rows = $this->db->get('order_details')->num_rows();
            } else {
                return false;
            }
        } elseif ($this->session->userdata('user_role_id') == 4 && $this->session->userdata('driver_login') == 1) {

            $this->db->where(['driver_id' => $this->logged_in_user_id, 'code' => $order_code]);
            $order_rows = $this->db->get('orders')->num_rows();
        } else {
            $order_rows = $this->db->get('orders')->num_rows();
        }

        return $order_rows > 0 ? true : false;
    }

    // CANCEL AN ORDER
    public function cancel($order_code)
    {
        $order_data = $this->get_by_code($order_code);
        if ($order_data['order_status'] == "pending" || $order_data['order_status'] == "approved") {
            $this->db->where('code', $order_code);
            $updater = array('order_status' => 'canceled', 'order_canceled_at' => strtotime(date('D, d-M-Y H:i:s')));
            $this->db->update('orders', $updater);
            return true;
        }

        return false;
    }

    // FILTER ORDERS
    public function filter()
    {
        $dynamic_function_name = "filter_orders_as_" . $this->logged_in_user_role;
        return $this->$dynamic_function_name();
    }


    /**
     * filter_orders_as_customer FUNCTION
     * THIS FUNCTION FILTERS ONLY CUSTOMERS ORDERS
     * @return object
     */
    public function filter_orders_as_customer()
    {
        // CUSTOMER ID INTEGRATING TO THE CONDITION
        $conditions['customer_id'] = $this->logged_in_user_id;

        // CHECK DATE RANGE
        if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
            $date_range                   = sanitize($this->input->get('date_range'));
            $date_range                   = explode(" - ", $date_range);
            $conditions['order_placed_at >='] = strtotime($date_range[0] . ' 00:00:01');
            $conditions['order_placed_at <=']   = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $first_day_of_month = "1 " . date("M") . " " . date("Y") . ' 00:00:01';
            $last_day_of_month = date("t") . " " . date("M") . " " . date("Y") . ' 23:59:59';
            $conditions['order_placed_at >=']   = strtotime($first_day_of_month);
            $conditions['order_placed_at <=']     = strtotime($last_day_of_month);
        }

        return $this->get_by_condition($conditions);
    }

    /**
     * filter_orders_as_admin FUNCTION
     * THIS FUNCTION FILTERS ONLY APPLICABLE FOR ADMIN, IT CAN FILTER ALL THE ORDERS
     * @return object
     */
    public function filter_orders_as_admin()
    {
        // CHECK DATE RANG
        if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
            $date_range                   = sanitize($this->input->get('date_range'));
            $date_range                   = explode(" - ", $date_range);
            $conditions['order_placed_at >='] = strtotime($date_range[0] . ' 00:00:01');
            $conditions['order_placed_at <=']   = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $first_day_of_month = "1 Jan " . date("Y") . ' 00:00:01';
            // $first_day_of_month = "1 " . date("M") . " " . date("Y") . ' 00:00:01';
            $last_day_of_month = date("t") . " " . date("M") . " " . date("Y") . ' 23:59:59';
            $conditions['order_placed_at >=']   = strtotime($first_day_of_month);
            $conditions['order_placed_at <=']     = strtotime($last_day_of_month);
        }

        // CHECK RESTAURANT SELECTION
        $restaurant_id = nuller(sanitize($this->input->get('restaurant_id')));
        // if ($restaurant_id) {
        //     $conditions['code'] = count($this->get_order_code_by_restaurant_id($restaurant_id)) > 0 ? $this->get_order_code_by_restaurant_id($restaurant_id) :  array();
        // }

        if ($restaurant_id && $restaurant_id != "all") {
            $order_codes = $this->get_order_code_by_restaurant_id($restaurant_id);
            if (count($order_codes) > 0) {
                $conditions['code'] = $order_codes;
            } else {
                $conditions['code'] = array();
            }
        }

        // CHECK CUSTOMER SELECTION
        $conditions['customer_id']     = nuller(sanitize($this->input->get('customer_id')));

        // CHECK DRIVER SELECTION
        $conditions['driver_id']     = nuller(sanitize($this->input->get('driver_id')));

        // CHECK STATUS SELECTION
        $conditions['order_status']     = nuller(sanitize($this->input->get('status')));

         // CHECK ORDER PLACED FROM SELECTION
        $conditions['order_url'] = nuller(sanitize($this->input->get('order_url')));

        return $this->get_by_condition($conditions);
    }

    /**
     * filter_orders_as_owner  FUNCTION FILTERS ONLY APPLICABLE FOR OWNER, IT CAN FILTER ALL THE ORDERS
     * @return object
     */
    public function filter_orders_as_owner()
    {
        // die();
        // AT FIRST CHECK IF THE OWNER HAS ANY RESTAURANT
       // CHECK DATE RANG
        if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
            $date_range                   = sanitize($this->input->get('date_range'));
            $date_range                   = explode(" - ", $date_range);
            $conditions['order_placed_at >='] = strtotime($date_range[0] . ' 00:00:01');
            $conditions['order_placed_at <=']   = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $first_day_of_month = "1 Jan " . date("Y") . ' 00:00:01';
            // $first_day_of_month = "1 " . date("M") . " " . date("Y") . ' 00:00:01';
            $last_day_of_month = date("t") . " " . date("M") . " " . date("Y") . ' 23:59:59';
            $conditions['order_placed_at >=']   = strtotime($first_day_of_month);
            $conditions['order_placed_at <=']     = strtotime($last_day_of_month);
        }

        // CHECK RESTAURANT SELECTION
        $restaurant_id = nuller(sanitize($this->input->get('restaurant_id')));
        // if ($restaurant_id) {
        //     $conditions['code'] = count($this->get_order_code_by_restaurant_id($restaurant_id)) > 0 ? $this->get_order_code_by_restaurant_id($restaurant_id) :  array();
        // }

        if ($restaurant_id && $restaurant_id != "all") {
            $order_codes = $this->get_order_code_by_restaurant_id($restaurant_id);
            if (count($order_codes) > 0) {
                $conditions['code'] = $order_codes;
            } else {
                $conditions['code'] = array();
            }
        }

        // CHECK CUSTOMER SELECTION
        $conditions['customer_id']     = nuller(sanitize($this->input->get('customer_id')));

        // CHECK DRIVER SELECTION
        $conditions['driver_id']     = nuller(sanitize($this->input->get('driver_id')));

        // CHECK STATUS SELECTION
        $conditions['order_status']     = nuller(sanitize($this->input->get('status')));

         // CHECK ORDER PLACED FROM SELECTION
        // $conditions['order_url'] = nuller(sanitize($this->input->get('order_url')));
        $conditions['order_type'] = nuller(sanitize($this->input->get('pos')));
        // print_r($conditions);
        // die();
        return $this->get_by_condition($conditions);
    }

    /**
     * FILTER ORDERS AS DRIVER FUNCTION
     * THIS FUNCTION FILTERS ONLY APPLICABLE FOR DRIVER, IT CAN FILTER ALL THE ORDERS
     * @return object
     */
    public function filter_orders_as_driver()
    {
        // CHECK DATE RANGE
        if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
            $date_range                   = sanitize($this->input->get('date_range'));
            $date_range                   = explode(" - ", $date_range);
            $conditions['order_placed_at >='] = strtotime($date_range[0] . ' 00:00:01');
            $conditions['order_placed_at <=']   = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $first_day_of_month = "1 " . date("M") . " " . date("Y") . ' 00:00:01';
            $last_day_of_month = date("t") . " " . date("M") . " " . date("Y") . ' 23:59:59';
            $conditions['order_placed_at >=']   = strtotime($first_day_of_month);
            $conditions['order_placed_at <=']     = strtotime($last_day_of_month);
        }

        // CHECK RESTAURANT SELECTION
        $restaurant_id = nuller(sanitize($this->input->get('restaurant_id')));
        if ($restaurant_id) {
            $conditions['code'] = count($this->get_order_code_by_restaurant_id($restaurant_id)) > 0 ? $this->get_order_code_by_restaurant_id($restaurant_id) : array();
        }

        // CHECK CUSTOMER SELECTION
        $conditions['customer_id']     = nuller(sanitize($this->input->get('customer_id')));

        // DRIVER ID WOULD BE THE LOGGED IN USER ID
        $conditions['driver_id']     = $this->logged_in_user_id;

        // CHECK STATUS SELECTION
        $conditions['order_status']     = nuller(sanitize($this->input->get('status')));

        return $this->get_by_condition($conditions);
    }


    /**
     *  THIS FUNCTION PROCESSES ORDERS. SO MAKE SURE THAT ADMIN, RESTAURANT OWNER AND DRIVER CAN ACCESS THIS
     */
    public function process($order_code, $phase)
    {
        $dynamic_function_name = "process_orders_as_" . $this->logged_in_user_role;
        return $this->$dynamic_function_name($order_code, $phase);
    }

    /**
     * PROCESS ORDER AS ADMIN
     */
    public function process_orders_as_admin($order_code, $phase)
    {
        $phases = ['pending', 'approved', 'preparing', 'prepared', 'delivered'];
        if (in_array($phase, $phases)) {
            $index = array_search($phase, $phases);

            $order_details = $this->db->get_where($this->table, ['code' => $order_code])->row_array();
            if (count($order_details) > 0) {
                if ($index && $phases[$index - 1] == $order_details['order_status']) {
                    $this->db->where('code', $order_code);
                    $this->db->update('orders', ['order_status' => $phase, 'order_' . $phase . '_at' => strtotime(date('D, d-M-Y H:i:s'))]);

                    // CHECK AUTO DRIVER ASSIGNMENT
                    if ($phase == "approved") {
                        $auto_driver_assignment = get_order_settings('auto_assign_driver');
                        if ($auto_driver_assignment) {
                            $this->driver_model->auto_assign_a_driver($order_code);
                        }
                    }

                    // DEVIDE COMMISSION AFTER AN ORDER GETS DELIVERED
                    if ($phase == 'delivered') {
                        $this->report_model->devide_commission($order_code);
                        // MARK AS PAID IF THE ORDER PAYMENT METHOD IS CASH ON DELIVERY
                        $this->payment_model->mark_order_as_paid($order_code);
                    }
                    if ($phase == "approved") {
                        success(get_phrase("order_status_has_been_changed_to_$phase"), $_SERVER['HTTP_REFERER']);
                    } else {
                        success(get_phrase("order_status_has_been_changed_to_$phase"), site_url('orders/details/' . $order_code));
                    }
                } else {
                    error(get_phrase('invalid_status'), site_url('orders'));
                }
            } else {
                error(get_phrase('invalid_order'), site_url('orders'));
            }
        } else {
            error(get_phrase('invalid_phase'), site_url('orders'));
        }
    }

    /**
     * PROCESS ORDER AS DRIVER
     */
    public function process_orders_as_driver($order_code, $phase)
    {
        $phases = ['approved', 'preparing', 'prepared', 'delivered'];
        if (in_array($phase, $phases)) {
            $index = array_search($phase, $phases);

            $order_details = $this->db->get_where($this->table, ['code' => $order_code])->row_array();
            if (count($order_details) > 0 && $order_details['driver_id'] == $this->logged_in_user_id) {
                if ($index && $phases[$index - 1] == $order_details['order_status']) {
                    $this->db->where('code', $order_code);
                    $this->db->update('orders', ['order_status' => $phase, 'order_' . $phase . '_at' => strtotime(date('D, d-M-Y H:i:s'))]);

                    // DEVIDE COMMISSION AFTER AN ORDER GETS DELIVERED
                    if ($phase == 'delivered') {
                        $this->report_model->devide_commission($order_code);
                        // MARK AS PAID IF THE ORDER PAYMENT METHOD IS CASH ON DELIVERY
                        $this->payment_model->mark_order_as_paid($order_code);
                    }
                    success(get_phrase("order_status_has_been_changed_to_$phase"), site_url('orders/today'));
                } else {
                    error(get_phrase('invalid_status'), site_url('orders/today'));
                }
            } else {
                error(get_phrase('invalid_order'), site_url('orders/today'));
            }
        } else {
            error(get_phrase('invalid_phase'), site_url('orders/today'));
        }
    }


    /**
     * PROCESS ORDER AS COOK
     */
    public function process_orders_as_cook($order_code, $phase)
    {
        $authentictes = $this->authenticating($order_code);
        if (!$authentictes) {
            error(get_phrase('you_are_not_authorized_to_access_this_order'), site_url('orders'));
        }

        $phases = ['pending', 'approved', 'preparing', 'prepared'];
        if (in_array($phase, $phases)) {
            $index = array_search($phase, $phases);

            $order_details = $this->db->get_where($this->table, ['code' => $order_code])->row_array();
            if (count($order_details) > 0) {
                if ($index && $phases[$index - 1] == $order_details['order_status']) {
                    $this->db->where('code', $order_code);
                    $this->db->update('orders', ['order_status' => $phase, 'order_' . $phase . '_at' => strtotime(date('D, d-M-Y H:i:s'))]);

                    // CHECK AUTO DRIVER ASSIGNMENT
                    if ($phase == "approved") {
                        $auto_driver_assignment = get_order_settings('auto_assign_driver');
                        if ($auto_driver_assignment) {
                            $this->driver_model->auto_assign_a_driver($order_code);
                        }
                    }

                    success(get_phrase("order_status_has_been_changed_to_$phase"), site_url('orders/today'));
                } else {
                    error(get_phrase('invalid_status'), site_url('orders/today'));
                }
            } else {
                error(get_phrase('invalid_order'), site_url('orders/today'));
            }
        } else {
            error(get_phrase('invalid_phase'), site_url('orders/today'));
        }
    }

    /**
     * PROCESS ORDER AS OWNER
     */
    public function process_orders_as_owner($order_code, $phase)
    {
        $authentictes = $this->authenticating($order_code);
        if (!$authentictes) {
            error(get_phrase('you_are_not_authorized_to_access_this_order'), site_url('orders'));
        }

        $phases = ['pending', 'approved', 'preparing', 'prepared', 'delivered'];
        if (in_array($phase, $phases)) {
            $index = array_search($phase, $phases);

            $order_details = $this->db->get_where($this->table, ['code' => $order_code])->row_array();
            if (count($order_details) > 0) {
                if ($index && $phases[$index - 1] == $order_details['order_status']) {
                    $this->db->where('code', $order_code);
                    $this->db->update('orders', ['order_status' => $phase, 'order_' . $phase . '_at' => strtotime(date('D, d-M-Y H:i:s'))]);

                    // CHECK AUTO DRIVER ASSIGNMENT
                    if ($phase == "approved") {
                        $auto_driver_assignment = get_order_settings('auto_assign_driver');
                        if ($auto_driver_assignment) {
                            $this->driver_model->auto_assign_a_driver($order_code);
                        }
                    }

                    // DEVIDE COMMISSION AFTER AN ORDER GETS DELIVERED
                    if ($phase == 'delivered') {
                        $this->report_model->devide_commission($order_code);
                        // MARK AS PAID IF THE ORDER PAYMENT METHOD IS CASH ON DELIVERY
                        $this->payment_model->mark_order_as_paid($order_code);
                    }
                    if ($phase == "approved") {
                        success(get_phrase("order_status_has_been_changed_to_$phase"), $_SERVER['HTTP_REFERER']);
                    } else {
                        success(get_phrase("order_status_has_been_changed_to_$phase"), site_url('orders/details/' . $order_code));
                    }
                } else {
                    error(get_phrase('invalid_status'), site_url('orders'));
                }
            } else {
                error(get_phrase('invalid_order'), site_url('orders'));
            }
        } else {
            error(get_phrase('invalid_phase'), site_url('orders'));
        }
    }

    /**
     * ASSIGNIGN A DRIVER TO AN ORDER
     *
     * @return void
     */
    public function assign_driver()
    {
        $dynamic_function_name = "assign_driver_as_" . $this->logged_in_user_role;
        $this->$dynamic_function_name();
    }

    // ASSIGNING A DRIVER AS ADMIN
    public function assign_driver_as_admin()
    {
        $order_code = required(sanitize($this->input->post('order_code')));
        $driver_id = required(sanitize($this->input->post('driver_id')));

        $order_details = $this->db->get_where($this->table, ['code' => $order_code])->row_array();
        if (count($order_details) > 0) {
            if (empty($order_details['driver_id'])) {
                $this->db->where('code', $order_code);
                $this->db->update('orders', ['driver_id' => $driver_id]);
                success(get_phrase("driver_has_been_assigned_successfully"), site_url('orders/details/' . $order_code));
            } else {
                error(get_phrase('a_driver_is_already_assigned_to_this_order'), site_url('orders/details/' . $order_code));
            }
        } else {
            error(get_phrase('invalid_order'), site_url('orders'));
        }
    }
    // ASSIGNING A DRIVER AS RESTAURANT OWNER


    // DASHBOARD TILE DATA USER AND STATUS WISE
    public function get_number_of_orders($order_url = null, $order_status = "", $restaurant_id = "all", $starting_timestamp = null, $ending_timestamp = null, $is_paid_status = null)
    {

        $user_role = $this->session->userdata('user_role');

        // Parse date range from GET if timestamps are not provided
        if (is_null($starting_timestamp) || is_null($ending_timestamp)) {
            if (isset($_GET['date_range'])) {
                $dates = explode(' - ', $_GET['date_range']);
                if (count($dates) === 2) {
                    $starting_timestamp = strtotime($dates[0]);
                    $ending_timestamp = strtotime($dates[1] . ' 23:59:59');
                    if (!$starting_timestamp || !$ending_timestamp) {
                        $starting_timestamp = null;
                        $ending_timestamp = null;
                    }
                }
            }
        }

        /* AT FIRST CHECK USER ROLE */
        if ($user_role == "customer") {
            $this->db->where('customer_id', $this->logged_in_user_id);
        } elseif ($user_role == "owner") {
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (count($restaurant_ids)) {
                $order_codes = $this->get_order_code_by_restaurant_id($restaurant_ids);
                if (count($order_codes) > 0) {
                    $this->db->where_in('code', $order_codes);
                } else {
                    return 0;  // No orders found
                }
            } else {
                return 0;  // No approved restaurants for this owner
            }
        }
        
        /* THEN CHECK ORDER STATUS */
        if (!empty($order_status)) {
            if ($order_status == "processed") {
                $this->db->where_in('order_status', ['preparing', 'prepared', 'delivered']);
            } elseif ($order_status == "delivered") {
                $this->db->where_in('order_status', 'delivered');
            } else {
                $this->db->where('order_status', $order_status);
            }
        }

        // Filter by status
        if (!empty($_GET['status'])) {
            if ($_GET['status'] === "paid") {
                $this->db->where('is_status', 1);
            } elseif ($_GET['status'] === "refund") {
                $this->db->where('is_status', 2);
            } elseif ($_GET['status'] === "unpaid") {
                $this->db->where('is_status', 0);
            }
        }

        /* FILTER BY RESTAURANT ID IF SELECTED */
        if ($restaurant_id != "all" && !empty($restaurant_id)) {
            $this->db->where('restaurant_id', $restaurant_id);
        }

        /* FILTER BY DATE RANGE */
        if (!empty($starting_timestamp)) {
            $this->db->where('order_placed_at >=', $starting_timestamp);
        }
        if (!empty($ending_timestamp)) {
            $this->db->where('order_placed_at <=', $ending_timestamp);
        }

        if (!is_null($is_paid_status)) {
            $this->db->where('is_status', $is_paid_status);
        }

        if ($order_url != '') {
            $this->db->where('order_url', $order_url);
        }
        
        $this->db->not_like('billing', '"first_name":"test"');
        $this->db->not_like('billing', '"last_name":"test"');

        // Execute the query and return the number of rows
        return $this->db->get($this->table)->num_rows();
    }






    // DASHBOARD TILE DATA USER AND STATUS WISE
    public function get_number_of_todays_pending_orders()
    {
        $user_role = $this->session->userdata('user_role');

        /*AT FIRST CHECK USER ROLE*/
        if ($user_role == "owner") {
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (count($restaurant_ids)) {
                $order_codes = $this->get_order_code_by_restaurant_id($restaurant_ids);
                if (count($order_codes) > 0) {
                    $this->db->where_in('code', $order_codes);
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
        $todays_starting_time = strtotime(date('D, d-M-Y') . ' 00:00:01');
        $todays_ending_time = strtotime(date('D, d-M-Y') . ' 23:59:59');
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        $this->db->where('order_status', 'pending');
        return $this->db->get($this->table)->num_rows();
    }

    // ADD A NOTE BY DRIVER ONLY
    public function add_note()
    {
        $order_code = required(sanitize($this->input->post('code')));
        $order_details = $this->get_by_code($order_code);
        if ($order_details['driver_id'] == $this->logged_in_user_id) {
            $data['note'] = required(sanitize($this->input->post('note')));
            $this->db->where('code', $order_code);
            $this->db->update('orders', $data);
            return true;
        }
        return false;
    }

    /**
     * LIVE ORDERS USER WISE
     */

    /**
     * THIS FUNCTION IS ONLY APPLICABLE FOR DRIVERS ORDERS. IT WILL BE CALLED INTERNALLY
     *
     * @return object
     */
    public function get_live_orders()
    {
        $todays_starting_time = strtotime(date('D, d-M-Y') . ' 00:00:01');
        $todays_ending_time = strtotime(date('D, d-M-Y') . ' 23:59:59');

        // CHECK THE LOGGED IN USER ROLE IS OWNER
        if ($this->logged_in_user_role == "owner") {
            // AT FIRST CHECK IF THE OWNER HAS ANY RESTAURANT
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (count($restaurant_ids)) {
                $order_codes = $this->get_order_code_by_restaurant_id($restaurant_ids);
                if (count($order_codes) == 0) {
                    return array('pending' => array(), 'approved' => array(), 'preparing' => array(), 'prepared' => array(), 'delivered' => array());
                }
            } else {
                return array('pending' => array(), 'approved' => array(), 'preparing' => array(), 'prepared' => array(), 'delivered' => array());
            }
        }

        // PENDING ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        // CHECK USER ROLES
        if ($this->logged_in_user_role == "driver") {
            $this->db->where('driver_id', $this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "customer") {
            $this->db->where('customer_id', $this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "owner") {
            if ($order_codes && count($order_codes)) {
                $this->db->where_in('code', $order_codes);
            } else {
                return array();
            }
        }
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'pending');
        $obj = $this->db->get('orders');
        $orders['pending'] = $this->order_merger($obj);

        // APPROVED ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        // CHECK USER ROLES
        if ($this->logged_in_user_role == "driver") {
            $this->db->where('driver_id', $this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "customer") {
            $this->db->where('customer_id', $this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "owner") {
            if ($order_codes && count($order_codes)) {
                $this->db->where_in('code', $order_codes);
            } else {
                return array();
            }
        }
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'approved');
        $obj = $this->db->get('orders');
        $orders['approved'] = $this->order_merger($obj);

        // PREPARING
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        // CHECK USER ROLES
        if ($this->logged_in_user_role == "driver") {
            $this->db->where('driver_id', $this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "customer") {
            $this->db->where('customer_id', $this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "owner") {
            if ($order_codes && count($order_codes)) {
                $this->db->where_in('code', $order_codes);
            } else {
                return array();
            }
        }
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'preparing');
        $obj = $this->db->get('orders');
        $orders['preparing'] = $this->order_merger($obj);

        // PREPARED ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        // CHECK USER ROLES
        if ($this->logged_in_user_role == "driver") {
            $this->db->where('driver_id', $this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "customer") {
            $this->db->where('customer_id', $this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "owner") {
            if ($order_codes && count($order_codes)) {
                $this->db->where_in('code', $order_codes);
            } else {
                return array();
            }
        }
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'prepared');
        $obj = $this->db->get('orders');
        $orders['prepared'] = $this->order_merger($obj);

        // DELIVERED ORDERS
        $this->db->where('order_placed_at >=', $todays_starting_time);
        $this->db->where('order_placed_at <=', $todays_ending_time);
        // CHECK USER ROLES
        if ($this->logged_in_user_role == "driver") {
            $this->db->where('driver_id', $this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "customer") {
            $this->db->where('customer_id', $this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "owner") {
            if ($order_codes && count($order_codes)) {
                $this->db->where_in('code', $order_codes);
            } else {
                return array();
            }
        }
        $this->db->order_by("id", "asc");
        $this->db->where('order_status', 'delivered');
        $obj = $this->db->get('orders');
        $orders['delivered'] = $this->order_merger($obj);

        return $orders;
    }

    /**
     * AUTHENTICATING AN ORDER
     */
    public function authenticating($order_code)
    {
        $this->db->distinct();
        $this->db->select('restaurant_id');
        $restaurant_ids_of_order = $this->db->get_where('order_details', ['order_code' => $order_code])->result_array();
        $valid_restaurant_ids = [];
        if ($this->logged_in_user_role == "owner") {
            $valid_restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "cook") {
            $valid_restaurant_ids = $this->cook_model->get_restaurant_ids_by_cook_id($this->logged_in_user_id);
        } elseif ($this->logged_in_user_role == "admin") {
            return true;
        }

        foreach ($restaurant_ids_of_order as $key => $restaurant_id) {
            if (!in_array($restaurant_id['restaurant_id'], $valid_restaurant_ids)) {
                return false;
            }
        }
        return true;
    }


    public function get_stripe_payment_sum($order_url = null, $restaurant_id = null, $starting_timestamp = null, $ending_timestamp = null, $is_paid_status = null)
    {
        // Agar restaurant_id GET se aaye aur 'all' na ho to sanitize karo
        if (is_null($restaurant_id)) {
            if (isset($_GET['restaurant_id']) && $_GET['restaurant_id'] !== 'all') {
                $restaurant_id = sanitize($_GET['restaurant_id']);
            }
        }

        // Parse date range from GET if timestamps are not provided
        if (is_null($starting_timestamp) || is_null($ending_timestamp)) {
            if (isset($_GET['date_range'])) {
                $dates = explode(' - ', $_GET['date_range']);
                if (count($dates) === 2) {
                    $starting_timestamp = strtotime($dates[0]);
                    $ending_timestamp = strtotime($dates[1] . ' 23:59:59');

                    if (!$starting_timestamp || !$ending_timestamp) {
                        return 0;
                    }
                }
            }
        }

        $this->db->select_sum('payment.amount_paid', 'total_sum');
        $this->db->from('payment');
        $this->db->join('orders', 'payment.order_code = orders.code');
        $this->db->where('payment.payment_method', 'stripe');

        if (($restaurant_id) !== "all") {
            $this->db->where('orders.restaurant_id', $restaurant_id);
        }
        if ($order_url != null) {
            $this->db->where('orders.order_url', $order_url);
        }

        if (!empty($starting_timestamp) && !empty($ending_timestamp)) {
            $this->db->where('payment.created_at >=', $starting_timestamp);
            $this->db->where('payment.created_at <=', $ending_timestamp);
        }

        // Check GET status
        if (!empty($_GET['status'])) {
            if ($_GET['status'] === "paid") {
                $this->db->where('is_status', 1);
            } elseif ($_GET['status'] === "unpaid") {
                $this->db->where('is_status', 0);
            } elseif ($_GET['status'] === "refund") {
                // If status is refund, return 0 directly
                return 0;
            }
        } else {
            // Default behavior: exclude refund
            $this->db->where('is_status !=', 2);
        }

        // Manual override if passed
        if (!is_null($is_paid_status)) {
            if ($is_paid_status == 2) {
                return 0;
            } else {
                $this->db->where('is_status', $is_paid_status);
            }
        }

        $this->db->not_like('billing', '"first_name":"test"');
        $this->db->not_like('billing', '"last_name":"test"');

        $query = $this->db->get();
        $result = $query->row_array();

        return $result['total_sum'] ?? 0;
    }


    public function get_cash_on_delivery_payment_sum($order_url =null, $restaurant_id = null, $starting_timestamp = null, $ending_timestamp = null, $is_paid_status = null)
    {
        // Use restaurant_id from GET if not provided as argument
        if (is_null($restaurant_id)) {
            if (isset($_GET['restaurant_id']) && $_GET['restaurant_id'] !== 'all') {
                $restaurant_id = sanitize($_GET['restaurant_id']);
            }
        }

        // Parse date range from GET if timestamps are not provided
        if (is_null($starting_timestamp) || is_null($ending_timestamp)) {
            if (isset($_GET['date_range'])) {
                $dates = explode(' - ', $_GET['date_range']);
                if (count($dates) === 2) {
                    $starting_timestamp = strtotime($dates[0]);
                    $ending_timestamp = strtotime($dates[1] . ' 23:59:59');

                    // If parsing fails, return 0 to avoid bad query
                    if (!$starting_timestamp || !$ending_timestamp) {
                        return 0;
                    }
                }
            }
        }

        // Refund status → no revenue
        if (!empty($_GET['status']) && $_GET['status'] === 'refund') {
            return 0;
        }

        // Manual status override refund check
        if (!is_null($is_paid_status) && $is_paid_status == 2) {
            return 0;
        }

        // Build query
        $this->db->select_sum('payment.amount_to_pay', 'total_sum');
        $this->db->from('payment');
        $this->db->join('orders', 'payment.order_code = orders.code');
        $this->db->where('payment.payment_method', 'cash_on_collection');

        if (($restaurant_id) !== "all") {
            $this->db->where('orders.restaurant_id', $restaurant_id);
        }

        if (!empty($starting_timestamp) && !empty($ending_timestamp)) {
            $this->db->where('payment.created_at >=', $starting_timestamp);
            $this->db->where('payment.created_at <=', $ending_timestamp);
        }

        // Apply status from GET (if not refund)
        if (!empty($_GET['status'])) {
            if ($_GET['status'] === "paid") {
                $this->db->where('is_status', 1);
            } elseif ($_GET['status'] === "unpaid") {
                $this->db->where('is_status', 0);
            }
        } else {
            // Default: exclude refunded payments
            $this->db->where('is_status !=', 2);
        }

        // Manual status override (except refund, which already returned above)
        if (!is_null($is_paid_status)) {
            $this->db->where('is_status', $is_paid_status);
        }
        if ($order_url != null) {
            $this->db->where('orders.order_url', $order_url);
        }

        $this->db->not_like('billing', '"first_name":"test"');
        $this->db->not_like('billing', '"last_name":"test"');

        $query = $this->db->get();
        $result = $query->row_array();

        return $result['total_sum'] ?? 0;
    }




    public function get_total_revenue($order_url = null, $restaurant_id = "all", $starting_timestamp = null, $ending_timestamp = null, $is_paid_status = null)
    {
        if (is_null($restaurant_id)) {
            if (isset($_GET['restaurant_id']) && $_GET['restaurant_id'] !== 'all') {
                $restaurant_id = sanitize($_GET['restaurant_id']);
            }
        }

        // Parse date range from GET if timestamps are not provided
        if (is_null($starting_timestamp) || is_null($ending_timestamp)) {
            if (isset($_GET['date_range'])) {
                $dates = explode(' - ', $_GET['date_range']);
                if (count($dates) === 2) {
                    $starting_timestamp = strtotime($dates[0]);
                    $ending_timestamp = strtotime($dates[1] . ' 23:59:59');

                    if (!$starting_timestamp || !$ending_timestamp) {
                        return 0;
                    }
                }
            }
        }

        $this->db->select_sum('payment.amount_to_pay', 'total_sum');
        $this->db->from('payment');
        $this->db->join('orders', 'payment.order_code = orders.code');

        if ($restaurant_id !== "all") {
            $this->db->where('orders.restaurant_id', $restaurant_id);
        }

        // Handle status
        if (!empty($_GET['status'])) {
            if ($_GET['status'] === "paid") {
                $this->db->where('is_status', 1);
            } elseif ($_GET['status'] === "unpaid") {
                $this->db->where('is_status', 0);
            } elseif ($_GET['status'] === "refund") {
                // Refunds should not be included in revenue → return 0 directly
                return 0;
            }
        } else {
            // If status not passed, then ignore refunded payments by default
            $this->db->where('is_status !=', 2);
        }

        // Filter by date range
        if (!empty($starting_timestamp) && !empty($ending_timestamp)) {
            $this->db->where('payment.created_at >=', $starting_timestamp);
            $this->db->where('payment.created_at <=', $ending_timestamp);
        }

        // Extra condition if passed manually
        if (!is_null($is_paid_status)) {
            // But make sure it is not refund
            if ($is_paid_status == 2) {
                return 0; // refunded = no revenue
            } else {
                $this->db->where('is_status', $is_paid_status);
            }
        }
        
        if ($order_url != null) {
            $this->db->where('orders.order_url', $order_url);
        }

        $this->db->not_like('billing', '"first_name":"test"');
        $this->db->not_like('billing', '"last_name":"test"');

        $query = $this->db->get();
        $result = $query->row_array();

        return $result['total_sum'] ?? 0;
    }



    public function total_comission_sum($restaurant_id = null, $starting_timestamp = null, $ending_timestamp = null, $is_paid_status = null)
    {
        // Sanitize restaurant ID
        if (is_null($restaurant_id)) {
            if (isset($_GET['restaurant_id']) && $_GET['restaurant_id'] !== 'all') {
                $restaurant_id = sanitize($_GET['restaurant_id']);
            }
        }

        // Parse date range
        if (is_null($starting_timestamp) || is_null($ending_timestamp)) {
            if (isset($_GET['date_range'])) {
                $dates = explode(' - ', $_GET['date_range']);
                if (count($dates) === 2) {
                    $starting_timestamp = strtotime($dates[0]);
                    $ending_timestamp = strtotime($dates[1] . ' 23:59:59');

                    if (!$starting_timestamp || !$ending_timestamp) {
                        return 0;
                    }
                }
            }
        }

        $status_filter = $_GET['status'] ?? null;

        // CASE 1: Unpaid commission only
        if ($status_filter === 'unpaid') {
            $this->db->select_sum('orders.commission_paid', 'unpaid_commission');
            $this->db->from('orders');
            $this->db->join('payment', 'payment.order_code = orders.code');
            $this->db->where('orders.is_status', 0); // Only unpaid

            if ($restaurant_id && $restaurant_id !== "all") {
                $this->db->where('orders.restaurant_id', $restaurant_id);
            }
            if (!empty($starting_timestamp) && !empty($ending_timestamp)) {
                $this->db->where('payment.created_at >=', $starting_timestamp);
                $this->db->where('payment.created_at <=', $ending_timestamp);
            }

            $query = $this->db->get();
            $result = $query->row_array();
            return round($result['unpaid_commission'] ?? 0, 2);
        }

        // CASE 2: Paid commission only — return 0 as per your existing logic
        if ($status_filter === 'paid') {
            return 0;
        }

        // CASE 3: Refund commission only
        if ($status_filter === 'refund') {
            return 0;
        }

        // DEFAULT CASE: Total - Paid - Refund

        // 1. Get total commission (excluding refunded)
        $this->db->select_sum('orders.commission_paid', 'total_commission');
        $this->db->from('orders');
        $this->db->join('payment', 'payment.order_code = orders.code');
        $this->db->where('orders.is_status !=', 2); // exclude refund

        if ($restaurant_id && $restaurant_id !== "all") {
            $this->db->where('orders.restaurant_id', $restaurant_id);
        }
        if (!empty($starting_timestamp) && !empty($ending_timestamp)) {
            $this->db->where('payment.created_at >=', $starting_timestamp);
            $this->db->where('payment.created_at <=', $ending_timestamp);
        }
        $this->db->not_like('billing', '"first_name":"test"');
        $this->db->not_like('billing', '"last_name":"test"');

        $query_total = $this->db->get();
        $total = $query_total->row_array();
        $total_commission = $total['total_commission'] ?? 0;

        // 2. Get paid commission
        $this->db->select_sum('orders.commission_paid', 'paid_commission');
        $this->db->from('orders');
        $this->db->join('payment', 'payment.order_code = orders.code');
        $this->db->where('orders.is_status', 1);

        if ($restaurant_id && $restaurant_id !== "all") {
            $this->db->where('orders.restaurant_id', $restaurant_id);
        }
        if (!empty($starting_timestamp) && !empty($ending_timestamp)) {
            $this->db->where('payment.created_at >=', $starting_timestamp);
            $this->db->where('payment.created_at <=', $ending_timestamp);
        }
        

        $query_paid = $this->db->get();
        $paid = $query_paid->row_array();
        $paid_commission = $paid['paid_commission'] ?? 0;

        // 3. unpaid = total - paid
        $unpaid_commission = $total_commission - $paid_commission;

        return round(max(0, $unpaid_commission), 2);
    }


    public function mark_as_paid($order_ids = [])
    {
        if (!empty($order_ids) && is_array($order_ids)) {
            foreach ($order_ids as $id) {
                $this->db->where('id', $id);
                $this->db->update('orders', ['is_status' => 1]);
            }
        }
    }

    public function mark_as_unpaid($order_ids = [])
    {
        if (!empty($order_ids) && is_array($order_ids)) {
            foreach ($order_ids as $id) {
                $this->db->where('id', $id);
                $this->db->update('orders', ['is_status' => 0]);
            }
        }
    }

    public function get_order_by_code($order_code)
    {
        $this->db->where('code', $order_code);
        $query = $this->db->get('orders');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function mark_as_refund($order_code)
    {
        $this->db->where('code', $order_code);
        $this->db->update('orders', ['is_status' => 2]);
    }

    public function get_all_orders_for_customer_details($restaurant_id = 'all')
    {
        // $this->db->where('order_type', 'delivery');

        if ($restaurant_id !== 'all') {
            $this->db->where('restaurant_id', $restaurant_id);
        }

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('orders');
        return $query->result_array();
    }
    
    public function get_all_orders_for_placed_from($restaurant_ids = null)
    {
        if ($restaurant_ids != null) {
            $this->db->where_in('restaurant_id', $restaurant_ids['id']);
        }
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    public function get_orders_by_promo_code($promo_code)
    {
        if (empty($promo_code)) return [];

        $this->db->select('id, code, grand_total, address, created_at');
        $this->db->from('orders');
        $this->db->where('promo_code', $promo_code);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();

        return $query->result();
    }

}
