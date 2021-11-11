<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Cheque_out.php ]
 */
class Cheque_out extends MEMBER_Controller
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
		$this->load->model('ceosofts/Cheque_out_model', 'Cheque_out');
		$this->Cheque_out->session_name = 'ceosofts_cheque_out';

		$this->load->model('FileUpload_model', 'FileUpload');
		$this->data['page_url'] = site_url('ceosofts/cheque_out');

		$this->data['page_title'] = 'CEO Softs';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');
		$this->upload_store_path = './assets/uploads/cheque_out/';
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

		$js_url = 'assets/js_modules/ceosofts/cheque_out.js?ft=' . filemtime('assets/js_modules/ceosofts/cheque_out.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Cheque_out', 'class' => 'active', 'url' => '#'),
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
		$this->session->unset_userdata($this->Cheque_out->session_name . '_search_field');
		$this->session->unset_userdata($this->Cheque_out->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Cheque_out', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Cheque_out->session_name . '_search_field' => $search_field, $this->Cheque_out->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Cheque_out->session_name . '_search_field');
			$value = $this->session->userdata($this->Cheque_out->session_name . '_value');
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
			$this->Cheque_out->order_field = $field;
			$this->Cheque_out->order_sort = $sort;
		}
		$results = $this->Cheque_out->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/cheque_out');
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

		$this->render_view('ceosofts/cheque_out/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Cheque_out', 'url' => site_url('ceosofts/cheque_out')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Cheque_out->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);
				$this->render_view('ceosofts/cheque_out/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Cheque_out_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Cheque_out->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_cheque_out");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_cheque_out");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/cheque_out/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Cheque_out_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Cheque_out->load($id);
		$this->setPreviewFormat($results);

		if (file_exists($this->data['record_chequeout_photo'])) {
			$this->data['preview_chequeout_photo'] = '<img src="' . base_url($this->data['record_chequeout_photo']) . '" width="300">';
		} else {
			$this->data['preview_chequeout_photo'] = '';
		}
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/cheque_out/preview_view_excel', $data, true);

		$filename = "Cheque_out_preview" . date("Y-m-d-H-i-s") . "";
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
		echo $this->Cheque_out->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$chequeout_id_running = $this->Cheque_out->set_running_number('chequeout_id');
		$this->data['source_chequeout_id'] = $chequeout_id_running;

		$chequeout_user_make = $this->session->userdata('chequeout_user_make');
		$this->data['source_chequeout_user_make'] = $chequeout_user_make;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Cheque_out', 'url' => site_url('ceosofts/cheque_out')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$this->data['tb_bookbank_chequeout_bookbank_option_list'] = $this->Cheque_out->returnOptionList("tb_bookbank", "bank_cus_name", "CONCAT_WS(' - ', bank_cus_name,bank_name,bank_branch,bank_number)");
		$this->data['tb_cheque_status_chequeout_status_option_list'] = $this->Cheque_out->returnOptionList("tb_cheque_status", "chs_name", "chs_name");
		$this->data['preview_chequeout_photo'] = '<div id="div_preview_chequeout_photo" class="py-3 div_file_preview" style="clear:both"><img id="chequeout_photo_preview" height="300"/></div>';
		$this->data['record_chequeout_photo_label'] = '';
		$this->setFormAddData();
		$this->render_view('ceosofts/cheque_out/add_view');
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

		$frm->set_rules('chequeout_id', 'หมายเลขรายการเช็ค', 'trim|required');
		$frm->set_rules('chequeout_make_item', 'วันที่สร้างรายการ', 'trim|required');
		$frm->set_rules('chequeout_pay_date', 'วันที่จ่ายเช็ค', 'trim|required');
		$frm->set_rules('chequeout_plan_date', 'วันที่สั่งจ่าย', 'trim|required');
		$frm->set_rules('chequeout_to', 'จ่ายให้', 'trim|required');
		$frm->set_rules('chequeout_price', 'ยอดเงิน', 'trim|required|decimal');
		$frm->set_rules('chequeout_bookbank', 'ธนาคาร/บัญชี', 'trim|required');
		$frm->set_rules('chequeout_number', 'หมายเลขเช็ค', 'trim|required');
		$frm->set_rules('chequeout_status', 'สถานะเช็ค', 'trim|required');
		//file upload
		$check_file = FALSE;
		if ($this->input->post('chequeout_photo_label') == '') {
			$check_file = TRUE;
		}
		if ($check_file == TRUE) {
			if (empty($_FILES['chequeout_photo']['name'])) {
				$frm->set_rules('chequeout_photo', 'รูปเช็ค', 'trim');
			}
		}
		$frm->set_rules('chequeout_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('chequeout_id');
			$message .= form_error('chequeout_make_item');
			$message .= form_error('chequeout_pay_date');
			$message .= form_error('chequeout_plan_date');
			$message .= form_error('chequeout_to');
			$message .= form_error('chequeout_price');
			$message .= form_error('chequeout_bookbank');
			$message .= form_error('chequeout_number');
			$message .= form_error('chequeout_status');
			$message .= form_error('chequeout_photo');
			$message .= form_error('chequeout_remark');
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

		$frm->set_rules('chequeout_id', 'หมายเลขรายการเช็ค', 'trim|required');
		$frm->set_rules('chequeout_make_item', 'วันที่สร้างรายการ', 'trim|required');
		$frm->set_rules('chequeout_pay_date', 'วันที่จ่ายเช็ค', 'trim|required');
		$frm->set_rules('chequeout_plan_date', 'วันที่สั่งจ่าย', 'trim|required');
		$frm->set_rules('chequeout_to', 'จ่ายให้', 'trim|required');
		$frm->set_rules('chequeout_price', 'ยอดเงิน', 'trim|required|decimal');
		$frm->set_rules('chequeout_bookbank', 'ธนาคาร/บัญชี', 'trim|required');
		$frm->set_rules('chequeout_number', 'หมายเลขเช็ค', 'trim|required');
		$frm->set_rules('chequeout_status', 'สถานะเช็ค', 'trim|required');
		//file upload
		$check_file = FALSE;
		if ($this->input->post('chequeout_photo_label') == '') {
			$check_file = TRUE;
		}
		if ($check_file == TRUE) {
			if (empty($_FILES['chequeout_photo']['name'])) {
				$frm->set_rules('chequeout_photo', 'รูปเช็ค', 'trim');
			}
		}
		$frm->set_rules('chequeout_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('chequeout_id');
			$message .= form_error('chequeout_make_item');
			$message .= form_error('chequeout_pay_date');
			$message .= form_error('chequeout_plan_date');
			$message .= form_error('chequeout_to');
			$message .= form_error('chequeout_price');
			$message .= form_error('chequeout_bookbank');
			$message .= form_error('chequeout_number');
			$message .= form_error('chequeout_status');
			$message .= form_error('chequeout_photo');
			$message .= form_error('chequeout_remark');
			return $message;
		}
	}

	// ------------------------------------------------------------------------

	public function formValidateWithFile()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;
		$message = '';
		if (!empty($_FILES['chequeout_photo']['name'])) {
			$this->file_check_name = 'chequeout_photo';
			$frm->set_rules('chequeout_photo', 'รูปเช็ค', 'callback_file_check');
			if ($frm->run() == FALSE) {
				$message .= form_error('chequeout_photo');
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

			$post['chequeout_user_make'] = $this->session->userdata('chequeout_user_make');

			$upload_error = 0;
			$upload_error_msg = '';
			$post['chequeout_photo'] = '';
			if (!empty($_FILES['chequeout_photo']['name'])) {
				$arr = $this->uploadFile('chequeout_photo');
				if ($arr['result'] == TRUE) {
					$post['chequeout_photo'] = $arr['file_path'];
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}
			$encrypt_id = '';
			if ($upload_error == 0) {
				$success = TRUE;
				$id = $this->Cheque_out->create($post);
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
			array('title' => 'Cheque_out', 'url' => site_url('ceosofts/cheque_out')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Cheque_out->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_chequeout_id'] = '';
				$this->data['source_chequeout_user_make'] = $this->session->userdata('chequeout_user_make');

				$this->setPreviewFormat($results);

				$this->data['record_chequeout_make_item'] = setThaiDate($results['chequeout_make_item']);
				$this->data['record_chequeout_pay_date'] = setThaiDate($results['chequeout_pay_date']);
				$this->data['record_chequeout_plan_date'] = setThaiDate($results['chequeout_plan_date']);

				$this->data['tb_bookbank_chequeout_bookbank_option_list'] = $this->Cheque_out->returnOptionList("tb_bookbank", "bank_cus_name", "CONCAT_WS(' - ', bank_cus_name,bank_name,bank_branch,bank_number)");
				$this->data['tb_cheque_status_chequeout_status_option_list'] = $this->Cheque_out->returnOptionList("tb_cheque_status", "chs_name", "chs_name");
				$this->render_view('ceosofts/cheque_out/edit_view');
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
			if (!empty($_FILES['chequeout_photo']['name'])) {
				$arr = $this->uploadFile('chequeout_photo');
				if ($arr['result'] == TRUE) {
					$post['chequeout_photo'] = $arr['file_path'];
					$this->removeFile($post['chequeout_photo_old_path']);
					$arr = explode('/', $post['chequeout_photo_old_path']);
					$encrypt_name = end($arr);
					$this->FileUpload->delete($encrypt_name);
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}

			if ($upload_error == 0) {
				$post['chequeout_user_make'] = $this->session->userdata('chequeout_user_make');

				$result = $this->Cheque_out->update($post);
				if ($result == false) {
					$message = $this->Cheque_out->error_message;
					$ok = FALSE;
				} else {
					$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Cheque_out->error_message;
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
			$result = $this->Cheque_out->delete($post);
			if ($result == false) {
				$message = $this->Cheque_out->error_message;
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
			$data[$i]['chequeout_make_item'] = setThaiDate($data[$i]['chequeout_make_item']);
			$data[$i]['chequeout_pay_date'] = setThaiDate($data[$i]['chequeout_pay_date']);
			$data[$i]['chequeout_plan_date'] = setThaiDate($data[$i]['chequeout_plan_date']);
			$data[$i]['chequeout_price'] = number_format($data[$i]['chequeout_price'], 2);
			$arr = explode('/', $data[$i]['chequeout_photo']);
			$encrypt_file_name = end($arr);
			$filename = $this->table('tb_uploads_filename')->get_value('filename')->where("encrypt_name = '$encrypt_file_name'");
			$data[$i]['preview_chequeout_photo'] = setAttachLink('chequeout_photo', $data[$i]['chequeout_photo'], $filename);
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


		$titleRow = $this->table('tb_bookbank')->get_array('bank_cus_name, bank_name, bank_branch, bank_number')->where("bank_cus_name = '$data[chequeout_bookbank]'");
		if (!empty($titleRow)) {
			$chequeoutBookbankBankCusName = $titleRow['bank_cus_name'];
			$chequeoutBookbankBankName = $titleRow['bank_name'];
			$chequeoutBookbankBankBranch = $titleRow['bank_branch'];
			$chequeoutBookbankBankNumber = $titleRow['bank_number'];
		} else {
			$chequeoutBookbankBankCusName = '';
			$chequeoutBookbankBankName = '';
			$chequeoutBookbankBankBranch = '';
			$chequeoutBookbankBankNumber = '';
		}
		$this->data['chequeoutBookbankBankCusName'] = $chequeoutBookbankBankCusName;
		$this->data['chequeoutBookbankBankName'] = $chequeoutBookbankBankName;
		$this->data['chequeoutBookbankBankBranch'] = $chequeoutBookbankBankBranch;
		$this->data['chequeoutBookbankBankNumber'] = $chequeoutBookbankBankNumber;


		$chequeoutStatusChsName = $this->table('tb_cheque_status')->get_value('chs_name')->where("chs_name = '$data[chequeout_status]'");
		$this->data['chequeoutStatusChsName'] = $chequeoutStatusChsName;

		$this->data['record_id'] = $data['id'];
		$this->data['record_chequeout_id'] = $data['chequeout_id'];
		$this->data['record_chequeout_make_item'] = $data['chequeout_make_item'];
		$this->data['record_chequeout_pay_date'] = $data['chequeout_pay_date'];
		$this->data['record_chequeout_plan_date'] = $data['chequeout_plan_date'];
		$this->data['record_chequeout_to'] = $data['chequeout_to'];
		$this->data['record_chequeout_price'] = $data['chequeout_price'];
		$this->data['record_chequeout_bookbank'] = $data['chequeout_bookbank'];
		$this->data['record_chequeout_number'] = $data['chequeout_number'];
		$this->data['record_chequeout_status'] = $data['chequeout_status'];
		$this->data['record_chequeout_photo'] = $data['chequeout_photo'];

		$arr = explode('/', $data['chequeout_photo']);
		$encrypt_name = end($arr);
		$filename = $this->table('tb_uploads_filename')->get_value('filename')->where("encrypt_name = '$encrypt_name'");
		$this->data['record_chequeout_photo_label'] = $filename;

		$this->data['preview_chequeout_photo'] = setAttachPreview('chequeout_photo', $data['chequeout_photo'], $filename);
		$this->data['record_chequeout_remark'] = $data['chequeout_remark'];
		$this->data['record_chequeout_user_make'] = $data['chequeout_user_make'];

		$this->data['record_chequeout_make_item'] = setThaiDate($data['chequeout_make_item']);
		$this->data['record_chequeout_pay_date'] = setThaiDate($data['chequeout_pay_date']);
		$this->data['record_chequeout_plan_date'] = setThaiDate($data['chequeout_plan_date']);
		$this->data['record_chequeout_price'] = number_format($data['chequeout_price'], 2);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Cheque_out_list_pdf');

		$results = $this->Cheque_out->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		foreach ($data_lists as $key => $row) {
			if (file_exists($row['chequeout_photo'])) {
				$row['pdf_image_chequeout_photo'] = '<img src="' . base_url($row['chequeout_photo']) . '" width="100">';
			} else {
				$row['pdf_image_chequeout_photo'] = '';
			}
			$data_lists[$key] = $row;
		}

		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_cheque_out");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_cheque_out");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/cheque_out/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Cheque_out_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Cheque_out->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขรายการเช็ค');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'วันที่สร้างรายการ');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'วันที่จ่ายเช็ค');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'วันที่สั่งจ่าย');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'จ่ายให้');
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
			$sheet->setCellValueExplicit('A' . $rowCount, $row['chequeout_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['chequeout_make_item'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['chequeout_pay_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowCount, $row['chequeout_plan_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowCount, $row['chequeout_to'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('F' . $rowCount, $row['chequeout_price']);
			$sheet->setCellValueExplicit('G' . $rowCount, $row['chequeoutBookbankBankCusName'] . ' ' . $row['chequeoutBookbankBankName'] . ' ' . $row['chequeoutBookbankBankBranch'] . ' ' . $row['chequeoutBookbankBankNumber'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('H' . $rowCount, $row['chequeout_number'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('I' . $rowCount, $row['chequeoutStatusChsName'], PHPExcel_Cell_DataType::TYPE_STRING);

			if (file_exists($row['chequeout_photo'])) {
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setPath($row['chequeout_photo']);
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


		$filename = "Cheque_out_list" . date("Y-m-d-H-i-s") . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');
	}
}
/*---------------------------- END Controller Class --------------------------------*/
