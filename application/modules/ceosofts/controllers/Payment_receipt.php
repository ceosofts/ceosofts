<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Payment_receipt.php ]
 */
class Payment_receipt extends MEMBER_Controller
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
		$this->load->model('ceosofts/Payment_receipt_model', 'Payment_receipt');
		$this->Payment_receipt->session_name = 'ceosofts_payment_receipt';

		$this->load->model('FileUpload_model', 'FileUpload');
		$this->data['page_url'] = site_url('ceosofts/payment_receipt');

		$this->data['page_title'] = 'CEO Softs';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');
		$this->upload_store_path = './assets/uploads/payment_receipt/';
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

		$js_url = 'assets/js_modules/ceosofts/payment_receipt.js?ft=' . filemtime('assets/js_modules/ceosofts/payment_receipt.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Payment_receipt', 'class' => 'active', 'url' => '#'),
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
			if ($this->session->userdata('user_level') >= 1 && $this->session->userdata('user_department_id') == 9 || 11 || 12) {
				$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
			} else {
				$this->data['alert_message'] = 'เฉพาะผู้ใช้งานระดับ <b>ผู้ใช้งานทั่วไป</b> และ เฉพาะผู้ใช้งานแผนก <b>ฝ่ายจัดซื้อ</b>';
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
		$this->session->unset_userdata($this->Payment_receipt->session_name . '_search_field');
		$this->session->unset_userdata($this->Payment_receipt->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Payment_receipt', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Payment_receipt->session_name . '_search_field' => $search_field, $this->Payment_receipt->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Payment_receipt->session_name . '_search_field');
			$value = $this->session->userdata($this->Payment_receipt->session_name . '_value');
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
			$this->Payment_receipt->order_field = $field;
			$this->Payment_receipt->order_sort = $sort;
		}
		$results = $this->Payment_receipt->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/payment_receipt');
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

		$this->render_view('ceosofts/payment_receipt/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Payment_receipt', 'url' => site_url('ceosofts/payment_receipt')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Payment_receipt->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);
				$this->render_view('ceosofts/payment_receipt/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Payment_receipt_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Payment_receipt->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_payment_receipt");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_payment_receipt");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/payment_receipt/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Payment_receipt_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Payment_receipt->load($id);
		$this->setPreviewFormat($results);

		if (file_exists($this->data['record_pay_rec_scan'])) {
			$this->data['preview_pay_rec_scan'] = '<img src="' . base_url($this->data['record_pay_rec_scan']) . '" width="300">';
		} else {
			$this->data['preview_pay_rec_scan'] = '';
		}
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/payment_receipt/preview_view_excel', $data, true);

		$filename = "Payment_receipt_preview" . date("Y-m-d-H-i-s") . "";
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
		echo $this->Payment_receipt->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$pay_rec_id_running = $this->Payment_receipt->set_running_number('pay_rec_id');
		$this->data['source_pay_rec_id'] = $pay_rec_id_running;

		$pay_rec_by = $this->session->userdata('pay_rec_by');
		$this->data['source_pay_rec_by'] = $pay_rec_by;

		$pay_rec_edit_by = $this->session->userdata('pay_rec_edit_by');
		$this->data['source_pay_rec_edit_by'] = $pay_rec_edit_by;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Payment_receipt', 'url' => site_url('ceosofts/payment_receipt')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$this->data['tb_pay_pay_rec_pr_ref_option_list'] = $this->Payment_receipt->returnOptionList("tb_pay", "pay_id", "pay_id");
		$this->data['preview_pay_rec_scan'] = '<div id="div_preview_pay_rec_scan" class="py-3 div_file_preview" style="clear:both"><img id="pay_rec_scan_preview" height="300"/></div>';
		$this->data['record_pay_rec_scan_label'] = '';
		$this->setFormAddData();
		$this->render_view('ceosofts/payment_receipt/add_view');
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

		$frm->set_rules('pay_rec_id', 'หมายเลขใบเสร็จจ่ายเงิน', 'trim|required');
		$frm->set_rules('pay_rec_pr_ref', 'อ้างอิงใบสั่งจ่าย', 'trim|required');
		$frm->set_rules('pay_rec_date', 'วันที่ทำเอกสารรับใบเสร็จจ่ายเงิน', 'trim|required');
		$frm->set_rules('pay_rec_sup', 'ชื่อผู้จำหน่าย', 'trim|required');
		$frm->set_rules('pay_rec_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('pay_rec_price', 'ราคารวม', 'trim|required|decimal');
		$frm->set_rules('pay_rec_pay_by', 'จ่ายโดย', 'trim|required');
		$frm->set_rules('pay_rec_remark', 'หมายเหตุ', 'trim|required');
		//file upload
		$check_file = FALSE;
		if ($this->input->post('pay_rec_scan_label') == '') {
			$check_file = TRUE;
		}
		if ($check_file == TRUE) {
			if (empty($_FILES['pay_rec_scan']['name'])) {
				$frm->set_rules('pay_rec_scan', 'สแกนเอกสาร', 'trim|required');
			}
		}
		$frm->set_rules('pay_rec_pay_date', 'วันที่ได้รับเอกสาร', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('pay_rec_id');
			$message .= form_error('pay_rec_pr_ref');
			$message .= form_error('pay_rec_date');
			$message .= form_error('pay_rec_sup');
			$message .= form_error('pay_rec_project_name');
			$message .= form_error('pay_rec_price');
			$message .= form_error('pay_rec_pay_by');
			$message .= form_error('pay_rec_remark');
			$message .= form_error('pay_rec_scan');
			$message .= form_error('pay_rec_pay_date');
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

		$frm->set_rules('pay_rec_id', 'หมายเลขใบเสร็จจ่ายเงิน', 'trim|required');
		$frm->set_rules('pay_rec_pr_ref', 'อ้างอิงใบสั่งจ่าย', 'trim|required');
		$frm->set_rules('pay_rec_date', 'วันที่ทำเอกสารรับใบเสร็จจ่ายเงิน', 'trim|required');
		$frm->set_rules('pay_rec_sup', 'ชื่อผู้จำหน่าย', 'trim|required');
		$frm->set_rules('pay_rec_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('pay_rec_price', 'ราคารวม', 'trim|required|decimal');
		$frm->set_rules('pay_rec_pay_by', 'จ่ายโดย', 'trim|required');
		$frm->set_rules('pay_rec_remark', 'หมายเหตุ', 'trim|required');
		//file upload
		$check_file = FALSE;
		if ($this->input->post('pay_rec_scan_label') == '') {
			$check_file = TRUE;
		}
		if ($check_file == TRUE) {
			if (empty($_FILES['pay_rec_scan']['name'])) {
				$frm->set_rules('pay_rec_scan', 'สแกนเอกสาร', 'trim|required');
			}
		}
		$frm->set_rules('pay_rec_pay_date', 'วันที่ได้รับเอกสาร', 'trim|required');
		$frm->set_rules('pay_rec_edit_date', 'วันที่แก้ไข', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('pay_rec_id');
			$message .= form_error('pay_rec_pr_ref');
			$message .= form_error('pay_rec_date');
			$message .= form_error('pay_rec_sup');
			$message .= form_error('pay_rec_project_name');
			$message .= form_error('pay_rec_price');
			$message .= form_error('pay_rec_pay_by');
			$message .= form_error('pay_rec_remark');
			$message .= form_error('pay_rec_scan');
			$message .= form_error('pay_rec_pay_date');
			$message .= form_error('pay_rec_edit_date');
			return $message;
		}
	}

	// ------------------------------------------------------------------------

	public function formValidateWithFile()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;
		$message = '';
		if (!empty($_FILES['pay_rec_scan']['name'])) {
			$this->file_check_name = 'pay_rec_scan';
			$frm->set_rules('pay_rec_scan', 'สแกนเอกสาร', 'callback_file_check');
			if ($frm->run() == FALSE) {
				$message .= form_error('pay_rec_scan');
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

			$post['pay_rec_by'] = $this->session->userdata('pay_rec_by');
			$post['pay_rec_edit_by'] = $this->session->userdata('pay_rec_edit_by');

			$upload_error = 0;
			$upload_error_msg = '';
			$post['pay_rec_scan'] = '';
			if (!empty($_FILES['pay_rec_scan']['name'])) {
				$arr = $this->uploadFile('pay_rec_scan');
				if ($arr['result'] == TRUE) {
					$post['pay_rec_scan'] = $arr['file_path'];
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}
			$encrypt_id = '';
			if ($upload_error == 0) {
				$success = TRUE;
				$id = $this->Payment_receipt->create($post);
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
			array('title' => 'Payment_receipt', 'url' => site_url('ceosofts/payment_receipt')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Payment_receipt->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_pay_rec_id'] = '';
				$this->data['source_pay_rec_by'] = $this->session->userdata('pay_rec_by');
				$this->data['source_pay_rec_edit_by'] = $this->session->userdata('pay_rec_edit_by');

				$this->setPreviewFormat($results);

				$this->data['record_pay_rec_date'] = setThaiDate($results['pay_rec_date']);
				$this->data['record_pay_rec_pay_date'] = setThaiDate($results['pay_rec_pay_date']);
				$this->data['record_pay_rec_edit_date'] = setThaiDate($results['pay_rec_edit_date']);

				$this->data['tb_pay_pay_rec_pr_ref_option_list'] = $this->Payment_receipt->returnOptionList("tb_pay", "pay_id", "pay_id");
				$this->render_view('ceosofts/payment_receipt/edit_view');
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
			if (!empty($_FILES['pay_rec_scan']['name'])) {
				$arr = $this->uploadFile('pay_rec_scan');
				if ($arr['result'] == TRUE) {
					$post['pay_rec_scan'] = $arr['file_path'];
					$this->removeFile($post['pay_rec_scan_old_path']);
					$arr = explode('/', $post['pay_rec_scan_old_path']);
					$encrypt_name = end($arr);
					$this->FileUpload->delete($encrypt_name);
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}

			if ($upload_error == 0) {
				$post['pay_rec_by'] = $this->session->userdata('pay_rec_by');
				$post['pay_rec_edit_by'] = $this->session->userdata('pay_rec_edit_by');

				$result = $this->Payment_receipt->update($post);
				if ($result == false) {
					$message = $this->Payment_receipt->error_message;
					$ok = FALSE;
				} else {
					$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Payment_receipt->error_message;
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
			$result = $this->Payment_receipt->delete($post);
			if ($result == false) {
				$message = $this->Payment_receipt->error_message;
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
			$data[$i]['pay_rec_date'] = setThaiDate($data[$i]['pay_rec_date']);
			$data[$i]['pay_rec_price'] = number_format($data[$i]['pay_rec_price'], 2);
			$data[$i]['pay_rec_pay_date'] = setThaiDate($data[$i]['pay_rec_pay_date']);
			$data[$i]['pay_rec_edit_date'] = setThaiDate($data[$i]['pay_rec_edit_date']);
			$arr = explode('/', $data[$i]['pay_rec_scan']);
			$encrypt_file_name = end($arr);
			$filename = $this->table('tb_uploads_filename')->get_value('filename')->where("encrypt_name = '$encrypt_file_name'");
			$data[$i]['preview_pay_rec_scan'] = setAttachLink('pay_rec_scan', $data[$i]['pay_rec_scan'], $filename);
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


		$payRecPrRefPayId = $this->table('tb_pay')->get_value('pay_id')->where("pay_id = '$data[pay_rec_pr_ref]'");
		$this->data['payRecPrRefPayId'] = $payRecPrRefPayId;

		$this->data['record_id'] = $data['id'];
		$this->data['record_pay_rec_id'] = $data['pay_rec_id'];
		$this->data['record_pay_rec_pr_ref'] = $data['pay_rec_pr_ref'];
		$this->data['record_pay_rec_date'] = $data['pay_rec_date'];
		$this->data['record_pay_rec_sup'] = $data['pay_rec_sup'];
		$this->data['record_pay_rec_project_name'] = $data['pay_rec_project_name'];
		$this->data['record_pay_rec_price'] = $data['pay_rec_price'];
		$this->data['record_pay_rec_pay_by'] = $data['pay_rec_pay_by'];
		$this->data['record_pay_rec_remark'] = $data['pay_rec_remark'];
		$this->data['record_pay_rec_scan'] = $data['pay_rec_scan'];

		$arr = explode('/', $data['pay_rec_scan']);
		$encrypt_name = end($arr);
		$filename = $this->table('tb_uploads_filename')->get_value('filename')->where("encrypt_name = '$encrypt_name'");
		$this->data['record_pay_rec_scan_label'] = $filename;

		$this->data['preview_pay_rec_scan'] = setAttachPreview('pay_rec_scan', $data['pay_rec_scan'], $filename);
		$this->data['record_pay_rec_pay_date'] = $data['pay_rec_pay_date'];
		$this->data['record_pay_rec_by'] = $data['pay_rec_by'];
		$this->data['record_pay_rec_edit_by'] = $data['pay_rec_edit_by'];
		$this->data['record_pay_rec_edit_date'] = $data['pay_rec_edit_date'];

		$this->data['record_pay_rec_date'] = setThaiDate($data['pay_rec_date']);
		$this->data['record_pay_rec_price'] = number_format($data['pay_rec_price'], 2);
		$this->data['record_pay_rec_pay_date'] = setThaiDate($data['pay_rec_pay_date']);
		$this->data['record_pay_rec_edit_date'] = setThaiDate($data['pay_rec_edit_date']);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Payment_receipt_list_pdf');

		$results = $this->Payment_receipt->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);
		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_payment_receipt");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_payment_receipt");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/payment_receipt/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Payment_receipt_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Payment_receipt->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขใบเสร็จจ่ายเงิน');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'อ้างอิงใบสั่งจ่าย');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'วันที่ทำเอกสารรับใบเสร็จจ่ายเงิน');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ชื่อผู้จำหน่าย');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'ชื่อโครงการ');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'ราคารวม');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'จ่ายโดย');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'หมายเหตุ');

		// END SECTION 1

		// set header bold
		$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

		// set Row
		$rowCount = 2;
		foreach ($data_lists as $row) {

			// ***** SECTION 2 *****

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueExplicit('A' . $rowCount, $row['pay_rec_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['payRecPrRefPayId'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['pay_rec_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowCount, $row['pay_rec_sup'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowCount, $row['pay_rec_project_name'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('F' . $rowCount, $row['pay_rec_price']);
			$sheet->setCellValueExplicit('G' . $rowCount, $row['pay_rec_pay_by'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('H' . $rowCount, $row['pay_rec_remark'], PHPExcel_Cell_DataType::TYPE_STRING);


			$rowCount++;
		}

		foreach (range('A', 'I') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		$filename = "Payment_receipt_list" . date("Y-m-d-H-i-s") . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');
	}
}
/*---------------------------- END Controller Class --------------------------------*/
