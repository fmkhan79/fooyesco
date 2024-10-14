<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 23 - August - 2020
 * Author : TheDevs
 * Variation model handles all the database queries of menu variation
 */

class Variation_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     *  CREATE OR UPDATE VARIATION OPTIONS
     */

    public function save_options($action)
    {
        $data['menu_id'] = required(sanitize($this->input->post('menu_id')));
        $data['name'] = required(sanitize($this->input->post('name')));
        $data['options'] = required(trim(strtolower(str_replace('-', ' ', sanitize($this->input->post('options'))))));

        if ($this->menu_model->authentication($data['menu_id'])) {
            if ($action == "create") {
                $this->db->insert('variant_options', $data);
                return true;
            } else {
                $menu_option_id = required(sanitize($this->input->post('menu_option_id')));
                $this->db->where('id', $menu_option_id);
                $this->db->update('variant_options', $data);
                return true;
            }
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     * DELETE MENU OPTIONS
     */

    public function delete_options($menu_option_id)
    {
        $menu_options = $this->db->get_where('variant_options', ['id' => $menu_option_id])->row_array();
        if ($this->menu_model->authentication($menu_options['menu_id'])) {
            $this->db->where('id', $menu_option_id);
            $this->db->delete('variant_options');
            return true;
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     *  GET VARIATION OPTIONS
     */

    public function get_options($menu_id)
    {
        $menu_options = $this->db->get_where('variant_options', ['menu_id' => $menu_id])->result_array();
        return $menu_options;
    }

    /**
     *  GET VARIATION OPTIONS BY ID
     */

    public function get_options_by_id($id)
    {
        $menu_options = $this->db->get_where('variant_options', ['id' => $id])->row_array();
        if ($this->menu_model->authentication($menu_options['menu_id'])) {
            return $menu_options;
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     * THIS FUNCTION TOGGLES FLAG OF MENU VARIANT FIELD
     */
    public function toggle_menu_variant()
    {
        $menu_id = required(sanitize($this->input->post('menu_id')));
        $has_variant = required(sanitize($this->input->post('has_variant')));
        if ($this->menu_model->authentication($menu_id)) {
            $this->db->where('id', $menu_id);
            $this->db->update('food_menus', ['has_variant' => $has_variant]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * THIS FUNCTION GETS ALL THE MENU VARIANTS
     */
    public function get_variants($menu_id)
    {
        $variants = $this->db->get_where('variants', ['menu_id' => $menu_id])->result_array();
        if ($this->menu_model->authentication($menu_id)) {
            return $variants;
        } else {
            return array();
        }
    }

    /**
     *  CREATE OR UPDATE VARIATION
     */

    public function save_variant($action)
    {
        $data['menu_id'] = required(sanitize($this->input->post('menu_id')));
        $data['price'] = required(sanitize($this->input->post('variant_price')));
        $variants = $this->input->post('menu_variation_options');
        $variants = array_map('strtolower', $variants);
        sort($variants);
        $data['variant'] = required(trim(sanitize(implode(",", $variants))));
        
        if ($this->menu_model->authentication($data['menu_id'])) {
            if ($action == "create") {
                $previous_data = $this->db->get_where('variants', array('menu_id' => $data['menu_id'], 'variant' => $data['variant']));
                if ($previous_data->num_rows() == 0) {
                    $this->db->insert('variants', $data);
                } else {
                    $previous_data = $previous_data->row_array();
                    $menu_variant_id = $previous_data['id'];
                    $this->db->where('id', $menu_variant_id);
                    $this->db->update('variants', $data);
                }

                return true;
            } else {
                $previous_data = $this->db->get_where('variants', array('menu_id' => $data['menu_id'], 'variant' => $data['variant']));
                if ($previous_data->num_rows() == 0) {
                    $menu_variant_id = required(sanitize($this->input->post('menu_variant_id')));
                    $this->db->where('id', $menu_variant_id);
                    $this->db->update('variants', $data);
                } else {
                    $previous_data = $previous_data->row_array();
                    $menu_variant_id = $previous_data['id'];
                    $this->db->where('id', $menu_variant_id);
                    $this->db->update('variants', $data);
                }
                return true;
            }
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     * DELETE MENU VARIANT
     */

    public function delete_variant($menu_variant_id)
    {
        $menu_variants = $this->db->get_where('variants', ['id' => $menu_variant_id])->row_array();
        if ($this->menu_model->authentication($menu_variants['menu_id'])) {
            $this->db->where('id', $menu_variant_id);
            $this->db->delete('variants');
            return true;
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     *  GET VARIATION BY ID
     */

    public function get_variant_by_id($id)
    {
        $menu_variant = $this->db->get_where('variants', ['id' => $id])->row_array();
        if ($this->menu_model->authentication($menu_variant['menu_id'])) {
            return $menu_variant;
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }
}
