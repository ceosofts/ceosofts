<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Member_profile.php ]
 */
class Member_profile extends MEMBER_Controller
{

	private $another_js;
	private $another_css;
	private $tbMember;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Member_profile_model', 'Profile');
		$this->load->model('Member_login_model', 'Login_model');

		$this->tbMember = 'tb_members';

		$this->data['page_url'] = site_url('member_login');
		$this->data['page_title'] = 'CEO Softs - LOGIN';

		$js_url = 'assets/js/member_profile.js';
		$this->another_js = '<script src="' . base_url($js_url) . '"></script>';

		if (!$this->is_logged_in()) {
			redirect('member_login');
		}
	}

	// ------------------------------------------------------------------------
	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->edit();
	}

	protected function render_view($path)
	{
		$template_name = 'sb-admin-bs4';

		$this->data['top_navbar'] = $this->parser->parse('template/' . $template_name . '/top_navbar_view', $this->top_navbar_data, TRUE);
		$this->data['left_sidebar'] = $this->parser->parse('template/' . $template_name . '/left_sidebar_view', $this->left_sidebar_data, TRUE);
		$this->data['breadcrumb_list'] = $this->parser->parse('template/' . $template_name . '/breadcrumb_view', $this->breadcrumb_data, TRUE);
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;

		$this->parser->parse('template/' . $template_name . '/homepage_view', $this->data);
	}

	/**
	 * Default Validation
	 * see also https://www.codeigniter.com/userguide3/libraries/form_validation.html
	 */
	public function formValidate()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('email', 'อีเมล', 'trim|required');
		$frm->set_rules('tel_number', 'เบอร์โทรศัพท์', 'trim|required');
		$frm->set_rules('line_id', 'ไอดี Line', 'trim|required');

		$frm->set_message('required', 'กรุณากรอก %s');
		$frm->set_message('is_natural', '- %s ต้องระบุตัวเลขจำนวนเต็ม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('email');
			$message .= form_error('tel_number');
			$message .= form_error('line_id');
			return $message;
		}
	}

	/**
	 * Load data to form
	 * @param String encrypt id
	 */
	public function edit($encrypt_id = '')
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'ข้อมูลผู้ใช้งาน', 'class' => 'active', 'url' => '#'),
		);

		$id = $this->session->userdata('user_id'); //App User
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('message/warning');
		} else {
			$results = $this->Profile->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง $id";
				$this->render_view('message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);
				$this->setPreviewFormat($results);
				$this->render_view('member_profile/profile_edit');
			}
		}
	}


	// ------------------------------------------------------------------------
	public function checkRecordKey($data)
	{
		$error = '';
		$userid = checkEncryptData($data['encrypt_userid']);
		if ($userid == '') {
			$error .= '<br/>- รหัส userid';
		}
		return $error;
	}

	/**
	 * Update Record
	 */
	public function update()
	{
		$message = $this->formValidate();
		$edit_remark = $this->input->post('edit_remark', TRUE);
		if ($edit_remark == '') {
			$message .= 'ระบุเหตุผล';
		}

		$post = $this->input->post(NULL, TRUE);
		$error_pk_id = $this->checkRecordKey($post);
		if ($error_pk_id != '') {
			$message .= "รหัสอ้างอิงที่ใช้สำหรับอัพเดตข้อมูลไม่ถูกต้อง";
		}
		if ($message != '') {
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {

			$result = $this->Profile->update($post);
			if ($result == false) {
				$message = $this->Profile->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Profile->error_message;
				$ok = TRUE;
			}
			$json = json_encode(array(
				'is_successful' => $ok,
				'message' => $message
			));

			echo $json;
		}
	}

	/**
	 * Get title from level value
	 */
	private function setLevel($value)
	{
		return $this->Profile->getValueOf('tb_members_level', 'level_title', "level_value = $value");
	}

	/**
	 * SET array data list
	 */
	private function setPreviewFormat($lists_data)
	{

		$data = $lists_data;
		$pk1 = $data['userid'];

		$this->data['record_username'] = $data['username'];
		$this->data['record_fullname'] = $data['fullname'];
		$this->data['record_lastname'] = $data['lastname'];
		$this->data['record_email'] 	= $data['email'];
		$this->data['record_tel_number'] = $data['tel_number'];
		$this->data['record_line_id'] 	= $data['line_id'];

		$this->data['url_encrypt_id'] = urlencode(encrypt($pk1));

		if ($pk1 != '') {
			$pk1 = encrypt($pk1);
		}
		$this->data['encrypt_userid'] = $pk1;

		$departmentName = $this->Profile->getValueOf('tb_department', 'dpm_name', "dpm_id = $data[department_id]");
		$this->data['record_department_name'] = $departmentName;

		$createUserIdFullname = '';
		$createUserIdLastname = '';
		if ($data['create_user_id'] != '') {
			$titleRow = $this->Profile->getRowOf($this->tbMember, 'fullname, lastname', "userid = $data[create_user_id]", $this->db);
			$createUserIdFullname = $titleRow['fullname'];
			$createUserIdLastname = $titleRow['lastname'];
		}
		$this->data['record_create_fullname'] = $createUserIdFullname;
		$this->data['record_create_lastname'] = $createUserIdLastname;

		$modifyUserIdFullname = '';
		$modifyUserIdLastname = '';
		if ($data['modify_user_id'] != '') {
			$titleRow = $this->Profile->getRowOf($this->tbMember, 'fullname, lastname', "userid = $data[modify_user_id]", $this->db);
			$modifyUserIdFullname = $titleRow['fullname'];
			$modifyUserIdLastname = $titleRow['lastname'];
		}
		$this->data['record_modify_fullname'] = $modifyUserIdFullname;
		$this->data['record_modify_lastname'] = $modifyUserIdLastname;

		$this->data['record_create_date'] = setThaiDate($data['create_date']);
		$this->data['record_modify_date'] = setThaiDate($data['modify_date']);
		$this->data['record_level'] = $this->setLevel($data['level']);
	}

	public function change_passwd()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('resetPassword1', 'รหัสผ่านใหม่', 'trim|required');
		$frm->set_rules('resetPassword2', 'ยืนยันรหัสผ่านใหม่', 'trim|required');
		$frm->set_rules('uPasswordOld', 'รหัสผ่านเดิม', 'trim|required');

		$frm->set_message('required', 'กรุณากรอก %s');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('resetPassword1');
			$message .= form_error('resetPassword2');
			$message .= form_error('uPasswordOld');
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {
			$post = $this->input->post(NULL, TRUE);

			if ($post['resetPassword1'] != $post['resetPassword2']) {
				echo json_encode(array(
					'is_successful' => FALSE,
					'message' => 'กรุณายืนยันรหัสผ่านให้ตรงกัน'
				));
				return;
			}

			$result = $this->Profile->update_password($post);
			if ($result) {
				$json = array(
					'is_successful' => TRUE,
					'message' => '<strong>บันทึกข้อมูลเรียบร้อย</strong>'
				);
			} else {
				$json = array(
					'is_successful' => FALSE,
					'message' => $this->Profile->error_message
				);
			}
			echo json_encode($json);
		}
	}
}
/*---------------------------- END Controller Class --------------------------------*/
