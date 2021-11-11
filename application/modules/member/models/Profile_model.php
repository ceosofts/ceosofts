<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Profile_model Class
 * @date 2018-09-02
 */
class Profile_model extends MY_Model
{

	private $my_table;
	public $session_name;

	public function __construct()
	{
		parent::__construct();
		$this->my_table = 'tb_members';
		$this->set_table_name($this->my_table);
	}

	public function exists($data)
	{
		$userid = checkEncryptData($data['userid']);
		$this->set_where("userid = $userid");
		return $this->count_record();
	}


	public function load($id)
	{
		$this->set_where("userid = $id");
		return $this->load_record();
	}

	public function update($post)
	{
		$data = array(
			// 'prefix' => $post['prefix'],
			'firstname' => $post['firstname'],
			'lastname' => $post['lastname'],
			'tel_number' => $post['tel_number'],
			'line_id' => $post['line_id'],
			'modify_datetime' => date('Y-m-d H:i:s'),
			'modify_user_id'  => $this->session->userdata('user_id')
		);

		if (isset($post['photo'])) {
			$data['photo'] = $post['photo'];
		}

		$userid = checkEncryptData($post['encrypt_userid']);
		$this->set_table_name($this->my_table);
		$this->set_where("userid = $userid");
		return $this->update_record($data);
	}

	public function getUserQuestion($username)
	{
		$this->db->where(array('username' => $username));
		$query = $this->db->get('tb_members_question_forgot');
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	private function check_update_birthday($username, $birthday)
	{
		if ($birthday != '') {
			$data = array(
				'birthday' => setDateToStandard($birthday)
			);
			$this->set_table_name('tb_members');
			$this->set_where("username = '$username'");
			return $this->update_record($data);
		}
	}

	public function create_question($post)
	{
		$this->check_update_birthday($post['username'], $post['birthday']);

		$answer = $this->Login_model->secure_pass($post['answer']);
		$data = array(
			'username' => $post['username'], 'question' => $post['question'], 'answer' => $answer
		);
		$this->set_table_name('tb_members_question_forgot');
		return $this->add_record($data);
	}

	public function update_question($post)
	{
		$this->check_update_birthday($post['username'], $post['birthday']);

		$answer = $this->Login_model->secure_pass($post['answer']);

		$data = array(
			'question' => $post['question'], 'answer' => $answer
		);

		$username = checkEncryptData($post['encrypt_username']);
		$this->set_table_name('tb_members_question_forgot');
		$this->set_where("username = '$username'");
		return $this->update_record($data);
	}

	/**
	 * Update with current session user id
	 */
	public function update_password($data)
	{
		$userid = $this->session->userdata('user_id');
		$conditions = array('userid' => $userid);

		//ตรวจสอบความถูกต้องรหัสเดิม
		$this->db->where($conditions);
		$query = $this->db->get($this->my_table);
		if ($query->num_rows() > 0) {
			$this->log_remark = 'เปลี่ยนรหัสผ่าน';
			$row = $query->row();

			$secure_pass = $this->Login_model->secure_pass($data['resetPassword2']);
			$key_encrypt = $this->Login_model->encrypt_md5_salt($data['uPasswordOld']);
			if (password_verify($key_encrypt, $row->password)) {
				$data = array(
					'password' => $secure_pass, 'modify_datetime' => date('Y-m-d H:i:s'), 'modify_user_id' => $userid
				);
				$this->set_where("userid = $userid");
				return $this->update_record($data);
			} else {
				$this->error_message = "รหัสผ่านเดิมไม่ถูกต้อง กรุณาตรวจสอบรหัสผ่านเดิมอีกครั้ง";
			}
		} else {
			$this->error_message = "ไม่พบ SESSION ผู้ใช้งาน กรุณาล็อกอินก่อนทำรายการ";
		}
	}

	public function update_email($data)
	{
		$id = $this->session->userdata('user_id');

		if ($this->check_duplicate_email($data['new_email']) > 0) {
			$this->error_message = "ขออภัยอีเมล ไม่สามารถใช้อีเมลซ้ำกันได้<br/>
									$data[new_email] ซ้ำกับข้อมูลที่มีอยู่แล้วในระบบ<br/>";
			return false;
		}

		//ตรวจสอบความถูกต้องรหัสเดิม
		$conditions = array('userid' => $id);
		$this->db->where($conditions);
		$query = $this->db->get($this->my_table);
		if ($query->num_rows() > 0) {
			$confirm_password = $this->Login_model->encrypt_md5_salt($data['confirm_password']);
			$row = $query->row();
			if (password_verify($confirm_password, $row->password)) {
				$data = array(
					'email' => $data['new_email'], 'modify_datetime' => date('Y-m-d H:i:s')
				);
				return $this->db->update($this->my_table, $data, $conditions);
			} else {
				$this->error_message = "รหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบรหัสผ่านอีกครั้ง";
			}
		} else {
			$this->error_message = "ไม่พบข้อมูลสมาชิก กรุณาตรวจสอบการล็อกอิน";
		}
	}

	private function check_duplicate_email($email)
	{
		$this->db->where(array('email' => $email));
		return $this->db->get($this->my_table)->num_rows();
	}

	public function update_bank_detail($data)
	{
		$id = $this->session->userdata('user_id');

		//ตรวจสอบความถูกต้องรหัสเดิม
		$conditions = array('userid' => $id);
		$this->db->where($conditions);
		$query = $this->db->get($this->my_table);
		if ($query->num_rows() > 0) {
			$confirm_password = $this->Login_model->encrypt_md5_salt($data['confirm_password']);
			$row = $query->row();
			if (password_verify($confirm_password, $row->password)) {
				$data = array(
					'account_no' => $data['account_no'], 'bank_id' => $data['bank_id'], 'modify_datetime' => date('Y-m-d H:i:s')
				);
				return $this->db->update($this->my_table, $data, $conditions);
			} else {
				$this->error_message = "รหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบรหัสผ่านอีกครั้ง";
			}
		} else {
			$this->error_message = "ไม่พบข้อมูลสมาชิก กรุณาตรวจสอบการล็อกอิน";
		}
	}

	public function unsubscribe($value)
	{
		$data = array(
			'unsubscribe' => $value, 'modify_datetime' => date('Y-m-d H:i:s'), 'modify_user_id'  => $this->session->userdata('user_id')
		);
		$this->log_remark = 'ยกเลิกการรับอีเมล';
		$userid = $this->session->userdata('user_id');
		$this->set_where("userid = $userid");
		return $this->update_record($data);
	}
}
/*---------------------------- END Model Class --------------------------------*/
