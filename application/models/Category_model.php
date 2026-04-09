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
        $this->db->order_by("id", "asc");
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
     * GET SUBCATEGORIES BY ID
     */
    public function get_sub_categories($id)
    {
        $this->db->where('category_id', $id);
        return $this->db->get("food_sub_category")->result_array();
    }

    /**
     * GET SUBCATEGORY BY ID
    */
    public function get_sub_category_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get("food_sub_category")->row_array();
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
     * STORING SUB CATEGORY DATA
     */
    public function store_sub_category()
    {
        $data['name']  = required(sanitize($this->input->post('category_name')));
        $data['description']  = required(sanitize($this->input->post('category_description')));
        $data['category_id']  = required(sanitize($this->input->post('category_id')));
        
        $data['created_at'] = strtotime(date('D, d-M-Y'));

        $this->db->insert("food_sub_category", $data);
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

    public function update_sub_category()
    {
    
        $id = required(sanitize($this->input->post('id')));
        $previous_data = $this->get_by_id($id);

        $data['name']  = required(sanitize($this->input->post('category_name')));
        $data['category_id']  = required(sanitize($this->input->post('category_id')));
        $data["description"]  = required(sanitize($this->input->post('category_description')));
        
        $data['updated_at'] = strtotime(date('D, d-M-Y'));

        if (count($this->get_by_condition(['name' => $data['name'], 'id !=' => $id])) > 0) {
            error(get_phrase('this_category_is_already_registered'), site_url('category'));
        }

        $this->db->where('id', $id);
        $this->db->update('food_sub_category', $data);
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
        
        $current_domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
        $isFooyes = (strpos($current_domain, 'fooyes') !== false);

        $categories_array = $this->db->get('food_menus');

        if($isFooyes)
        {
            $this->db->where_in('menu_for_standalone', [0, NULL]);
            
            $categories_array = $this->db->get('food_menus');
        }else{
            $this->db->where('menu_for_standalone', 1);
            $categories_array = $this->db->get('food_menus');
        }


        $categories = array();
        
        foreach ($categories_array->result_array() as $category) {
            array_push($categories, $category['category_id']);
        }
    
        // NOW GET THE ACTUAL CATEGORY DETAILS
        if (count($categories) > 0) {
            $this->db->where_in('id', $categories);
            return $this->db->get('food_categories')->result_array();
        }
        return array();
    }

    public function get_all_categories()
    {
        // FIRST GET ALL THE CATEGORY ID AS NUMERIC ARRAY
        $this->db->distinct();
        $this->db->select('category_id');
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

     public function delete_sub_category($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('food_sub_category');


        return true;
    }

}
