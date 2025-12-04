<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }



public function get_menus_by_category($category_id)
{
    $this->db->where('category_id', $category_id);
    return $this->db->get('food_menus')->result_array();
}

    
}