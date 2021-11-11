<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Profile.php ]
 */
class Profile extends CRUD_Controller
{
	private $my_table;
	private $another_css;

	public function __construct()
	{
		parent::__construct();
		$this->my_table = 'tb_members';

		$this->load->model('Profile_model', 'Profile');
		$this->load->model('Login_model');

		if (!$this->check_is_login()) {
			redirect('member/login');
		}

		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'ข้อมูลผู้ใช้งาน', 'class' => 'active', 'url' => '#'),
		);

		$this->another_js = $this->add_js_modules('member/profile.js');

		$this->upload_store_path = './assets/uploads/members/';
		$this->file_allow = array(
			'application/pdf' => 'pdf',
			'application/msword' => 'doc',
			'application/vnd.ms-msword' => 'doc',
			'application/vnd.ms-excel' => 'xls',
			'application/powerpoint' => 'ppt',
			'application/vnd.ms-powerpoint' => 'ppt',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
			'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
			'application/vnd.oasis.opendocument.text' => 'odt',
			'application/vnd.oasis.opendocument.spreadsheet' => 'ods',
			'application/vnd.oasis.opendocument.presentation' => 'odp',
			'image/bmp' => 'bmp',
			'image/png' => 'png',
			'image/pjpeg' => 'jpeg',
			'image/jpeg' => 'jpg'
		);
		$this->file_allow_type = array_values($this->file_allow);
		$this->file_allow_mime = array_keys($this->file_allow);
		$this->file_check_name = '';
	}

	protected function render_view($path)
	{
		$template_name = 'sb-admin-bs4';

		$this->data['top_navbar'] = $this->parser->parse('template/' . $template_name . '/top_navbar_view', $this->top_navbar_data, TRUE);
		$this->data['left_sidebar'] = $this->parser->parse('template/' . $template_name . '/left_sidebar_view', $this->left_sidebar_data, TRUE);
		$this->data['breadcrumb_list'] = $this->parser->parse('template/' . $template_name . '/breadcrumb_view', $this->breadcrumb_data, TRUE);

		$this->data['csrf_protection'] = $this->data['csrf_protection_field'];
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);

		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;
		$this->parser->parse('template/' . $template_name . '/homepage_view', $this->data);
	}

	// ------------------------------------------------------------------------
	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->edit();
	}

	/**
	 * Default Validation
	 * see also https://www.codeigniter.com/userguide3/libraries/form_validation.html
	 */
	public function formValidate()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('firstname', 'ชื่อ', 'trim|required');
		$frm->set_rules('lastname', 'นามสกุล', 'trim|required');


		$frm->set_message('required', 'กรุณากรอก %s');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('firstname');
			$message .= form_error('lastname');
			return $message;
		}
	}

	/**
	 * Load data to form
	 * @param String encrypt id
	 */
	public function edit($encrypt_id = '')
	{
		$id = $this->session->userdata('user_id');
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
				$this->data['master_data'] = $this->setPreviewFormat($results);

				$this->data['tb_members_prefix_prefix_option_list'] = $this->Profile->returnOptionList("tb_members_prefix", "id", "prefix_name");

				$this->render_view('profile_edit');
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
		$message .= $this->formValidateWithFile();

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
			$file_path = '';
			$this->load->model('FileUpload_model', 'FileUpload');
			$upload_error = 0;
			$upload_error_msg = '';
			if (!empty($_FILES['photo']['name'])) {
				$config = array();
				$config['width'] = 300;
				$arr = $this->uploadFile('photo', '', $config);
				if ($arr['result'] == TRUE) {

					$post['photo'] = $arr['file_path'];
					$this->removeFile($post['photo_old_path']);
					$arr = explode('/', $post['photo_old_path']);
					$encrypt_name = end($arr);
					$this->FileUpload->delete($encrypt_name);

					$file_path = base_url($post['photo']);
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}

			if ($upload_error == 0) {
				$result = $this->Profile->update($post);
				if ($result == false) {
					$message = $this->Profile->error_message;
					$ok = FALSE;
				} else {
					$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Profile->error_message;
					$ok = TRUE;
				}
			} else {
				$ok = FALSE;
				$message = $upload_error_msg;
			}
			$json = json_encode(array(
				'is_successful' => $ok,
				'message' => $message,
				'photo' => $file_path
			));

			echo $json;
		}
	}

	public function formValidateWithFile()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;
		$message = '';
		if (!empty($_FILES['photo']['name'])) {
			$this->file_check_name = 'photo';
			$frm->set_rules('photo', 'ภาพประจำตัว', 'callback_file_check');
			if ($frm->run() == FALSE) {
				$message .= form_error('photo');
			}
		}
		return $message;
	}
	public function file_check()
	{
		$allowed_mime_type_arr = $this->file_allow_mime;
		$mime = get_mime_by_extension($_FILES[$this->file_check_name]['name']);
		if (isset($_FILES[$this->file_check_name]['name']) && $_FILES[$this->file_check_name]['name'] != '') {
			if (in_array($mime, $allowed_mime_type_arr)) {
				return true;
			} else {
				$this->form_validation->set_message('file_check', '- กรุณาเลือกประเภทไฟล์  ' . implode(" | ", $this->file_allow_type) . ' เท่านั้นครับ');
				return false;
			}
		} else {
			//$this->form_validation->set_message('file_check', '- กรุณาเลือกไฟล์ %s');
			//return false;
			return true;
		}
	}
	private function resize_photo($full_path, $width)
	{
		$config['image_library'] 	= 'gd2';
		$config['source_image'] 	= $full_path;
		$config['quality'] 			= 80;
		$config['width'] 			= $width;
		$config['maintain_ratio'] 	= TRUE;
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();
	}
	private function uploadFile($file_name, $dir = '', $config = array())
	{
		if ($dir != '' && substr($dir, 0, 1) != '/') {
			$dir = '/' . $dir;
		}
		$path = $this->upload_store_path . (date('Y') + 543) . $dir;
		//เปิดคอนฟิก Auto ชื่อไฟล์ใหม่ด้วย
		$config['upload_path']          = $path;
		$config['allowed_types']        = $this->file_allow_type;
		$config['encrypt_name']			= TRUE;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload($file_name)) {
			$encrypt_name = $this->upload->file_name;
			$orig_name = $this->upload->orig_name;
			$this->FileUpload->create($encrypt_name, $orig_name);

			$file_path = $path . '/' . $encrypt_name; //ไม่ต้องใช้ Path เต็ม
			$data = array(
				'result' => TRUE,
				'file_path' => $file_path,
				'error' => ''
			);

			if (isset($config['width'])) {
				$this->resize_photo($file_path, $config['width']);
			}
		} else {
			$data = array(
				'result' => FALSE,
				'error' => $this->upload->display_errors()
			);
		}
		return $data;
	}
	private function removeFile($file_path)
	{
		if ($file_path != '') {
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}
	}

	/**
	 * SET array data list
	 */
	private function setPreviewFormat($lists_data)
	{

		$data = $lists_data;
		$pk1 = $data['userid'];

		$this->data['url_encrypt_id'] = urlencode(encrypt($pk1));

		if ($pk1 != '') {
			$pk1 = encrypt($pk1);
		}
		$this->data['encrypt_userid'] = $pk1;

		// Get encrypt from question table

		$arr_ques = $this->Profile->getUserQuestion($data['username']);
		if (!empty($arr_ques)) {
			$this->data['encrypt_username'] = ci_encrypt($arr_ques['username']);
			$this->data['forgot_question'] = $arr_ques['question'];
		} else {
			$this->data['encrypt_username'] = '';
			$this->data['forgot_question'] = '';
		}

		$prefixprefixName = $this->Profile->getValueOf('tb_members_prefix', 'prefix_name', "id = $data[prefix]");
		$this->data['prefixprefixName'] = $prefixprefixName;

		$levelLevelTitle = $this->Profile->getValueOf('tb_members_level', 'level_title', "level_value = $data[level]");
		$this->data['levelLevelTitle'] = $levelLevelTitle;

		$departmentIdDpmName = $this->Profile->getValueOf('tb_department', 'dpm_name', "dpm_id = $data[department_id]");
		$this->data['departmentIdDpmName'] = $departmentIdDpmName;

		$this->data['record_userid'] = $data['userid'];
		$this->data['record_username'] = $data['username'];
		$this->data['record_password'] = $data['password'];

		$this->data['record_prefix'] = $data['prefix'];

		$this->data['record_firstname'] = $data['firstname'];
		$this->data['record_lastname'] = $data['lastname'];
		$this->data['preview_sex'] = $this->setSexSubject($data['sex']);
		$this->data['record_sex'] = $data['sex'];

		$this->data['record_level'] = $data['level'];

		$this->data['record_email'] = $data['email'];
		$this->data['record_tel_number'] = $data['tel_number'];
		$this->data['record_line_id'] = $data['line_id'];
		$this->data['record_department_id'] = $data['department_id'];
		$this->data['record_photo'] = $data['photo'];

		$arr = explode('/', $data['photo']);
		$encrypt_name = end($arr);
		$filename = $this->Profile->getValueOf('tb_uploads_filename', 'filename', "encrypt_name = '$encrypt_name'", $this->db);
		$this->data['record_photo_label'] = $filename;

		$this->data['preview_photo'] = setAttachPreview('photo', $data['photo'], $filename);
		$this->data['record_void'] = $data['void'];
		$this->data['record_create_datetime'] = $data['create_datetime'];
		$this->data['record_create_user_id'] = $data['create_user_id'];
		$this->data['record_modify_datetime'] = $data['modify_datetime'];
		$this->data['record_modify_user_id'] = $data['modify_user_id'];

		$this->data['record_create_datetime'] = setThaiDate($data['create_datetime']);
		$this->data['record_modify_datetime'] = setThaiDate($data['modify_datetime']);

		if ($data['create_user_id'] != '') {
			$titleRow = $this->Profile->getRowOf($this->my_table, 'firstname, lastname', "userid = $data[create_user_id]", $this->db);
			$createUserIdFirstname = $titleRow['firstname'];
			$createUserIdLastname = $titleRow['lastname'];
			$this->data['createUserIdFirstname'] = $createUserIdFirstname;
			$this->data['createUserIdLastname'] = $createUserIdLastname;
		}

		if ($data['modify_user_id'] != '') {
			$titleRow = $this->Profile->getRowOf($this->my_table, 'firstname, lastname', "userid = $data[modify_user_id]", $this->db);
			$modifyUserIdFirstname = $titleRow['firstname'];
			$modifyUserIdLastname = $titleRow['lastname'];
			$this->data['modifyUserIdFirstname'] = $modifyUserIdFirstname;
			$this->data['modifyUserIdLastname'] = $modifyUserIdLastname;
		}
		$this->data['firstname'] = $data['firstname'];
		$this->data['lastname'] = $data['lastname'];
		$this->data['email'] = $data['email'];
		$this->data['unsubscribe'] = $data['unsubscribe'];
		if ($data['unsubscribe'] == 1) {
			$this->data['unsubscribe_label'] = 'ไม่รับอีเมลข่าวสาร';
			$this->data['unsubscribe_class'] = 'danger';
			$this->data['unsubscribe_title'] = 'คลิกที่นี่ เพื่อเปิดรับอีเมลข่าวสาร';
		} else {
			$this->data['unsubscribe_label'] = 'รับอีเมลข่าวสาร';
			$this->data['unsubscribe_class'] = 'success';
			$this->data['unsubscribe_title'] = 'คลิกที่นี่ เพื่อยกเลิกการรับอีเมลข่าวสาร';
		}

		$this->data['birthday_th'] = setThaiDate($data['birthday']);
	}

	/**
	 * SET choice subject
	 */
	private function setSexSubject($value)
	{
		$subject = '';
		switch ($value) {
			case 1:
				$subject = 'ชาย';
				break;
			case 2:
				$subject = 'หญิง';
				break;
		}
		return $subject;
	}


	public function formValidateQuestion()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('question', 'คำถาม', 'trim|required');
		$frm->set_rules('answer', 'คำตอบ', 'trim|required');
		$frm->set_rules('birthday', 'วันเกิด', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');


		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('question');
			$message .= form_error('answer');
			$message .= form_error('birthday');
			return $message;
		}
	}

	public function save_question()
	{
		$message = '';
		$message .= $this->formValidateQuestion();

		$post = $this->input->post(NULL, TRUE);

		if ($message != '') {
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {

			$encrypt_id = '';
			if ($post['encrypt_username'] == '') {
				$result = $this->Profile->create_question($post);
			} else {
				$result = $this->Profile->update_question($post);
			}

			if ($result) {
				$success = TRUE;
				$encrypt_id = ci_encrypt($post['username']);
				$message = '<strong>บันทึกคำถามเรียบร้อย</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Profile->error_message;
			}

			$json = json_encode(array(
				'is_successful' => $success,
				'encrypt_id' =>  $encrypt_id,
				'message' => $message
			));
			echo $json;
		}
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

	public function change_email()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('new_email', 'รหัสผ่านใหม่', 'trim|required|valid_email');
		$frm->set_rules('confirm_password', 'ยืนยันรหัสผ่าน', 'trim|required');

		$frm->set_message('required', 'กรุณากรอก %s');
		$frm->set_message('valid_email', 'กรุณาตรวจสอบรูปแบบอีเมลให้ถูกต้อง');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('new_email');
			$message .= form_error('confirm_password');
			$json = array(
				'is_successful' => FALSE,
				'message' => $message
			);
			echo json_encode($json);
		} else {
			$post = $this->input->post(NULL, TRUE);

			$result = $this->Profile->update_email($post);
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

	public function unsubscribe()
	{
		$post = $this->input->post(NULL, TRUE);
		if ($post['unsubscribe'] == 1) {
			$value = 0;
		} else {
			$value = 1;
		}
		$result = $this->Profile->unsubscribe($value);
		if ($result) {
			$json = array(
				'is_successful' => TRUE,
				'message' => '<strong>ยกเลิกการรับอีเมลข่าวสารเรียบร้อย</strong>'
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
/*---------------------------- END Controller Class --------------------------------*/
