<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - July - 2020
 * Author : TheDevs
 * Cart model handles all the database queries of Cart
 */

class items_model extends Base_model
{
   public function order_items($order_code = "")
{
    $cart_items = [];
    
    if (!empty($order_code)) {

        $ordered_items = $this->order_model->get_order_by_code($order_code);
        
        foreach ($ordered_items as $ordered_item) {

        
            $ordered_item = is_array($ordered_item) ? $ordered_item : (array)$ordered_item;

        }   

    } else {
     
        $restaurant_ids = $this->cart_model->get_restaurant_ids();

        if (count($restaurant_ids) > 0) {
            foreach ($restaurant_ids as $restaurant_id) {

                $restaurant_details = $this->restaurant_model->get_by_id($restaurant_id);

                $cart_data = $this->cart_model->get_cart_by_condition([
                    'customer_id'   => $this->session->userdata('user_id'),
                    'restaurant_id' => sanitize($restaurant_details['id'])
                ]);

                if (!empty($cart_data)) {
                    $cart_items = array_merge($cart_items, $cart_data);
                }
            }
        }
    }

    return $cart_items;
}

}
