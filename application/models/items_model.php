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

    // ===============================
    // 🔵 BACKEND ORDER (PRINT RECEIPT)
    // ===============================
    if (!empty($order_code)) {

        $ordered_items = $this->order_model->details($order_code);

        if (!empty($ordered_items)) {

            foreach ($ordered_items as $ordered_item) {

                $ordered_item = is_array($ordered_item)
                    ? $ordered_item
                    : (array) $ordered_item;
                // dd($ordered_item);
                $menu_details = $this->menu_model
                    ->get_by_id($ordered_item['menu_id'] ?? 0);

                if (empty($menu_details)) continue;

                $menu_details = (array) $menu_details;

                $addons_data = [];
                $addons = !empty($ordered_item["addons"])
                    ? json_decode($ordered_item["addons"], true)
                    : [];

                if (!empty($addons) && is_array($addons)) {

                    foreach ($addons as $addon) {

                        if (empty($addon['itemId'])) continue;

                        $item = $this->menu_model
                            ->get_addon_item_detail($addon['itemId']);

                        if (!empty($item)) {

                            $addons_data[] = [
                                'variantName'   => $item['variantName'] ?? '',
                                'subOptionName' => $item['subOptionName'] ?? ''
                            ];
                        }
                    }
                }

                // ✅ ONE ROW PER MENU ITEM
                $cart_items[] = [
                    'id'        => $menu_details['id'],
                    'menu_name' => $menu_details['name'],
                    'quantity'  => $ordered_item['quantity'] ?? 1,
                    'price'     => $ordered_item['total'] ?? 0,
                    'variant_id'=> $ordered_item['variant_id'] ?? null,
                    'options_1_details' => $addons_data
                ];
            }
        }

        return $cart_items;
    }

    // ===============================
    // 🟢 FRONTEND CART
    // ===============================

    $restaurant_ids = $this->cart_model->get_restaurant_ids();

    if (!empty($restaurant_ids)) {

        foreach ($restaurant_ids as $restaurant_id) {

            $restaurant_details = $this->restaurant_model
                ->get_by_id($restaurant_id);

            if (empty($restaurant_details)) continue;

            $cart_data = $this->cart_model->get_cart_by_condition([
                'customer_id'   => $this->session->userdata('user_id'),
                'restaurant_id' => sanitize($restaurant_details['id'])
            ]);

            if (!empty($cart_data)) {
                $cart_items = array_merge($cart_items, $cart_data);
            }
        }
    }

    return $cart_items;
}

}
