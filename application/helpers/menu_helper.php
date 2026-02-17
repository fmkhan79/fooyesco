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

if (!function_exists('items_menu')) {
    function items_menu($order_code)
    {
        if($order_code){
            // print_r($order_code);
            $CI    = &get_instance();
        // $CI->load->database();
        $CI->load->model('items_model');
        $order = $CI->items_model->order_items($order_code);
            return $order;
        // print_r($order);
        // return $order;
        // dd($order);
                }
    }
}



// ------------------------------------------------------------------------
/* End of file common_helper.php */
/* Location: ./system/helpers/common.php */
