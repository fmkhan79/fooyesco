<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 27 - June - 2020
 * Author : TheDevs
 * Menu Controller controlls the Food Menu
 */

include 'Authorization.php';

class Pos extends Authorization
{
    /**
     * CONSTRUCTOR CHECKS IF REQUIRED USER IS LOGGED IN
     */
    // public function __construct()
    // {
    //     parent::__construct();
    //     authorization(['admin', 'owner'], true);
    // }

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
        $page_data['page_name'] = 'pos/index';
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
        $page_data['pos_type'] = 'list';

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

    public function pos_cart_items()
{
    $pos_id = $this->input->get('pos_id') ?? 1001;

    $items = $this->cart_model->get_all_by_pos($pos_id);

    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($items));
}


public function add_to_pos_cart()
{
    // Assign POS terminal ID here, e.g., via POST or hardcoded per terminal
    $data['customer_id'] = 1001;
        $data['servings'] = "menu";
        $data['menu_id'] = (int) $this->input->post('menuId');

        $quantity = (int) $this->input->post('quantity');
        $totalprice = (float) $this->input->post('totalprice');

        $data['quantity'] = $quantity;
        $data['price'] = $totalprice * $quantity;

        $data['variant_id'] = $this->input->post('variantId');
        $data['addons'] = $this->input->post('addons');
        $data['options_1'] = $this->input->post('options_1');
        $data['options_2'] = $this->input->post('options_2');
        $data['note'] = "";

    $menu_details = $this->menu_model->get_menu_by_condition(['id' => $data['menu_id'], 'availability' => 1]);
    $data['restaurant_id'] = $menu_details[0]['restaurant_id'];

    $this->db->insert("cart", $data);

    echo "success";
}

public function update_cart()
{
    $data = json_decode(file_get_contents("php://input"), true);

    $cart_id  = $data["cart_id"] ?? null;
    $quantity = $data["quantity"] ?? null;
    $price    = $data["price"] ?? null;

    if (!$cart_id || !$quantity) {
        echo "Missing required data";
        return;
    }

    // Update in model
    $result = $this->cart_model->update_cart_pos($cart_id, $quantity, $price);

    echo $result ? "success" : "error";
}

  public function order_placing_mail($order_code)
    {

        $this->cart_model->order_placing_mail_pos($order_code);
        // $this->session->sess_destroy();
    }



public function item_delete($id)
    {

        $response = $this->cart_model->delete($id);
        if ($response) {
            success(get_phrase('item_deleted_successfully'), site_url('cart'));
        } else {
            error(get_phrase('an_error_occurred'), site_url('cart'));
        }
    }

public function cash_on_delivery()
{
    // $payment_method = $this->input->post('pay_with'); // "cash"
    // print_r($payment_method . "vada");
    // die();
        $pos_customer_id = 1001;
        $cart_items = $this->cart_model->get_all_by_pos($pos_customer_id);
      
     if (empty($cart_items)) {
    return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['success' => false, 'message' => 'Cart is empty']));
}   

    // Call a new POS-specific confirm
    $order_code = $this->order_model->confirm_pos_order($pos_customer_id);
       return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['success' => true, 'order_code' => $order_code]));
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
    public function selected_cat_items($maincatid, $option = null)
{
    $data["option"] = $option;
    $data["maincatid"] = $maincatid;

    $this->load->view("frontend/default/menu/pos_sub_catagories_and_items.php", $data);

}


    public function image_remove()
{
    $menu_id = required(sanitize($this->input->get('id')));
    
    // Check menu authenticity
    $authenticity = $this->menu_model->authentication($menu_id);
    if (!$authenticity) {
        error(get_phrase('you_are_not_authorized'), site_url('menu'));
    }

    $result = $this->menu_model->remove_thumbnail($menu_id);

    if ($result) {
        success(get_phrase('image_removed_successfully'), site_url('menu/edit/' . $menu_id . '/gallery'));
    } else {
        error(get_phrase('something_went_wrong'), site_url('menu/edit/' . $menu_id . '/gallery'));
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
    public function category($category_id)
{
    $this->load->model('Pos_model');
    $this->load->model('Category_model');

    // Get category info
    $page_data['category'] = $this->Category_model->get_by_id($category_id);

    // Get menus under this category
    $page_data['menus'] = $this->Pos_model->get_menus_by_category($category_id);
    $page_data['page_name'] = 'pos/index';
    $page_data['pos_type'] = 'category_view';
      $this->load->view('backend/index', $page_data);
}


}
