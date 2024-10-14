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

// THIS HELPER METHOD RETURN THE USER ROLE
if (!function_exists('get_user_role')) {
	function get_user_role($type = "", $user_id = '')
	{
		$CI	= &get_instance();
		$CI->load->database();

		$role_id	=	$CI->db->get_where('users', array('id' => $user_id))->row()->role_id;
		$user_role	=	$CI->db->get_where('role', array('id' => $role_id))->row()->type;

		if ($type == "user_role") {
			return $user_role;
		} else {
			return $role_id;
		}
	}
}

// THIS HELPER METHOD CHECKS IF THE EMAIL IS VALID OR NOT. IT BASICALLY CHECKES THE DUPLICATION
if (!function_exists('email_duplication')) {
	function email_duplication($email = "", $user_id = "")
	{
		$CI	= &get_instance();
		$CI->load->database();

		$query = $CI->db->get_where('users', ['email' => $email]);
		if (!empty($user_id)) {
			$query_result = $query->row_array();
			if ($query->num_rows() == 0 || $query_result['id'] == $user_id) {
				return true;
			} else {
				$CI->session->set_flashdata('error_message', get_phrase('duplicate_email'));
				redirect($_SERVER['HTTP_REFERER'], 'refresh');
			}
		} else {
			if ($query->num_rows() > 0) {
				$CI->session->set_flashdata('error_message', get_phrase('duplicate_email'));
				redirect($_SERVER['HTTP_REFERER'], 'refresh');
			} else {
				return true;
			}
		}
	}
}

// THIS HELPER METHOD CHECKS IF THE USER IS A RESTAURANT OWNER OR NOT
if (!function_exists('is_restaurant_owner')) {
	function is_restaurant_owner($user_id = "")
	{
		$CI	= &get_instance();
		$CI->load->database();

		if (empty($user_id)) {
			$user_id = $CI->session->userdata('user_id');
		}
		$user_data = $CI->db->get_where('users', array('id' => $user_id))->row_array();

		$owner_role = $CI->db->get_where('role', ['type' => 'owner'])->row_array();
		if (count($user_data) > 0) {
			return ($user_data['role_id'] == $owner_role['id']) ? true : false;
		}

		return false;
	}
}


// THIS HELPER METHOD CHECKS IF THE USER HAS ANY RESTAURANT OWNED
if (!function_exists('has_restaurant')) {
	function has_restaurant($user_id = "")
	{
		$CI	= &get_instance();
		$CI->load->database();

		if (empty($user_id)) {
			$user_id = $CI->session->userdata('user_id');
		}
		$query = $CI->db->get_where('restaurants', array('owner_id' => $user_id))->num_rows();
		if ($query > 0) {
			return true;
		}

		return false;
	}
}

/**
 * CHECK IF THE OWNER HAS THE PERMISSION TO APPROVE ORDERS
 */
if (!function_exists('can_process_order')) {
	function can_process_order()
	{
		$multi_restaurant_order = get_order_settings('multi_restaurant_order');
		$owner_order_processing = get_order_settings('owner_order_processing');

		if (!$multi_restaurant_order && $owner_order_processing) {
			return true;
		}

		return false;
	}
}

// ------------------------------------------------------------------------
/* End of file user_helper.php */
/* Location: ./system/helpers/user_helper.php */
