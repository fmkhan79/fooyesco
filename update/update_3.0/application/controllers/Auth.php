<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 09 - June - 2020
 * Author : TheDevs
 * AUTH CONTROLLER FOR LOGGIN IN AND LOGGIN OT=UT FUNCTIONALITIES
 */

include 'Base.php';
class Auth extends Base
{

	public function index()
	{
		if ($this->session->userdata('is_logged_in')) {
			redirect(site_url('dashboard'), 'refresh');
		}

		$this->load->view('auth/login');
	}

	// Validating a user
	public function validate()
	{
		if ($this->session->userdata('is_logged_in')) {
			redirect(site_url('dashboard'), 'refresh');
		}

		$validity = $this->auth_model->validate_login();

		if ($validity) {
			$userdata = $this->user_model->get_user_by_id($this->session->userdata('user_id'));
			$this->session->set_flashdata('flash_message', get_phrase('welcome') . ", " . $userdata['name']);
			if ($this->session->userdata('user_role') == "driver") {
				redirect(site_url('orders/today'), 'refresh');
			} elseif ($this->session->userdata('user_role') == "customer") {
				redirect(site_url(), 'refresh');
			} else {
				redirect(site_url('dashboard'), 'refresh');
			}
		} else {
			error(get_phrase('invalid_login_credentials'), site_url('auth'));
		}
	}

	// SWITCH USER ROLES. LIKE SWITCHING FROM CUSTOMER TO RESTAURANT OWNER
	public function switch_role()
	{
		if ($this->session->userdata('user_role') == 'customer' && is_restaurant_owner($this->session->userdata('user_id'))) {
			$this->session->set_userdata('user_role_id', 3);
			$this->session->set_userdata('user_role', "owner");
			$this->session->set_userdata('owner_login', 1);
			$this->session->set_flashdata('flash_message', get_phrase('successfully_switched_to_restaurant_owner', true));
		} elseif ($this->session->userdata('user_role') == 'owner' && is_restaurant_owner($this->session->userdata('user_id'))) {
			$this->session->set_userdata('user_role_id', 2);
			$this->session->set_userdata('user_role', "customer");
			$this->session->set_userdata('customer_login', 1);
			$this->session->set_flashdata('flash_message', get_phrase('successfully_switched_to_customer', true));
		}
		redirect(site_url('dashboard'), 'refresh');
	}


	/**
	 * ROLES FUNCTION SHOW THE ROLES VIEW FOR REGISTRAION
	 *
	 * @return void
	 */
	public function roles()
	{
		if ($this->session->userdata('is_logged_in')) {
			redirect(site_url('dashboard'), 'refresh');
		}

		$this->load->view('auth/roles');
	}


	/**
	 * REGISTRATION FUNCTION IS RESPONSI
	 *
	 * @param [type] $role
	 * @return void
	 */
	public function registration($role)
	{
		if ($this->session->userdata('is_logged_in')) {
			redirect(site_url('dashboard'), 'refresh');
		}
		$page_data['role'] = sanitize($role);
		$this->load->view('auth/registration', $page_data);
	}

	/**
	 * FORGET PASSWORD FUNCTION IS RESPONSIBLE FOR RESETTING PASSWORD
	 *
	 * @return void
	 */
	public function forget_password()
	{
		$this->load->view('auth/forget_password');
	}

	/**
	 * FORGET PASSWORD FUNCTION IS RESPONSIBLE FOR RESETTING PASSWORD
	 *
	 * @return void
	 */
	public function resetpassword()
	{
		$this->auth_model->reset_password();
	}

	/**
	 * REGISTER FUNCTION IS FOR REGISTERING USERS
	 *
	 * @return void
	 */
	public function register()
	{
		if ($this->session->userdata('is_logged_in')) {
			redirect(site_url('dashboard'), 'refresh');
		}
		$validate_recaptcha = $this->validate_captcha();
		if ($validate_recaptcha) {
			$this->auth_model->registration();
		} else {
			error(get_phrase('recaptcha_validation_failed'), $_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * VALIDATE RECAPTHCA FUNCTION IS RESPONSIBLE FOR VALIDATING THE REACAPTCHA
	 *
	 * @return boolean
	 */
	function validate_captcha()
	{
		$recaptcha = trim($this->input->post('g-recaptcha-response'));
		$userIp = $this->input->ip_address();
		$secret = get_system_settings('recaptcha_secretkey');
		$data = array(
			'secret' => "$secret",
			'response' => "$recaptcha",
			'remoteip' => "$userIp"
		);

		$verify = curl_init();
		curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($verify);
		$status = json_decode($response, true);

		if (empty($status['success'])) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	// Destroying session
	public function logout()
	{
		$this->logged_in_user_id = null;
		$this->logged_in_user_role = null;
		$this->session->sess_destroy();
		redirect(site_url('auth'), 'refresh');
	}
}
