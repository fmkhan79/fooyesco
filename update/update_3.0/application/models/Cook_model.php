<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 09 - June - 2020
 * Author : TheDevs
 * cook model handles all the database queries of cooks
 */

class Cook_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "users";
    }

    /**
     * GET ONLY APPROVED cookS
     *
     */
    public function get_approved_cooks()
    {
        $restaurant_ids = [];
        if ($this->logged_in_user_role == "owner") {
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (count($restaurant_ids) == 0) {
                return array();
            } else {
                $this->db->distinct();
                $this->db->select('user_id');
                $this->db->where_in('restaurant_id', $restaurant_ids);
                $cook_details = $this->db->get('cooks')->result_array();
                $cook_ids = array();
                foreach ($cook_details as $key => $cook_detail) {
                    if (!in_array($cook_detail['user_id'], $cook_ids)) {
                        array_push($cook_ids, $cook_detail['user_id']);
                    }
                }
                if (count($cook_ids) > 0) {
                    $this->db->where_in('id', $cook_ids);
                } else {
                    return array();
                }
            }
        }

        $this->db->where('status', 1);
        $this->db->where('role_id', 5);
        return $this->merger($this->db->get($this->table));
    }


    /**
     * GET ONLY PENDING cookS
     */
    public function get_pending_cooks()
    {
        $restaurant_ids = [];
        if ($this->logged_in_user_role == "owner") {
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (count($restaurant_ids) == 0) {
                return array();
            } else {
                $this->db->distinct();
                $this->db->select('user_id');
                $this->db->where_in('restaurant_id', $restaurant_ids);
                $cook_details = $this->db->get('cooks')->result_array();
                $cook_ids = array();
                foreach ($cook_details as $key => $cook_detail) {
                    if (!in_array($cook_detail['user_id'], $cook_ids)) {
                        array_push($cook_ids, $cook_detail['user_id']);
                    }
                }
                if (count($cook_ids) > 0) {
                    $this->db->where_in('id', $cook_ids);
                } else {
                    return array();
                }
            }
        }

        $this->db->where('status', 0);
        $this->db->where('role_id', 5);
        return $this->merger($this->db->get($this->table));
    }

    /**
     * GET cook BY ID
     */
    public function get_by_id($id)
    {
        $cook_details = $this->db->get_where('cooks', ['user_id' => $id])->num_rows();
        if ($cook_details) {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->join('cooks', 'users.id = cooks.user_id');
            $this->db->where('users.id', $id);
            $this->db->where('users.role_id', 5);
            $cook = $this->db->get()->row_array();

            $cook_id = $cook['id'];
            $cook['id'] = $cook['user_id'];
            $cook['cook_id'] = $cook_id;
            return $cook;
        } else {
            return $this->db->get_where('users', ['id' => $id])->row_array();
        }
    }

    /**
     * GET THE RESTAURANTS HE BELONGS TO
     *
     */
    public function restaurants_he_belongs_to($cook_id)
    {
        $this->db->select('cooks.*');
        $this->db->select('restaurants.id AS restaurant_id');
        $this->db->select('restaurants.name AS restaurant_name');
        $this->db->select('restaurants.slug AS restaurant_slug');
        $this->db->from('cooks');
        $this->db->join('restaurants', 'cooks.restaurant_id=restaurants.id');
        $this->db->where('cooks.user_id', $cook_id);
        $cook_details = $this->db->get()->result_array();
        return $cook_details;
    }
    /**
     * PAGINATE METHOD FOR cook
     */
    public function paginate_cooks($per_page, $page_number)
    {
        $restaurant_ids = [];
        if ($this->logged_in_user_role == "owner") {
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (count($restaurant_ids) == 0) {
                return array();
            } else {
                $this->db->distinct();
                $this->db->select('user_id');
                $this->db->where_in('restaurant_id', $restaurant_ids);
                $cook_details = $this->db->get('cooks')->result_array();
                $cook_ids = array();
                foreach ($cook_details as $key => $cook_detail) {
                    if (!in_array($cook_detail['user_id'], $cook_ids)) {
                        array_push($cook_ids, $cook_detail['user_id']);
                    }
                }
                if (count($cook_ids) > 0) {
                    $this->db->where_in('id', $cook_ids);
                } else {
                    return array();
                }
            }
        }

        $this->db->where('status', 1);
        $this->db->where('role_id', 5);
        $offset = $page_number > 0 ? ($page_number - 1) * $per_page : 0;
        $this->db->limit($per_page, $offset);
        $this->db->order_by("users.id", "desc");
        return $this->merger($this->db->get($this->table));
    }


    /**
     * cook MERGER
     */
    public function merger($query_obj, $is_single_row = false)
    {
        if (!$is_single_row) {
            $cooks = $query_obj->result_array();
            foreach ($cooks as $key => $cook) {
                $cook_data = $this->db->get_where('cooks', array('user_id' => $cook['id']))->row_array();
                $cooks[$key]['address']  = !empty($cook_data['address']) ? $cook_data['address'] : "";
                $cooks[$key]['cook_id']  = !empty($cook_data['id']) ? $cook_data['id'] : 0;
            }
            return $cooks;
        } else {
            $cook = $query_obj->row_array();
            $cook_data = $this->db->get_where('cooks', array('user_id' => $cook['id']))->row_array();
            $cook['address'] = !empty($cook_data['address']) ? $cook_data['address'] : "";
            $cook['cook_id']  = !empty($cook_data['id']) ? $cook_data['id'] : 0;
            return $cook;
        }
    }

    /**
     * STORE cook DATA
     */
    public function store_cook()
    {
        $cook_id = sanitize($this->input->post('cook_id'));
        $restaurant_id = required(sanitize($this->input->post('restaurant_id')));
        if ($cook_id) {
            $availability = $this->db->get_where('cooks', array('user_id' => $cook_id, 'restaurant_id' => $restaurant_id));
            if ($availability->num_rows() == 0) {
                $previous_data = $this->db->get_where('cooks', array('user_id' => $cook_id))->row_array();
                $data['user_id'] = $cook_id;
                $data['address'] = isset($previous_data['address']) ? $previous_data['address'] : "";
                $data['restaurant_id'] = $restaurant_id;
                $this->db->insert('cooks', $data);
            }
            return true;
        } else {
            $email = required(sanitize($this->input->post('email')));
            if (email_duplication($email)) {
                $data['name'] = required(sanitize($this->input->post('name')));
                $data['email'] = $email;
                $data['password'] = sha1(required($this->input->post('password')));
                $data['phone'] = required(sanitize($this->input->post('phone')));
                $data['role_id'] = 5; // 5 for cooks
                $data['status'] = 1;
                $data['created_at'] = strtotime(date('d-m-y'));
                // UPLOAD THUMBNAIL
                $data['thumbnail']  = $this->upload('user', $_FILES['image']);
                $this->db->insert('users', $data);

                $cook_data['user_id'] = $this->db->insert_id();
                $cook_data['address'] = sanitize($this->input->post('address'));
                $cook_data['restaurant_id'] = required(sanitize($this->input->post('restaurant_id')));
                $this->db->insert('cooks', $cook_data);

                return true;
            }
        }
    }

    /**
     * UPDATE cook DATA
     */
    public function update_cook()
    {
        $id = required(sanitize($this->input->post('id')));
        $email = required(sanitize($this->input->post('email')));
        $previous_data = $this->get_by_id($id);

        // AUTHENTICATING
        if (!$this->authentic($id)) {
            error(get_phrase("you_are_not_authorized"), site_url('cook'));
        }

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

            $cook_data['address'] = sanitize($this->input->post('address'));
            $this->db->where('user_id', $id);
            $this->db->update('cooks', $cook_data);

            return true;
        }
    }

    /**
     * UPDATE cook DATA STATUS
     */
    public function update_cook_status($id)
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
     * DELETE cook DATA
     */
    public function delete_cook($id)
    {
        // AUTHENTICATING
        if (!$this->authentic($id)) {
            error(get_phrase("you_are_not_authorized"), site_url('cook'));
        }

        if ($this->logged_in_user_role == "owner") {
            $cook_details = $this->db->get_where('cooks', ['user_id' => $id])->result_array();
            foreach ($cook_details as $cook_detail) {
                $this->remove_from_restaurant($cook_detail['id']);
            }
        } elseif ($this->logged_in_user_role == "admin") {
            $this->db->where('id', $id);
            $this->db->delete('users');

            $this->db->where('user_id', $id);
            $this->db->delete('cooks');
        }

        return true;
    }


    public function remove_from_restaurant($belong_id)
    {
        $belong_details = $this->db->get_where('cooks', ['id' => $belong_id])->row_array();
        $cook_details = $this->db->get_where('cooks', ['id' => $belong_details['user_id']])->row_array();
        $restaurant_ids = [];
        if ($this->logged_in_user_role == "owner") {
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            if (count($restaurant_ids) == 0) {
                return false;
            } else {
                if (in_array($belong_details['restaurant_id'], $restaurant_ids)) {
                    $this->db->delete('cooks', ['id' => $belong_id]);
                }
            }
        } else {
            $this->db->delete('cooks', ['id' => $belong_id]);
        }

        return true;
    }

    public function authentic($cook_id)
    {
        if ($this->logged_in_user_role == "owner") {
            $restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            $cook_details = $this->db->get_where('cooks', ['user_id' => $cook_id])->result_array();
            foreach ($cook_details as $cook_detail) {
                if (in_array($cook_detail['restaurant_id'], $restaurant_ids))
                    return true;
            }
            return false;
        } elseif ($this->logged_in_user_role == "admin") {
            return true;
        } else {
            return false;
        }
    }

    public function get_restaurant_ids_by_cook_id($cook_id)
    {
        $restaurants = $this->restaurants_he_belongs_to($cook_id);
        $restaurant_ids = array();
        foreach ($restaurants as $restaurant) {
            if (!in_array($restaurant['restaurant_id'], $restaurant_ids)) {
                array_push($restaurant_ids, $restaurant['restaurant_id']);
            }
        }

        return $restaurant_ids;
    }
}
