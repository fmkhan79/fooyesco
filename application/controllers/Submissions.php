<?php
defined('BASEPATH') or exit('No direct script access allowed');

include 'Base.php';
class Submissions extends Base {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('submission_model');
        $this->load->model('settings_model');
        $this->load->model('email_model');
    }

    public function submit()
    {
        $host = $_SERVER['HTTP_HOST'];
        $submitData = $this->input->post();
        $recaptchaResponse = $this->input->post('g-recaptcha-response');

        // ✅ get sitekey & secretkey from DB
        $reCaptcha = $this->settings_model->get_system_recaptcha();
        $siteKey   = '';
        $secretKey = '';
        foreach ($reCaptcha as $row) {
            if ($row->key == 'recaptcha_sitekey') {
                $siteKey = $row->value;
            } elseif ($row->key == 'recaptcha_secretkey') {
                $secretKey = $row->value;
            }
        }

        // ✅ verify recaptcha
        $verifyResponse = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $recaptchaResponse
        );
        $responseData = json_decode($verifyResponse);

        if ($responseData->success) {
            // form data save
            $result = $this->submission_model->submit_contact_form($submitData);

            if (!$result) {
                $this->session->set_flashdata('error', 'Submission failed. Please try again.');
                return redirect(site_url('/contact-us'));
            }

            // email data
            $message = $submitData;
            $subject = $submitData['subject'];

            if ($host === 'fooyes.co.uk') {
                $to = 'fooyesuk@gmail.com';
            } else {
                $to = 'website25developer@gmail.com';
            }

            $this->email_model->send_mail_using_php_mailer($message, $subject, $to, false, true);

            $this->session->set_flashdata('success', 'Message submitted successfully!');
            return redirect(site_url('/contact-us'));
        } else {
            // ❌ recaptcha failed
            $this->session->set_flashdata('error', 'reCAPTCHA verification failed. Please try again.');
            return redirect(site_url('/contact-us'));
        }
    }
}
