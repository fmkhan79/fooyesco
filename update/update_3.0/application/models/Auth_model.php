<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Auth_model for authenticate users
 */
class Auth_model extends CI_Model
{
    /**
     * CHECKS LOGIN CREDENTIALS. IF USER IS FOUND RETURN TRUE OTHERWISE RETURN FALSE
     */
    public function validate_login()
    {
        $email = required(sanitize($this->input->post('email')));
        $password = required($this->input->post('password')); // DID NOT SANITIZE THE PASSWORD BECAUSE IT CAN TAKE SPECIAL CHARS
        $credential = array('email' => $email, 'password' => sha1($password), 'status' => 1);

        $query = $this->db->get_where('users', $credential);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('is_logged_in', 1);
            $this->session->set_userdata('user_role_id', $row->role_id);
            $this->session->set_userdata('user_role', get_user_role('user_role', $row->id));
            if ($row->role_id == 1) {
                $this->session->set_userdata('admin_login', 1);
            } else if ($row->role_id == 2) {
                $this->check_cart_items_with_temporary_user_id($query->row_array());
                $this->session->set_userdata('customer_login', 1);
            } else if ($row->role_id == 3) {
                $this->check_cart_items_with_temporary_user_id($query->row_array());
                $this->session->set_userdata('owner_login', 1);
            } else if ($row->role_id == 4) {
                $this->session->set_userdata('driver_login', 1);
            } else if ($row->role_id == 5) {
                $this->session->set_userdata('cook_login', 1);
            }

            $this->session->set_userdata('user_id', $row->id);

            return true;
        }

        return false;
    }

    /**
     * THIS FUNCTION IS RESPONSIBLE FOR REGISTERING USERS
     */
    public function registration()
    {
        $role = required(sanitize($this->input->post('role')));
        if ($role == "customer" || $role == "owner" || $role == "driver") {
            $user_data['name'] = required(sanitize($this->input->post('name')));
            $user_data['email'] = required(sanitize($this->input->post('email')));
            $user_data['phone'] = required(sanitize($this->input->post('phone')));
            $user_data['password'] = sha1(required($this->input->post('password'))); // DID NOT SANITIZE THE PASSWORD BECAUSE IT CAN TAKE SPECIAL CHARS

            // GET THE ROLE DETAILS
            $role_details = $this->db->get_where('role', ['type' => $role])->row_array();
            $user_data['role_id'] = $role_details['id'];
            $user_data['created_at'] = strtotime(date('D, d-M-Y'));

            if (email_duplication($user_data['email'])) {
                if ($role == "driver") {
                    $user_data['status'] = 0;
                    $this->db->insert('users', $user_data);
                    $user_id = $this->db->insert_id();
                    $driver_data['user_id'] = $user_id;
                    $this->db->insert('drivers', $driver_data);
                    success(get_phrase('your_registration_has_been_done') . '. ' . get_phrase('please_wait_till_admin_approves_your_registration'), site_url('login'));
                } else {
                    $user_data['status'] = 1;
                    $this->db->insert('users', $user_data);
                    $user_id = $this->db->insert_id();
                    $customer_data['user_id'] = $user_id;
                    $this->db->insert('customers', $customer_data);
                    $this->auto_login('customer', $user_id);
                }
            } else {
                error(get_phrase("email_duplication"), site_url('auth/roles'));
            }
        } else {
            error(get_phrase("invalid_user_role"), site_url('auth/roles'));
        }
    }

    /**
     * THIS FUNCTION HELPS TO LOGIN A USER AFTER REGISTRATION HAS BEEN DONE
     */
    public function auto_login($role, $user_id)
    {
        $user_data = $this->user_model->get_user_by_id($user_id);
        if (count($user_data) > 0 && $user_data['status']) {
            $this->session->set_userdata('is_logged_in', 1);
            $this->session->set_userdata('user_role_id', $user_data['role_id']);
            $this->session->set_userdata('user_role', get_user_role('user_role', $user_data['id']));
            if ($user_data['role_id'] == 1) {
                $this->session->set_userdata('admin_login', 1);
            } else if ($user_data['role_id'] == 2) {
                $this->check_cart_items_with_temporary_user_id($user_data);
                $this->session->set_userdata('customer_login', 1);
            } else if ($user_data['role_id'] == 3) {
                $this->check_cart_items_with_temporary_user_id($user_data);
                $this->session->set_userdata('owner_login', 1);
            } else if ($user_data['role_id'] == 4) {
                $this->session->set_userdata('driver_login', 1);
            }
            $this->session->set_userdata('user_id', $user_data['id']);
            success(get_phrase('congratulations_your_registration_has_been_done_successfully'), site_url('dashboard'));
        } else {
            redirect(site_url('auth'), 'refresh');
        }
    }

    /**
     * THIS FUNCTION IS RESPONSIBLE FOR RESETTING THE PASSWORD
     * IT WILL SEND AN EMAIL
     */
    public function reset_password()
    {
        $email = required(sanitize($this->input->post('email')));
        $this->db->where('email', $email);
        $user_data = $this->db->get('users')->row_array();
        if (count($user_data) > 0) {
            //resetting user password here
            $new_password = substr(sha1(rand(100000000, 20000000000)), 0, 7);
            $response = $this->email_model->password_reset($email, $new_password);
            if ($response) {
                $updater['password'] = sha1($new_password);
                $this->db->where('email', $email);
                $this->db->update('users', $updater);

                success(get_phrase('please_check_your_mail'), site_url('auth'));
            } else {
                error(get_phrase('error_occurred_during_sending_mail'), site_url('auth'));
            }
        } else {
            error(get_phrase('invalid_email'), site_url('auth/forget_password'));
        }
    }

    /**
     * CHECKING THE CART ITEMS WHICH WAS INSERTED WITH TEMPORARY USER ID
     */
    public function check_cart_items_with_temporary_user_id($row)
    {
        if ($this->session->userdata('user_id')) {
            $temporary_user_id = $this->session->userdata('user_id');
            $current_user_id = $row['id'];
            $this->db->where('customer_id', $temporary_user_id);
            $this->db->update('cart', ['customer_id' => $current_user_id]);
        }
        $this->session->set_userdata('user_id', $row['id']);
    }
}
