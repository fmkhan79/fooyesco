<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 09 - June - 2020
 * Author : TheDevs
 * Customer model handles all the database queries of Customer
 */

class Customer_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "users";
    }

    /**
     * GET ONLY APPROVED CUSTOMERS. RESTAURANT OWNERS ARE ALSO CUSTOMERS
     */
    public function get_approved_customers()
    {
        $this->db->where('status', 1);
        $this->db->where_in('role_id', [2, 3]);
        return $this->merger($this->db->get($this->table));
    }

    /**
     * GET ONLY PENDING CUSTOMERS. RESTAURANT OWNERS ARE ALSO CUSTOMERS
     */
    public function get_pending_customers()
    {
        $this->db->where('status', 0);
        $this->db->where_in('role_id', [2, 3]);
        return $this->merger($this->db->get($this->table));
    }

    /**
     * GET CUSTOMER BY ID
     */
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->where_in('role_id', [2, 3]);
        $customer = $this->db->get('users');

        if ($customer->num_rows()) {
            return $this->merger($customer, true);
        } else {
            return array();
        }
    }

    /**
     * CUSTOMER MERGER
     */
    public function merger($query_obj, $is_single_row = false)
    {
        if (!$is_single_row) {
            $customers = $query_obj->result_array();
            foreach ($customers as $key => $customer) {
                $customer_data = $this->db->get_where('customers', array('user_id' => $customer['id']))->row_array();
                $customers[$key]['address_1']  = $customer_data['address_1'];
                $customers[$key]['address_2']  = $customer_data['address_2'];
                $customers[$key]['address_3']  = $customer_data['address_3'];
                $customers[$key]['coordinate_1']    = $customer_data['coordinate_1'] ? json_decode($customer_data['coordinate_1'], true) : ['latitude' => '', 'longitude' => ''];
                $customers[$key]['coordinate_2']    = $customer_data['coordinate_2'] ? json_decode($customer_data['coordinate_2'], true) : ['latitude' => '', 'longitude' => ''];
                $customers[$key]['coordinate_3']    = $customer_data['coordinate_3'] ? json_decode($customer_data['coordinate_3'], true) : ['latitude' => '', 'longitude' => ''];
            }
            return $customers;
        } else {
            $customer = $query_obj->row_array();
            $customer_data = $this->db->get_where('customers', array('user_id' => $customer['id']))->row_array();
            $customer['address_1']  = $customer_data['address_1'];
            $customer['address_2']  = $customer_data['address_2'];
            $customer['address_3']  = $customer_data['address_3'];
            $customer['coordinate_1']    = $customer_data['coordinate_1'] ? json_decode($customer_data['coordinate_1'], true) : ['latitude' => '', 'longitude' => ''];
            $customer['coordinate_2']    = $customer_data['coordinate_2'] ? json_decode($customer_data['coordinate_2'], true) : ['latitude' => '', 'longitude' => ''];
            $customer['coordinate_3']    = $customer_data['coordinate_3'] ? json_decode($customer_data['coordinate_3'], true) : ['latitude' => '', 'longitude' => ''];
            return $customer;
        }
    }

    /**
     * STORE CUSTOMER DATA
     *
     * @return boolean
     */
    public function store_customer()
    {
        $email = required(sanitize($this->input->post('email')));
        if (email_duplication($email)) {
            $data['name'] = required(sanitize($this->input->post('name')));
            $data['email'] = $email;
            $data['password'] = sha1(required($this->input->post('password')));
            $data['phone'] = required(sanitize($this->input->post('phone')));
            $data['role_id'] = 2; // 2 for Customer
            $data['status'] = 1;
            $data['created_at'] = strtotime(date('d-m-y'));
            // UPLOAD THUMBNAIL
            $data['thumbnail']  = $this->upload('user', $_FILES['image']);
            $this->db->insert('users', $data);

            $customer_data = $this->update_customer_address();
            $customer_data['user_id'] = $this->db->insert_id();
            $this->db->insert('customers', $customer_data);

            return true;
        }
    }

    /**
     * UPDATE CUSTOMER DATA
     *
     * @return boolean
     */
    public function update_customer()
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

            $customer_data = $this->update_customer_address();

            $this->db->where('user_id', $id);
            $this->db->update('customers', $customer_data);

            return true;
        }
    }

    /**
     * UPDATE CUSTOMER'S ADDRESS
     */
    public function update_customer_address()
    {
        $latitude_1 = required(sanitize($this->input->post('latitude_1')));
        $longitude_1 = required(sanitize($this->input->post('longitude_1')));
        $coordinate_1 = array('latitude' => $latitude_1, 'longitude' => $longitude_1);
        $address_data['address_1'] = required(sanitize($this->input->post('address_1')));
        $address_data['coordinate_1'] = json_encode($coordinate_1);

        $latitude_2 = sanitize($this->input->post('latitude_2'));
        $longitude_2 = sanitize($this->input->post('longitude_2'));
        $coordinate_2 = array('latitude' => $latitude_2, 'longitude' => $longitude_2);
        $address_data['address_2'] = sanitize($this->input->post('address_2'));
        $address_data['coordinate_2'] = json_encode($coordinate_2);

        $latitude_3 = sanitize($this->input->post('latitude_3'));
        $longitude_3 = sanitize($this->input->post('longitude_3'));
        $coordinate_3 = array('latitude' => $latitude_3, 'longitude' => $longitude_3);
        $address_data['address_3'] = sanitize($this->input->post('address_3'));
        $address_data['coordinate_3'] = json_encode($coordinate_3);

        return $address_data;
    }


    /**
     * UPDATE CUSTOMER DATA STATUS
     * @return boolean
     */
    public function update_customer_status($id)
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
     * DELETE CUSTOMER DATA
     * @return boolean
     */
    public function delete_customer($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');

        $this->db->where('user_id', $id);
        $this->db->delete('customers');

        return true;
    }
}
