<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 09 - June - 2020
 * Author : TheDevs
 * Driver model handles all the database queries of Drivers
 */

class Driver_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "users";
    }

    /**
     * GET ONLY APPROVED DRIVERS
     *
     */
    public function get_approved_drivers()
    {
        $this->db->where('status', 1);
        $this->db->where('role_id', 4);
        return $this->merger($this->db->get($this->table));
    }

    /**
     * GET ONLY PENDING DRIVERS
     */
    public function get_pending_drivers()
    {
        $this->db->where('status', 0);
        $this->db->where('role_id', 4);
        return $this->merger($this->db->get($this->table));
    }

    /**
     * GET DRIVER BY ID
     */
    public function get_by_id($id)
    {
        $driver = $this->db->get_where('users', array('id' => $id, 'role_id' => 4));
        return $this->merger($driver, true);
    }

    /**
     * DRIVER MERGER
     */
    public function merger($query_obj, $is_single_row = false)
    {
        if (!$is_single_row) {
            $drivers = $query_obj->result_array();
            foreach ($drivers as $key => $driver) {
                $driver_data = $this->db->get_where('drivers', array('user_id' => $driver['id']))->row_array();
                $drivers[$key]['vehicle_type']  = $driver_data['vehicle_type'];
                $drivers[$key]['address']  = $driver_data['address'];
            }
            return $drivers;
        } else {
            $driver = $query_obj->row_array();
            $driver_data = $this->db->get_where('drivers', array('user_id' => $driver['id']))->row_array();
            $driver['vehicle_type'] = $driver_data['vehicle_type'];
            $driver['address'] = $driver_data['address'];
            return $driver;
        }
    }

    /**
     * STORE DRIVER DATA
     */
    public function store_driver()
    {
        $email = required(sanitize($this->input->post('email')));
        if (email_duplication($email)) {
            $data['name'] = required(sanitize($this->input->post('name')));
            $data['email'] = $email;
            $data['password'] = sha1(required($this->input->post('password')));
            $data['phone'] = required(sanitize($this->input->post('phone')));
            $data['role_id'] = 4; // 4 for drivers
            $data['status'] = $this->session->userdata('admin_login') ? 1 : 0;
            $data['created_at'] = strtotime(date('d-m-y'));
            // UPLOAD THUMBNAIL
            $data['thumbnail']  = $this->upload('user', $_FILES['image']);
            $this->db->insert('users', $data);

            $driver_data['user_id'] = $this->db->insert_id();
            $driver_data['vehicle_type'] = sanitize($this->input->post('vehicle_type'));
            $driver_data['address'] = sanitize($this->input->post('address'));
            $this->db->insert('drivers', $driver_data);

            return true;
        }
    }

    /**
     * UPDATE DRIVER DATA
     */
    public function update_driver()
    {
        $id = required(sanitize($this->input->post('id')));
        $email = required(sanitize($this->input->post('email')));
        $previous_data = $this->get_by_id($id);

        if (email_duplication($email, $id)) {
            $data['name'] = required(sanitize($this->input->post('name')));
            $data['email'] = $email;
            $data['phone'] = required(sanitize($this->input->post('phone')));
            $data['updated_at'] = strtotime(date('d-m-y'));
            // UPLOAD THUMBNAIL
            if (!empty($_FILES['image']['name'])) {
                $data['thumbnail']  = $this->upload('user', $_FILES['image'], $previous_data["thumbnail"]);
            }

            $this->db->where('id', $id);
            $this->db->update('users', $data);

            $driver_data['vehicle_type'] = sanitize($this->input->post('vehicle_type'));
            $driver_data['address'] = sanitize($this->input->post('address'));

            $this->db->where('user_id', $id);
            $this->db->update('drivers', $driver_data);

            return true;
        }
    }

    /**
     * UPDATE DRIVER DATA STATUS
     */
    public function update_driver_status($id)
    {
        $previous_data = $this->get_by_id($id);
        if ($previous_data['status']) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }

        $this->db->where('id', $id);
        $this->db->update('users', $data);

        return true;
    }

    /**
     * DELETE DRIVER DATA
     */
    public function delete_driver($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');

        $this->db->where('user_id', $id);
        $this->db->delete('drivers');

        return true;
    }


    /**
     * GET DRIVER'S DELIVERED ORDER DATA FOR THIS WEEK
     */

    public function get_this_week_delivered_order_data($driver_id = null)
    {
        $driver_id = $driver_id ? $driver_id : $this->logged_in_user_id;
        $conditions['driver_id'] = $driver_id;

        $day = date('w');
        $week_start = date('D, d-M-Y', strtotime('-' . $day . ' days')) . ' 00:00:01';
        $week_end = date('D, d-M-Y', strtotime('+' . (6 - $day) . ' days')) . ' 23:59:59';
        $conditions['order_delivered_at >=']   = strtotime($week_start);
        $conditions['order_delivered_at <=']     = strtotime($week_end);
        return $this->order_model->get_by_condition($conditions);
    }

    /**
     * GET DRIVER'S DELIVERED ORDER DATA FOR THIS MONTH
     */

    public function get_this_month_delivered_order_data($driver_id = null)
    {
        $driver_id = $driver_id ? $driver_id : $this->logged_in_user_id;
        $conditions['driver_id'] = $driver_id;

        $first_day_of_month = "1 " . date("M") . " " . date("Y") . ' 00:00:00';
        $last_day_of_month = date("t") . " " . date("M") . " " . date("Y") . ' 23:59:59';
        $conditions['order_delivered_at >=']   = strtotime($first_day_of_month);
        $conditions['order_delivered_at <=']     = strtotime($last_day_of_month);
        return $this->order_model->get_by_condition($conditions);
    }

    /**
     * GET DRIVER'S TOTAL DELIVERED ORDER DATA
     */

    public function get_total_delivered_order_data($driver_id = null)
    {
        $driver_id = $driver_id ? $driver_id : $this->logged_in_user_id;
        $conditions['driver_id'] = $driver_id;
        $conditions['order_status'] = "delivered";
        return $this->order_model->get_by_condition($conditions);
    }

    /**
     * CHECK IF DRIVER IS IN A RIDE NOW
     */

    public function in_ride($driver_id = null)
    {
        $driver_id = $driver_id ? $driver_id : $this->logged_in_user_id;
        $conditions['driver_id'] = $driver_id;
        $starting_time = date('D, d-M-Y') . ' 00:00:00';
        $ending_time = date('D, d-M-Y') . ' 23:59:59';
        $conditions['order_placed_at >='] = strtotime($starting_time);
        $conditions['order_placed_at <='] = strtotime($ending_time);
        $todays_orders = $this->order_model->get_by_condition($conditions);

        $conditions['order_status'] = "delivered";
        $todays_delivered_orders = $this->order_model->get_by_condition($conditions);
        if (count($todays_orders) == count($todays_delivered_orders)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * THIS FUNCTION IS RESPONSIBLE FOR AUTO ASSIGNING A DRIVER
     */
    public function auto_assign_a_driver($order_code = null)
    {
        $available_drivers = $this->driver_model->get_approved_drivers();
        $free_drivers = array();
        $in_ride_drivers = array();
        $assigned_driver_id = false;

        if (count($available_drivers) > 0) {
            foreach ($available_drivers as $available_driver) {
                $response = $this->driver_model->in_ride($available_driver['id']);
                if ($response) {
                    array_push($in_ride_drivers, $available_driver['id']);
                } else {
                    array_push($free_drivers, $available_driver['id']);
                }
            }

            if (count($free_drivers) > 0) {
                $assigned_driver_id = $free_drivers[array_rand($free_drivers)];
            } else {
                $assigned_driver_id = $in_ride_drivers[array_rand($in_ride_drivers)];
            }


            $order_details = $this->order_model->get_by_code($order_code);
            if (empty($order_details['driver_id']) && !empty($assigned_driver_id) && $order_details['order_type'] != "pickup") {
                $updater['driver_id'] = $assigned_driver_id;
                $this->db->where('code', $order_code);
                $this->db->update('orders', $updater);
            }
        }
        return $assigned_driver_id;
    }
}
