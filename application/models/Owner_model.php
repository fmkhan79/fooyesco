<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 20 - June - 2020
 * Author : TheDevs
 * Owner model handles all the database queries of Owner
 */

class Owner_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "users";
    }

    // GET ALL OWNERS, WHICH IS ROLE ID 3
    public function get_all()
    {
        $this->db->where('role_id', 3);
        return $this->owner_merger($this->db->get($this->table));
    }

    // GET ONLY APPROVED OWNERS, WHICH IS ROLE ID 3
    public function get_approved_owners()
    {
        $this->db->where('status', 1);
        $this->db->where('role_id', 3);
        return $this->owner_merger($this->db->get($this->table));
    }

    // GET ONLY PENDING OWNERS, WHICH IS ROLE ID 3
    public function get_pending_owners()
    {
        $this->db->where('role_id', 3);
        $this->db->where('status', 0);
        return $this->owner_merger($this->db->get($this->table));
    }


    // GET OWNER BY ID
    public function get_owner_by_id($id)
    {
        $owner = $this->db->get_where($this->table, array('id' => $id, 'role_id' => 3));
        return $this->owner_merger($owner, true);
    }

    // owner MERGER
    public function owner_merger($query_obj, $is_single_row = false)
    {
        if (!$is_single_row) {
            $owners = $query_obj->result_array();
            foreach ($owners as $key => $owner) {
                $owner_data = $this->db->get_where('customers', array('user_id' => $owner['id']))->row_array();
                $owners[$key]['address_1']  = $owner_data['address_1'];
                $owners[$key]['address_2']  = $owner_data['address_2'];
                $owners[$key]['address_3']  = $owner_data['address_3'];
                $owners[$key]['coordinate_1']    = $owner_data['coordinate_1'] ? json_decode($owner_data['coordinate_1'], true) : ['latitude' => '', 'longitude' => ''];
                $owners[$key]['coordinate_2']    = $owner_data['coordinate_2'] ? json_decode($owner_data['coordinate_2'], true) : ['latitude' => '', 'longitude' => ''];
                $owners[$key]['coordinate_3']    = $owner_data['coordinate_3'] ? json_decode($owner_data['coordinate_3'], true) : ['latitude' => '', 'longitude' => ''];

                $approved_restaurants = $this->restaurant_model->get_restaurants_by_condition(['owner_id' => $owner['id'], 'status' => 1]);
                $pending_restaurants  = $this->restaurant_model->get_restaurants_by_condition(['owner_id' => $owner['id'], 'status' => 0]);

                $owners[$key]['number_of_approved_restaurants'] = count($approved_restaurants) ? count($approved_restaurants) : 0;
                $owners[$key]['number_of_pending_restaurants']  = count($pending_restaurants) ? count($pending_restaurants) : 0;
            }
            return $owners;
        } else {
            $owner = $query_obj->row_array();
            $owner_data = $this->db->get_where('customers', array('user_id' => $owner['id']))->row_array();
            $owner['address_1']  = $owner_data['address_1'];
            $owner['address_2']  = $owner_data['address_2'];
            $owner['address_3']  = $owner_data['address_3'];
            $owner['coordinate_1']    = $owner_data['coordinate_1'] ? json_decode($owner_data['coordinate_1'], true) : ['latitude' => '', 'longitude' => ''];
            $owner['coordinate_2']    = $owner_data['coordinate_2'] ? json_decode($owner_data['coordinate_2'], true) : ['latitude' => '', 'longitude' => ''];
            $owner['coordinate_3']    = $owner_data['coordinate_3'] ? json_decode($owner_data['coordinate_3'], true) : ['latitude' => '', 'longitude' => ''];

            $approved_restaurants = $this->restaurant_model->get_restaurants_by_condition(['owner_id' => $owner['id'], 'status' => 1]);
            $pending_restaurants  = $this->restaurant_model->get_restaurants_by_condition(['owner_id' => $owner['id'], 'status' => 0]);

            $owner['number_of_approved_restaurants'] = count($approved_restaurants) ? count($approved_restaurants) : 0;
            $owner['number_of_pending_restaurants']  = count($pending_restaurants) ? count($pending_restaurants) : 0;
            return $owner;
        }
    }


    //UPDATE owner DATA
    public function update_owner()
    {
        $id = required(sanitize($this->input->post('id')));
        $email = required(sanitize($this->input->post('email')));
        $previous_data = $this->get_owner_by_id($id);

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
            $this->db->update($this->table, $data);

            $owner_data = $this->update_owner_address();

            $this->db->where('user_id', $id);
            $this->db->update('customers', $owner_data);

            return true;
        }
    }

    // UPDATE owner'S ADDRESS
    public function update_owner_address()
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


    //UPDATE owner DATA STATUS
    public function update_owner_status($id)
    {
        $previous_data = $this->get_owner_by_id($id);
        if ($previous_data['status']) {
            $data['status'] = 0;
        } else {
            $data['status'] = 1;
        }

        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return true;
    }

    // DELETE owner DATA
    public function delete_owner($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);

        $this->db->where('user_id', $id);
        $this->db->delete('customers');

        return true;
    }

    // UPDATE THIS RESTAURANT OWNER ROLE TO CUSTOMER
    public function become_customer($user_id)
    {
        $previous_data = $this->user_model->get_user_by_id($user_id);
        if ($previous_data['role_id'] != 1 && $previous_data['role_id'] != 4) {
            $this->db->where('id', $user_id);
            $this->db->update('users', ['role_id' => 2]);
            return true;
        }
        return false;
    }

    // UPDATE CUSTOMER ROLE TO RESTAURANT OWNER ROLE MEANS UPDATE TOT 2 -> 3
    public function become_restaurant_owner($user_id)
    {
        $previous_data = $this->user_model->get_user_by_id($user_id);
        if ($previous_data['role_id'] != 1 && $previous_data['role_id'] != 4) {
            $this->db->where('id', $user_id);
            $this->db->update('users', ['role_id' => 3]);
            return true;
        }
        return false;
    }
}
