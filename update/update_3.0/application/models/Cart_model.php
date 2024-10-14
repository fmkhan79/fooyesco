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
    function add_to_cart()
    {
        // CHECK IF THE USER IS LOGGED IN, IF NOT THEN ASSIGN A RANDOM NUMBER AS USER ID
        if (!$this->logged_in_user_id || empty($this->logged_in_user_id)) {
            $this->session->set_userdata('user_id', rand(9999, 99999));
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

        if ($menu_details['has_variant']) {
            $data['variant_id'] = sanitize($this->input->post('variantId'));
            $variant_details = $this->db->get_where('variants', ['id' => $data['variant_id']]);
            if ($variant_details->num_rows() > 0) {
                $variant_details = $variant_details->row_array();
                $price = $data['quantity'] * $variant_details['price'];
                $data['price'] = $price;
            }
        } else {
            $price = $data['quantity'] * get_menu_price($data['menu_id']);
            $data['price'] = $price;
        }

        if (isset($_POST['addons']) && !empty($_POST['addons'])) {
            $total_addon_price = 0;
            $selected_addons = explode(',', $this->input->post('addons'));
            foreach ($selected_addons as $selected_addon) {
                $selected_addon_details = $this->db->get_where('addons', ['id' => $selected_addon])->row_array();
                $total_addon_price += $selected_addon_details['price'];
            }

            $data['addons'] = implode(",", $selected_addons);
            $data['price'] = $data['price'] + $total_addon_price;
        }

        //CHECK MENU ID VALIDITY

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
    function get_all()
    {
        $data['customer_id'] = $this->logged_in_user_id;
        $obj = $this->db->get_where($this->table, $data);
        return $this->merger($obj);
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
            return $cart_item;
        }
    }

    /**
     * GET THE RESTAURANT IDS ONLY. THIS FUNCTION WILL RETURN ALL THE INDIVIDUAL RESTAURANT IDS OF THE CART ITEMS
     */
    public function get_restaurant_ids()
    {
        $restaurant_ids = array();
        $cart_items = $this->get_all();
        foreach ($cart_items as $cart_item) {
            if (!in_array($cart_item['restaurant_id'], $restaurant_ids)) {
                array_push($restaurant_ids, $cart_item['restaurant_id']);
            }
        }
        return $restaurant_ids;
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
        $total_delivery_charge = 0;
        $restaurant_ids = $this->get_restaurant_ids();
        foreach ($restaurant_ids as $restaurant_id) {
            $delivery_charge = delivery_charge($restaurant_id) > 0 ? delivery_charge($restaurant_id) : 0;
            $total_delivery_charge = $total_delivery_charge + $delivery_charge;
        }
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
     * GET SMALLER DATA FOR CART PAGE : GRAND TOTAL
     */
    public function get_grand_total()
    {
        $grand_total = 0;
        $sub_total = $this->get_sub_total();
        $total_delivery_charge = $this->get_total_delivery_charge();
        $grand_total = $sub_total + $total_delivery_charge;
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
}
