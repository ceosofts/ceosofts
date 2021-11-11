<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Tax_receipt.php ]
 */
class Tax_receipt extends MEMBER_Controller
{

	private $per_page;
	private $another_js;
	private $another_css;

	public function __construct()
	{
		parent::__construct();
		$this->per_page = 30;
		$this->num_links = 6;
		$this->uri_segment = 4;
		$this->load->model('ceosofts/Tax_receipt_model', 'Tax_receipt');
		$this->Tax_receipt->session_name = 'ceosofts_tax_receipt';

		$this->data['page_url'] = site_url('ceosofts/tax_receipt');

		$this->data['page_title'] = 'PHP CI MANIA';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');

		$js_url = 'assets/js_modules/ceosofts/tax_receipt.js?ft=' . filemtime('assets/js_modules/ceosofts/tax_receipt.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Tax_receipt', 'class' => 'active', 'url' => '#'),
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
			if ($this->session->userdata('user_level') >= 1 && $this->session->userdata('user_department_id') == 10 || 8 || 11 || 12) {
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
		$this->session->unset_userdata($this->Tax_receipt->session_name . '_search_field');
		$this->session->unset_userdata($this->Tax_receipt->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Tax_receipt', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Tax_receipt->session_name . '_search_field' => $search_field, $this->Tax_receipt->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Tax_receipt->session_name . '_search_field');
			$value = $this->session->userdata($this->Tax_receipt->session_name . '_value');
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
			$this->Tax_receipt->order_field = $field;
			$this->Tax_receipt->order_sort = $sort;
		}
		$results = $this->Tax_receipt->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/tax_receipt');
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

		$this->render_view('ceosofts/tax_receipt/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Tax_receipt', 'url' => site_url('ceosofts/tax_receipt')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);

		// added vat funtion
		$tar_rec_projectprice = 0; // คิดราคารวม copy มาจาก web
		// end vat funtion copy from web

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Tax_receipt->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);

				// added vat funtion
				$tar_rec_projectprice = $this->data['record_tar_rec_projectprice']; //ยอดตามใบเสร็จรับเงิน
				$tar_percent = $this->data['record_tar_percent']; //เปอร์เซ็นที่จะหัก
				$record_tar_rec_price_mo = round($tar_rec_projectprice * ($tar_percent / 100)); //ยอดที่หักภาษี
				$this->data['tar_rec_price'] = $record_tar_rec_price_mo; //ของเดิม copy from web
				$this->data['tar_rec_price'] = number_format($record_tar_rec_price_mo, 2); //แปลงตัวเลข
				// end vat funtion copy from web

				$this->render_view('ceosofts/tax_receipt/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Tax_receipt_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Tax_receipt->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_tax_receipt");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_tax_receipt");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/tax_receipt/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Tax_receipt_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Tax_receipt->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/tax_receipt/preview_view_excel', $data, true);

		$filename = "Tax_receipt_preview" . date("Y-m-d-H-i-s") . "";
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
		echo $this->Tax_receipt->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$tar_rec_id_running = $this->Tax_receipt->set_running_number('tar_rec_id');
		$this->data['source_tar_rec_id'] = $tar_rec_id_running;

		$tar_rec_by = $this->session->userdata('tar_rec_by');
		$this->data['source_tar_rec_by'] = $tar_rec_by;

		$tar_rec_crate_date = $this->session->userdata('tar_rec_crate_date');
		$this->data['source_tar_rec_crate_date'] = $tar_rec_crate_date;

		$tar_rec_edit_by = $this->session->userdata('tar_rec_edit_by');
		$this->data['source_tar_rec_edit_by'] = $tar_rec_edit_by;

		$tax_rec_edit_date = $this->session->userdata('tax_rec_edit_date');
		$this->data['source_tax_rec_edit_date'] = $tax_rec_edit_date;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Tax_receipt', 'url' => site_url('ceosofts/tax_receipt')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);

		// added vat funtion
		$tar_rec_projectprice = 0; // คิดราคารวม copy มาจาก web
		// end vat funtion copy from web

		$options = array();
		$options['attributes'] = array('rec_cus', 'rec_project_name', 'rec_price');
		$this->data['tb_receipt_tar_rec_number_ref_option_list'] = $this->Tax_receipt->returnOptionList("tb_receipt", "rec_id", "rec_id", $options);
		$this->data['tb_customer_tar_rec_cus_option_list'] = $this->Tax_receipt->returnOptionList("tb_customer", "cus_name", "CONCAT_WS(' - ', cus_name,cus_contact,cus_address,cus_tel,cus_tax,cus_branch)");
		$options = array();
		$options['attributes'] = array('tar_percent_detail');
		$this->data['tb_tax_receipt_percent_tar_law_option_list'] = $this->Tax_receipt->returnOptionList("tb_tax_receipt_percent", "tar_law_detail", "tar_law_detail", $options);
		$this->data['tb_tax_receipt_status_tar_rec_status_option_list'] = $this->Tax_receipt->returnOptionList("tb_tax_receipt_status", "tar_name", "tar_name");
		$this->setFormAddData();

		// added vat funtion
		// $tar_rec_projectprice = $this->data['tar_rec_projectprice']; //ยอดตามใบเสร็จรับเงิน
		// $tar_percent = $this->data['source_tar_percent']; //เปอร์เซ็นที่จะหัก
		// $tar_rec_price = $tar_rec_projectprice * ($tar_percent / 100); //ยอดที่หักภาษี
		// $this->data['tar_rec_price'] = $tar_rec_price; //ของเดิม copy from web
		// $this->data['tar_rec_price'] = number_format($tar_rec_price, 2); //แปลงตัวเลข
		// end vat funtion copy from web

		$this->render_view('ceosofts/tax_receipt/add_view');
	}

	// ------------------------------------------------------------------------


	public function import_excel_form()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Tax_receipt', 'url' => site_url('ceosofts/tax_receipt')),
			array('title' => 'นำข้อมูลด้วย Excel', 'url' => '#', 'class' => 'active')
		);
		$this->data['start_row'] = 2;
		$this->render_view('ceosofts/tax_receipt/addnew_import_form');
	}

	public function read_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$table_list = '';
		$success = FALSE;
		$message = '';

		if (isset($_FILES) && isset($_FILES["FileUpload"]["name"]) && $_FILES["FileUpload"]["name"] != '') {

			$fileName = $_FILES["FileUpload"]["name"];
			$fileType = $_FILES["FileUpload"]["type"];
			$fileSize = ($_FILES["FileUpload"]["size"] / 1024) . " kB";
			$fileTmp = $_FILES["FileUpload"]["tmp_name"];

			$deniedExts = array("exe", "bat", "inf", "pif", "com", "scr", "vbs", "html", "asp", "php");
			$ext = explode(".", $fileName);
			$extension = end($ext);
			if (!in_array($extension, $deniedExts)) {
				if ($_FILES["FileUpload"]["error"] > 0) {
					$filesError = array(
						"There is no error, the file uploaded with success",
						"The uploaded file exceeds the upload_max_filesize directive in php.ini",
						"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
						"The uploaded file was only partially uploaded",
						"No file was uploaded",
						"Missing a temporary folder"
					);
					$errorMsg = isset($filesError[$_FILES["FileUpload"]["error"]]) ? $filesError[$_FILES["FileUpload"]["error"]] : '';
					$message = "เกิดข้อผิดพลาด : " . $errorMsg;
				} else {

					$inputFileType = PHPExcel_IOFactory::identify($fileTmp);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($fileTmp);

					$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
					$highestRow = $objWorksheet->getHighestRow();
					$highestColumn = $objWorksheet->getHighestColumn();

					$startRow = $this->input->post('start_row', true);

					$dataRow = $objWorksheet->rangeToArray('A' . $startRow . ':' . $highestColumn . $highestRow, null, true, true, true);

					$fieldName = array();

					if (!empty($dataRow)) {
						$success = TRUE;
						$no = 0;
						foreach ($dataRow as $row_data) {
							if (empty(array_filter($row_data))) {
								continue;
							}
							$no++;
							$table_list .= '<tr>';
							$table_list .= '<td>' . $no . '<input name="insert_excel[' . $no . ']" value="' . $no . '" type="hidden" /></td>';
							$col = 0;
							foreach ($row_data as $td_data) {
								if (isset($fieldName[$col])) {
									$field_name = $fieldName[$col];

									$class_bg = '';
									$td_data = trim($td_data);
									$check_value = $td_data;

									$table_list .= '<td' . $class_bg . '>' . $td_data;
									$table_list .= '<input name="' . $field_name . '[' . $no . ']" value="' . $check_value . '" type="hidden" />';
									$table_list .= '</td>';
								}
								$col++;
							}
							$table_list .= '</tr>';
						}
						$table_list = htmlspecialchars($table_list);
					} else {
						$message = 'ไม่พบข้อมูลในไฟล์ ' .  $fileName;
					}
				}
			} else {
				$message = 'ไม่อนุญาติให้อัพโหลดไฟล์ *.' . $extension . 'เข้าระบบครับ';
			}
		}

		$json = json_encode(array(
			'is_successful' => $success,
			'message' => $message,
			'table_list' => $table_list
		), ENT_QUOTES);

		echo $json;
	}

	public function save_excel_data()
	{
		$post_data = $this->input->post(NULL, TRUE);

		if (!empty($post_data['insert_excel'])) {

			$insert_data = array();
			foreach ($post_data['insert_excel'] as $index => $no) {
				$insert_data[] = array();
			}

			$num_rows = $this->Tax_receipt->save_excel_data($insert_data);
			if ($num_rows) {
				$success = TRUE;
				$message = '<strong>นำเข้าข้อมูลเรียบร้อย ' . $num_rows . ' รายการ</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Tax_receipt->error_message;
			}
		} else {
			$success = FALSE;
			$message = 'ไม่พบข้อมูลในแบบฟอร์มที่บันทึก';
		}

		$json = array(
			'is_successful' => $success,
			'message' =>  $message
		);

		echo json_encode($json);
	}
	/**
	 * Default Validation
	 * see also https://www.codeigniter.com/userguide3/libraries/form_validation.html
	 */
	public function formValidate()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('tar_rec_id', 'หมายเลขใบหักภาษี', 'trim|required');
		$frm->set_rules('tar_rec_number_ref', 'อ้างอิงหมายเลขใบเสร็จรับเงิน', 'trim|required');
		$frm->set_rules('tar_rec_date', 'วันที่ใบหักภาษี', 'trim|required');
		$frm->set_rules('tar_rec_cus', 'ชื่อลูกค้า', 'trim|required');
		$frm->set_rules('tar_rec_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('tar_rec_projectprice', 'ยอดตามใบเสร็จรับเงิน', 'trim|required|decimal');
		$frm->set_rules('tar_law', 'หักภาษี', 'trim|required');
		$frm->set_rules('tar_percent', 'เปอร์เซ็นต์ที่หัก', 'trim|required|decimal');
		$frm->set_rules('tar_rec_price', 'ยอดหักภาษี', 'trim|decimal');
		$frm->set_rules('tar_rec_status', 'สถานะ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('tar_rec_id');
			$message .= form_error('tar_rec_number_ref');
			$message .= form_error('tar_rec_date');
			$message .= form_error('tar_rec_cus');
			$message .= form_error('tar_rec_project_name');
			$message .= form_error('tar_rec_projectprice');
			$message .= form_error('tar_law');
			$message .= form_error('tar_percent');
			$message .= form_error('tar_rec_price');
			$message .= form_error('tar_rec_status');
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

		$frm->set_rules('tar_rec_id', 'หมายเลขใบหักภาษี', 'trim|required');
		$frm->set_rules('tar_rec_number_ref', 'อ้างอิงหมายเลขใบเสร็จรับเงิน', 'trim|required');
		$frm->set_rules('tar_rec_date', 'วันที่ใบหักภาษี', 'trim|required');
		$frm->set_rules('tar_rec_cus', 'ชื่อลูกค้า', 'trim|required');
		$frm->set_rules('tar_rec_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('tar_rec_projectprice', 'ยอดตามใบเสร็จรับเงิน', 'trim|required|decimal');
		$frm->set_rules('tar_law', 'หักภาษี', 'trim|required');
		$frm->set_rules('tar_percent', 'เปอร์เซ็นต์ที่หัก', 'trim|required|decimal');
		$frm->set_rules('tar_rec_price', 'ยอดหักภาษี', 'trim|decimal');
		$frm->set_rules('tar_rec_status', 'สถานะ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('tar_rec_id');
			$message .= form_error('tar_rec_number_ref');
			$message .= form_error('tar_rec_date');
			$message .= form_error('tar_rec_cus');
			$message .= form_error('tar_rec_project_name');
			$message .= form_error('tar_rec_projectprice');
			$message .= form_error('tar_law');
			$message .= form_error('tar_percent');
			$message .= form_error('tar_rec_price');
			$message .= form_error('tar_rec_status');
			return $message;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Create new record
	 */
	public function save()
	{

		$message = '';
		$message .= $this->formValidate();
		if ($message != '') {
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {

			$post = $this->input->post(NULL, TRUE);

			$post['tar_rec_by'] = $this->session->userdata('tar_rec_by');
			$post['tar_rec_crate_date'] = $this->session->userdata('tar_rec_crate_date');
			$post['tar_rec_edit_by'] = $this->session->userdata('tar_rec_edit_by');
			$post['tax_rec_edit_date'] = $this->session->userdata('tax_rec_edit_date');

			$encrypt_id = '';
			$id = $this->Tax_receipt->create($post);
			if ($id != '') {
				$success = TRUE;
				$encrypt_id = ci_encrypt($id);
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Tax_receipt->error_message;
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
			array('title' => 'Tax_receipt', 'url' => site_url('ceosofts/tax_receipt')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		// added vat funtion
		$tar_rec_projectprice = 0; // คิดราคารวม copy มาจาก web
		// end vat funtion copy from web

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Tax_receipt->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_tar_rec_id'] = '';
				$this->data['source_tar_rec_by'] = $this->session->userdata('tar_rec_by');
				$this->data['source_tar_rec_crate_date'] = $this->session->userdata('tar_rec_crate_date');
				$this->data['source_tar_rec_edit_by'] = $this->session->userdata('tar_rec_edit_by');
				$this->data['source_tax_rec_edit_date'] = $this->session->userdata('tax_rec_edit_date');

				$this->setPreviewFormat($results);

				$this->data['record_tar_rec_date'] = setThaiDate($results['tar_rec_date']);
				$this->data['record_tar_rec_crate_date'] = setThaiDate($results['tar_rec_crate_date']);
				$this->data['record_tax_rec_edit_date'] = setThaiDate($results['tax_rec_edit_date']);

				$options = array();
				$options['attributes'] = array('rec_cus', 'rec_project_name', 'rec_price');
				$this->data['tb_receipt_tar_rec_number_ref_option_list'] = $this->Tax_receipt->returnOptionList("tb_receipt", "rec_id", "rec_id", $options);
				$this->data['tb_customer_tar_rec_cus_option_list'] = $this->Tax_receipt->returnOptionList("tb_customer", "cus_name", "CONCAT_WS(' - ', cus_name,cus_contact,cus_address,cus_tel,cus_tax,cus_branch)");
				$options = array();
				$options['attributes'] = array('tar_percent_detail');
				$this->data['tb_tax_receipt_percent_tar_law_option_list'] = $this->Tax_receipt->returnOptionList("tb_tax_receipt_percent", "tar_law_detail", "tar_law_detail", $options);
				$this->data['tb_tax_receipt_status_tar_rec_status_option_list'] = $this->Tax_receipt->returnOptionList("tb_tax_receipt_status", "tar_name", "tar_name");

				// added vat funtion
				$tar_rec_projectprice = $this->data['record_tar_rec_projectprice']; //ยอดตามใบเสร็จรับเงิน
				$tar_percent = $this->data['record_tar_percent']; //เปอร์เซ็นที่จะหัก
				$tar_rec_price = $tar_rec_projectprice * ($tar_percent / 100); //ยอดที่หักภาษี
				$this->data['tar_rec_price'] = $tar_rec_price; //ของเดิม copy from web
				$this->data['tar_rec_price'] = number_format($tar_rec_price, 2); //แปลงตัวเลข
				// end vat funtion copy from web

				$this->render_view('ceosofts/tax_receipt/edit_view');
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

			$post['tar_rec_by'] = $this->session->userdata('tar_rec_by');
			$post['tar_rec_crate_date'] = $this->session->userdata('tar_rec_crate_date');
			$post['tar_rec_edit_by'] = $this->session->userdata('tar_rec_edit_by');
			$post['tax_rec_edit_date'] = $this->session->userdata('tax_rec_edit_date');

			$result = $this->Tax_receipt->update($post);
			if ($result == false) {
				$message = $this->Tax_receipt->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Tax_receipt->error_message;
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
			$result = $this->Tax_receipt->delete($post);
			if ($result == false) {
				$message = $this->Tax_receipt->error_message;
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
			$data[$i]['tar_rec_date'] = setThaiDate($data[$i]['tar_rec_date']);
			$data[$i]['tar_rec_projectprice'] = number_format($data[$i]['tar_rec_projectprice'], 2);
			$data[$i]['tar_percent'] = number_format($data[$i]['tar_percent'], 2);
			$data[$i]['tar_rec_price'] = number_format($data[$i]['tar_rec_price'], 2);
			$data[$i]['tar_rec_crate_date'] = setThaiDate($data[$i]['tar_rec_crate_date']);
			$data[$i]['tax_rec_edit_date'] = setThaiDate($data[$i]['tax_rec_edit_date']);
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


		$tarRecNumberRefRecId = $this->table('tb_receipt')->get_value('rec_id')->where("rec_id = '$data[tar_rec_number_ref]'");
		$this->data['tarRecNumberRefRecId'] = $tarRecNumberRefRecId;


		$titleRow = $this->table('tb_customer')->get_array('cus_name, cus_contact, cus_address, cus_tel, cus_tax, cus_branch')->where("cus_name = '$data[tar_rec_cus]'");
		if (!empty($titleRow)) {
			$tarRecCusCusName = $titleRow['cus_name'];
			$tarRecCusCusContact = $titleRow['cus_contact'];
			$tarRecCusCusAddress = $titleRow['cus_address'];
			$tarRecCusCusTel = $titleRow['cus_tel'];
			$tarRecCusCusTax = $titleRow['cus_tax'];
			$tarRecCusCusBranch = $titleRow['cus_branch'];
		} else {
			$tarRecCusCusName = '';
			$tarRecCusCusContact = '';
			$tarRecCusCusAddress = '';
			$tarRecCusCusTel = '';
			$tarRecCusCusTax = '';
			$tarRecCusCusBranch = '';
		}
		$this->data['tarRecCusCusName'] = $tarRecCusCusName;
		$this->data['tarRecCusCusContact'] = $tarRecCusCusContact;
		$this->data['tarRecCusCusAddress'] = $tarRecCusCusAddress;
		$this->data['tarRecCusCusTel'] = $tarRecCusCusTel;
		$this->data['tarRecCusCusTax'] = $tarRecCusCusTax;
		$this->data['tarRecCusCusBranch'] = $tarRecCusCusBranch;


		$tarLawTarLawDetail = $this->table('tb_tax_receipt_percent')->get_value('tar_law_detail')->where("tar_law_detail = '$data[tar_law]'");
		$this->data['tarLawTarLawDetail'] = $tarLawTarLawDetail;


		$tarRecStatusTarName = $this->table('tb_tax_receipt_status')->get_value('tar_name')->where("tar_name = '$data[tar_rec_status]'");
		$this->data['tarRecStatusTarName'] = $tarRecStatusTarName;

		$this->data['record_id'] = $data['id'];
		$this->data['record_tar_rec_id'] = $data['tar_rec_id'];
		$this->data['record_tar_rec_number_ref'] = $data['tar_rec_number_ref'];
		$this->data['record_tar_rec_date'] = $data['tar_rec_date'];
		$this->data['record_tar_rec_cus'] = $data['tar_rec_cus'];
		$this->data['record_tar_rec_project_name'] = $data['tar_rec_project_name'];
		$this->data['record_tar_rec_projectprice'] = $data['tar_rec_projectprice'];
		$this->data['record_tar_law'] = $data['tar_law'];
		$this->data['record_tar_percent'] = $data['tar_percent'];
		$this->data['record_tar_rec_price'] = $data['tar_rec_price'];
		$this->data['record_tar_rec_status'] = $data['tar_rec_status'];
		$this->data['record_tar_rec_by'] = $data['tar_rec_by'];
		$this->data['record_tar_rec_crate_date'] = $data['tar_rec_crate_date'];
		$this->data['record_tar_rec_edit_by'] = $data['tar_rec_edit_by'];
		$this->data['record_tax_rec_edit_date'] = $data['tax_rec_edit_date'];

		$this->data['record_tar_rec_date'] = setThaiDate($data['tar_rec_date']);
		$this->data['record_tar_rec_projectprice'] = number_format($data['tar_rec_projectprice'], 2);
		$this->data['record_tar_percent'] = number_format($data['tar_percent'], 2);
		$this->data['record_tar_rec_price'] = number_format($data['tar_rec_price'], 2);
		$this->data['record_tar_rec_crate_date'] = setThaiDate($data['tar_rec_crate_date']);
		$this->data['record_tax_rec_edit_date'] = setThaiDate($data['tax_rec_edit_date']);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Tax_receipt_list_pdf');

		$results = $this->Tax_receipt->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);
		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_tax_receipt");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_tax_receipt");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/tax_receipt/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Tax_receipt_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Tax_receipt->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขใบหักภาษี');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'อ้างอิงหมายเลขใบเสร็จรับเงิน');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'วันที่ใบหักภาษี');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ชื่อลูกค้า');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'ชื่อโครงการ');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'ยอดตามใบเสร็จรับเงิน');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'หักภาษี');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'เปอร์เซ็นต์ที่หัก');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'ยอดหักภาษี');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'สถานะ');

		// END SECTION 1

		// set header bold
		$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

		// set Row
		$rowCount = 2;
		foreach ($data_lists as $row) {

			// ***** SECTION 2 *****

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueExplicit('A' . $rowCount, $row['tar_rec_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['tarRecNumberRefRecId'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['tar_rec_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowCount, $row['tarRecCusCusName'] . ' ' . $row['tarRecCusCusContact'] . ' ' . $row['tarRecCusCusAddress'] . ' ' . $row['tarRecCusCusTel'] . ' ' . $row['tarRecCusCusTax'] . ' ' . $row['tarRecCusCusBranch'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowCount, $row['tar_rec_project_name'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('F' . $rowCount, $row['tar_rec_projectprice']);
			$sheet->setCellValueExplicit('G' . $rowCount, $row['tarLawTarLawDetail'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('H' . $rowCount, $row['tar_percent']);
			$sheet->SetCellValue('I' . $rowCount, $row['tar_rec_price']);
			$sheet->setCellValueExplicit('J' . $rowCount, $row['tarRecStatusTarName'], PHPExcel_Cell_DataType::TYPE_STRING);


			$rowCount++;
		}

		foreach (range('A', 'K') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		$filename = "Tax_receipt_list" . date("Y-m-d-H-i-s") . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');
	}
}
/*---------------------------- END Controller Class --------------------------------*/
