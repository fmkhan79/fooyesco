<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - July - 2020
 * Author : TheDevs
 * Cart model handles all the database queries of Cart
 */

class Cart_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "cart";
    }

    /**
     * ADDING TO CART METHOD
     */
    function add_menu_to_cart(){

             // CHECK IF THE USER IS LOGGED IN, IF NOT THEN ASSIGN A RANDOM NUMBER AS USER ID
        if (!$this->logged_in_user_id || empty($this->logged_in_user_id)) {
            // $this->session->set_userdata('user_id', rand(9999, 99999));
            //Session user id 
            $this->customer_model->insert_guest_user();
            //Get session user_id 
            $data['customer_id'] = $this->session->userdata('user_id');
            
            $this->logged_in_user_id = $data['customer_id'];
        } else {
            $data['customer_id'] = $this->logged_in_user_id;
        }


        $data['servings'] = "menu"; // STATIC VALUE
        $data['note'] = sanitize($this->input->post('note'));
        $data['menu_id'] = required(sanitize($this->input->post('menuId')));                                                                
        $data['quantity'] = sanitize($this->input->post('quantity')) > 0 ? sanitize($this->input->post('quantity')) : 1;


        $menu_details = $this->menu_model->get_menu_by_condition(['id' => $data['menu_id'], 'availability' => 1]);
        $menu_details = $menu_details[0];
        $data['restaurant_id'] = $menu_details['restaurant_id'];




        if (!($menu_details['has_variant'])) {
            return "has_variant";
            exit;

            //   need to update as per new flow 


            // $data['variant_id'] = sanitize($this->input->post('variantId'));
            // $variant_details = $this->db->get_where('variants', ['id' => $data['variant_id']]);
            // if ($variant_details->num_rows() > 0) {
            //     $variant_details = $variant_details->row_array();
            //     $price = $data['quantity'] * $variant_details['price'];
            //     $data['price'] = $price;
            // }


        } else {
            return "no has_variant";
            exit;
            $price = $data['quantity'] * get_menu_price($data['menu_id']);
            $data['price'] = $price;
        }

        // addons case need to address hear


        $previous_data = $this->db->get_where($this->table, ['customer_id' => $data['customer_id'], 'menu_id' => $data['menu_id']]);
        if ($previous_data->num_rows() == 0 && count($menu_details) > 0) {
            $this->db->insert($this->table, $data);
        } elseif ($previous_data->num_rows() > 0 && count($menu_details) > 0) {
            $previous_data = $previous_data->row_array();
            $this->db->where('id', $previous_data['id']);
            $this->db->update($this->table, $data);
        }
        return true;

    }
    
    
    
    
    /**
     * ADDING TO CART METHOD
     */
    function add_to_cart()
    {


        // CHECK IF THE USER IS LOGGED IN, IF NOT THEN ASSIGN A RANDOM NUMBER AS USER ID
        if (!$this->logged_in_user_id || empty($this->logged_in_user_id)) {
            // $this->session->set_userdata('user_id', rand(9999, 99999));
            $this->customer_model->insert_guest_customer(array());
            // $user_id = $this->get_customer_id_from_user_id($user_id);
            //Get session user_id 
            // $data['customer_id'] = $this->customer_model->get_customer_id_from_user_id($this->session->userdata('user_id'));
            $data['customer_id'] = $this->session->userdata('user_id');
            // echo "created";
            $this->logged_in_user_id = $data['customer_id'];
        } else {
            // $data['customer_id'] = $this->customer_model->get_customer_id_from_user_id($this->logged_in_user_id);
            $data['customer_id'] = $this->logged_in_user_id;
        }
        
        // print_r($data['customer_id'] . "<br>");

        $data['servings'] = "menu"; // STATIC VALUE
        $data['note'] = sanitize($this->input->post('note'));
        $data['menu_id'] = required(sanitize($this->input->post('menuId')));
        $data['options_1'] = $this->input->post('options_1');
        $data['options_2'] = $this->input->post('options_2');
        $totalprice = required(sanitize($this->input->post('totalprice')));

        $data['quantity'] = sanitize($this->input->post('quantity')) > 0 ? sanitize($this->input->post('quantity')) : 1;

        $menu_details = $this->menu_model->get_menu_by_condition(['id' => $data['menu_id'], 'availability' => 1]);
        $menu_details = $menu_details[0];
        $data['restaurant_id'] = $menu_details['restaurant_id'];

        // CHECK MULTI RESTAURANT ORDER PERMISSION
        if (!get_order_settings('multi_restaurant_order')) {
            $get_current_items = $this->db->get_where($this->table, ['customer_id' => $data['customer_id']]);
            if ($get_current_items->num_rows()) {
                foreach ($get_current_items->result_array() as $current_item) {
                    if ($current_item['restaurant_id'] != $data['restaurant_id']) {
                        return false;
                    }
                }
            }
        }

        // if (!($menu_details['has_variant'])) {
        //     $data['variant_id'] = sanitize($this->input->post('variantId'));
        //     $variant_details = $this->db->get_where('variants', ['id' => $data['variant_id']]);
        //     if ($variant_details->num_rows() > 0) {
        //         $variant_details = $variant_details->row_array();
        //         $price = $data['quantity'] * $variant_details['price'];
        //         $data['price'] = $price;
        //     }
        // } else {
        //     $price = $data['quantity'] * get_menu_price($data['menu_id']);
        //     $data['price'] = $price;
        // }

        // if (isset($_POST['addons']) && !empty($_POST['addons'])) {
        //     $total_addon_price = 0;
        //     $selected_addons = explode(',', $this->input->post('addons'));
        //     foreach ($selected_addons as $selected_addon) {
        //         $selected_addon_details = $this->db->get_where('addons', ['id' => $selected_addon])->row_array();
        //         $total_addon_price += $selected_addon_details['price'];
        //     }

        //     $data['addons'] = implode(",", $selected_addons);
        //     $data['price'] = $data['price'] + $total_addon_price;
        // }

        $price = $data['quantity'] * $totalprice;
            $data['price'] = $price;

        //CHECK MENU ID VALIDITY

        $previous_data = $this->db->get_where($this->table, ['customer_id' => $data['customer_id'], 'menu_id' => $data['menu_id']]);
        // if ($previous_data->num_rows() == 0 && count($menu_details) > 0) {
            $this->db->insert($this->table, $data);
        // } elseif ($previous_data->num_rows() > 0 && count($menu_details) > 0) {
        //     $previous_data = $previous_data->row_array();
        //     $this->db->where('id', $previous_data['id']);
        //     $this->db->update($this->table, $data);
        // }
        return true;
    }

    /**
     * UPDATE CART ITEM METHOD
     */
    function update_cart()
    {
        $cart_id = required(sanitize($this->input->post('cartId')));
        $data['quantity'] = sanitize($this->input->post('quantity')) > 0 ? sanitize($this->input->post('quantity')) : 1;
        $cart_detail = $this->db->get_where('cart', ['id' => $cart_id])->row_array();
        if ($cart_detail['variant_id'] > 0) {
            $variant_details = $this->db->get_where('variants', ['id' => $cart_detail['variant_id']])->row_array();
            $unit_price = $variant_details['price'];
        } else {
            $menu_details = $this->db->get_where('food_menus', ['id' => $cart_detail['menu_id']])->row_array();
            $unit_price = get_menu_price($menu_details['id']);
        }

        $price = $unit_price * $data['quantity'];

        if (isset($cart_detail['addons']) && !empty($cart_detail['addons'])) {
            $total_addon_price = 0;
            $selected_addons = explode(',', $cart_detail['addons']);
            foreach ($selected_addons as $selected_addon) {
                $selected_addon_details = $this->db->get_where('addons', ['id' => $selected_addon])->row_array();
                $total_addon_price += $selected_addon_details['price'];
            }

            $price = $price + $total_addon_price;
        }

        $data['price'] = $price;

        $this->db->where('id', $cart_id);
        $this->db->update('cart', $data);

        return currency($data['price']);
    }

    /**
     * RETURN THE TOTAL NUMBER OF CART ITEMS
     */
    function total_cart_items()
    {
        $data['customer_id'] = $this->session->userdata('user_id');
        return $this->db->get_where($this->table, $data)->num_rows();
    }

    /**
     * RETURN ALL THE CART ITEMS
     */
    public function get_all() {
        $data['customer_id'] = $this->logged_in_user_id; // Assuming this is set in the mode
        $obj = $this->db->get_where($this->table, $data);
        return $this->merger($obj); // Process the result through the merger method
    }
    /**
     * RETURN A SINGLE CART ITEM
     */
    function get_by_id($id)
    {
        $data['id'] = $id;
        $obj = $this->db->get_where($this->table, $data);
        return $this->merger($obj, true);
    }

    /**
     * RETURN RESULT ARRAY CONDITION WISE
     */
    function get_cart_by_condition($conditions = [])
    {
        foreach ($conditions as $key => $value) {
            if (!is_null($value)) {
                if (is_array($value)) {
                    $this->db->where_in($key, $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }

        $menus = $this->db->get($this->table);
        return $this->merger($menus);
    }

    /**
     * MERGER FUNCTION IS FOR MERGING NECESSARY DATA
     */
    public function merger($query_obj, $is_single_row = false)
    {
        if (!$is_single_row) {
            $cart_items = $query_obj->result_array();
            foreach ($cart_items as $key => $cart_item) {
                $menu_data = $this->menu_model->get_by_id($cart_item['menu_id']);
                $restaurant_data = $this->restaurant_model->get_by_id($cart_item['restaurant_id']);
                
                $cart_items[$key]['menu_name']  = $menu_data['name'];
                $cart_items[$key]['menu_thumbnail']  = $menu_data['thumbnail'];
                $cart_items[$key]['restaurant_name']  = $restaurant_data['name'];
                $cart_items[$key]['delivery_charge']  = delivery_charge($restaurant_data['id']);
                $cart_items[$key]['options_1_details'] = $this->get_options_details(json_decode($cart_item['options_1'], true));
                $cart_items[$key]['options_2_details'] = $this->get_options_details(json_decode($cart_item['options_2'], true));
            }
            return $cart_items;
        } else {
            $cart_item = $query_obj->row_array();
            $menu_data = $this->menu_model->get_by_id($cart_item['menu_id']);
            $restaurant_data = $this->restaurant_model->get_by_id($cart_item['restaurant_id']);
            $cart_item['menu_name']  = $menu_data['name'];
            $cart_item['menu_thumbnail']  = $menu_data['thumbnail'];
            $cart_item['restaurant_name']  = $restaurant_data['name'];
            $cart_item['delivery_charge']  = delivery_charge($restaurant_data['id']);
            $cart_item['options_1_details'] = $this->get_options_details(json_decode($cart_item['options_1'], true));
            $cart_item['options_2_details'] = $this->get_options_details(json_decode($cart_item['options_2'], true));
            return $cart_item;
        }
    }
    
    private function get_options_details($options)
{
    $details = [];
    foreach ($options as $option) {
        $subVariantId = $option['subVariantId'];
        $itemId = $option['itemId'];

        // Get variant sub-option name
        $variantSubOption = $this->variation_model->get_variant_sub_options_name_by_id($subVariantId);
    
        // Get sub-option item name
        $subOptionItem = $this->variation_model->get_variant_name_by_id($itemId);
    
        $details[] = [
            'subVariantId' => $subVariantId,
            'itemId' => $itemId,
            'variantName' => $variantSubOption,
            'subOptionName' => $subOptionItem
        ];
    }
    return $details;
}


public function get_restaurants_by_ids($restaurant_ids) {
    if (empty($restaurant_ids)) {
        return []; // Return an empty array if no IDs are provided
    }

    $this->db->where_in('id', $restaurant_ids);
    $query = $this->db->get('restaurants'); // Assuming the table name is 'restaurants'
    return $query->result(); // Return as an array of objects
}



    
    /**
     * GET THE RESTAURANT IDS ONLY. THIS FUNCTION WILL RETURN ALL THE INDIVIDUAL RESTAURANT IDS OF THE CART ITEMS
     */
    public function get_restaurant_ids() {
        $restaurant_ids = array();
        $cart_items = $this->get_all(); // Get all cart items
        // print_r($cart_items);
        foreach ($cart_items as $cart_item) {
                    if (!in_array($cart_item['restaurant_id'], $restaurant_ids)) {
                array_push($restaurant_ids, $cart_item['restaurant_id']);
            }
        }
      
        return $restaurant_ids;
    }

    public function order_placing_mail($order_code)
    {
        // print_r($customer_details . "<dada");                                                            
        // SENDING MAIL TO CUSTOMER
        // print_r("id" . $this->logged_in_user_id . "das");
        $customer_details = $this->user_model->get_user_by_id($this->logged_in_user_id);
            // print_r($customer_details . "Da");
            // print_r($this->user_model->get_user_by_id($this->logged_in_user_id));
        // print_r($customer_details. "hey");
        $message  = get_phrase('hello') . ' ' . $customer_details['name'] . ', <br/>';
          $message .= get_phrase('your_order_has_been_placed_successfully') . '.<br/>';
        $message .= get_phrase('the_order_code_is') . ' <b>' . $order_code . '</b>.<br/>';
        // $message .= get_phrase('please_track_down_your_order_status_from_the_order_details_page') . '.';
        $this->email_model->order_pacing($customer_details['email'], $message);
        // print_r($customer_details['email'] ."email");
        // SENDING MAIL TO ADMIN
        $admin_details = $this->user_model->get_admin_details();
        $message  = get_phrase('hello') . ' ' . $admin_details['name'] . ', <br/>';
        $message .= get_phrase('a_new_order_has_been_placed_by_the_customer_name') . ' <b>' . $customer_details['name'] . '</b>.<br/>';
        $message .= get_phrase('the_order_code_is') . ' <b>' . $order_code . '</b>.<br/>';
        // $message .= get_phrase('please_check_the_order_as_soon_as_possible_and_process_the_order') . '.';
        $this->email_model->order_pacing($admin_details['email'], $message);
        // print_r($admin_details['email']. "admin");


        // PUSH ALL THE RESTAURANT IDS TO THIS ARRAY FOR SENDING MAILS TO THE RESTAURANT OWNERS
        $restaurant_ids = $this->get_restaurant_ids($order_code);
        // print_r($restaurant_id)
        foreach ($restaurant_ids as $key => $restaurant_id) {
            $restaurant_details = $this->restaurant_model->get_by_id($restaurant_id);
            $message  = get_phrase('hello') . ' ' . $restaurant_details['owner_name'] . ', <br/>';
            $message .= get_phrase('a_new_order_has_been_placed_to_your_restaurant_from') . ' <b>' . $customer_details['name'] . '</b>.<br/>';
            $message .= get_phrase('the_order_code_is') . ' <b>' . $order_code . '</b>.<br/>';
            $message .= get_phrase('please_check_the_order_as_soon_as_possible') . '.';
            $this->email_model->order_pacing($restaurant_details['owner_email'], $message);
            
        }
        // print_r($restaurant_details . "admin");

    }

    /**
     * GET SMALLER DATA FOR CART PAGE : DISCOUNT % FOR CURRENT CART
     */
    public function get_discound_val()
    {
        $discount = 0;
        $cart_details = $this->get_all();
        foreach ($cart_details as $cart_detail) {
            $discount = $cart_detail['discount'];
            break;
        }
        return $discount;
    }


    /**
     * GET SMALLER DATA FOR CART PAGE : TOTAL MENU PRICE
     */
    public function get_total_menu_price()
    {
        $total_price = 0;
        $cart_details = $this->get_all();
        foreach ($cart_details as $cart_detail) {
            $total_price = $total_price + $cart_detail['price'];
        }
        return $total_price;
    }

    /**
     * GET SMALLER DATA FOR CART PAGE : TOTAL DELIVERY CHARGE FOR MULTIPLE RESTAURANTS
     */
    public function get_total_delivery_charge()
    {
       
        $total_delivery_charge = $this->session->userdata('delivery_fees');

        return $total_delivery_charge;
    }

    /**
     * GET SMALLER DATA FOR CART PAGE : TOTAL SUB TOTAL
     */
    public function get_sub_total()
    {
        $sub_total = 0;
        $total_menu_price = $this->get_total_menu_price();
        $total_vat_amount = $this->get_vat_amount();
        $sub_total = $total_vat_amount + $total_menu_price;
        return $sub_total;
    }

    /**
     * GET SMALLER DATA FOR CART PAGE : VAT
     */
    public function get_vat_amount()
    {
        $total_vat = 0;
        $total_menu_price = $this->get_total_menu_price();
        $vat_percentage = get_delivery_settings('vat');
        $total_vat = ($total_menu_price * $vat_percentage) / 100;
        return ceil($total_vat);
    }

    /**
     * GET SMALLER DATA FOR CART PAGE : VAT
     */

     public function acc_distance_charges()
     {

     }

     
     public function get_service_amount()
    {
        $total_service = 0.00;
        if($this->get_sub_total() > 0) {
            $total_service = 0.25;
        }
        return $total_service;
    }

    /**
     * GET SMALLER DATA FOR CART PAGE : GRAND TOTAL
     */
    public function get_grand_total()
    {
        $grand_total = 0;
        $total_service = 0.00;
        if($this->get_sub_total() > 0) {
            $total_service = 0.25;
        }
        $sub_total = $this->get_sub_total();
        $total_delivery_charge = $this->get_total_delivery_charge();

        // var_dump();
        $discount =  $this->get_discound_val();
        // $grand_total = $sub_total + $total_delivery_charge + $total_service;
        $grand_total = $sub_total + $total_service;
        if($discount && $discount > 0){
        $discountAmount =  ($grand_total * $discount) / 100;
        }
        if($discountAmount > 0){
            return $grand_total - $discountAmount;
        }
        

        return $grand_total;
    }

    /**
     * CLEARING A CART
     */
    public function clearing_cart()
    {
        $data['customer_id'] = $this->logged_in_user_id;
        $this->db->where($data);
        return $this->db->delete($this->table);
    }


    /**
     * DASHBOARD TILE DATA USER WISE
     */
    public function get_number_of_cart_items()
    {
        $user_role = $this->session->userdata('user_role');
        if ($user_role == "customer") {
            $this->db->where('customer_id', $this->logged_in_user_id);
        }
        return $this->db->get($this->table)->num_rows();
    }

    /**
     * GET MENU DETAILS WITH VARIANTS
     */
    public function get_menu_details_with_variants_and_addons()
    {
        $menu_id = sanitize($this->input->post('menuId'));
        $quantity = $this->input->post('quantity') > 0 ? sanitize($this->input->post('quantity')) : 1;

        $query_object = $this->db->get_where('food_menus', ['id' => $menu_id]);
        $menu_availability = $query_object->num_rows();
        $menu_details = $query_object->row_array();

        $selected_variants = sanitize($this->input->post('selectedVariants'));

        $menu_price = 0;

        if ($menu_details['has_variant']) {
            $selected_variants = explode(',', $selected_variants);
            $selected_variants = array_map('strtolower', $selected_variants);
            sort($selected_variants);
            $selected_variants = implode(",", $selected_variants);

            $query_object = $this->db->get_where('variants', ['menu_id' => $menu_id, 'variant' => $selected_variants]);
            $variant_availability = $query_object->num_rows();
            $variant_details = $query_object->row_array();

            if ($variant_availability > 0) {
                $menu_price = $variant_details['price'];
            }
        } else {
            $menu_price = get_menu_price($menu_details['id']);
        }

        $total_price = is_numeric($quantity) ? $quantity * $menu_price : $menu_price;

        $selected_addons = sanitize($this->input->post('selectedAddons'));

        if (!empty($selected_addons)) {
            $selected_addons = explode(',', $selected_addons);
            foreach ($selected_addons as $selected_addon) {
                $selected_addon_details = $this->db->get_where('addons', ['id' => $selected_addon])->row_array();
                $total_price += $selected_addon_details['price'];
            }

            $selected_addons = implode(",", $selected_addons);
        }

        // ROUNDING UP THE TOTAL PRICE
        // $total_price = is_int($total_price) ? $total_price : number_format((float)$total_price, 3, '.', '');
        if (!is_int($total_price)) {
            $lengh_of_decimal_value = strlen(substr(strrchr($total_price, "."), 1));
            $total_price = $lengh_of_decimal_value > 3 ? number_format((float)$total_price, 3, '.', '') : $total_price;
        }

        if ($menu_availability > 0) {
            if ($menu_details['has_variant'] == 1) {
                if (isset($variant_availability) && $variant_availability > 0) {
                    return json_encode(['status' => true, 'hasVariant' => true, 'menuId' => $menu_details['id'], 'variantId' => $variant_details['id'], 'addons' => $selected_addons, 'totalPrice' => $total_price, 'currencyCode' => currency_code_and_symbol()]);
                } else {
                    return json_encode(['status' => false]);
                }
            } else {
                return json_encode(['status' => true, 'hasVariant' => false, 'menuId' => $menu_details['id'], 'addons' => $selected_addons, 'totalPrice' => $total_price, 'currencyCode' => currency_code_and_symbol()]);
            }
        } else {
            return json_encode(['status' => false]);
        }
    }


    public function updateDiscountCodeToCart($promo_code, $discount, $user_id) {
        $data = array(
            'offer_code' => $promo_code,
            'discount' => (int) $discount
        );
        $this->db->where('customer_id', $user_id);
        $this->db->update('cart', $data);
    }

    public function getDiscountCodeToCart() {
        $user_role = $this->session->userdata('user_role');
    
        $data = array();
        // $this->db->select('id, discount');

        if ($user_role == "customer") {
            $data['customer_id'] = $this->logged_in_user_id;
            // $data['offer_code'] = $promo_code;
        }
    
        $this->db->where($data);
        $this->db->order_by('id', 'desc'); 
        $this->db->limit(1);
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 'null';
        }
    }
    
    
}