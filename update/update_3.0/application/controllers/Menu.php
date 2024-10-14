<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 27 - June - 2020
 * Author : TheDevs
 * Menu Controller controlls the Food Menu
 */

include 'Authorization.php';

class Menu extends Authorization
{
    /**
     * CONSTRUCTOR CHECKS IF REQUIRED USER IS LOGGED IN
     */
    public function __construct()
    {
        parent::__construct();
        authorization(['admin', 'owner'], true);
    }

    // index function is responsible for showing the index page.
    function index()
    {
        /** CHECK IF THE USER HAS ACCESS TO SEE THIS **/
        if (isset($_GET['restaurant_id']) && $_GET['restaurant_id'] != "all") {
            if (!has_access('restaurants', $_GET['restaurant_id'])) {
                error(get_phrase('you_are_not_authorized_for_this_action'), site_url('menu'));
            }
        }

        $page_data['restaurant_id'] = isset($_GET['restaurant_id']) ? sanitize($_GET['restaurant_id']) : "all";
        $page_data['category_id']   = isset($_GET['category_id']) ? sanitize($_GET['category_id']) : "all";
        $page_data['page_name'] = 'menu/index';
        $page_data['page_title'] = get_phrase('food_menu');
        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        $page_data['categories']  = $this->category_model->get_all();

        if ($this->logged_in_user_role == "admin") {
            $conditions = array(
                'restaurant_id' => $page_data['restaurant_id'] == "all" ? null : $page_data['restaurant_id'],
                'category_id' => $page_data['category_id'] == "all" ? null : $page_data['category_id']
            );
        } else {
            $approved_restaurant_ids = $this->restaurant_model->get_approved_restaurant_ids_by_owner_id($this->logged_in_user_id);
            $approved_restaurant_ids = count($approved_restaurant_ids) > 0 ? $approved_restaurant_ids : [null];
            $conditions = array(
                'restaurant_id' => $page_data['restaurant_id'] == "all" ? $approved_restaurant_ids : $page_data['restaurant_id'],
                'category_id' => $page_data['category_id'] == "all" ? null : $page_data['category_id']
            );
        }


        /**PAGINATION STARTS**/
        $menus = $this->menu_model->get_menu_by_condition($conditions);
        $total_rows = count($menus);
        $page_size = 12;
        $config = pagintaion($total_rows, $page_size, site_url('menu/index'));
        $current_page = sanitize($this->input->get('page', 0));
        $this->pagination->initialize($config);
        /**PAGINATION ENDS**/

        $page_data['menus'] =  $this->menu_model->merger($this->menu_model->paginate($page_size, $current_page, $conditions));
        $this->load->view('backend/index', $page_data);
    }

    // Create function is responsible for showing the menu creation page.
    function create()
    {
        $page_data['page_name'] = 'menu/create';
        $page_data['page_title'] = get_phrase('create_new_menu');
        $page_data['categories'] = $this->category_model->get_all();
        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        $this->load->view('backend/index', $page_data);
    }

    // Edit function is responsible for showing the menu edit page.
    function edit($id, $active_tab = 'basic')
    {
        // CHECK MENU AUTHENTICITY
        $authenticity = $this->menu_model->authentication($id);
        if (!$authenticity) {
            error(get_phrase('your_are_not_authorized'), site_url('menu'));
        }

        $page_data['restaurants'] = $this->restaurant_model->get_all_approved();
        $page_data['categories']  = $this->category_model->get_all();
        $page_data['id'] = $id;
        $page_data['active_tab'] = $active_tab;
        $page_data['menu_data'] = $this->menu_model->get_by_id($id);
        $page_data['page_name'] = 'menu/edit';
        $page_data['page_title'] = $page_data['menu_data']['name'];
        $this->load->view('backend/index', $page_data);
    }

    // store function is responsible for storing the menu data.
    function store()
    {
        $response = $this->menu_model->store();
        if ($response) {
            success(get_phrase('menu_added_successfully'), site_url('menu'));
        }
    }

    // Update function is responsible for updating the menu data.
    function update()
    {
        // CHECK MENU AUTHENTICITY
        $menu_id = required(sanitize($this->input->post('id')));
        $active_tab = required(sanitize($this->input->post('type')));
        $authenticity = $this->menu_model->authentication($menu_id);
        if (!$authenticity) {
            error(get_phrase('your_are_not_authorized'), site_url('menu'));
        }

        $response = $this->menu_model->update();
        if ($response) {
            success(get_phrase('menu_updated_successfully'), site_url('menu/edit/' . $menu_id . '/' . $active_tab));
        }
    }

    // Delete function is responsible for deleting the menu data.
    function delete($id)
    {
        // CHECK MENU AUTHENTICITY
        $authenticity = $this->menu_model->authentication($id);
        if (!$authenticity) {
            error(get_phrase('your_are_not_authorized'), site_url('menu'));
        }

        $response = $this->menu_model->delete($id);
        if ($response) {
            success(get_phrase('menu_delete_successfully'), site_url('menu'));
        }
    }

    /**
     * SHOW MENU REPORT
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

        $page_data['page_name'] = 'menu/report';
        $page_data['page_title'] = get_phrase("menu_report");
        $page_data['reports'] = $this->menu_model->report();
        $this->load->view('backend/index', $page_data);
    }
}
