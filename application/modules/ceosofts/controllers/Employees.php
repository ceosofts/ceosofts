<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Employees.php ]
 */
class Employees extends MEMBER_Controller
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
		$this->load->model('ceosofts/Employees_model', 'Employees');
		$this->Employees->session_name = 'ceosofts_employees';

		$this->load->model('FileUpload_model', 'FileUpload');
		$this->data['page_url'] = site_url('ceosofts/employees');

		$this->data['page_title'] = 'CEO Softs';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');
		$this->upload_store_path = './assets/uploads/employees/';
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

		$js_url = 'assets/js_modules/ceosofts/employees.js?ft=' . filemtime('assets/js_modules/ceosofts/employees.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Employees', 'class' => 'active', 'url' => '#'),
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
			if ($this->session->userdata('user_level') >= 1 && $this->session->userdata('user_department_id') == 7 || 11 || 12) {
				$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
			} else {
				$this->data['alert_message'] = 'เฉพาะผู้ใช้งานระดับ <b>ผู้ใช้งานทั่วไป</b> และ เฉพาะผู้ใช้งานแผนก <b>ฝ่ายบุคคล</b>';
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
		$this->session->unset_userdata($this->Employees->session_name . '_search_field');
		$this->session->unset_userdata($this->Employees->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Employees', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Employees->session_name . '_search_field' => $search_field, $this->Employees->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Employees->session_name . '_search_field');
			$value = $this->session->userdata($this->Employees->session_name . '_value');
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
			$this->Employees->order_field = $field;
			$this->Employees->order_sort = $sort;
		}
		$results = $this->Employees->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/employees');
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

		$this->render_view('ceosofts/employees/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Employees', 'url' => site_url('ceosofts/employees')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Employees->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);
				$this->render_view('ceosofts/employees/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Employees_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Employees->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_employees");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_employees");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/employees/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Employees_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Employees->load($id);
		$this->setPreviewFormat($results);

		if (file_exists($this->data['record_emp_photo'])) {
			$this->data['preview_emp_photo'] = '<img src="' . base_url($this->data['record_emp_photo']) . '" width="300">';
		} else {
			$this->data['preview_emp_photo'] = '';
		}
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/employees/preview_view_excel', $data, true);

		$filename = "Employees_preview" . date("Y-m-d-H-i-s") . "";
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
		echo $this->Employees->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$emp_id_running = $this->Employees->set_running_number('emp_id');
		$this->data['source_emp_id'] = $emp_id_running;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Employees', 'url' => site_url('ceosofts/employees')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$this->data['tb_members_prefix_emp_title_name_option_list'] = $this->Employees->returnOptionList("tb_members_prefix", "prefix_name", "prefix_name");
		$this->data['tb_position_emp_position_option_list'] = $this->Employees->returnOptionList("tb_position", "position_name", "position_name");
		$this->data['tb_department_emp_section_option_list'] = $this->Employees->returnOptionList("tb_department", "dpm_name", "dpm_name");
		$this->data['preview_emp_photo'] = '<div id="div_preview_emp_photo" class="py-3 div_file_preview" style="clear:both"><img id="emp_photo_preview" height="300"/></div>';
		$this->data['record_emp_photo_label'] = '';
		$this->setFormAddData();
		$this->render_view('ceosofts/employees/add_view');
	}

	// ------------------------------------------------------------------------


	public function import_excel_form()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Employees', 'url' => site_url('ceosofts/employees')),
			array('title' => 'นำข้อมูลด้วย Excel', 'url' => '#', 'class' => 'active')
		);
		$this->data['start_row'] = 2;
		$this->render_view('ceosofts/employees/addnew_import_form');
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

			$num_rows = $this->Employees->save_excel_data($insert_data);
			if ($num_rows) {
				$success = TRUE;
				$message = '<strong>นำเข้าข้อมูลเรียบร้อย ' . $num_rows . ' รายการ</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Employees->error_message;
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

		$frm->set_rules('emp_id', 'หมายเลขพนักงาน', 'trim|required');
		$frm->set_rules('emp_title_name', 'คำนำหน้าชื่อ', 'trim|required');
		$frm->set_rules('emp_fname', 'ชื่อพนักงาน', 'trim|required');
		$frm->set_rules('emp_lname', 'นามสกุลพนักงาน', 'trim|required');
		$frm->set_rules('emd_id_card', 'เลขบัตรประชาชน', 'trim|required');
		$frm->set_rules('emp_sex', 'เพศ[1=ชาย, 2=หญิง]', 'trim|required');
		$frm->set_rules('emp_birthday', 'วันที่เกิด', 'trim|required');
		$frm->set_rules('emp_age', 'อายุ', 'trim|required|decimal');
		$frm->set_rules('emp_position', 'ตำแหน่งพนักงาน', 'trim|required');
		$frm->set_rules('emp_section', 'แผนกพนักงาน', 'trim|required');
		$frm->set_rules('emp_tel', 'เบอร์โทรศัพท์', 'trim|required');
		$frm->set_rules('emp_start', 'วันที่เริ่มงาน', 'trim|required');
		$frm->set_rules('emp_ss', 'โรงพยาบาลประกันสังคม', 'trim|required');
		$frm->set_rules('emp_welfare', 'สวัสดิการเพิ่มเติม', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('emp_id');
			$message .= form_error('emp_title_name');
			$message .= form_error('emp_fname');
			$message .= form_error('emp_lname');
			$message .= form_error('emd_id_card');
			$message .= form_error('emp_sex');
			$message .= form_error('emp_birthday');
			$message .= form_error('emp_age');
			$message .= form_error('emp_position');
			$message .= form_error('emp_section');
			$message .= form_error('emp_tel');
			$message .= form_error('emp_start');
			$message .= form_error('emp_ss');
			$message .= form_error('emp_welfare');
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

		$frm->set_rules('emp_id', 'หมายเลขพนักงาน', 'trim|required');
		$frm->set_rules('emp_title_name', 'คำนำหน้าชื่อ', 'trim|required');
		$frm->set_rules('emp_fname', 'ชื่อพนักงาน', 'trim|required');
		$frm->set_rules('emp_lname', 'นามสกุลพนักงาน', 'trim|required');
		$frm->set_rules('emd_id_card', 'เลขบัตรประชาชน', 'trim|required');
		$frm->set_rules('emp_sex', 'เพศ[1=ชาย, 2=หญิง]', 'trim|required');
		$frm->set_rules('emp_birthday', 'วันที่เกิด', 'trim|required');
		$frm->set_rules('emp_age', 'อายุ', 'trim|required|decimal');
		$frm->set_rules('emp_position', 'ตำแหน่งพนักงาน', 'trim|required');
		$frm->set_rules('emp_section', 'แผนกพนักงาน', 'trim|required');
		$frm->set_rules('emp_tel', 'เบอร์โทรศัพท์', 'trim|required');
		$frm->set_rules('emp_start', 'วันที่เริ่มงาน', 'trim|required');
		$frm->set_rules('emp_ss', 'โรงพยาบาลประกันสังคม', 'trim|required');
		$frm->set_rules('emp_welfare', 'สวัสดิการเพิ่มเติม', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('emp_id');
			$message .= form_error('emp_title_name');
			$message .= form_error('emp_fname');
			$message .= form_error('emp_lname');
			$message .= form_error('emd_id_card');
			$message .= form_error('emp_sex');
			$message .= form_error('emp_birthday');
			$message .= form_error('emp_age');
			$message .= form_error('emp_position');
			$message .= form_error('emp_section');
			$message .= form_error('emp_tel');
			$message .= form_error('emp_start');
			$message .= form_error('emp_ss');
			$message .= form_error('emp_welfare');
			return $message;
		}
	}

	// ------------------------------------------------------------------------

	public function formValidateWithFile()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;
		$message = '';
		if (!empty($_FILES['emp_photo']['name'])) {
			$this->file_check_name = 'emp_photo';
			$frm->set_rules('emp_photo', 'รูปพนักงาน', 'callback_file_check');
			if ($frm->run() == FALSE) {
				$message .= form_error('emp_photo');
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

			$upload_error = 0;
			$upload_error_msg = '';
			$post['emp_photo'] = '';
			if (!empty($_FILES['emp_photo']['name'])) {
				$arr = $this->uploadFile('emp_photo');
				if ($arr['result'] == TRUE) {
					$post['emp_photo'] = $arr['file_path'];
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}
			$encrypt_id = '';
			if ($upload_error == 0) {
				$success = TRUE;
				$id = $this->Employees->create($post);
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
			array('title' => 'Employees', 'url' => site_url('ceosofts/employees')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Employees->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_emp_id'] = '';

				$this->setPreviewFormat($results);

				$this->data['record_emp_birthday'] = setThaiDate($results['emp_birthday']);
				$this->data['record_emp_start'] = setThaiDate($results['emp_start']);
				$this->data['record_emp_end'] = setThaiDate($results['emp_end']);

				$this->data['tb_members_prefix_emp_title_name_option_list'] = $this->Employees->returnOptionList("tb_members_prefix", "prefix_name", "prefix_name");
				$this->data['tb_position_emp_position_option_list'] = $this->Employees->returnOptionList("tb_position", "position_name", "position_name");
				$this->data['tb_department_emp_section_option_list'] = $this->Employees->returnOptionList("tb_department", "dpm_name", "dpm_name");
				$this->render_view('ceosofts/employees/edit_view');
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
			if (!empty($_FILES['emp_photo']['name'])) {
				$arr = $this->uploadFile('emp_photo');
				if ($arr['result'] == TRUE) {
					$post['emp_photo'] = $arr['file_path'];
					$this->removeFile($post['emp_photo_old_path']);
					$arr = explode('/', $post['emp_photo_old_path']);
					$encrypt_name = end($arr);
					$this->FileUpload->delete($encrypt_name);
				} else {
					$upload_error++;
					$upload_error_msg .= '<br/>' . print_r($arr['error'], TRUE);
				}
			}

			if ($upload_error == 0) {
				$result = $this->Employees->update($post);
				if ($result == false) {
					$message = $this->Employees->error_message;
					$ok = FALSE;
				} else {
					$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Employees->error_message;
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
			$result = $this->Employees->delete($post);
			if ($result == false) {
				$message = $this->Employees->error_message;
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
			$data[$i]['preview_emp_sex'] = $this->setEmpSexSubject($data[$i]['emp_sex']);
			$data[$i]['emp_birthday'] = setThaiDate($data[$i]['emp_birthday']);
			$data[$i]['emp_age'] = number_format($data[$i]['emp_age'], 2);
			$data[$i]['emp_start'] = setThaiDate($data[$i]['emp_start']);
			$data[$i]['emp_time'] = number_format($data[$i]['emp_time'], 2);
			$data[$i]['emp_end'] = setThaiDate($data[$i]['emp_end']);
			$arr = explode('/', $data[$i]['emp_photo']);
			$encrypt_file_name = end($arr);
			$filename = $this->table('tb_uploads_filename')->get_value('filename')->where("encrypt_name = '$encrypt_file_name'");
			$data[$i]['preview_emp_photo'] = setAttachLink('emp_photo', $data[$i]['emp_photo'], $filename);
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
	private function setEmpSexSubject($value)
	{
		$subject = '';
		switch ($value) {
			case '1':
				$subject = 'ชาย';
				break;
			case '2':
				$subject = 'หญิง';
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

		$pk1 = $data['id'];
		$this->data['recode_url_encrypt_id'] = urlencode(encrypt($pk1));

		if ($pk1 != '') {
			$pk1 = ci_encrypt($pk1);
		}
		$this->data['encrypt_id'] = $pk1;


		$empTitleNamePrefixName = $this->table('tb_members_prefix')->get_value('prefix_name')->where("prefix_name = '$data[emp_title_name]'");
		$this->data['empTitleNamePrefixName'] = $empTitleNamePrefixName;


		$empPositionPositionName = $this->table('tb_position')->get_value('position_name')->where("position_name = '$data[emp_position]'");
		$this->data['empPositionPositionName'] = $empPositionPositionName;


		$empSectionDpmName = $this->table('tb_department')->get_value('dpm_name')->where("dpm_name = '$data[emp_section]'");
		$this->data['empSectionDpmName'] = $empSectionDpmName;

		$this->data['record_id'] = $data['id'];
		$this->data['record_emp_id'] = $data['emp_id'];
		$this->data['record_emp_title_name'] = $data['emp_title_name'];
		$this->data['record_emp_fname'] = $data['emp_fname'];
		$this->data['record_emp_lname'] = $data['emp_lname'];
		$this->data['record_emd_id_card'] = $data['emd_id_card'];
		$this->data['record_emp_photo'] = $data['emp_photo'];

		$arr = explode('/', $data['emp_photo']);
		$encrypt_name = end($arr);
		$filename = $this->table('tb_uploads_filename')->get_value('filename')->where("encrypt_name = '$encrypt_name'");
		$this->data['record_emp_photo_label'] = $filename;

		$this->data['preview_emp_photo'] = setAttachPreview('emp_photo', $data['emp_photo'], $filename);
		$this->data['preview_emp_sex'] = $this->setEmpSexSubject($data['emp_sex']);
		$this->data['record_emp_sex'] = $data['emp_sex'];
		$this->data['record_emp_birthday'] = $data['emp_birthday'];
		$this->data['record_emp_age'] = $data['emp_age'];
		$this->data['record_emp_position'] = $data['emp_position'];
		$this->data['record_emp_section'] = $data['emp_section'];
		$this->data['record_emp_tel'] = $data['emp_tel'];
		$this->data['record_emp_start'] = $data['emp_start'];
		$this->data['record_emp_time'] = $data['emp_time'];
		$this->data['record_emp_end'] = $data['emp_end'];
		$this->data['record_emp_holiday_max'] = $data['emp_holiday_max'];
		$this->data['record_emp_holiday_off'] = $data['emp_holiday_off'];
		$this->data['record_emp_dayoff_day'] = $data['emp_dayoff_day'];
		$this->data['record_emp_dayoff_off'] = $data['emp_dayoff_off'];
		$this->data['record_emp_ss'] = $data['emp_ss'];
		$this->data['record_emp_welfare'] = $data['emp_welfare'];

		$this->data['record_emp_birthday'] = setThaiDate($data['emp_birthday']);
		$this->data['record_emp_age'] = number_format($data['emp_age'], 2);
		$this->data['record_emp_start'] = setThaiDate($data['emp_start']);
		$this->data['record_emp_time'] = number_format($data['emp_time'], 2);
		$this->data['record_emp_end'] = setThaiDate($data['emp_end']);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Employees_list_pdf');

		$results = $this->Employees->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);
		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_employees");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_employees");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/employees/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Employees_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Employees->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขพนักงาน');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'คำนำหน้าชื่อ');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'ชื่อพนักงาน');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'นามสกุลพนักงาน');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'เลขบัตรประชาชน');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'เพศ');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'วันที่เกิด');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'ตำแหน่งพนักงาน');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'แผนกพนักงาน');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'เบอร์โทรศัพท์');

		// END SECTION 1

		// set header bold
		$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

		// set Row
		$rowCount = 2;
		foreach ($data_lists as $row) {

			// ***** SECTION 2 *****

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueExplicit('A' . $rowCount, $row['emp_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['empTitleNamePrefixName'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['emp_fname'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowCount, $row['emp_lname'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowCount, $row['emd_id_card'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('F' . $rowCount, $row['preview_emp_sex'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('G' . $rowCount, $row['emp_birthday'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('H' . $rowCount, $row['empPositionPositionName'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('I' . $rowCount, $row['empSectionDpmName'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('J' . $rowCount, $row['emp_tel'], PHPExcel_Cell_DataType::TYPE_STRING);


			$rowCount++;
		}

		foreach (range('A', 'K') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		$filename = "Employees_list" . date("Y-m-d-H-i-s") . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');
	}
}
/*---------------------------- END Controller Class --------------------------------*/
