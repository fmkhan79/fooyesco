<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - June - 2020
 * Author : TheDevs
 * Category Controller controlls the Food Menu Categories of a restaurant
 */

include 'Authorization.php';

class Category extends Authorization
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
        $page_data['page_name'] = 'category/index';
        $page_data['page_title'] = get_phrase("menu_category");
        $page_data['categories'] = $this->category_model->get_all();
        $this->load->view('backend/index', $page_data);
    }

    // Create method is responsible for showing create view
    function create()
    {
        $page_data['page_name'] = 'category/create';
        $page_data['page_title'] = get_phrase("create_new_category");
        $this->load->view('backend/index', $page_data);
    }

    // Store method is responsible for storing data
    function store()
    {
        $response = $this->category_model->store();
        if ($response) {
            success(get_phrase('category_added_successfully'), site_url('category'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('category'));
        }
    }

    // Edit method is responsible for showing edit view
    function edit($id)
    {
        /** CHECK IF THE USER HAS ACCESS TO SEE THIS **/
        if (!has_access('food_categories', $id)) {
            error(get_phrase('you_are_not_authorized_for_this_action'), site_url('category'));
        }

        $page_data['category'] = $this->category_model->get_by_id($id);
        $page_data['page_name'] = 'category/edit';
        $page_data['page_title'] = get_phrase("update_category");
        $this->load->view('backend/index', $page_data);
    }

    // Update method is responsible for Updating the restaurant types
    function update()
    {
        /** CHECK IF THE USER HAS ACCESS TO SEE THIS **/
        if (!has_access('food_categories', sanitize($this->input->post('id')))) {
            error(get_phrase('you_are_not_authorized_for_this_action'), site_url('category'));
        }

        $response = $this->category_model->update();
        if ($response) {
            success(get_phrase('category_updated_successfully'), site_url('category'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('category'));
        }
    }

    // Delete method is responsible for storing data
    function delete($id)
    {
        /** CHECK IF THE USER HAS ACCESS TO SEE THIS **/
        if (!has_access('food_categories', $id)) {
            error(get_phrase('you_are_not_authorized_for_this_action'), site_url('category'));
        }

        $response = $this->category_model->delete($id);
        if ($response) {
            success(get_phrase('category_deleted_successfully'), site_url('category'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('category'));
        }
    }
}
