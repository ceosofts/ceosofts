<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hit_counter
{
	private $filename;
	private $ip_filename;

	public function __construct()
	{
		$this->filename = './assets/userfiles/counter.txt';
		$this->ip_filename = './assets/userfiles/ip.txt';
	}
	
	public function set_count()
	{
		$ip = $this->get_ip();
		$filename = $this->filename;
		$ip_filename = $this->ip_filename;
		$ipfile =  (file_exists($filename)) ? file($ip_filename, FILE_IGNORE_NEW_LINES) : array();
		if(!in_array($ip, $ipfile)){
			$current_value = $this->get_count() +1;
			file_put_contents($ip_filename, $ip."\n", FILE_APPEND);
			file_put_contents($filename, $current_value);
		}
	}
	
	public function get_count()
	{
		$filename = $this->filename;
		return (file_exists($filename)) ? file_get_contents($filename) : 0;
	}
	
	private function get_ip()
	{
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		return $ip_address;
	}
}