<?php 
class My404 extends CI_Controller 
{
 public function __construct() 
 {
    parent::__construct(); 
 } 

 public function index() 
 { 
    $this->load->library('user_agent');
	echo $this->agent->referrer();
	
	$data = $this->router->fetch_class();
	echo $data;
 } 
} 