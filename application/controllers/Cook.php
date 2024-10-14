<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 09 - July - 2020
 * Author : TheDevs
 * Cook Controller controlls the The Cooks
 */

include 'Authorization.php';

class Cook extends Authorization
{
    /**
     * CONSTRUCTOR CHECKS IF REQUIRED USER IS LOGGED IN
     */
    public function __construct()
    {
        parent::__construct();
        authorization(['admin', 'owner'], true);
    }

    // index function responsible for showing the index page.
    function index()
    {
        $page_data['status'] = isset($_GET['status']) ? sanitize($_GET['status']) : "approved";
        $page_data['page_name'] = 'cook/index';
        $page_data['page_title'] = get_phrase("cooks");

        /**PAGINATION STARTS**/
        $cooks = ($page_data['status'] == 'approved') ? $this->cook_model->get_approved_cooks() : $this->cook_model->get_pending_cooks();
        $total_rows = count($cooks);
        $page_size = 12;
        $config = pagintaion($total_rows, $page_size, site_url('cook'));
        $current_page = sanitize($this->input->get('page', 0));
        $this->pagination->initialize($config);
        $page_data['cooks'] = $this->cook_model->paginate_cooks($page_size, $current_page);
        /**PAGINATION ENDS**/

        $this->load->view('backend/index', $page_data);
    }

    // create function is responsible for showing cook adding view
    function create()
    {
        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        $page_data['page_name'] = 'cook/create';
        $page_data['page_title'] = get_phrase("register_new_cook");
        $page_data['cooks'] = $this->cook_model->get_approved_cooks();
        $this->load->view('backend/index', $page_data);
    }

    // store function is responsible for storing cook's data
    function store()
    {
        $response = $this->cook_model->store_cook();
        if ($response) {
            success(get_phrase('cook_added_successfully'), site_url('cook'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('cook'));
        }
    }

    // Update function is responsible for updating the profile data of a cook
    function update()
    {
        $response = $this->cook_model->update_cook();
        if ($response) {
            success(get_phrase('cook_updated_successfully'), site_url('cook'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('cook'));
        }
    }

    // Delete function is responsible for deleting the profile data of a cook
    function delete($id)
    {
        $response = $this->cook_model->delete_cook($id);
        if ($response) {
            success(get_phrase('cook_deleted_successfully'), site_url('cook'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('cook'));
        }
    }

    // profile function is responsible for showing the profile page of a cook
    function profile($id)
    {
        $page_data['page_name'] = 'cook/profile';
        $page_data['page_title'] = get_phrase("cook_edit_profile");
        $page_data['cook'] = $this->cook_model->get_by_id($id);
        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        $this->load->view('backend/index', $page_data);
    }

    // REMOVING A cook FROM THE RESTAURANT
    public function remove_from_restaurant($belong_id)
    {
        $response = $this->cook_model->remove_from_restaurant($belong_id);
        if ($response) {
            success(get_phrase('cook_removed_successfully'), site_url('cook'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('cook'));
        }
    }
}

/* End of file cook.php */
