<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Regis_model Class
 * @date 2020-05-25
 */
class Regis_model extends MY_Model
{

	private $my_table;
	public $session_name;

	public function __construct()
	{
		parent::__construct();
		$this->my_table = 'tb_members';
		$this->set_table_name($this->my_table);
	}

	/**
	 * Check by Email
	 */
	public function exists_email($email)
	{
		$email = trim($email);
		$this->set_table_name($this->my_table);
		$this->set_where("email = '$email'");
		return $this->count_record();
	}


	/**
	 * New register
	 */
	public function add($post)
	{
		$this->set_table_name($this->my_table);

		if ($this->exists_email($post['reg_email'])) {
			$this->error_message = 'ชื่อผู้ใช้ซ้ำกัน';
			return false;
		} else {
			$this->load->model('Login_model');

			$data = array(
				'username' => $post['reg_username'],
				'firstname' => $post['reg_fname'],
				'lastname' => $post['reg_lname'],
				'email' 	=> $post['reg_email'],
				'create_datetime' 	=> date('Y-m-d H:i:s'),
				'create_user_id'  	=> $this->session->userdata('user_id')
			);

			return $this->add_record($data);
		}
	}
}
/*---------------------------- END Model Class --------------------------------*/