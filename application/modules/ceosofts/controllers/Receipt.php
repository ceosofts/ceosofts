<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Receipt.php ]
 */
class Receipt extends MEMBER_Controller
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
		$this->load->model('ceosofts/Receipt_model', 'Receipt');
		$this->Receipt->session_name = 'ceosofts_receipt';

		$this->data['page_url'] = site_url('ceosofts/receipt');

		$this->data['page_title'] = 'PHP CI MANIA';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');

		$js_url = 'assets/js_modules/ceosofts/receipt.js?ft=' . filemtime('assets/js_modules/ceosofts/receipt.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Receipt', 'class' => 'active', 'url' => '#'),
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
			if ($this->session->userdata('user_level') >= 1 && $this->session->userdata('user_department_id') == 8 || 11 || 12) {
				$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
			} else {
				$this->data['alert_message'] = 'เฉพาะผู้ใช้งานระดับ <b>ผู้ใช้งานทั่วไป</b> และ เฉพาะผู้ใช้งานแผนก <b>ฝ่ายขาย</b>';
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
		$this->session->unset_userdata($this->Receipt->session_name . '_search_field');
		$this->session->unset_userdata($this->Receipt->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Receipt', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Receipt->session_name . '_search_field' => $search_field, $this->Receipt->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Receipt->session_name . '_search_field');
			$value = $this->session->userdata($this->Receipt->session_name . '_value');
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
			$this->Receipt->order_field = $field;
			$this->Receipt->order_sort = $sort;
		}
		$results = $this->Receipt->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/receipt');
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

		$this->render_view('ceosofts/receipt/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Receipt', 'url' => site_url('ceosofts/receipt')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);

		// added vat funtion
		$total_price = 0; // คิดราคารวม copy มาจาก web
		// end vat funtion copy from web

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Receipt->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);

				// added vat funtion

				// คำนวณ VAT copy from web
				$total_price = $this->data['record_rec_price']; //fx_detail_total_price ของเดิม //order_total_price ของเดิม copy from web
				$total_vat = 0;
				$product_price = $total_price;
				$grand_total = $total_price;

				//กรณีตั้งค่าให้มีการกำหนด ราคา รวม vat หรือ ยังไม่รวม เอาไว้ใช้ในอนาคต
				// switch ($results['vat_type']) {
				// 	case 1:
				// 		// สินค้าไม่รวม VAT (เพิ่ม VAT)
				// 		$arr_vat = excludingVat($total_price);
				// 		$product_price = $arr_vat['product_price'];
				// 		$total_vat = $arr_vat['vat'];
				// 		$grand_total = $product_price + $total_vat;
				// 		break;
				// 	case 2:
				// 		// สินค้ารวม VAT (ถอด VAT)
				// 		$arr_vat = includingVat($total_price);
				// 		$product_price = $arr_vat['product_price'];
				// 		$total_vat = $arr_vat['vat'];
				// 		$grand_total = $total_price;
				// }

				//กำหนดให้ราคายังไม่รวม vat option เลือกใช้ค่าเพิ่ม vat ที่หลัง
				$arr_vat = excludingVat($total_price);
				$product_price = $arr_vat['product_price'];
				$total_vat = $arr_vat['vat'];
				$grand_total = $product_price + $total_vat;

				$this->data['total_product_price'] = $product_price; //ของเดิม copy from web
				$this->data['total_vat'] = $total_vat; //ของเดิม copy from web
				$this->data['grand_total'] = $grand_total; //ของเดิม copy from web

				$this->data['total_product_price'] = number_format($product_price, 2); //แปลงตัวเลข ราคาสินค้ารวมทั้งสิ้น
				$this->data['total_vat'] = number_format($total_vat, 2); //แปลงตัวเลข ราคาสินค้ารวมทั้งสิ้น
				$this->data['grand_total'] = number_format($grand_total, 2); //แปลงตัวเลข ราคาสินค้ารวมทั้งสิ้น


				// $this->render_view('module_name/product_order_master/preview_view'); // ค่า copy from web ไม่ได้ใช้เพราะชื่อ floder ไม่เหมือนกัน
				// end vat funtion copy from web

				$this->render_view('ceosofts/receipt/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Receipt_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Receipt->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_receipt");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_receipt");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/receipt/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Receipt_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Receipt->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/receipt/preview_view_excel', $data, true);

		$filename = "Receipt_preview" . date("Y-m-d-H-i-s") . "";
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
		echo $this->Receipt->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$rec_id_running = $this->Receipt->set_running_number('rec_id');
		$this->data['source_rec_id'] = $rec_id_running;

		$rec_by = $this->session->userdata('rec_by');
		$this->data['source_rec_by'] = $rec_by;

		$rec_create_date = $this->session->userdata('rec_create_date');
		$this->data['source_rec_create_date'] = $rec_create_date;

		$rec_edit_by = $this->session->userdata('rec_edit_by');
		$this->data['source_rec_edit_by'] = $rec_edit_by;

		$rec_edit_date = $this->session->userdata('rec_edit_date');
		$this->data['source_rec_edit_date'] = $rec_edit_date;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Receipt', 'url' => site_url('ceosofts/receipt')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$options = array();
		$options['attributes'] = array('inv_cus', 'inv_project_name', 'inv_price_this_period');
		$this->data['tb_invoice_rec_inv_number_ref_option_list'] = $this->Receipt->returnOptionList("tb_invoice", "inv_id", "inv_id", $options);
		$this->data['tb_customer_rec_cus_option_list'] = $this->Receipt->returnOptionList("tb_customer", "cus_name", "CONCAT_WS(' - ', cus_name,cus_contact,cus_address,cus_tel,cus_tax,cus_branch)");
		$this->data['tb_receipt_status_rec_status_option_list'] = $this->Receipt->returnOptionList("tb_receipt_status", "str_name", "str_name");
		$this->setFormAddData();
		$this->data['input_start_row_detail'] = 2;
		$this->render_view('ceosofts/receipt/add_view');
	}

	// ------------------------------------------------------------------------


	public function import_excel_form()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Receipt', 'url' => site_url('ceosofts/receipt')),
			array('title' => 'นำข้อมูลด้วย Excel', 'url' => '#', 'class' => 'active')
		);
		$this->data['start_row'] = 2;
		$this->render_view('ceosofts/receipt/addnew_import_form');
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

			$num_rows = $this->Receipt->save_excel_data($insert_data);
			if ($num_rows) {
				$success = TRUE;
				$message = '<strong>นำเข้าข้อมูลเรียบร้อย ' . $num_rows . ' รายการ</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Receipt->error_message;
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

		$frm->set_rules('rec_id', 'หมายเลขใบเสร็จรับเงิน', 'trim|required');
		$frm->set_rules('rec_inv_number_ref', 'อ้างอิงหมายเลขใบวางบิล', 'trim|required');
		$frm->set_rules('rec_date', 'วันที่ใบเสร็จรับเงิน', 'trim|required');
		$frm->set_rules('rec_cus', 'ชื่อลูกค้า', 'trim|required');
		$frm->set_rules('rec_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('rec_price', 'ยอดตามใบวางบิล', 'trim|required|decimal');
		$frm->set_rules('rec_status', 'สถานะ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('rec_id');
			$message .= form_error('rec_inv_number_ref');
			$message .= form_error('rec_date');
			$message .= form_error('rec_cus');
			$message .= form_error('rec_project_name');
			$message .= form_error('rec_price');
			$message .= form_error('rec_status');
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

		$frm->set_rules('rec_id', 'หมายเลขใบเสร็จรับเงิน', 'trim|required');
		$frm->set_rules('rec_inv_number_ref', 'อ้างอิงหมายเลขใบวางบิล', 'trim|required');
		$frm->set_rules('rec_date', 'วันที่ใบเสร็จรับเงิน', 'trim|required');
		$frm->set_rules('rec_cus', 'ชื่อลูกค้า', 'trim|required');
		$frm->set_rules('rec_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('rec_price', 'ยอดตามใบวางบิล', 'trim|required|decimal');
		$frm->set_rules('rec_status', 'สถานะ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('rec_id');
			$message .= form_error('rec_inv_number_ref');
			$message .= form_error('rec_date');
			$message .= form_error('rec_cus');
			$message .= form_error('rec_project_name');
			$message .= form_error('rec_price');
			$message .= form_error('rec_status');
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

			$post['rec_by'] = $this->session->userdata('rec_by');
			$post['rec_create_date'] = $this->session->userdata('rec_create_date');
			$post['rec_edit_by'] = $this->session->userdata('rec_edit_by');
			$post['rec_edit_date'] = $this->session->userdata('rec_edit_date');

			$encrypt_id = '';
			$id = $this->Receipt->create($post);
			if ($id != '') {
				$success = TRUE;
				$encrypt_id = ci_encrypt($id);
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Receipt->error_message;
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
			array('title' => 'Receipt', 'url' => site_url('ceosofts/receipt')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		//added vat FUNCTION
		$total_price = 0; // คิดราคารวม copy มาจาก web
		//end vat FUNCTION

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Receipt->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_rec_id'] = '';
				$this->data['source_rec_by'] = $this->session->userdata('rec_by');
				$this->data['source_rec_create_date'] = $this->session->userdata('rec_create_date');
				$this->data['source_rec_edit_by'] = $this->session->userdata('rec_edit_by');
				$this->data['source_rec_edit_date'] = $this->session->userdata('rec_edit_date');

				$this->setPreviewFormat($results);

				$this->data['record_rec_date'] = setThaiDate($results['rec_date']);
				$this->data['record_rec_create_date'] = setThaiDate($results['rec_create_date']);
				$this->data['record_rec_edit_date'] = setThaiDate($results['rec_edit_date']);

				$options = array();
				$options['attributes'] = array('inv_cus', 'inv_project_name', 'inv_price_this_period');
				$this->data['tb_invoice_rec_inv_number_ref_option_list'] = $this->Receipt->returnOptionList("tb_invoice", "inv_id", "inv_id", $options);
				$this->data['tb_customer_rec_cus_option_list'] = $this->Receipt->returnOptionList("tb_customer", "cus_name", "CONCAT_WS(' - ', cus_name,cus_contact,cus_address,cus_tel,cus_tax,cus_branch)");
				$this->data['tb_receipt_status_rec_status_option_list'] = $this->Receipt->returnOptionList("tb_receipt_status", "str_name", "str_name");

				// added vat funtion

				// คำนวณ VAT copy from web
				$total_price = $this->data['record_rec_price']; //fx_detail_total_price ของเดิม //order_total_price ของเดิม copy from web
				$total_vat = 0;
				$product_price = $total_price;
				$grand_total = $total_price;

				//กรณีตั้งค่าให้มีการกำหนด ราคา รวม vat หรือ ยังไม่รวม เอาไว้ใช้ในอนาคต
				// switch ($results['vat_type']) {
				// 	case 1:
				// 		// สินค้าไม่รวม VAT (เพิ่ม VAT)
				// 		$arr_vat = excludingVat($total_price);
				// 		$product_price = $arr_vat['product_price'];
				// 		$total_vat = $arr_vat['vat'];
				// 		$grand_total = $product_price + $total_vat;
				// 		break;
				// 	case 2:
				// 		// สินค้ารวม VAT (ถอด VAT)
				// 		$arr_vat = includingVat($total_price);
				// 		$product_price = $arr_vat['product_price'];
				// 		$total_vat = $arr_vat['vat'];
				// 		$grand_total = $total_price;
				// }

				//กำหนดให้ราคายังไม่รวม vat option เลือกใช้ค่าเพิ่ม vat ที่หลัง
				$arr_vat = excludingVat($total_price);
				$product_price = $arr_vat['product_price'];
				$total_vat = $arr_vat['vat'];
				$grand_total = $product_price + $total_vat;

				$this->data['total_product_price'] = $product_price; //ของเดิม copy from web
				$this->data['total_vat'] = $total_vat; //ของเดิม copy from web
				$this->data['grand_total'] = $grand_total; //ของเดิม copy from web

				$this->data['total_product_price'] = number_format($product_price, 2); //แปลงตัวเลข ราคาสินค้ารวมทั้งสิ้น
				$this->data['total_vat'] = number_format($total_vat, 2); //แปลงตัวเลข ราคาสินค้ารวมทั้งสิ้น
				$this->data['grand_total'] = number_format($grand_total, 2); //แปลงตัวเลข ราคาสินค้ารวมทั้งสิ้น


				// $this->render_view('module_name/product_order_master/preview_view'); // ค่า copy from web ไม่ได้ใช้เพราะชื่อ floder ไม่เหมือนกัน
				// end vat funtion copy from web

				$this->render_view('ceosofts/receipt/edit_view');
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

			$post['rec_by'] = $this->session->userdata('rec_by');
			$post['rec_create_date'] = $this->session->userdata('rec_create_date');
			$post['rec_edit_by'] = $this->session->userdata('rec_edit_by');
			$post['rec_edit_date'] = $this->session->userdata('rec_edit_date');

			$result = $this->Receipt->update($post);
			if ($result == false) {
				$message = $this->Receipt->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Receipt->error_message;
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
			$result = $this->Receipt->delete($post);
			if ($result == false) {
				$message = $this->Receipt->error_message;
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
			$data[$i]['rec_date'] = setThaiDate($data[$i]['rec_date']);
			$data[$i]['rec_price'] = number_format($data[$i]['rec_price'], 2);
			$data[$i]['rec_create_date'] = setThaiDate($data[$i]['rec_create_date']);
			$data[$i]['rec_edit_date'] = setThaiDate($data[$i]['rec_edit_date']);
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


		$recInvNumberRefInvId = $this->table('tb_invoice')->get_value('inv_id')->where("inv_id = '$data[rec_inv_number_ref]'");
		$this->data['recInvNumberRefInvId'] = $recInvNumberRefInvId;


		$titleRow = $this->table('tb_customer')->get_array('cus_name, cus_contact, cus_address, cus_tel, cus_tax, cus_branch')->where("cus_name = '$data[rec_cus]'");
		if (!empty($titleRow)) {
			$recCusCusName = $titleRow['cus_name'];
			$recCusCusContact = $titleRow['cus_contact'];
			$recCusCusAddress = $titleRow['cus_address'];
			$recCusCusTel = $titleRow['cus_tel'];
			$recCusCusTax = $titleRow['cus_tax'];
			$recCusCusBranch = $titleRow['cus_branch'];
		} else {
			$recCusCusName = '';
			$recCusCusContact = '';
			$recCusCusAddress = '';
			$recCusCusTel = '';
			$recCusCusTax = '';
			$recCusCusBranch = '';
		}
		$this->data['recCusCusName'] = $recCusCusName;
		$this->data['recCusCusContact'] = $recCusCusContact;
		$this->data['recCusCusAddress'] = $recCusCusAddress;
		$this->data['recCusCusTel'] = $recCusCusTel;
		$this->data['recCusCusTax'] = $recCusCusTax;
		$this->data['recCusCusBranch'] = $recCusCusBranch;


		$recStatusStrName = $this->table('tb_receipt_status')->get_value('str_name')->where("str_name = '$data[rec_status]'");
		$this->data['recStatusStrName'] = $recStatusStrName;

		$this->data['record_id'] = $data['id'];
		$this->data['record_rec_id'] = $data['rec_id'];
		$this->data['record_rec_inv_number_ref'] = $data['rec_inv_number_ref'];
		$this->data['record_rec_date'] = $data['rec_date'];
		$this->data['record_rec_cus'] = $data['rec_cus'];
		$this->data['record_rec_project_name'] = $data['rec_project_name'];
		$this->data['record_rec_price'] = $data['rec_price'];
		$this->data['record_rec_status'] = $data['rec_status'];
		$this->data['record_rec_by'] = $data['rec_by'];
		$this->data['record_rec_create_date'] = $data['rec_create_date'];
		$this->data['record_rec_edit_by'] = $data['rec_edit_by'];
		$this->data['record_rec_edit_date'] = $data['rec_edit_date'];

		$this->data['record_rec_date'] = setThaiDate($data['rec_date']);
		$this->data['record_rec_price'] = number_format($data['rec_price'], 2);
		$this->data['record_rec_create_date'] = setThaiDate($data['rec_create_date']);
		$this->data['record_rec_edit_date'] = setThaiDate($data['rec_edit_date']);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Receipt_list_pdf');

		$results = $this->Receipt->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);
		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_receipt");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_receipt");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/receipt/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Receipt_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Receipt->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขใบเสร็จรับเงิน');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'อ้างอิงหมายเลขใบวางบิล');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'วันที่ใบเสร็จรับเงิน');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ชื่อลูกค้า');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'ชื่อโครงการ');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'ยอดตามใบวางบิล');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'สถานะ');

		// END SECTION 1

		// set header bold
		$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

		// set Row
		$rowCount = 2;
		foreach ($data_lists as $row) {

			// ***** SECTION 2 *****

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueExplicit('A' . $rowCount, $row['rec_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['recInvNumberRefInvId'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['rec_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowCount, $row['recCusCusName'] . ' ' . $row['recCusCusContact'] . ' ' . $row['recCusCusAddress'] . ' ' . $row['recCusCusTel'] . ' ' . $row['recCusCusTax'] . ' ' . $row['recCusCusBranch'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowCount, $row['rec_project_name'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('F' . $rowCount, $row['rec_price']);
			$sheet->setCellValueExplicit('G' . $rowCount, $row['recStatusStrName'], PHPExcel_Cell_DataType::TYPE_STRING);


			$rowCount++;
		}

		foreach (range('A', 'H') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		$filename = "Receipt_list" . date("Y-m-d-H-i-s") . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');
	}
}
/*---------------------------- END Controller Class --------------------------------*/
