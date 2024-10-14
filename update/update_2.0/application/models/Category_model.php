<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 10 - June - 2020
 * Author : TheDevs
 * Category model handles all the database queries of Menu Categories
 */

class Category_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "food_categories";
    }

    /**
     * GET ALL CATEGORIES
     */
    public function get_all()
    {
        $this->db->order_by("id", "desc");
        return $this->db->get($this->table)->result_array();
    }

    /**
     * GET CATEGORIES BY ID
     */
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    /**
     * GET FEATURED CATEGORIES
     */
    public function get_featured_categories()
    {
        $this->db->where('is_featured', 1);
        return $this->db->get($this->table)->result_array();
    }

    /**
     * GET DATA BY A CONDITION ARRAY
     */
    public function get_by_condition($conditions = [])
    {
        foreach ($conditions as $key => $value) {
            if (!is_null($value)) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        return $this->db->get($this->table)->result_array();
    }

    /**
     * STORING DATA
     */
    public function store()
    {
        $data['name']  = required(sanitize($this->input->post('category_name')));
        $data['created_by'] = $this->logged_in_user_id;
        if (isset($_POST['is_featured'])) {
            if (count($this->get_featured_categories()) < 8) {
                $data['is_featured'] = 1;
            } else {
                $data['is_featured'] = 0;
            }
        } else {
            $data['is_featured'] = 0;
        }
        $data['created_at'] = strtotime(date('D, d-M-Y'));

        if (count($this->get_by_condition(['name' => $data['name']])) > 0) {
            error(get_phrase('this_category_is_already_registered'), site_url('category'));
        }
        $data['thumbnail']  = $this->upload('category', $_FILES['category_thumbnail']);
        $this->db->insert($this->table, $data);
        return true;
    }

    /**
     * UPDATING CATEGORY
     */
    public function update()
    {
        $id = required(sanitize($this->input->post('id')));
        $previous_data = $this->get_by_id($id);
        $data['name']  = required(sanitize($this->input->post('category_name')));
        if (isset($_POST['is_featured'])) {
            if (count($this->get_featured_categories()) < 8) {
                $data['is_featured'] = 1;
            } else {
                if ($previous_data['is_featured']) {
                    $data['is_featured'] = 1;
                } else {
                    $data['is_featured'] = 0;
                }
            }
        } else {
            $data['is_featured'] = 0;
        }
        $data['updated_at'] = strtotime(date('D, d-M-Y'));

        if (count($this->get_by_condition(['name' => $data['name'], 'id !=' => $id])) > 0) {
            error(get_phrase('this_category_is_already_registered'), site_url('category'));
        }

        if (!empty($_FILES['category_thumbnail']['name'])) {
            $data['thumbnail']  = $this->upload('category', $_FILES['category_thumbnail'], $previous_data["thumbnail"]);
        } else {
            $data['thumbnail']  = $previous_data["thumbnail"];
        }

        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return true;
    }

    /**
     * PUBLIC FUNCTION GET FOOD CATEGORIES ACCORDING TO RESTAURANT
     */
    public function get_categories_by_restaurant_id($restaurant_id)
    {
        // FIRST GET ALL THE CATEGORY ID AS NUMERIC ARRAY
        $this->db->distinct();
        $this->db->select('category_id');
        $this->db->where('restaurant_id', $restaurant_id);
        $categories_array = $this->db->get('food_menus')->result_array();
        $categories = array();
        foreach ($categories_array as $category) {
            array_push($categories, $category['category_id']);
        }

        // NOW GET THE ACTUAL CATEGORY DETAILS
        if (count($categories) > 0) {
            $this->db->where_in('id', $categories);
            return $this->db->get('food_categories')->result_array();
        }
        return array();
    }
}
