<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 31 - July - 2021
 * Author : TheDevs
 * Ingredient Controller controlls the Food Menu Ingredients
 */

include 'Authorization.php';

class Ingredient extends Authorization
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
        $page_data['restaurant_id'] = isset($_GET['restaurant_id']) ? sanitize($_GET['restaurant_id']) : "all";
        $page_data['page_name'] = 'ingredient/index';
        $page_data['page_title'] = get_phrase("menu_ingredient");
        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        if ($page_data['restaurant_id'] != "all") {
            $page_data['ingredients'] = $this->ingredient_model->get_ingredients($page_data['restaurant_id']);
        } else {
            $page_data['ingredients'] = $this->ingredient_model->get_ingredients();
        }
        $this->load->view('backend/index', $page_data);
    }

    // Create method is responsible for showing create view
    function create()
    {
        $page_data['page_name'] = 'ingredient/create';
        $page_data['page_title'] = get_phrase("create_new_ingredient");
        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        $this->load->view('backend/index', $page_data);
    }

    // Store method is responsible for storing data
    function store()
    {
        $response = $this->ingredient_model->store();
        if ($response) {
            success(get_phrase('ingredient_added_successfully'), site_url('ingredient'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('ingredient'));
        }
    }

    /**
     * EDIT VIEW FOR EDITING AN INGREDIENT
     *
     * @param int $name
     * @return void
     */
    function edit($id)
    {
        $page_data['ingredient'] = $this->ingredient_model->get_by_id($id);
        $page_data['page_name'] = 'ingredient/edit';
        $page_data['page_title'] = get_phrase("update_ingredient");
        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        $this->load->view('backend/index', $page_data);
    }

    // Update method is responsible for Updating the restaurant types
    function update()
    {
        $response = $this->ingredient_model->update();
        if ($response) {
            success(get_phrase('ingredient_updated_successfully'), site_url('ingredient'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('ingredient'));
        }
    }

    // Delete method is responsible for storing data
    function delete($id)
    {
        $response = $this->ingredient_model->delete($id);
        if ($response) {
            success(get_phrase('ingredient_deleted_successfully'), site_url('ingredient'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('ingredient'));
        }
    }

    /**
     * This function returns the view of ingredient report
     *
     * @return void
     */
    public function report()
    {
        $page_data['restaurant_id'] = isset($_GET['restaurant_id']) ? sanitize($_GET['restaurant_id']) : "all";

        if (isset($_GET['date_range']) && !empty($_GET['date_range'])) {
            $date_range                   = sanitize($this->input->get('date_range'));
            $date_range                   = explode(" - ", $date_range);
            $page_data['starting_timestamp'] = strtotime($date_range[0] . ' 00:00:01');
            $page_data['ending_timestamp']   = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $day = date('w');
            $starting_date = date('d M Y', strtotime('-' . $day . ' days')) . ' 00:00:01';
            $ending_date = date('d M Y', strtotime('+' . (6 - $day) . ' days')) . ' 23:59:59';
            $page_data['starting_timestamp']   = strtotime($starting_date);
            $page_data['ending_timestamp']     = strtotime($ending_date);
        }

        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();

        $page_data['page_name'] = 'ingredient/report';
        $page_data['page_title'] = get_phrase("ingredient_report");
        $page_data['reports'] = $this->ingredient_model->report();

        $this->load->view('backend/index', $page_data);
    }

    /**
     * THIS FUNCTION IS RESPONSIBLE FOR ADDING, EDITING OR DELETING INGREDIENTS FROM A MENU
     *
     * @param string $action
     * @param string $row_id
     * @return void
     */
    public function menu_ingredient($action = "", $row_id = "")
    {
        if ($action == "add") {
            $response = $this->ingredient_model->update_menu_ingredient();
        } elseif ($action == "edit") {
            $response = $this->ingredient_model->update_menu_ingredient("edit", $row_id);
        } elseif ($action == "delete") {
            $response = $this->ingredient_model->update_menu_ingredient("delete", $row_id);
        }

        $response = json_decode($response, true);
        if ($response['menu_id']) {
            $response['status'] ? success(get_phrase('ingredient_added_to_the_menu'), site_url("menu/edit/" . $response['menu_id'] . "/ingredients")) : error(get_phrase('ingredient_already_added_to_the_menu'), site_url("menu/edit/" . $response['menu_id'] . "/ingredients"));
        } else {
            error(get_phrase('you_are_not_authorized'), site_url("menu"));
        }
    }
}
