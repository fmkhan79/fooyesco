<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 2 - April - 2020
 * Author : TheDevs
 * Variation Controller controlls the task for menu variations
 */

include 'Base.php';
class Variation extends Base
{
    //Controlling menu options
    public function option($action, $option_id = null)
    {
        authorization(['owner', 'admin'], true);

        if ($action == "delete") {
            $menu_options = $this->variation_model->get_options_by_id($option_id);
            $menu_id = $menu_options['menu_id'];
            $response = $this->variation_model->delete_options($option_id);
        } else {
            $menu_id = required(sanitize($this->input->post('menu_id')));
            $response = $this->variation_model->save_options($action);
        }
        $message = ($action == "delete") ? get_phrase("data_has_been_deleted_successfully") : get_phrase('data_has_been_saved_successfully');
        if (!$response) {
            error(get_phrase('some_error_occurred'), site_url('menu/edit/' . $menu_id . '/variation'));
        }
        success($message, site_url('menu/edit/' . $menu_id . '/variation'));
    }


    function create_vartiation_item()
    {
        $response = $this->variation_model->save_item();
        echo $response;
    }


    function delete_vartiation_item()
    {
        $response = $this->variation_model->delete_item();
        echo $response;
    }


    function duplicate_vartiation_item()
    {
        
        $response = $this->variation_model->duplicate_sub_variant();
        $id = required(sanitize($this->input->post('menu_id')));
        $page_data['menu_data'] = $this->menu_model->get_by_id($id);
        $this->load->view('backend/admin/variant/list.php', $page_data);

    }


    function udpate_vartiation_item()
    {
        $response = $this->variation_model->update_item();
        echo $response;
    }


    function update_sub_vartiation()
    {
        $response = $this->variation_model->update_sub_variant();
        echo $response;
    }

    function delete_sub_vartiation()
    {
        $response = $this->variation_model->delete_sub_variant();
        echo $response;
    }

    


    function create_sub_vartiation()
    {
        $response = $this->variation_model->save_sub_variant();
        echo $response;
    }
    // TOGGLE MENU VARIATION FLAG
    public function toggle_menu_variant()
    {
        $response = $this->variation_model->toggle_menu_variant();
        echo $response;
    }

    //Controlling menu variants
    public function variant($action, $variant_id = null)
    {
        authorization(['owner', 'admin'], true);

        if ($action == "delete") {
            $menu_variant = $this->variation_model->get_variant_by_id($variant_id);
            $menu_id = $menu_variant['menu_id'];
            $response = $this->variation_model->delete_variant($variant_id);
        } else {
            $menu_id = required(sanitize($this->input->post('menu_id')));
            $response = $this->variation_model->save_variant($action);
        }
        $message = ($action == "delete") ? get_phrase("menu_variant_has_been_deleted_successfully") : get_phrase('menu_variant_has_been_saved_successfully');
        if (!$response) {
            error(get_phrase('some_error_occurred'), site_url('menu/edit/' . $menu_id . '/variation'));
        }
        success($message, site_url('menu/edit/' . $menu_id . '/variation'));
    }
}

/* End of file Orders.php */