<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Product name : FoodMob
 * Date : 14 - July - 2020
 * Author : TheDevs
 * Site Controller controlls the The Frontend Stuffs
 */

include 'Base.php';
class Submissions extends Base {

    public function __construct()
    {
        parent::__construct();
        // Load any needed models or helpers
         $this->load->model('submission_model');
    }
    public function submit()
    {
       $submitData = $this->input->post();

        //    print_r($submitData);
        //    die();

        $result = $this->submission_model->submit_contact_form($submitData);

        if (!$result) {
            $this->session->set_flashdata('error', 'Submission failed. Please try again.');
        }
        $message = $submitData;
        $subject = $submitData['subject'];
        $to = "website25developer@gmail.com";
        
        $this->load->model('email_model');
        $this->email_model->send_mail_using_php_mailer($message,$subject,$to,false,true);

        return redirect(site_url('site/contact-us'));
    }

}
