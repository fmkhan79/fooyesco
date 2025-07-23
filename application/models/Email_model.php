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

	public function send_mail_using_php_mailer($message = NULL, $subject = NULL, $to = NULL, $is_password_restting_mail = false, $is_contact_submission_mail = false, $is_refund_request_mail = false, $is_promotion_mail_to_customers = false)
	{
		// Load PHPMailer library
		$this->load->library('phpmailer_lib');

		// PHPMailer object
		$mail = $this->phpmailer_lib->load();
// SMTP configuration
$mail->isSMTP();
$mail->Host       = 'mail.fooyes.co.uk'; // Your SMTP server
$mail->SMTPAuth   = true;
$mail->Username   = 'no-reply@fooyes.co.uk'; // Your email username
$mail->Password   = '^X{zK)uB%XrS'; // Your email password
$mail->SMTPSecure = 'ssl'; // Use 'ssl' for SSL
$mail->Port       = 465; // Use 465 for SSL

$mail->setFrom('no-reply@fooyes.co.uk', 'Fooyes'); // Your email and name

		// Add a recipient
		$mail->addAddress($to);

		$mail->addBCC('fooyesuk@gmail.com');

		// Email subject
		$mail->Subject = $subject;

		// Set email format to HTML
		$mail->isHTML(true);

		// Enabled debug
		$mail->SMTPDebug = false;
		if ($is_password_restting_mail) {
			$htmlContent = $this->load->view('email/template', array('message' => $message), TRUE);
		} elseif($is_contact_submission_mail) {
			$htmlContent = $this->load->view('email/contact_submission', array('subject' => $subject, 'message' => $message), TRUE);

			  // ========== SECOND EMAIL TO USER ==========
				$mail2 = $this->phpmailer_lib->load();
				$mail2->isSMTP();
				$mail2->Host = 'mail.fooyes.co.uk';
				$mail2->SMTPAuth = true;
				$mail2->Username = 'no-reply@fooyes.co.uk';
				$mail2->Password = '^X{zK)uB%XrS';
				$mail2->SMTPSecure = 'ssl';
				$mail2->Port = 465;
				$mail2->setFrom('no-reply@fooyes.co.uk', 'Fooyes');
				$mail2->isHTML(true);
				$mail2->SMTPDebug = false;

				$mail2->addAddress($message['email']); 
				$mail2->Subject = 'Thank You for Contacting Fooyes';
				$htmlContent2 = $this->load->view('email/thank_you', ['name' => $message['name']], TRUE);
				$mail2->Body = $htmlContent2;

				$sentToUser = $mail2->send();

				if (!$sentToUser) {
					log_message('error', 'Thank You Mail to user failed: ' . $mail2->ErrorInfo);
				} else {
					log_message('info', 'Thank You Mail to user sent');
				}

		}elseif ($is_refund_request_mail) {
			$htmlContent = $this->load->view('email/refund_request_admin', array('subject' => $subject, 'message' => $message), TRUE);
		} elseif ($is_promotion_mail_to_customers) {
			$htmlContent = $this->load->view('email/promotion_mail_to_customers', array('subject' => $subject, 'message' => $message), TRUE);
		} else {
			$htmlContent = $this->load->view('email/order_placing', array('subject' => $subject, 'message' => $message), TRUE);
		}

		$mail->Body = $htmlContent;
		// Send email
		if (!$mail->send()) {

			log_message('error', 'Mail Error: ' . $mail->ErrorInfo);

			// YOU CAN DEBUG HERE, WHETHER MAIL IS GOING OT NO. YOU CAN PRING THE "ErrorInfo" OF MAIL OBJECT
			return false;
		} else {
			// YOU CAN DEBUG HERE. WHETHER THE MAIL IS GOING OR NOT. YOU CAN ECHO HERE
			return true;
		}
	}
}
