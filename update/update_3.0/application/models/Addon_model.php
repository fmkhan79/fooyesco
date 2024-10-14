<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 3 - April - 2021
 * Author : TheDevs
 * Addons model handles all the database queries of menu addon
 */

class Addon_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     *  CREATE OR UPDATE ADDON MENU
     */

    public function save_addon($action)
    {
        $data['menu_id'] = required(sanitize($this->input->post('menu_id')));
        $data['name'] = required(sanitize($this->input->post('addon_name')));
        $data['price'] = required(sanitize($this->input->post('addon_price')));

        if ($this->menu_model->authentication($data['menu_id'])) {
            if ($action == "create") {
                $this->db->insert('addons', $data);
                return true;
            } else {
                $addon_id = required(sanitize($this->input->post('addon_id')));
                $this->db->where('id', $addon_id);
                $this->db->update('addons', $data);
                return true;
            }
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     * DELETE MENU addonS
     */

    public function delete_addon($menu_addon_id)
    {
        $menu_addons = $this->db->get_where('addons', ['id' => $menu_addon_id])->row_array();
        if ($this->menu_model->authentication($menu_addons['menu_id'])) {
            $this->db->where('id', $menu_addon_id);
            $this->db->delete('addons');
            return true;
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }

    /**
     *  GET menu addonS
     */

    public function get_addons($menu_id)
    {
        $menu_addons = $this->db->get_where('addons', ['menu_id' => $menu_id])->result_array();
        return $menu_addons;
    }

    /**
     *  GET menu addonS BY ID
     */

    public function get_addon_by_id($id)
    {
        $menu_addons = $this->db->get_where('addons', ['id' => $id])->row_array();
        if ($this->menu_model->authentication($menu_addons['menu_id'])) {
            return $menu_addons;
        } else {
            error(get_phrase("you_are_not_authorized"), site_url('menu'));
        }
    }
}
