<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 07 - July - 2020
 * Author : TheDevs
 * Settings model handles all the database queries of settings related data
 */

class Settings_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
    }

    // GET CURRENCIES
    public function get_system_currencies()
    {
        return $this->db->get('currencies')->result_array();
    }
    // UPDATE METHOD UPDATES THE SETTINGS DATA
    public function update()
    {
        $settings_type = required(sanitize($this->input->post('settings_type')));
        $dynamic_function_name = "update_" . $settings_type . '_settings';
        return $this->$dynamic_function_name();
    }

    // UPDATE DELIVERY SETTINGS
    public function update_delivery_settings()
    {
        authorization(['admin'], true);

        $is_free_delivery_charge = isset($_POST['free_delivery_charge']) ? 1 : 0;
        $this->db->where('key', 'free_delivery_charge');
        $this->db->update('delivery_settings', ['value' => $is_free_delivery_charge]);

        $delivery_charge = !empty(sanitize($this->input->post('delivery_charge'))) ? sanitize($this->input->post('delivery_charge')) : 0;
        $this->db->where('key', 'delivery_charge');
        $this->db->update('delivery_settings', ['value' => $delivery_charge]);

        $maximum_time_to_deliver = !empty(sanitize($this->input->post('maximum_time_to_deliver'))) ? sanitize($this->input->post('maximum_time_to_deliver')) : 30;
        $this->db->where('key', 'maximum_time_to_deliver');
        $this->db->update('delivery_settings', ['value' => $maximum_time_to_deliver]);

        return true;
    }

    // UPDATE ORDER SETTINGS
    public function update_order_settings()
    {
        authorization(['admin'], true);

        $order_infos = ['multi_restaurant_order', 'auto_approve_order', 'auto_assign_driver', 'pickup_order', 'owner_order_processing'];
        foreach ($order_infos as $order_info) {
            $updater = required(sanitize($this->input->post($order_info)));
            if ($order_info == "pickup_order" || $order_info == "owner_order_processing") {
                $updater = $this->input->post('multi_restaurant_order') ? 0 : $updater;
            }
            $this->db->where('key', $order_info);
            $this->db->update('order_settings', ['value' => $updater]);
        }
        return true;
    }

    // UPDATE SYSTEM SETTINGS
    public function update_system_settings()
    {
        authorization(['admin'], true);

        $system_infos = ['purchase_code', 'system_name', 'system_title', 'system_email', 'address', 'phone', 'author', 'website_description', 'website_keywords', 'footer_text', 'footer_link', 'timezone'];
        foreach ($system_infos as $system_info) {
            if ($system_info == "address" || $system_info == "website_keywords" || $system_info == "website_description") {
                $updater = sanitize($this->input->post($system_info));
            } else {
                $updater = required(sanitize($this->input->post($system_info)));
            }
            $this->db->where('key', $system_info);
            $this->db->update('system_settings', ['value' => $updater]);
        }
        return true;
    }

    // UPDATE SMTP SETTINGS
    public function update_smtp_settings()
    {
        authorization(['admin'], true);

        $smtp_infos = ['sender', 'protocol', 'host', 'username', 'password', 'port', 'security', 'from'];
        foreach ($smtp_infos as $smtp_info) {
            $updater = required(sanitize($this->input->post($smtp_info)));
            $this->db->where('key', $smtp_info);
            $this->db->update('smtp_settings', ['value' => $updater]);
        }
        return true;
    }
    // UPDATE WEBSITE SETTINGS
    public function update_website_settings()
    {
        authorization(['admin'], true);

        $website_infos = ['title', 'sub_title', 'about_us', 'terms_and_conditions', 'privacy_policy'];
        foreach ($website_infos as $website_info) {
            if ($website_info == 'about_us' || $website_info == 'terms_and_conditions' || $website_info == 'privacy_policy') {
                // SKIP SANITIZER FOR THE TEXT EDITOR VALUES
                $updater = $this->input->post($website_info);
            } else {
                $updater = required(sanitize($this->input->post($website_info)));
            }

            $this->db->where('key', $website_info);
            $this->db->update('website_settings', ['value' => $updater]);
        }

        // SOCIAL LINKS
        $social_link['facebook'] = sanitize($this->input->post('facebook_link'));
        $social_link['twitter'] = sanitize($this->input->post('twitter_link'));
        $social_link['instagram'] = sanitize($this->input->post('instagram_link'));
        $social_links = json_encode($social_link);

        $this->db->where('key', 'social_links');
        $this->db->update('website_settings', ['value' => $social_links]);
        return true;
    }

    // WEBSITE GALLERY UPDATE
    public function update_gallery_settings()
    {
        authorization(['admin'], true);

        $gallery_type = sanitize($this->input->post('gallery_type'));
        $previous_data = get_website_settings($gallery_type);

        if (!empty($_FILES[$gallery_type]['name'])) {
            $gallery_data  = $this->upload('system', $_FILES[$gallery_type], $previous_data);
        } else {
            $gallery_data  = $previous_data;
        }
        $this->db->where('key', $gallery_type);
        $this->db->update('website_settings', ['value' => $gallery_data]);
        return true;
    }


    // UPDATE LOGGED IN USER PROFILE
    public function update_profile_settings()
    {
        $updater = sanitize($this->input->post('updater'));
        if ($updater == 'profile') {
            $response = $this->user_model->update_profile();
        } else {
            $response = $this->user_model->update_password();
        }
        return $response;
    }

    // UPDATE REVENUE SETTINGS
    public function update_revenue_settings()
    {
        authorization(['admin'], true);

        $admin_revenue = required(sanitize($this->input->post('admin_revenue')));
        if ($admin_revenue >= 0 && $admin_revenue <= 100) {
            $restaurant_revenue = 100 - $admin_revenue;

            $this->db->where('key', 'admin_revenue');
            $this->db->update('delivery_settings', ['value' => $admin_revenue]);

            $this->db->where('key', 'restaurant_revenue');
            $this->db->update('delivery_settings', ['value' => $restaurant_revenue]);
            return true;
        } else {
            error(get_phrase('invalid_number'), site_url('settings/revenue'));
        }
    }

    // UPDATE VAT SETTINGS
    public function update_vat_settings()
    {
        authorization(['admin'], true);

        $vat = required(sanitize($this->input->post('vat')));
        if ($vat >= 0) {
            $this->db->where('key', 'vat');
            $this->db->update('delivery_settings', ['value' => $vat]);
            return true;
        } else {
            error(get_phrase('invalid_number'), site_url('settings/vat'));
        }
    }

    // UPDATE RECAPTCHA SETTINGS
    public function update_recaptcha_settings()
    {
        authorization(['admin'], true);
        $recaptcha_data = ['recaptcha_sitekey', 'recaptcha_secretkey'];
        foreach ($recaptcha_data as $recaptcha_info) {
            $updater = required(sanitize($this->input->post($recaptcha_info)));
            $this->db->where('key', $recaptcha_info);
            $this->db->update('system_settings', ['value' => $updater]);
        }
        return true;
    }
}
