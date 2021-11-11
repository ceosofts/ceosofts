<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Cheque_in.php ]
 */
class Cheque_in extends MEMBER_Controller
{

	private $per_page;
	private $another_js;
	private $another_css;
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
		$this->uri_segment = 4;
		$this->load->model('ceosofts/Cheque_in_model', 'Cheque_in');
		$this->Cheque_in->session_name = 'ceosofts_cheque_in';

		$this->load->model('FileUpload_model', 'FileUpload');
		$this->data['page_url'] = site_url('ceosofts/cheque_in');

		$this->data['page_title'] = 'CEO Softs';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');
		$this->upload_store_path = './assets/uploads/cheque_in/';
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

		$js_url = 'assets/js_modules/ceosofts/cheque_in.js?ft=' . filemtime('assets/js_modules/ceosofts/cheque_in.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Cheque_in', 'class' => 'active', 'url' => '#'),
		);
		if ($this->session->userdata('login_validated') == false) {
			$this->render_view('');
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
			if ($this->session->userdata('user_level') >= 1 && $this->session->userdata('user_department_id') == 10 || 11 || 12) {
				$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
			} else {
				$this->data['alert_message'] = 'เฉพาะผู้ใช้งานระดับ <b>ผู้ใช้งานทั่วไป</b> และ เฉพาะผู้ใช้งานแผนก <b>ฝ่ายการเงิน</b>';
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
		$this->session->unset_userdata($this->Cheque_in->session_name . '_search_field');
		$this->session->unset_userdata($this->Cheque_in->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Cheque_in', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Cheque_in->session_name . '_search_field' => $search_field, $this->Cheque_in->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Cheque_in->session_name . '_search_field');
			$value = $this->session->userdata($this->Cheque_in->session_name . '_value');
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
			$this->Cheque_in->order_field = $field;
			$this->Cheque_in->order_sort = $sort;
		}
		$results = $this->Cheque_in->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/cheque_in');
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

		$this->render_view('ceosofts/cheque_in/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Cheque_in', 'url' => site_url('ceosofts/cheque_in')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Cheque_in->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);
				$this->render_view('ceosofts/cheque_in/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Cheque_in_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Cheque_in->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_cheque_in");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_cheque_in");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/cheque_in/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Cheque_in_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Cheque_in->load($id);
		$this->setPreviewFormat($results);

		if (file_exists($this->data['record_chequein_photo'])) {
			$this->data['preview_chequein_photo'] = '<img src="' . base_url($this->data['record_chequein_photo']) . '" width="300">';
		} else {
			$this->data['preview_chequein_photo'] = '';
		}
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/cheque_in/preview_view_excel', $data, true);

		$filename = "Cheque_in_preview" . date("Y-m-d-H-i-s") . "";
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
		echo $this->Cheque_in->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$chequein_id_running = $this->Cheque_in->set_running_number('chequein_id');
		$this->data['source_chequein_id'] = $chequein_id_running;

		$chequein_user_make = $this->session->userdata('chequein_user_make');
		$this->data['source_chequein_user_make'] = $chequein_user_make;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Cheque_in', 'url' => site_url('ceosofts/cheque_in')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$this->data['tb_customer_chequein_from_option_list'] = $this->Cheque_in->returnOptionList("tb_customer", "cus_name", "cus_name");
		$this->data['tb_bookbank_chequein_bookbank_option_list'] = $this->Cheque_in->returnOptionList("tb_bookbank", "bank_cus_name", "CONCAT_WS(' - ', bank_cus_name,bank_name,bank_branch,bank_number)");
		$this->data['tb_cheque_status_chequein_status_option_list'] = $this->Cheque_in->returnOptionList("tb_cheque_status", "chs_name", "chs_name");
		$this->data['preview_chequein_photo'] = '<div id="div_preview_chequein_photo" class="py-3 div_file_preview" style="clear:both"><img id="chequein_photo_preview" height="300"/></div>';
		$this->data['record_chequein_photo_label'] = '';
		$this->setFormAddData();
		$this->render_view('ceosofts/cheque_in/add_view');
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

		$frm->set_rules('chequein_id', 'หมายเลขรายการเช็ค', 'trim|required');
		$frm->set_rules('chequein_make_item', 'วันที่สร้างรายการ', 'trim|required');
		$frm->set_rules('chequein_receive_date', 'วันที่รับเช็ค', 'trim|required');
		$frm->set_rules('chequein_plan_date', 'วันที่สั่งจ่าย', 'trim|required');
		$frm->set_rules('chequein_from', 'รับจาก', 'trim|required');
		$frm->set_rules('chequein_price', 'ยอดเงิน', 'trim|required|decimal');
		$frm->set_rules('chequein_bookbank', 'ธนาคาร/บัญชี', 'trim|required');
		$frm->set_rules('chequein_number', 'หมายเลขเช็ค', 'trim|required');
		$frm->set_rules('chequein_status', 'สถานะเช็ค', 'trim|required');
		//file upload
		$check_file = FALSE;
		if ($this->input->post('chequein_photo_label') == '') {
			$check_file = TRUE;
		}
		if ($check_file == TRUE) {
			if (empty($_FILES['chequein_photo']['name'])) {
				$frm->set_rules('chequein_photo', 'รูปเช็ค', 'trim');
			}
		}
		$frm->set_rules('chequein_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('chequein_id');
			$message .= form_error('chequein_make_item');
			$message .= form_error('chequein_receive_date');
			$message .= form_error('chequein_plan_date');
			$message .= form_error('chequein_from');
			$message .= form_error('chequein_price');
			$message .= form_error('chequein_bookbank');
			$message .= form_error('chequein_number');
			$message .= form_error('chequein_status');
			$message .= form_error('chequein_photo');
			$message .= form_error('chequein_remark');
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

		$frm->set_rules('chequein_id', 'หมายเลขรายการเช็ค', 'trim|required');
		$frm->set_rules('chequein_make_item', 'วันที่สร้างรายการ', 'trim|required');
		$frm->set_rules('chequein_receive_date', 'วันที่รับเช็ค', 'trim|required');
		$frm->set_rules('chequein_plan_date', 'วันที่สั่งจ่าย', 'trim|required');
		$frm->set_rules('chequein_from', 'รับจาก', 'trim|required');
		$frm->set_rules('chequein_price', 'ยอดเงิน', 'trim|required|decimal');
		$frm->set_rules('chequein_bookbank', 'ธนาคาร/บัญชี', 'trim|required');
		$frm->set_rules('chequein_number', 'หมายเลขเช็ค', 'trim|required');
		$frm->set_rules('chequein_status', 'สถานะเช็ค', 'trim|required');
		//file upload
		$check_file = FALSE;
		if ($this->input->post('chequein_photo_label') == '') {
			$check_file = TRUE;
		}
		if ($check_file == TRUE) {
			if (empty($_FILES['chequein_photo']['name'])) {
				$frm->set_rules('chequein_photo', 'รูปเช็ค', 'trim');
			}
		}
		$frm->set_rules('chequein_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('chequein_id');
			$message .= form_error('chequein_make_item');
			$message .= form_error('chequein_receive_date');
			$message .= form_error('chequein_plan_date');
			$message .= form_error('chequein_from');
			$message .= form_error('chequein_price');
			$message .= form_error('chequein_bookbank');
			$message .= form_error('chequein_number');
			$message .= form_error('chequein_status');
			$message .= form_error('chequein_photo');
			$message .= form_error('chequein_remark');
			return $message;
		}
	}

	// ------------------------------------------------------------------------

	public function formValidateWithFile()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;
		$message = '';
		if (!empty($_FILES['chequein_photo']['name'])) {
			$this->file_check_name = 'chequein_photo';
			$frm->set_rules('chequein_photo', 'รูปเช็ค', 'callback_file_check');
			if ($frm->run() == FALSE) {
				$message .= form_error('chequein_photo');
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

			$post['chequein_user_make'] = $this->session->userdata('chequein_user_make');

			$upload_error = 0;
			$upload_error_msg = '';
			$post['chequein_photo'] = '';
			if (!empty($_FILES['chequein_photo']['name'])) {
				$arr = $this->uploadFile('chequein_photo');
				if ($arr['result'] == TRUE) {
					$post['chequein_photo'] = $arr['file_path'];
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}
			$encrypt_id = '';
			if ($upload_error == 0) {
				$success = TRUE;
				$id = $this->Cheque_in->create($post);
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
			array('title' => 'Cheque_in', 'url' => site_url('ceosofts/cheque_in')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Cheque_in->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_chequein_id'] = '';
				$this->data['source_chequein_user_make'] = $this->session->userdata('chequein_user_make');

				$this->setPreviewFormat($results);

				$this->data['record_chequein_make_item'] = setThaiDate($results['chequein_make_item']);
				$this->data['record_chequein_receive_date'] = setThaiDate($results['chequein_receive_date']);
				$this->data['record_chequein_plan_date'] = setThaiDate($results['chequein_plan_date']);

				$this->data['tb_customer_chequein_from_option_list'] = $this->Cheque_in->returnOptionList("tb_customer", "cus_name", "cus_name");
				$this->data['tb_bookbank_chequein_bookbank_option_list'] = $this->Cheque_in->returnOptionList("tb_bookbank", "bank_cus_name", "CONCAT_WS(' - ', bank_cus_name,bank_name,bank_branch,bank_number)");
				$this->data['tb_cheque_status_chequein_status_option_list'] = $this->Cheque_in->returnOptionList("tb_cheque_status", "chs_name", "chs_name");
				$this->render_view('ceosofts/cheque_in/edit_view');
			}
		}
	}

	// ------------------------------------------------------------------------
	public function checkRecordKey($data)
	{
		$error = '';
		$id = ci_decrypt($data['encrypt_id']);
		if ($id == '') {
			$error .= '- รหัส id';
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
			if (!empty($_FILES['chequein_photo']['name'])) {
				$arr = $this->uploadFile('chequein_photo');
				if ($arr['result'] == TRUE) {
					$post['chequein_photo'] = $arr['file_path'];
					$this->removeFile($post['chequein_photo_old_path']);
					$arr = explode('/', $post['chequein_photo_old_path']);
					$encrypt_name = end($arr);
					$this->FileUpload->delete($encrypt_name);
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}

			if ($upload_error == 0) {
				$post['chequein_user_make'] = $this->session->userdata('chequein_user_make');

				$result = $this->Cheque_in->update($post);
				if ($result == false) {
					$message = $this->Cheque_in->error_message;
					$ok = FALSE;
				} else {
					$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Cheque_in->error_message;
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
			$result = $this->Cheque_in->delete($post);
			if ($result == false) {
				$message = $this->Cheque_in->error_message;
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
			$pk1 = $data[$i]['id'];
			$data[$i]['url_encrypt_id'] = urlencode(encrypt($pk1));

			if ($pk1 != '') {
				$pk1 = ci_encrypt($pk1);
			}
			$data[$i]['encrypt_id'] = $pk1;
			$data[$i]['chequein_make_item'] = setThaiDate($data[$i]['chequein_make_item']);
			$data[$i]['chequein_receive_date'] = setThaiDate($data[$i]['chequein_receive_date']);
			$data[$i]['chequein_plan_date'] = setThaiDate($data[$i]['chequein_plan_date']);
			$data[$i]['chequein_price'] = number_format($data[$i]['chequein_price'], 2);
			$arr = explode('/', $data[$i]['chequein_photo']);
			$encrypt_file_name = end($arr);
			$filename = $this->table('tb_uploads_filename')->get_value('filename')->where("encrypt_name = '$encrypt_file_name'");
			$data[$i]['preview_chequein_photo'] = setAttachLink('chequein_photo', $data[$i]['chequein_photo'], $filename);
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
	 * SET array data list
	 */
	private function setPreviewFormat($row_data)
	{
		$data = $row_data;

		$pk1 = $data['id'];
		$this->data['recode_url_encrypt_id'] = urlencode(encrypt($pk1));

		if ($pk1 != '') {
			$pk1 = ci_encrypt($pk1);
		}
		$this->data['encrypt_id'] = $pk1;


		$chequeinFromCusName = $this->table('tb_customer')->get_value('cus_name')->where("cus_name = '$data[chequein_from]'");
		$this->data['chequeinFromCusName'] = $chequeinFromCusName;


		$titleRow = $this->table('tb_bookbank')->get_array('bank_cus_name, bank_name, bank_branch, bank_number')->where("bank_cus_name = '$data[chequein_bookbank]'");
		if (!empty($titleRow)) {
			$chequeinBookbankBankCusName = $titleRow['bank_cus_name'];
			$chequeinBookbankBankName = $titleRow['bank_name'];
			$chequeinBookbankBankBranch = $titleRow['bank_branch'];
			$chequeinBookbankBankNumber = $titleRow['bank_number'];
		} else {
			$chequeinBookbankBankCusName = '';
			$chequeinBookbankBankName = '';
			$chequeinBookbankBankBranch = '';
			$chequeinBookbankBankNumber = '';
		}
		$this->data['chequeinBookbankBankCusName'] = $chequeinBookbankBankCusName;
		$this->data['chequeinBookbankBankName'] = $chequeinBookbankBankName;
		$this->data['chequeinBookbankBankBranch'] = $chequeinBookbankBankBranch;
		$this->data['chequeinBookbankBankNumber'] = $chequeinBookbankBankNumber;


		$chequeinStatusChsName = $this->table('tb_cheque_status')->get_value('chs_name')->where("chs_name = '$data[chequein_status]'");
		$this->data['chequeinStatusChsName'] = $chequeinStatusChsName;

		$this->data['record_id'] = $data['id'];
		$this->data['record_chequein_id'] = $data['chequein_id'];
		$this->data['record_chequein_make_item'] = $data['chequein_make_item'];
		$this->data['record_chequein_receive_date'] = $data['chequein_receive_date'];
		$this->data['record_chequein_plan_date'] = $data['chequein_plan_date'];
		$this->data['record_chequein_from'] = $data['chequein_from'];
		$this->data['record_chequein_price'] = $data['chequein_price'];
		$this->data['record_chequein_bookbank'] = $data['chequein_bookbank'];
		$this->data['record_chequein_number'] = $data['chequein_number'];
		$this->data['record_chequein_status'] = $data['chequein_status'];
		$this->data['record_chequein_photo'] = $data['chequein_photo'];

		$arr = explode('/', $data['chequein_photo']);
		$encrypt_name = end($arr);
		$filename = $this->table('tb_uploads_filename')->get_value('filename')->where("encrypt_name = '$encrypt_name'");
		$this->data['record_chequein_photo_label'] = $filename;

		$this->data['preview_chequein_photo'] = setAttachPreview('chequein_photo', $data['chequein_photo'], $filename);
		$this->data['record_chequein_remark'] = $data['chequein_remark'];
		$this->data['record_chequein_user_make'] = $data['chequein_user_make'];

		$this->data['record_chequein_make_item'] = setThaiDate($data['chequein_make_item']);
		$this->data['record_chequein_receive_date'] = setThaiDate($data['chequein_receive_date']);
		$this->data['record_chequein_plan_date'] = setThaiDate($data['chequein_plan_date']);
		$this->data['record_chequein_price'] = number_format($data['chequein_price'], 2);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Cheque_in_list_pdf');

		$results = $this->Cheque_in->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		foreach ($data_lists as $key => $row) {
			if (file_exists($row['chequein_photo'])) {
				$row['pdf_image_chequein_photo'] = '<img src="' . base_url($row['chequein_photo']) . '" width="100">';
			} else {
				$row['pdf_image_chequein_photo'] = '';
			}
			$data_lists[$key] = $row;
		}

		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_cheque_in");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_cheque_in");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/cheque_in/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Cheque_in_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Cheque_in->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขรายการเช็ค');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'วันที่สร้างรายการ');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'วันที่รับเช็ค');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'วันที่สั่งจ่าย');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'รับจาก');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'ยอดเงิน');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'ธนาคาร/บัญชี');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'หมายเลขเช็ค');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'สถานะเช็ค');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'รูปเช็ค');

		// END SECTION 1

		// set header bold
		$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

		// set Row
		$rowCount = 2;
		foreach ($data_lists as $row) {

			// ***** SECTION 2 *****

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueExplicit('A' . $rowCount, $row['chequein_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['chequein_make_item'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['chequein_receive_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowCount, $row['chequein_plan_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowCount, $row['chequeinFromCusName'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('F' . $rowCount, $row['chequein_price']);
			$sheet->setCellValueExplicit('G' . $rowCount, $row['chequeinBookbankBankCusName'] . ' ' . $row['chequeinBookbankBankName'] . ' ' . $row['chequeinBookbankBankBranch'] . ' ' . $row['chequeinBookbankBankNumber'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('H' . $rowCount, $row['chequein_number'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('I' . $rowCount, $row['chequeinStatusChsName'], PHPExcel_Cell_DataType::TYPE_STRING);

			if (file_exists($row['chequein_photo'])) {
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setPath($row['chequein_photo']);
				$objDrawing->setCoordinates('J' . $rowCount);
				$objDrawing->setWorksheet($sheet);
				$objDrawing->setResizeProportional(true);
				$objDrawing->setHeight(70);
				$sheet->getRowDimension($rowCount)->setRowHeight(50);
			} else {
				$sheet->setCellValue('J' . $rowCount, '');
			}


			$rowCount++;
		}

		foreach (range('A', 'K') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		$filename = "Cheque_in_list" . date("Y-m-d-H-i-s") . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');
	}
}
/*---------------------------- END Controller Class --------------------------------*/
