<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 3 - April - 2021
 * Author : TheDevs
 * Addons Controller controlls the task for addon menu
 */

include 'Authorization.php';
class Addon extends Authorization
{
    //Controlling menu addons
    public function addons($action, $addon_id = null)
    {
        authorization(['owner', 'admin'], true);

        if ($action == "delete") {
            $addons = $this->addon_model->get_addon_by_id($addon_id);
            $menu_id = $addons['menu_id'];
            $response = $this->addon_model->delete_addon($addon_id);
        } else {
            $menu_id = required(sanitize($this->input->post('menu_id')));
            $response = $this->addon_model->save_addon($action);
        }
        $message = ($action == "delete") ? get_phrase("addon_has_been_deleted_successfully") : get_phrase('addon_has_been_saved_successfully');
        if (!$response) {
            error(get_phrase('some_error_occurred'), site_url('menu/edit/' . $menu_id . '/addons'));
        }
        success($message, site_url('menu/edit/' . $menu_id . '/addons'));
    }

    //Controlling menu variants
    public function variant($action, $variant_id = null)
    {
        authorization(['owner', 'admin'], true);

        if ($action == "delete") {
            $menu_variant = $this->addon_model->get_variant_by_id($variant_id);
            $menu_id = $menu_variant['menu_id'];
            $response = $this->addon_model->delete_variant($variant_id);
        } else {
            $menu_id = required(sanitize($this->input->post('menu_id')));
            $response = $this->addon_model->save_variant($action);
        }
        $message = ($action == "delete") ? get_phrase("menu_variant_has_been_deleted_successfully") : get_phrase('menu_variant_has_been_saved_successfully');
        if (!$response) {
            error(get_phrase('some_error_occurred'), site_url('menu/edit/' . $menu_id . '/addons'));
        }
        success($message, site_url('menu/edit/' . $menu_id . '/addons'));
    }
}

/* End of file Orders.php */