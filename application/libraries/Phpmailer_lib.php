<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class PHPMailer_Lib
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
         // Debugging: Verify the path
        log_message('Debug', APPPATH);
        // Include PHPMailer library files
        // Include PHPMailer library files with error handling
        require_once APPPATH.'third_party/phpmailer/Exception.php';
        require_once APPPATH.'third_party/phpmailer/PHPMailer.php';
        require_once APPPATH.'third_party/phpmailer/SMTP.php';
        
        $mail = new PHPMailer;
        return $mail;
    }
}