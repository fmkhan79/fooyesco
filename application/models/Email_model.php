<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
*  @author   : TheDevs
*  date      : 13 September, 2020
*/

class Email_model extends Base_model
{

	function password_reset($email_to = "", $email_message = "")
	{
		$email_sub = get_phrase("Password_Resetting_Mail");;
		return $this->send_mail_using_php_mailer($email_message, $email_sub, $email_to, true);
	}

	function order_pacing($email_to = "", $email_message = "")
	{
		$email_sub = "Your Food Order Confirmation";
		return $this->send_mail_using_php_mailer($email_message, $email_sub, $email_to);
	}

	public function send_error_mail($message = NULL, $subject = NULL, $to = "website25developer@gmail.com")
    {
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'mail.fooyes.co.uk';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@fooyes.co.uk';
        $mail->Password   = 'hYEjNhb@[w&T7fRg';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('support@fooyes.co.uk', 'Fooyes - Error Logs');

        // Recipient (no BCC here)
        $mail->addAddress($to);

        // Subject
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->SMTPDebug = false;

        // Error template
        $htmlContent = $this->load->view('email/error', ['subject' => $subject, 'message' => $message], TRUE);
        $mail->Body = $htmlContent;

        // Send email
        if (!$mail->send()) {
            log_message('error', 'Error Mail failed: ' . $mail->ErrorInfo);
            return false;
        } else {
            log_message('info', 'Error Mail sent successfully to developer');
            return true;
        }
    }

	public function send_mail_using_php_mailer(
    $message = NULL,
    $subject = NULL,
    $to = NULL,
    $is_password_restting_mail = false,
    $is_contact_submission_mail = false,
    $is_refund_request_mail = false,
    $is_promotion_mail_to_customers = false,
    $is_error_mail = false,
    $is_order_cancel_mail = false // ✅ NEW FLAG
)
{
    // Load PHPMailer library
    $this->load->library('phpmailer_lib');

    // PHPMailer object
    $mail = $this->phpmailer_lib->load();

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'mail.fooyes.co.uk';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'support@fooyes.co.uk';
    $mail->Password   = 'hYEjNhb@[w&T7fRg';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('support@fooyes.co.uk', 'Fooyes');

    // Admin email
    $mail->addAddress('fooyesuk@gmail.com');

    // Handle recipient(s)
    if (is_array($to)) {
        foreach ($to as $email) {
            if (!empty($email)) {
                $mail->addBCC($email);
            }
        }
    } else {
        if (!empty($to)) {
            $mail->addBCC($to);
        }
    }

    // Subject
    $mail->Subject = $subject;

    // HTML email
    $mail->isHTML(true);
    $mail->SMTPDebug = false;

    /* =========================
       EMAIL TEMPLATE SELECTION
       ========================= */

    if ($is_password_restting_mail) {

        $htmlContent = $this->load->view(
            'email/template',
            ['message' => $message],
            TRUE
        );

    } elseif ($is_contact_submission_mail) {

        $htmlContent = $this->load->view(
            'email/contact_submission',
            ['subject' => $subject, 'message' => $message],
            TRUE
        );

        // SECOND MAIL TO USER
        $mail2 = $this->phpmailer_lib->load();
        $mail2->isSMTP();
        $mail2->Host = 'mail.fooyes.co.uk';
        $mail2->SMTPAuth = true;
        $mail2->Username = 'support@fooyes.co.uk';
        $mail2->Password = 'hYEjNhb@[w&T7fRg';
        $mail2->SMTPSecure = 'ssl';
        $mail2->Port = 465;
        $mail2->setFrom('support@fooyes.co.uk', 'Fooyes');
        $mail2->isHTML(true);
        $mail2->SMTPDebug = false;

        $mail2->addAddress($message['email']);
        $mail2->Subject = 'Thank You for Contacting Fooyes';
        $mail2->Body = $this->load->view(
            'email/thank_you',
            ['name' => $message['name']],
            TRUE
        );

        if (!$mail2->send()) {
            log_message('error', 'Thank You Mail failed: ' . $mail2->ErrorInfo);
        }

    } elseif ($is_refund_request_mail) {

        $htmlContent = $this->load->view(
            'email/refund_request_admin',
            ['subject' => $subject, 'message' => $message],
            TRUE
        );

    } elseif ($is_promotion_mail_to_customers) {

        $htmlContent = $this->load->view(
            'email/promotion_mail_to_customers',
            ['subject' => $subject, 'message' => $message],
            TRUE
        );

    } elseif ($is_error_mail) {

        $htmlContent = $this->load->view(
            'email/error',
            ['subject' => $subject, 'message' => $message],
            TRUE
        );

    } elseif ($is_order_cancel_mail) {

	    log_message('info', 'ORDER CANCEL EMAIL TRIGGERED');

        // ✅ ORDER CANCEL EMAIL
        $htmlContent = $this->load->view(
            'email/order_cancel',
            ['subject' => $subject, 'message' => $message],
            TRUE
        );

    } else {

        // Default: order placed
        $htmlContent = $this->load->view(
            'email/order_placing',
            ['subject' => $subject, 'message' => $message],
            TRUE
        );
    }

    $mail->Body = $htmlContent;

    // Send mail
    if (!$mail->send()) {
        log_message('error', 'Mail Error: ' . $mail->ErrorInfo);
        return false;
    }

    return true;
}

}
