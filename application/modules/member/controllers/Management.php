<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Members_manage.php ]
 */
class Management extends MEMBER_Controller
{

	private $another_js;
	private $another_css;
	private $tbMember;

	private $upload_store_path;
	private $file_allow;
	private $file_allow_type;
	private $file_allow_mime;
	private $file_check_name;

	public function __construct()
	{
		parent::__construct();
		$this->per_page = 30;
		$this->num_links = 6;
		$this->uri_segment = 3;
		$this->load->model('Member_profile_model', 'Member_profile');
		$this->load->model('Login_model', 'Login_model');

		$this->tbMember = 'tb_members';

		$this->data['page_url'] = site_url('member/management');
		$this->data['page_title'] = 'CEO Softs';

		$js_url = 'assets/js_modules/member/manage.js';
		$this->another_js = '<script src="' . base_url($js_url) . '"></script>';

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

		if (!$this->is_logged_in()) {
			redirect('member/login');
		}
	}

	protected function render_view($path)
	{
		$template_name = 'sb-admin-bs4';
		$this->data['top_navbar'] = $this->parser->parse('template/' . $template_name . '/top_navbar_view', $this->top_navbar_data, TRUE);

		$this->data['left_sidebar'] = $this->parser->parse('template/' . $template_name . '/left_sidebar_view', $this->left_sidebar_data, TRUE);

		$this->data['breadcrumb_list'] = $this->parser->parse('template/' . $template_name . '/breadcrumb_view', $this->breadcrumb_data, TRUE);

		if (!$this->isAdmin()) {
			$this->data['page_content'] = $this->parser->parse_repeat('admin_permission', $this->data, TRUE);
		} else {
			$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
		}

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
		$this->list_all();
	}

	/**
	 * Set up pagination config
	 * @param String path of controller
	 * @param Integer total record
	 */
	public function create_pagination($page_url, $total)
	{
		$this->load->library('pagination');
		$config['base_url'] = $page_url;
		$config['total_rows'] = $total;
		$config['per_page'] = $this->per_page;
		$config['num_links'] = $this->num_links;
		$config['uri_segment'] = $this->uri_segment;
		$config['attributes'] = array('class' => 'page-link');
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}

	// ------------------------------------------------------------------------

	/**
	 * List all record 
	 */
	public function list_all()
	{
		$this->session->unset_userdata('member_manage_search_field');
		$this->session->unset_userdata('member_manage_search_value');
		$this->session->unset_userdata('member_manage_search_order_by');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'รายชื่อสมาชิก', 'class' => 'active', 'url' => '#'),
		);

		$search_order_by = '';
		if (isset($_POST['submit'])) {
			$search_field 	=  $this->input->post('search_field');
			$value 			= $this->input->post('txtSearch');
			$search_order_by =  $this->input->post('order_by', TRUE);

			$arr = array(
				'member_manage_search_field' => $search_field,
				'member_manage_search_value' => $value,
				'member_manage_search_order_by' => $search_order_by,
			);

			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata('member_manage_search_field');
			$value = $this->session->userdata('member_manage_search_value');
			$search_order_by = $this->session->userdata('member_manage_search_order_by');
		}

		$start_row = $this->uri->segment($this->uri_segment, '0');
		if (!is_numeric($start_row)) {
			$start_row = 0;
		}

		$per_page = $this->per_page;

		if ($search_order_by != '') {
			$arr = explode('|', $search_order_by);
			$field = $arr[0];
			$sort = $arr[1];
			switch ($sort) {
				case 'asc':
					$sort = 'ASC';
					break;
				case 'desc':
					$sort = 'DESC';
					break;
			}
			$this->Member_profile->order_field = $field;
			$this->Member_profile->order_sort = $sort;
		}

		$results = $this->Member_profile->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataFormat($results['list_data'], $start_row);

		$page_url = site_url('member/management');
		$pagination = $this->create_pagination($page_url . '/search', $search_row);
		$end_row = $start_row + $per_page;
		if ($search_row < $per_page) {
			$end_row = $search_row;
		}

		$this->data['recData']	= $list_data;
		$this->data['search_field']	= $search_field;
		$this->data['txt_search']	= $value;
		$this->data['current_page_offset'] = $start_row;
		$this->data['start_row']	= $start_row + 1;
		$this->data['end_row']	= $end_row;
		$this->data['order_by']	= $search_order_by;
		$this->data['total_row']	= $total_row;
		$this->data['search_row']	= $search_row;
		$this->data['page_url']	= $page_url;
		$this->data['pagination_link']	= $pagination;
		$this->data['csrf_protection']	= insert_csrf_field(true);

		$this->render_view('member_manage/list_view');
	}

	/**
	 * Get title from level value
	 */
	private function setLevel($value)
	{
		return $this->Member_profile->getValueOf('tb_members_level', 'level_title', "level_value = $value"); //setค่าตามค่าตัวเลข แปลงค่าจากตัวเลขเป็นชื่อ
	}

	/**
	 * Get title from prefix value
	 */
	private function setPrefix($value)
	{
		return $this->Member_profile->getValueOf('tb_members_prefix', 'prefix_name', "id = $value"); //setค่าตามค่าตัวเลข แปลงค่าจากตัวเลขเป็นชื่อ
	}

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'รายชื่อสมาชิก', 'url' => site_url('member/management')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('message/warning');
		} else {
			$results = $this->Member_profile->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('message/danger');
			} else {
				$this->data['master_data'] = $this->setPreviewFormat($results);
				$this->render_view('member_manage/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------
	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Members', 'url' => site_url('member/management')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);

		// $options = array(
		// 	'join' => "LEFT JOIN tb_members_prefix ON tb_members.prefix = tb_members_prefix.id"
		// );

		$this->data['department_option_list'] = optionList("tb_department", "dpm_id", "dpm_name", array('return' => true), $this->db);
		$this->data['members_prefix_option_list'] = optionList("tb_members_prefix", "id", "prefix_name", array('return' => true), $this->db);
		$this->data['members_level_option_list'] = optionList("tb_members_level", "level_value", "level_title", array('return' => true), $this->db);
		$this->data['status_option_list'] = optionList("tb_status", "dpm_void", "dpm_name", array('return' => true), $this->db);
		$this->render_view('member_manage/add_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Default Validation
	 * see also https://www.codeigniter.com/userguide3/libraries/form_validation.html
	 */
	public function formValidate($case = '')
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;
		if ($case == 'insert') {
			$frm->set_rules('username', 'ชื่อผู้ใช้งาน', 'trim|required');
			$frm->set_rules('password', 'รหัสผ่าน', 'trim|required');
		}
		$frm->set_rules('level', 'สิทธิ์การใช้งาน', 'trim|required|is_natural');
		$frm->set_rules('email', 'อีเมล', 'trim|required');
		$frm->set_rules('tel_number', 'เบอร์โทรศัพท์', 'trim|required');
		$frm->set_rules('line_id', 'ไอดี Line', 'trim|required');
		$frm->set_rules('prefix', 'คำนำหน้าชื่อ', 'trim');
		$frm->set_rules('firstname', 'ชื่อ', 'trim|required');
		$frm->set_rules('lastname', 'นามสกุล', 'trim|required');
		$frm->set_rules('department_id', 'ไอดีหน่วยงาน', 'trim|required|is_natural');

		$frm->set_message('required', 'กรุณากรอก %s');
		$frm->set_message('is_natural', '- %s ต้องระบุตัวเลขจำนวนเต็ม');

		if ($frm->run() == FALSE) {
			$message  = '';
			if ($case == 'insert') {
				$message .= form_error('username');
				$message .= form_error('password');
			}
			$message .= form_error('level');
			$message .= form_error('email');
			$message .= form_error('tel_number');
			$message .= form_error('line_id');
			$message .= form_error('prefix');
			$message .= form_error('firstname');
			$message .= form_error('lastname');
			$message .= form_error('department_id');
			return $message;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Create new record
	 */
	public function save()
	{

		if ($message = $this->formValidate()) {
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {
			$post = $this->input->post(NULL, TRUE);

			$id = $this->Member_profile->create($post);
			if ($id !== false) {
				$encrypt_id = encrypt($id);

				$json = json_encode(array(
					'is_successful' => TRUE,
					'encrypt_id' =>  $encrypt_id,
					'message' => '<strong>บันทึกข้อมูลเรียบร้อย</strong>'
				));
			} else {
				$json = json_encode(array(
					'is_successful' => FALSE,
					'message' => $this->Member_profile->error_message
				));
			}
			echo $json;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Load data to form
	 * @param String encrypt id
	 */
	public function edit($encrypt_id = '')
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'รายชื่อสมาชิก', 'url' => site_url('member/management')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		// $options = array(
		// 	'join' => "LEFT JOIN tb_members_prefix ON tb_members.prefix = tb_members_prefix.id"
		// );
		// $option_list = $this->Resume->returnOptionList("tb_members", "userid", "CONCAT(prefix_name,firstname,' ',lastname)", $options);

		$encrypt_id = urldecode($encrypt_id);
		$id = decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('message/warning');
		} else {
			$results = $this->Member_profile->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);
				$this->data['master_data'] = $this->setPreviewFormat($results);
				$this->data['department_option_list'] = optionList("tb_department", "dpm_id", "dpm_name", array('return' => true), $this->db);
				$this->data['members_prefix_option_list'] = optionList("tb_members_prefix", "id", "prefix_name", array('return' => true), $this->db);
				// $this->data['tb_members_member_id_option_list'] = $option_list;
				$this->data['members_level_option_list'] = optionList("tb_members_level", "level_value", "level_title", array('return' => true), $this->db);
				$this->data['status_option_list'] = optionList("tb_status", "dpm_void", "dpm_name", array('return' => true), $this->db);
				$this->render_view('member_manage/edit_view');
			}
		}
	}

	// ------------------------------------------------------------------------
	public function checkRecordKey($data)
	{
		$error = '';
		$userid = checkEncryptData($data['encrypt_userid']);
		if ($userid == '') {
			$error .= '- รหัส userid';
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
				$result = $this->Member_profile->update($post);
				if ($result == false) {
					$message = $this->Member_profile->error_message;
					$ok = FALSE;
				} else {
					$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Member_profile->error_message;
					$ok = TRUE;
				}
			} else {
				$ok = FALSE;
				$message = $upload_error_msg;
			}

			$json = json_encode(array(
				'is_successful' => $ok,
				'message' => $message
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
	 * Delete Record
	 */
	public function del()
	{
		$delete_remark = $this->input->post('delete_remark', TRUE);
		$message = '';
		if ($delete_remark == '') {
			$message .= 'ระบุเหตุผล';
		}

		$post = $this->input->post(NULL, TRUE);
		$error_pk_id = $this->checkRecordKey($post);
		if ($error_pk_id != '') {
			$message .= "รหัสอ้างอิงที่ใช้สำหรับลบข้อมูลไม่ถูกต้อง";
		}
		if ($message != '') {
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {
			$result = $this->Member_profile->delete($post);
			if ($result == false) {
				$message = $this->Member_profile->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>ลบข้อมูลเรียบร้อย</strong>';
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
	 * SET array data list
	 */
	private function setDataFormat($lists_data, $start_row = 0)
	{
		$data = $lists_data;
		$count = count($lists_data);
		for ($i = 0; $i < $count; $i++) {
			$start_row++;
			$data[$i]['record_number'] = $start_row;
			$pk1 = $data[$i]['userid'];
			$data[$i]['url_encrypt_id'] = urlencode(encrypt($pk1));

			if ($pk1 != '') {
				$pk1 = encrypt($pk1);
			}
			$data[$i]['encrypt_userid'] = $pk1;
			$data[$i]['create_datetime'] = setThaiDate($data[$i]['create_datetime']);
			$data[$i]['modify_datetime'] = setThaiDate($data[$i]['modify_datetime']);

			$count_pass = strlen($data[$i]['password']);
			$data[$i]['password'] = str_repeat('*', $count_pass);
			$data[$i]['level_text'] = $this->setLevel($data[$i]['level']); //แปลงจากหมายเลขเป็นตัวหนังสือ
			$data[$i]['prefix_text'] = $this->setPrefix($data[$i]['prefix']); //แปลงจากหมายเลขเป็นตัวหนังสือ
			$data[$i]['show_photo'] = $this->check_photo($data[$i]['photo']);
		}
		return $data;
	}

	private function check_photo($photo)
	{
		if (!file_exists($photo)) {
			$photo = 'assets/images/avatar.png';
		}
		return $photo;
	}

	/**
	 * SET array data list
	 */
	private function setPreviewFormat($lists_data)
	{
		$data = $lists_data;
		$pk1 = $data['userid'];
		$data['url_encrypt_id'] = urlencode(encrypt($pk1));

		if ($pk1 != '') {
			$pk1 = encrypt($pk1);
		}
		$data['encrypt_userid'] = $pk1;

		$departmentIdDepartmentName = $this->Member_profile->getValueOf('tb_department', 'dpm_name', "dpm_id = '$data[department_id]'");
		$data['departmentIdDepartmentName'] = $departmentIdDepartmentName;

		$titleRow = $this->Member_profile->getRowOf('tb_members', 'firstname, lastname', "userid = '$data[create_user_id]'", $this->db);
		if (!empty($titleRow)) {
			$createUserIdFullname = $titleRow['firstname'];
			$createUserIdLastname = $titleRow['lastname'];
		} else {
			$createUserIdFullname = '';
			$createUserIdLastname = '';
		}
		$data['createUserIdFullname'] = $createUserIdFullname;
		$data['createUserIdLastname'] = $createUserIdLastname;


		$titleRow = $this->Member_profile->getRowOf('tb_members', 'firstname, lastname', "userid = '$data[modify_user_id]'", $this->db);
		if (!empty($titleRow)) {
			$modifyUserIdFullname = $titleRow['firstname'];
			$modifyUserIdLastname = $titleRow['lastname'];
		} else {
			$modifyUserIdFullname = '';
			$modifyUserIdLastname = '';
		}
		$data['modifyUserIdFullname'] = $modifyUserIdFullname;
		$data['modifyUserIdLastname'] = $modifyUserIdLastname;

		$data['create_datetime'] = setThaiDate($data['create_datetime']);
		$data['modify_datetime'] = setThaiDate($data['modify_datetime']);

		$count_pass = strlen($data['password']);
		$data['password'] = str_repeat('*', $count_pass);
		$data['level_text'] = $this->setLevel($data['level']); //แปลงจากหมายเลขเป็นตัวหนังสือ
		$data['prefix_text'] = $this->setPrefix($data['prefix']); //แปลงจากหมายเลขเป็นตัวหนังสือ

		$void_class = 'bg-success ';
		if ($data['void'] == 1) {
			$void_class = 'bg-danger text-white';
		}
		$data['void_class'] = $void_class;

		$this->data['record_photo'] = $data['photo'];

		$arr = explode('/', $data['photo']);
		$encrypt_name = end($arr);
		$filename = $this->Member_profile->getValueOf('tb_uploads_filename', 'filename', "encrypt_name = '$encrypt_name'", $this->db);
		$this->data['record_photo_label'] = $filename;
		$this->data['preview_photo'] = setAttachPreview('photo', $data['photo'], $filename);

		return array('master' => $data);
	}

	public function reset_password()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('password1', 'รหัสผ่านใหม่', 'trim|required');
		$frm->set_rules('password2', 'ยืนยันรหัสผ่านใหม่', 'trim|required');
		$frm->set_rules('adminPassword', 'รหัสผ่านแอดมินผู้แก้ไข', 'trim|required');
		$frm->set_rules('encrypt_userid', 'รหัสสมาชิกที่ต้องการเปลี่ยนแปลง', 'trim|required');

		$frm->set_message('required', 'กรุณากรอก %s');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('password1');
			$message .= form_error('password2');
			$message .= form_error('adminPassword');
			$message .= form_error('encrypt_userid');
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {
			$post = $this->input->post(NULL, TRUE);

			if ($post['password1'] != $post['password2']) {
				echo json_encode(array(
					'is_successful' => FALSE,
					'message' => 'กรุณายืนยันรหัสผ่านให้ตรงกัน'
				));
				return;
			}

			$member_id = checkEncryptData($post['encrypt_userid']);
			if ($member_id == '') {
				echo json_encode(array(
					'is_successful' => FALSE,
					'message' => 'ไม่พบรหัสสมาชิกที่ต้องการเปลี่ยนแปลง <b>' . $post['encrypt_userid'] . '</b> เป็นรหัสสมาชิกที่ไม่ถูกต้อง'
				));
				return;
			}

			$post['uPasswordOld'] = NULL; //bypass
			$post['resetPassword2'] = $post['password1'];
			$result = $this->Member_profile->update_password($post, $member_id);
			if ($result) {
				$json = array(
					'is_successful' => TRUE,
					'message' => '<strong>บันทึกข้อมูลเรียบร้อย</strong>'
				);
			} else {
				$json = array(
					'is_successful' => FALSE,
					'message' => $this->Member_profile->error_message
				);
			}
			echo json_encode($json);
		}
	}
}
/*---------------------------- END Controller Class --------------------------------*/
