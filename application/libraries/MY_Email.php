<?php
if (!defined('BASEPATH'))    exit('No direct script access allowed');

class MY_Email extends CI_Email {

	public function __construct()
	{
			parent::__construct();
	}
	
	private function errorHandler() {
		
	}

	/**
		* Send mail by Gmail
	 */
	public function send_mail($to, $subject, $message)
	{
		$CI =& get_instance();
		$CI->config->load('email', TRUE);
        $config = $CI->config->config['email'];
		
		// For test
		if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost:8080' ){
			$this->initialize($config);
		}
		
		$this->set_mailtype("html");
		$this->set_newline("\r\n");

		$this->to($to);
		$this->from($config['from_mail'], $config['from_name']);
		$this->subject($subject);
		$this->message($message);

		//Send email
		set_error_handler('MailErrorHandler');
		//try{
			if ( $this->send(false) ) {
				return true;
			}else{
				return false;
			}
		//} catch(Exception $e){
			//$this->email->print_debugger();
		//}
	}
	
	/**
	 * Send mail by Gmail
	 */
	public function send_gmail($to, $subject, $message)
	{
		$CI =& get_instance();
		$CI->config->load('gmail', TRUE);
        $config = $CI->config->config['gmail'];
			
		//บางที Localhost ส่งไม่ได้ แต่บนโฮสต์จริงส่งได้ 
		// เจอกรณีที่ใน Localhost ต้อง  initialize ค่า config อีกรอบถึงจะส่งได้
		if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost:8080' ){			
			$this->initialize($config);
		}

		$this->set_mailtype("html");
		$this->set_newline("\r\n");

		$this->to($to);
		$this->from($config['from_mail'], $config['from_name']);
		$this->subject($subject);
		$this->message($message);

		//Send email
		try{
			if ( $this->send() ) {
				return true;
			}else{
				return false;
			}
		} catch(Exception $e){
			$this->email->print_debugger();
		}
	}
}