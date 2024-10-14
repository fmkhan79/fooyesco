<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 7 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// RETURN PRICE OF A MENU. CHECK THE PRICE HAS DISCOUNT OR NOT
// price_type DEFINES, IF USER WANTS TO FETCH THE ACTUAL PRICE. NO MATTER IT HAS A DISCOUNT OR NOT, IT WILL RETURN THE ACTUAL PRICE
if (!function_exists('get_menu_price')) {
  function get_menu_price($menu_id, $servings = "menu", $price_type = "")
  {
    $CI    = &get_instance();
    $CI->load->database();
    $menu_details = $CI->menu_model->get_by_id($menu_id);
    $price_decoder = json_decode($menu_details['price'], true);
    $discount_flag_decoder = json_decode($menu_details['has_discount'], true);
    $discounted_price_decoder = json_decode($menu_details['discounted_price'], true);
    return $discount_flag_decoder[$servings] ? (empty($price_type) ? $discounted_price_decoder[$servings] : $price_decoder[$servings]) : $price_decoder[$servings];
  }
}

// CHECK IF A MENU ITEM HAS DISCOUNT
if (!function_exists('has_discount')) {
  function has_discount($menu_id, $servings = "menu")
  {
    $CI    = &get_instance();
    $CI->load->database();
    $menu_details = $CI->menu_model->get_by_id($menu_id);
    $price_decoder = json_decode($menu_details['price'], true);
    $discount_flag_decoder = json_decode($menu_details['has_discount'], true);
    $discounted_price_decoder = json_decode($menu_details['discounted_price'], true);

    return $discount_flag_decoder[$servings];
  }
}


// GET THE DISCOUNT PERCETAGE
if (!function_exists('discount_percentage')) {
  function discount_percentage($actual_price, $discounted_price)
  {
    if ($actual_price > 0 && $discounted_price > 0) {
      $reducedPrice = $actual_price - $discounted_price;
      $discountedPercentage = ($reducedPrice / $actual_price) * 100;
      return number_format((float) $discountedPercentage, 2, '.', '');
    }

    return 0;
  }
}


if (!function_exists('is_open')) {
  function is_open($restaurant_id = '')
  {
    $CI  = &get_instance();
    $CI->load->database();
    $restaurant_details = $CI->db->get_where('restaurants', array('id' => $restaurant_id))->row_array();

    if (empty($restaurant_details['schedule'])) {
      return false;
    }

    $time_configurations = json_decode($restaurant_details['schedule'], true);
    $today = strtolower(date('l'));

    if ($time_configurations[$today . '_opening'] == "closed") {
      return false;
    } else {
      $startTime = strtotime($time_configurations[$today . '_opening']);
      $endTime = strtotime($time_configurations[$today . '_closing']);
      $currentTime = strtotime(date('H:i:s'));
      if (
        ($startTime < $endTime &&
          $currentTime >= $startTime &&
          $currentTime <= $endTime) ||
        ($startTime > $endTime && ($currentTime >= $startTime ||
          $currentTime <= $endTime))
      ) {
        return true;
      } else {
        return false;
      }
    }
  }
}

// GET DELIVERY CHARGE OF A RESTAURANT
if (!function_exists('delivery_charge')) {
  function delivery_charge($restaurant_id)
  {
    $CI  = &get_instance();
    $CI->load->database();
    $restaurant_details = $CI->restaurant_model->get_by_id($restaurant_id);
    if (!empty($restaurant_details['delivery_charge'])) {
      return $restaurant_details['delivery_charge'];
    } else {
      return get_delivery_settings('free_delivery_charge') ? 0 :  get_delivery_settings('delivery_charge');
    }
  }
}

// GET MAXIMUM TIME TO DELIVER OF A RESTAURANT
if (!function_exists('maximum_time_to_deliver')) {
  function maximum_time_to_deliver($restaurant_id)
  {
    $CI  = &get_instance();
    $CI->load->database();
    $restaurant_details = $CI->restaurant_model->get_by_id($restaurant_id);
    if (!empty($restaurant_details['maximum_time_to_deliver'])) {
      return $restaurant_details['maximum_time_to_deliver'];
    } else {
      return get_delivery_settings('maximum_time_to_deliver');
    }
  }
}

// GET RATING FOR A RESTAURANT
if (!function_exists('get_restaurant_rating')) {
  function get_restaurant_rating($restaurant_id)
  {
    $CI  = &get_instance();
    $CI->load->database();
    $reviews = $CI->db->get_where('reviews', ['restaurant_id' => $restaurant_id]);
    $total_ratings = 0;
    foreach ($reviews->result_array() as $review) {
      $total_ratings = $total_ratings + $review['rating'];
    }

    return $total_ratings > 0 ? number_format(($total_ratings / $reviews->num_rows()), 1) : 0;
  }
}

// GET PICKUP ORDER AVAILABILITY FOR A RESTAURANT
if (!function_exists('pickup_order_availability')) {
  function pickup_order_availability($restaurant_id)
  {
    $CI  = &get_instance();
    $CI->load->database();
    if (get_order_settings('pickup_order') && !get_order_settings('multi_restaurant_order')) {
      $restaurant_details = $CI->restaurant_model->get_by_id($restaurant_id);
      return $restaurant_details['support_pickup_order'] ? 1 : 0;
    }

    return false;
  }
}
// ------------------------------------------------------------------------
/* End of file restaurant_helper.php */
/* Location: ./system/helpers/restaurant.php */
