<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Description of my_controller
 *
 */
class MEMBER_Controller extends CRUD_Controller
{
	public $member_data;
	private $admin_level;

	public function __construct()
	{
		parent::__construct();
		$this->admin_level = 9; //Admin
		$this->member_data['user_username']	= $this->session->userdata('user_username');
		$this->member_data['user_prefix']	= $this->session->userdata('user_prefix');
		$this->member_data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->member_data['user_lastname']		= $this->session->userdata('user_lastname');
	}

	public function is_logged_in()
	{
		if ($this->session->userdata('login_validated') == false) {
			$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$this->session->set_userdata('after_login_redirect', $current_url);
		} else {
			return TRUE;
		}
	}

	public function isAdmin()
	{
		if (!$this->is_logged_in()) {
			return TRUE;
		} else {
			if ($this->session->userdata('user_level') == $this->admin_level) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
}
 
/* End of file MEMBER_Controller.php */
/* Location: ./application/core/MEMBER_Controller.php */