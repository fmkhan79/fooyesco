<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 25 - July - 2020
 * Author : TheDevs
 * Cart Controller controlls the task for a Cart
 */

include 'Base.php';
class TwilioSetting extends Base
{
    public function index()
    {

        $page_data['page_title'] = site_phrase("twilio_setting", true);
        $page_data['page_name'] = 'twilio_settings/index';
        $this->load->model('Admin_setting');
        $page_data['settings'] = $this->Admin_setting->get_twilio_credentials();
        $this->load->view('backend/index', $page_data);
    }

     public function save_twilio_settings()
    {
        $data = [
            'twilio_sid'   => $this->input->post('twilio_sid'),
            'twilio_token'    => $this->input->post('twilio_token'),
            'twilio_phone' => $this->input->post('twilio_phone')
        ];
        $this->load->model('Admin_setting');

        $result = $this->Admin_setting->save_twilio_settings($data);

        if ($result) {
            $this->session->set_flashdata('success', 'Twilio settings updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update settings.');
        }

        redirect('twilio-setting');
    }

}