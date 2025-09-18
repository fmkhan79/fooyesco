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
        $host = $_SERVER['HTTP_HOST'];
        $submitData = [
            'name'    => $this->input->post('name', true),
            'email'   => $this->input->post('email', true),
            'subject' => $this->input->post('subject', true),
            'message' => $this->input->post('message', true)
        ];

        $reCaptcha = $this->settings_model->get_system_recaptcha();

        $siteKey = '';
        $secretKey = '';
        foreach ($reCaptcha as $row) {
            if ($row->key == 'recaptcha_sitekey') {
                $siteKey = $row->value;
            } elseif ($row->key == 'recaptcha_secretkey') {
                $secretKey = $row->value;
            }
        }

        // reCAPTCHA validation
        $recaptchaResponse = $this->input->post('g-recaptcha-response');
        $secretKey = "<?= $secretKey ?>"; // DB se fetch kar lo jese aap site key le rahe ho
        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
        $responseData = json_decode($verifyResponse);

        if (!$responseData->success) {
            $this->session->set_flashdata('error', 'Please verify the reCAPTCHA.');
            return redirect(site_url('/contact-us'));
        }

        // Save to DB
        $result = $this->submission_model->submit_contact_form($submitData);

        if (!$result) {
            $this->session->set_flashdata('error', 'Submission failed. Please try again.');
            return redirect(site_url('/contact-us'));
        }

        // Email send
        $message = $submitData;
        $subject = $submitData['subject'];
        $to = ($host === 'www.fooyes.co.uk') ? 'fooyesuk@gmail.com' : 'website25developer@gmail.com';

        $this->load->model('email_model');
        $this->email_model->send_mail_using_php_mailer($message, $subject, $to, false, true);

        $this->session->set_flashdata('success', 'Your message has been submitted successfully.');
        return redirect(site_url('/contact-us'));
    }


}
