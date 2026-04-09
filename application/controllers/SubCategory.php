<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - June - 2020
 * Author : TheDevs
 * Category Controller controlls the Food Menu Categories of a restaurant
 */

include 'Authorization.php';

class SubCategory extends Authorization
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
    function edit($id)
    {
        /** CHECK IF THE USER HAS ACCESS TO SEE THIS **/
        if (!has_access('food_categories', $id)) {
            error(get_phrase('you_are_not_authorized_for_this_action'), site_url('category'));
        }

        $page_data['subcategory'] = $this->category_model->get_sub_category_by_id($id);
        
        $page_data['categories'] = $this->category_model->get_all();
        
        $page_data['page_name'] = 'subcategory/edit';
        $page_data['page_title'] = "Update Sub Category";

        $this->load->view('backend/index', $page_data);
    }

    function update()
    {
        /** CHECK IF THE USER HAS ACCESS TO SEE THIS **/
        if (!has_access('food_categories', sanitize($this->input->post('id')))) {
            error(get_phrase('you_are_not_authorized_for_this_action'), site_url('category'));
        }

        $response = $this->category_model->update_sub_category();
        if ($response) {
            success("Sub Category Updated Successfully", site_url('subcategory/edit/'.sanitize($this->input->post('id'))));
        } else {
            error(get_phrase('an_error_occurred'), site_url('category'));
        }
    }

    function delete($id, $category_id)
    {
        /** CHECK IF THE USER HAS ACCESS TO SEE THIS **/
        if (!has_access('food_categories', $id)) {
            error(get_phrase('you_are_not_authorized_for_this_action'), site_url('category'));
        }

        $response = $this->category_model->delete_sub_category($id);
        if ($response) {
            success("Sub Category Deleted Successfully",  site_url('category/edit/'.sanitize($category_id)));
        } else {
            error(get_phrase('an_error_occurred'), site_url('category'));
        }
    }

    // Create method is responsible for showing create view
    function create($id)
    {
        $page_data['page_name'] = 'subcategory/create';
        $page_data['page_title'] = "Create New Sub Category";
        $page_data['categories'] = $this->category_model->get_all();
        $page_data['category_id'] = $id;    
        $this->load->view('backend/index', $page_data);
    }

    function store()
    {
        $response = $this->category_model->store_sub_category();
        if ($response) {
            success(get_phrase('category_added_successfully'), site_url('category/edit/'.sanitize($this->input->post('category_id'))));
        } else {
            error(get_phrase('an_error_occurred'), site_url('category'));
        }
    }

}
