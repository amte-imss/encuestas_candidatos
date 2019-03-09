<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_phpmailer {
	public function __construct() {
    	$this->CI =& get_instance();
    	$this->CI->config->load('email');
    	include APPPATH.'third_party/phpmailer/Phpmailerautoload.php';
    }

    public function phpmailerclass(){
    	$config_email = $this->CI->config->item('email');
    	$mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        //$mail->SMTPAuth = false;
        //$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
        $mail->Debugoutput = 'html';
        $mail->Host = $config_email['host'];
        //$mail->Host = '172.16.23.18';
        //$mail->Port = '25';
        $mail->Port = $config_email['port'];
        $mail->SMTPSecure = $config_email['crypt'];
        //$mail->SMTPSecure = 'ssl';
        $mail->Username = $config_email['username'];
        $mail->Password = $config_email['password'];
        
        $mail->setFrom($config_email['setFrom']['email'], $config_email['setFrom']['name']);

        return $mail;
    }
	/*
    public function phpmailerclass() {
        echo $path = APPPATH.'third_party/phpmailer/';
    	//$this->CI->load->add_package_path($path)->library('PHPMailer');
    	$this->CI->load->add_package_path($path);

    }*/
}
