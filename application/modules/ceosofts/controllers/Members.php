<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Members.php ]
 */
class Members extends MEMBER_Controller
{
	protected $session;
	protected $parser;
	protected $pagination;

	private $per_page;
	private $num_links;
	private $another_js = '';
	private $another_css;
	private $upload_store_path;
	private $file_allow;
	private $file_allow_type;
	private $file_allow_mime;
	private $file_check_name;
	private $uri_segment;
	private $Members;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('parser');
		$this->per_page = 30;
		$this->num_links = 6;
		$this->uri_segment = 4;
		$this->load->model('ceosofts/Members_model', 'Members');
		$this->Members->session_name = 'ceosofts_members';

		$this->load->model('FileUpload_model', 'FileUpload');
		$this->data['page_url'] = site_url('ceosofts/members');

		$this->data['page_title'] = 'CEO Softs';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');
		$this->upload_store_path = './assets/uploads/members/';
		$this->file_allow = array(
			'application/pdf' => 'pdf',
			'application/msword' => 'doc',
			'application/vnd.ms-excel' => 'xls',
			'application/powerpoint' => 'ppt',
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

		$js_url = 'assets/js_modules/ceosofts/members.js?ft=' . filemtime('assets/js_modules/ceosofts/members.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Members', 'class' => 'active', 'url' => '#'),
		);
		if ($this->session->userdata('login_validated') == false) {
			$this->load->view('ceosofts/members/login_view', $this->data);
			return;
		}
		$this->list_all();
	}

	// ------------------------------------------------------------------------

	/**
	 * Render this controller page
	 * @param String path of controller
	 * @param Integer total record
	 */
	protected function render_view($path)
	{
		$this->data['top_navbar'] = $this->parser->parse('template/sb-admin-bs4/top_navbar_view', $this->top_navbar_data, TRUE);
		$this->data['left_sidebar'] = $this->parser->parse('template/sb-admin-bs4/left_sidebar_view', $this->left_sidebar_data, TRUE);
		$this->data['breadcrumb_list'] = $this->parser->parse('template/sb-admin-bs4/breadcrumb_view', $this->breadcrumb_data, TRUE);
		if ($this->session->userdata('login_validated') == false) {
			$this->data['page_content'] = $this->parser->parse_repeat('member_permission.php', $this->data, TRUE);
			$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$this->session->set_userdata('after_login_redirect', $current_url);
		} else {
			if ($this->session->userdata('user_level') >= 1 && ($this->session->userdata('user_department_id') == 11 || $this->session->userdata('user_department_id') == 12)) {
				// User has the required level and department
			} else {
				$this->data['alert_message'] = 'เฉพาะผู้ใช้งานระดับ <b>ผู้ใช้งานทั่วไป</b> และ เฉพาะผู้ใช้งานแผนก <b>ฝ่ายไอที</b>';
				$this->data['page_content'] = $this->parser->parse_repeat('member_authen_permission.php', $this->data, TRUE);
			}
		}
		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;
		$this->data['utilities_file_time'] = filemtime('assets/js/ci_utilities.js');
		$this->parser->parse('template/sb-admin-bs4/homepage_view', $this->data);
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
		$this->session->unset_userdata($this->Members->session_name . '_search_field');
		$this->session->unset_userdata($this->Members->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Members', 'class' => 'active', 'url' => '#'),
		);
		$search_field = '';
		$value = '';
		if (isset($_POST['submit'])) {
			$search_field = $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Members->session_name . '_search_field' => $search_field, $this->Members->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Members->session_name . '_search_field');
			$value = $this->session->userdata($this->Members->session_name . '_value');
		}

		$start_row = $this->uri->segment($this->uri_segment, '0');
		if (!is_numeric($start_row)) {
			$start_row = 0;
		}
		$per_page = $this->per_page;
		$order_by =  $this->input->post('order_by', TRUE);
		if ($order_by != '') {
			$arr = explode('|', $order_by);
			$field = $arr[0];
			$sort = $arr[1];
			switch ($sort) {
				case 'asc':
					$sort = 'ASC';
					break;
				case 'desc':
					$sort = 'DESC';
					break;
				default:
					$sort = 'DESC';
					break;
			}
			$this->Members->order_field = $field;
			$this->Members->order_sort = $sort;
		}
		$results = $this->Members->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/members');
		$pagination = $this->create_pagination($page_url . '/search', $search_row);
		$end_row = $start_row + $per_page;
		if ($search_row < $per_page) {
			$end_row = $search_row;
		}

		if ($end_row > $search_row) {
			$end_row = $search_row;
		}

		$this->data['data_list']	= $list_data;
		$this->data['search_field']	= $search_field;
		$this->data['txt_search']	= $value;
		$this->data['current_path_uri'] = uri_string();
		$this->data['current_page_offset'] = $start_row;
		$this->data['start_row']	= $start_row + 1;
		$this->data['end_row']	= $end_row;
		$this->data['order_by']	= $order_by;
		$this->data['total_row']	= $total_row;
		$this->data['search_row']	= $search_row;
		$this->data['page_url']	= $page_url;
		$this->data['pagination_link']	= $pagination;
		$this->data['csrf_protection_field']	= insert_csrf_field(true);

		$this->render_view('ceosofts/members/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Members', 'url' => site_url('ceosofts/members')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Members->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);
				$this->render_view('ceosofts/members/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Members_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Members->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_members");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_members");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/members/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Members_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Members->load($id);
		$this->setPreviewFormat($results);

		if (file_exists($this->data['record_photo'])) {
			$this->data['preview_photo'] = '<img src="' . base_url($this->data['record_photo']) . '" width="300">';
		} else {
			$this->data['preview_photo'] = '';
		}
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/members/preview_view_excel', $data, true);

		$filename = "Members_preview" . date("Y-m-d-H-i-s") . "";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		echo $table;
	}

	// ------------------------------------------------------------------------
	/**
	 * Reload running number
	 */
	public function reload_runninng()
	{
		$field = $this->input->post('field', TRUE);
		echo $this->Members->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$user_id_running = $this->Members->set_running_number('user_id');
		$this->data['source_user_id'] = $user_id_running;

		$this->data['source_create_datetime'] = date('Y-m-d H:i:s');
		$this->data['source_create_user_id'] = $this->session->userdata('user_id');
		$this->data['source_modify_datetime'] = date('Y-m-d H:i:s');
		$this->data['source_modify_user_id'] = $this->session->userdata('user_id');
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Members', 'url' => site_url('ceosofts/members')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$this->data['tb_members_prefix_prefix_option_list'] = $this->Members->returnOptionList("tb_members_prefix", "prefix_name", "prefix_name");
		$this->data['tb_members_level_level_option_list'] = $this->Members->returnOptionList("tb_members_level", "level_value", "level_title");
		$this->data['tb_department_department_id_option_list'] = $this->Members->returnOptionList("tb_department", "dpm_id", "dpm_name");
		$this->data['tb_status_void_option_list'] = $this->Members->returnOptionList("tb_status", "dpm_void", "dpm_name");
		$this->data['preview_photo'] = '<div id="div_preview_photo" class="py-3 div_file_preview" style="clear:both"><img id="photo_preview" height="300"/></div>';
		$this->data['record_photo_label'] = '';
		$this->setFormAddData();
		$this->render_view('ceosofts/members/add_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Default Validation
	 * see also https://www.codeigniter.com/userguide3/libraries/form_validation.html
	 */
	public function formValidate()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('user_id', 'หมายเลขผู้ใช้', 'trim|required');
		$frm->set_rules('username', 'ชื่อผู้ใช้งาน', 'trim|required');
		$frm->set_rules('password', 'รหัสผ่าน', 'trim|required');
		$frm->set_rules('referral_code', 'รหัสยืนยันสมาชิก', 'trim|required');
		$frm->set_rules('email', 'อีเมล', 'trim|required');
		$frm->set_rules('prefix', 'คำนำหน้า', 'trim|required');
		$frm->set_rules('firstname', 'ชื่อ', 'trim|required');
		$frm->set_rules('lastname', 'นามสกุล', 'trim|required');
		$frm->set_rules('sex', 'เพศ[1=ชาย,2=หญิง]', 'trim|required|is_natural');
		$frm->set_rules('tel_number', 'เบอร์โทรศัพท์', 'trim|required');
		$frm->set_rules('line_id', 'ไอดี Line', 'trim|required');
		$frm->set_rules('level', 'สิทธิ์การใช้งาน', 'trim|required|is_natural');
		$frm->set_rules('department_id', 'แผนก/ฝ่าย', 'trim|required|is_natural');
		$frm->set_rules('unsubscribe', 'การรับข่าวสาร [1=รับข่าวสาร,2=ไม่รับข่าวสาร]', 'trim|required|is_natural');
		$frm->set_rules('void', 'สถานะการใช้งาน', 'trim|required|is_natural');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('is_natural', '- %s ต้องระบุตัวเลขจำนวนเต็ม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('user_id');
			$message .= form_error('username');
			$message .= form_error('password');
			$message .= form_error('referral_code');
			$message .= form_error('email');
			$message .= form_error('prefix');
			$message .= form_error('firstname');
			$message .= form_error('lastname');
			$message .= form_error('sex');
			$message .= form_error('tel_number');
			$message .= form_error('line_id');
			$message .= form_error('level');
			$message .= form_error('department_id');
			$message .= form_error('unsubscribe');
			$message .= form_error('void');
			return $message;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Default Validation for Update
	 * see also https://www.codeigniter.com/userguide3/libraries/form_validation.html
	 */
	public function formValidateUpdate()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('user_id', 'หมายเลขผู้ใช้', 'trim|required');
		$frm->set_rules('username', 'ชื่อผู้ใช้งาน', 'trim|required');
		$frm->set_rules('password', 'รหัสผ่าน', 'trim|required');
		$frm->set_rules('referral_code', 'รหัสยืนยันสมาชิก', 'trim|required');
		$frm->set_rules('email', 'อีเมล', 'trim|required');
		$frm->set_rules('prefix', 'คำนำหน้า', 'trim|required');
		$frm->set_rules('firstname', 'ชื่อ', 'trim|required');
		$frm->set_rules('lastname', 'นามสกุล', 'trim|required');
		$frm->set_rules('sex', 'เพศ[1=ชาย,2=หญิง]', 'trim|required|is_natural');
		$frm->set_rules('tel_number', 'เบอร์โทรศัพท์', 'trim|required');
		$frm->set_rules('line_id', 'ไอดี Line', 'trim|required');
		$frm->set_rules('level', 'สิทธิ์การใช้งาน', 'trim|required|is_natural');
		$frm->set_rules('department_id', 'แผนก/ฝ่าย', 'trim|required|is_natural');
		$frm->set_rules('unsubscribe', 'การรับข่าวสาร [1=รับข่าวสาร,2=ไม่รับข่าวสาร]', 'trim|required|is_natural');
		$frm->set_rules('void', 'สถานะการใช้งาน', 'trim|required|is_natural');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('is_natural', '- %s ต้องระบุตัวเลขจำนวนเต็ม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('user_id');
			$message .= form_error('username');
			$message .= form_error('password');
			$message .= form_error('referral_code');
			$message .= form_error('email');
			$message .= form_error('prefix');
			$message .= form_error('firstname');
			$message .= form_error('lastname');
			$message .= form_error('sex');
			$message .= form_error('tel_number');
			$message .= form_error('line_id');
			$message .= form_error('level');
			$message .= form_error('department_id');
			$message .= form_error('unsubscribe');
			$message .= form_error('void');
			return $message;
		}
	}

	// ------------------------------------------------------------------------

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
			$this->form_validation->set_message('file_check', '- กรุณาเลือกไฟล์ %s');
			return false;
		}
	}
	private function uploadFile($file_name, $dir = '')
	{
		if ($dir != '' && substr($dir, 0, 1) != '/') {
			$dir = '/' . $dir;
		}
		$path = $this->upload_store_path . (date('Y') + 543) . $dir;
		//เปิดคอนฟิก Auto ชื่อไฟล์ใหม่ด้วย
		$config['upload_path']          = $path;
		$config['allowed_types']        = $this->file_allow_type;
		$config['encrypt_name']		= TRUE;
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
	 * Create new record
	 */
	public function save()
	{

		$message = '';
		$message .= $this->formValidateWithFile();
		$message .= $this->formValidate();
		if ($message != '') {
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {

			$post = $this->input->post(NULL, TRUE);

			$post['create_datetime'] = date('Y-m-d H:i:s');
			$post['create_user_id'] = $this->session->userdata('user_id');
			$post['modify_datetime'] = date('Y-m-d H:i:s');
			$post['modify_user_id'] = $this->session->userdata('user_id');

			$upload_error = 0;
			$upload_error_msg = '';
			$post['photo'] = '';
			if (!empty($_FILES['photo']['name'])) {
				$arr = $this->uploadFile('photo');
				if ($arr['result'] == TRUE) {
					$post['photo'] = $arr['file_path'];
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}
			$encrypt_id = '';
			if ($upload_error == 0) {
				$success = TRUE;
				$id = $this->Members->create($post);
				$encrypt_id = ci_encrypt($id);
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>';
			} else {
				$success = FALSE;
				$message = $upload_error_msg;
			}

			$json = json_encode(array(
				'is_successful' => $success,
				'encrypt_id' =>  $encrypt_id,
				'message' => $message
			));
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
			array('title' => 'Members', 'url' => site_url('ceosofts/members')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Members->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_user_id'] = '';
				$this->data['source_create_datetime'] = date('Y-m-d H:i:s');
				$this->data['source_create_user_id'] = $this->session->userdata('user_id');
				$this->data['source_modify_datetime'] = date('Y-m-d H:i:s');
				$this->data['source_modify_user_id'] = $this->session->userdata('user_id');

				$this->setPreviewFormat($results);

				$this->data['record_birthday'] = setThaiDate($results['birthday']);
				$this->data['record_create_datetime'] = setThaiDate($results['create_datetime']);
				$this->data['record_modify_datetime'] = setThaiDate($results['modify_datetime']);

				$this->data['tb_members_prefix_prefix_option_list'] = $this->Members->returnOptionList("tb_members_prefix", "prefix_name", "prefix_name");
				$this->data['tb_members_level_level_option_list'] = $this->Members->returnOptionList("tb_members_level", "level_value", "level_title");
				$this->data['tb_department_department_id_option_list'] = $this->Members->returnOptionList("tb_department", "dpm_id", "dpm_name");
				$this->data['tb_status_void_option_list'] = $this->Members->returnOptionList("tb_status", "dpm_void", "dpm_name");
				$this->render_view('ceosofts/members/edit_view');
			}
		}
	}

	// ------------------------------------------------------------------------
	public function checkRecordKey($data)
	{
		$error = '';
		$userid = ci_decrypt($data['encrypt_userid']);
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
		$message = '';
		$message .= $this->formValidateWithFile();
		$message .= $this->formValidateUpdate();
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

			$upload_error = 0;
			$upload_error_msg = '';
			if (!empty($_FILES['photo']['name'])) {
				$arr = $this->uploadFile('photo');
				if ($arr['result'] == TRUE) {
					$post['photo'] = $arr['file_path'];
					$this->removeFile($post['photo_old_path']);
					$arr = explode('/', $post['photo_old_path']);
					$encrypt_name = end($arr);
					$this->FileUpload->delete($encrypt_name);
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}

			if ($upload_error == 0) {
				$post['create_datetime'] = date('Y-m-d H:i:s');
				$post['create_user_id'] = $this->session->userdata('user_id');
				$post['modify_datetime'] = date('Y-m-d H:i:s');
				$post['modify_user_id'] = $this->session->userdata('user_id');

				$result = $this->Members->update($post);
				if ($result == false) {
					$message = $this->Members->error_message;
					$ok = FALSE;
				} else {
					$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Members->error_message;
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
			$result = $this->Members->delete($post);
			if ($result == false) {
				$message = $this->Members->error_message;
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
	private function setDataListFormat($lists_data, $start_row = 0)
	{
		$data = $lists_data;
		$count = count($lists_data);
		for ($i = 0; $i < $count; $i++) {
			$start_row++;
			$data[$i]['record_number'] = $start_row;
			$pk1 = $data[$i]['userid'];
			$data[$i]['url_encrypt_id'] = urlencode(encrypt($pk1));

			if ($pk1 != '') {
				$pk1 = ci_encrypt($pk1);
			}
			$data[$i]['encrypt_userid'] = $pk1;
			$data[$i]['preview_sex'] = $this->setSexSubject($data[$i]['sex']);
			$data[$i]['preview_unsubscribe'] = $this->setUnsubscribeSubject($data[$i]['unsubscribe']);
			$data[$i]['birthday'] = setThaiDate($data[$i]['birthday']);
			$data[$i]['create_datetime'] = setThaiDate($data[$i]['create_datetime']);
			$data[$i]['modify_datetime'] = setThaiDate($data[$i]['modify_datetime']);
			$arr = explode('/', $data[$i]['photo']);
			$encrypt_file_name = end($arr);
			$filename = $this->table('tb_uploads_filename')->get_value('filename')->where("encrypt_name = '$encrypt_file_name'");
			$data[$i]['preview_photo'] = setAttachLink('photo', $data[$i]['photo'], $filename);
		}
		return $data;
	}

	/**
	 * SET array data for add form 
	 */
	private function setAddFormat($row_data)
	{
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

	/**
	 * SET choice subject
	 */
	private function setUnsubscribeSubject($value)
	{
		$subject = '';
		switch ($value) {
			case 1:
				$subject = 'รับข่าวสาร';
				break;
			case 2:
				$subject = 'ไม่รับข่าวสาร';
				break;
		}
		return $subject;
	}

	/**
	 * SET array data list
	 */
	private function setPreviewFormat($row_data)
	{
		$data = $row_data;

		$pk1 = $data['userid'];
		$this->data['recode_url_encrypt_id'] = urlencode(encrypt($pk1));

		if ($pk1 != '') {
			$pk1 = ci_encrypt($pk1);
		}
		$this->data['encrypt_userid'] = $pk1;


		$prefixPrefixName = $this->table('tb_members_prefix')->get_value('prefix_name')->where("prefix_name = '$data[prefix]'");
		$this->data['prefixPrefixName'] = $prefixPrefixName;


		$levelLevelTitle = $this->table('tb_members_level')->get_value('level_title')->where("level_value = '$data[level]'");
		$this->data['levelLevelTitle'] = $levelLevelTitle;


		$departmentIdDpmName = $this->table('tb_department')->get_value('dpm_name')->where("dpm_id = '$data[department_id]'");
		$this->data['departmentIdDpmName'] = $departmentIdDpmName;


		$voidDpmName = $this->table('tb_status')->get_value('dpm_name')->where("dpm_void = '{$data['void']}'");
		$this->data['voidDpmName'] = $voidDpmName;

		$this->data['record_userid'] = $data['userid'];
		$this->data['record_user_id'] = $data['user_id'];
		$this->data['record_username'] = $data['username'];
		$this->data['record_password'] = $data['password'];
		$this->data['record_referral_code'] = $data['referral_code'];
		$this->data['record_email'] = $data['email'];
		$this->data['record_prefix'] = $data['prefix'];
		$this->data['record_firstname'] = $data['firstname'];
		$this->data['record_lastname'] = $data['lastname'];
		$this->data['record_photo'] = $data['photo'];

		$arr = explode('/', $data['photo']);
		$encrypt_name = end($arr);
		$filename = $this->table('tb_uploads_filename')->get_value('filename')->where("encrypt_name = '$encrypt_name'");
		$this->data['record_photo_label'] = $filename;

		$this->data['preview_photo'] = setAttachPreview('photo', $data['photo'], $filename);
		$this->data['preview_sex'] = $this->setSexSubject($data['sex']);
		$this->data['record_sex'] = $data['sex'];
		$this->data['record_birthday'] = $data['birthday'];
		$this->data['record_tel_number'] = $data['tel_number'];
		$this->data['record_line_id'] = $data['line_id'];
		$this->data['record_level'] = $data['level'];
		$this->data['record_department_id'] = $data['department_id'];
		$this->data['preview_unsubscribe'] = $this->setUnsubscribeSubject($data['unsubscribe']);
		$this->data['record_unsubscribe'] = $data['unsubscribe'];
		$this->data['record_void'] = $data['void'];
		$this->data['record_create_datetime'] = $data['create_datetime'];
		$this->data['record_create_user_id'] = $data['create_user_id'];
		$this->data['record_modify_datetime'] = $data['modify_datetime'];
		$this->data['record_modify_user_id'] = $data['modify_user_id'];

		$this->data['record_birthday'] = setThaiDate($data['birthday']);
		$this->data['record_create_datetime'] = setThaiDate($data['create_datetime']);
		$this->data['record_modify_datetime'] = setThaiDate($data['modify_datetime']);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Members_list_pdf');

		$results = $this->Members->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);
		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_members");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_members");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/members/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Members_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Members->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขผู้ใช้');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'ชื่อผู้ใช้งาน');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'รหัสผ่าน');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'รหัสยืนยันสมาชิก');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'อีเมล');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'คำนำหน้า');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'ชื่อ');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'นามสกุล');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'เพศ');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'วันเกิด');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'เบอร์โทรศัพท์');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'ไอดี Line');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'สิทธิ์การใช้งาน');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'แผนก/ฝ่าย');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'การรับข่าวสาร');
		$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'สถานะการใช้งาน');

		// END SECTION 1

		// set header bold
		$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

		// set Row
		$rowCount = 2;
		foreach ($data_lists as $row) {

			// ***** SECTION 2 *****

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueExplicit('A' . $rowCount, $row['user_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['username'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['password'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowCount, $row['referral_code'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowCount, $row['email'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('F' . $rowCount, $row['prefixPrefixName'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('G' . $rowCount, $row['firstname'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('H' . $rowCount, $row['lastname'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('I' . $rowCount, $row['preview_sex']);
			$sheet->setCellValueExplicit('J' . $rowCount, $row['birthday'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('K' . $rowCount, $row['tel_number'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('L' . $rowCount, $row['line_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('M' . $rowCount, $row['levelLevelTitle']);
			$sheet->SetCellValue('N' . $rowCount, $row['departmentIdDpmName']);
			$sheet->SetCellValue('O' . $rowCount, $row['preview_unsubscribe']);
			$sheet->SetCellValue('P' . $rowCount, $row['voidDpmName']);


			$rowCount++;
		}

		foreach (range('A', 'Q') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		$filename = "Members_list" . date("Y-m-d-H-i-s") . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');
	}
}
/*---------------------------- END Controller Class --------------------------------*/