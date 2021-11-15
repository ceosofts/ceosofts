<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Pob.php ]
 */
class Pob extends MEMBER_Controller
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
		$this->load->model('ceosofts/Pob_model', 'Pob');
		$this->Pob->session_name = 'ceosofts_pob';

		$this->data['page_url'] = site_url('ceosofts/pob');

		$this->data['page_title'] = 'PHP CI MANIA';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');

		$js_url = 'assets/js_modules/ceosofts/pob.js?ft=' . filemtime('assets/js_modules/ceosofts/pob.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Pob', 'class' => 'active', 'url' => '#'),
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
		$this->session->unset_userdata($this->Pob->session_name . '_search_field');
		$this->session->unset_userdata($this->Pob->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Pob', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Pob->session_name . '_search_field' => $search_field, $this->Pob->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Pob->session_name . '_search_field');
			$value = $this->session->userdata($this->Pob->session_name . '_value');
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
			$this->Pob->order_field = $field;
			$this->Pob->order_sort = $sort;
		}
		$results = $this->Pob->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/pob');
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

		$this->render_view('ceosofts/pob/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Pob', 'url' => site_url('ceosofts/pob')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Pob->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);

				$detail_list = $this->Pob->loadDetailList($results['id']);
				$this->data['detail_list'] = $this->setDetailDataListFormat($detail_list);
				$this->render_view('ceosofts/pob/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Pob_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Pob->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$detail_list = $this->Pob->loadDetailList($results['id']);
		$data_lists = $this->setDetailDataListFormat($detail_list);

		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_pob");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_pob");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/pob/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Pob_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Pob->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$detail_list = $this->Pob->loadDetailList($results['id']);
		$data_lists = $this->setDetailDataListFormat($detail_list);

		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/pob/preview_view_excel', $data, true);

		$filename = "Pob_preview" . date("Y-m-d-H-i-s") . "";
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
		echo $this->Pob->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$pob_id_running = $this->Pob->set_running_number('pob_id');
		$this->data['source_pob_id'] = $pob_id_running;

		$pob_by = $this->session->userdata('pob_by');
		$this->data['source_pob_by'] = $pob_by;

		$pob_edit_by = $this->session->userdata('pob_edit_by');
		$this->data['source_pob_edit_by'] = $pob_edit_by;

		$pob_edit_date = $this->session->userdata('pob_edit_date');
		$this->data['source_pob_edit_date'] = $pob_edit_date;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Pob', 'url' => site_url('ceosofts/pob')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$options = array();
		$options['attributes'] = array('pr_sup', 'pr_project_name', 'pr_price'); //เมื่อเลือกแล้วจะดึงข้อมูลชุดนี้มา
		$this->data['tb_prs_pob_pr_ref_option_list'] = $this->Pob->returnOptionList("tb_prs", "pr_id", "CONCAT_WS(' - ', id,pr_id)", $options); //ตัวเลือกที่สร้างขึ้น จะมีผลกับ บรรทัดด้านบน
		//ความหมายคำสั่งด้านบน ชุด option_list ->= ดึงข้อมูลมาจาก ตาราง tb_prs อ้างอิง pr_id โชว์ id และ pr_id

		$this->data['tb_supplier_pob_sup_option_list'] = $this->Pob->returnOptionList("tb_supplier", "sup_name", "CONCAT_WS(' - ', sup_name,sup_contact,sup_address,sup_tel,sup_tax,sup_branch)");
		//ความหมายคำสั่งด้านบน สามารถปรับเปลี่ยนข้อมูลได้ แต่ตอนแรกก็อ้างอิงตามตัวเลือกด้านบน

		$this->data['tb_pay_status_pob_pay_by_option_list'] = $this->Pob->returnOptionList("tb_pay_status", "name", "name");
		$this->data['tb_pob_status_pob_status_option_list'] = $this->Pob->returnOptionList("tb_pob_status", "pob_name", "pob_name");

		//ยกเลิกคำสั่งชุดนี้ เพื่อใช้ชุดคำสั่งโหลดข้อมูลมาเลยหลังจากเลือก หมายเลขใบขอซื้อ
		// $options['attributes'] = array('pr_name', 'pr_id', 'pr_price', 'pr_unit', 'pr_qty', 'pr_remark'); //เมื่อเลือกแล้วจะดึงข้อมูลชุดนี้มา
		// $this->data['detail_tb_prs_list_pob_pr_id_ref_option_list'] = $this->Pob->returnOptionList("tb_prs_list", "pr_ref", "pr_ref", $options); //ตัวเลือกที่สร้างขึ้น อ้างอิง id ใบเสนอซื้อ

		//ยกเลิกคำสั่งชุดนี้ เพื่อใช้ชุดคำสั่งโหลดข้อมูลมาเลยหลังจากเลือก หมายเลขใบขอซื้อ
		// $options['attributes'] = array('prb_id', 'prb_price', 'prb_unit');
		// $this->data['detail_tb_product_buy_pob_name_option_list'] = $this->Pob->returnOptionList("tb_product_buy", "prb_name", "prb_name", $options); //สามารถเปลี่ยนรายการได้ แต่ไม่ให้เปลี่ยนจะดีกว่า



		$this->setFormAddData();
		$this->data['input_start_row_detail'] = 2;

		$this->data['fx_detail_grand_ราคารวม'] = number_format(0, 2);

		$this->render_view('ceosofts/pob/add_view');
	}

	// ------------------------------------------------------------------------


	public function import_excel_form()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Pob', 'url' => site_url('ceosofts/pob')),
			array('title' => 'นำข้อมูลด้วย Excel', 'url' => '#', 'class' => 'active')
		);
		$this->data['start_row'] = 2;
		$this->render_view('ceosofts/pob/addnew_import_form');
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

			$num_rows = $this->Pob->save_excel_data($insert_data);
			if ($num_rows) {
				$success = TRUE;
				$message = '<strong>นำเข้าข้อมูลเรียบร้อย ' . $num_rows . ' รายการ</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Pob->error_message;
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

		$frm->set_rules('pob_id', 'หมายเลขใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pob_pr_ref', 'อ้างอิงใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pob_date', 'วันที่ใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pob_sup', 'ชื่อผู้จำหน่าย', 'trim|required');
		$frm->set_rules('pob_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('pob_price', 'ราคารวม', 'trim|required|decimal');
		$frm->set_rules('pob_pay_by', 'จ่ายโดย', 'trim|required');
		$frm->set_rules('pob_pay_date', 'วันที่นัดจ่าย', 'trim|required');
		$frm->set_rules('pob_status', 'สถานะ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('pob_id');
			$message .= form_error('pob_pr_ref');
			$message .= form_error('pob_date');
			$message .= form_error('pob_sup');
			$message .= form_error('pob_project_name');
			$message .= form_error('pob_price');
			$message .= form_error('pob_pay_by');
			$message .= form_error('pob_pay_date');
			$message .= form_error('pob_status');
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

		$frm->set_rules('pob_id', 'หมายเลขใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pob_pr_ref', 'อ้างอิงใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pob_date', 'วันที่ใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pob_sup', 'ชื่อผู้จำหน่าย', 'trim|required');
		$frm->set_rules('pob_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('pob_price', 'ราคารวม', 'trim|required|decimal');
		$frm->set_rules('pob_pay_by', 'จ่ายโดย', 'trim|required');
		$frm->set_rules('pob_pay_date', 'วันที่นัดจ่าย', 'trim|required');
		$frm->set_rules('pob_status', 'สถานะ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('pob_id');
			$message .= form_error('pob_pr_ref');
			$message .= form_error('pob_date');
			$message .= form_error('pob_sup');
			$message .= form_error('pob_project_name');
			$message .= form_error('pob_price');
			$message .= form_error('pob_pay_by');
			$message .= form_error('pob_pay_date');
			$message .= form_error('pob_status');
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

			$post['pob_by'] = $this->session->userdata('pob_by');
			$post['pob_edit_by'] = $this->session->userdata('pob_edit_by');
			$post['pob_edit_date'] = $this->session->userdata('pob_edit_date');

			$encrypt_id = '';
			$id = $this->Pob->create($post);
			if ($id != '') {
				$success = TRUE;
				$encrypt_id = ci_encrypt($id);
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Pob->error_message;
			}

			$json = json_encode(array(
				'is_successful' => $success,
				'encrypt_id' =>  $encrypt_id,
				'pob_ref_encrypt_id' =>  $encrypt_id,
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
			array('title' => 'Pob', 'url' => site_url('ceosofts/pob')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Pob->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_pob_id'] = '';
				$this->data['source_pob_by'] = $this->session->userdata('pob_by');
				$this->data['source_pob_edit_by'] = $this->session->userdata('pob_edit_by');
				$this->data['source_pob_edit_date'] = $this->session->userdata('pob_edit_date');

				$this->setPreviewFormat($results);

				$this->data['record_pob_date'] = setThaiDate($results['pob_date']);
				$this->data['record_pob_pay_date'] = setThaiDate($results['pob_pay_date']);
				$this->data['record_pob_edit_date'] = setThaiDate($results['pob_edit_date']);

				$options = array();
				$options['attributes'] = array('pr_sup', 'pr_project_name', 'pr_price');
				$this->data['tb_prs_pob_pr_ref_option_list'] = $this->Pob->returnOptionList("tb_prs", "pr_id", "CONCAT_WS(' - ', id,pr_id)", $options);
				$this->data['tb_supplier_pob_sup_option_list'] = $this->Pob->returnOptionList("tb_supplier", "sup_name", "CONCAT_WS(' - ', sup_name,sup_contact,sup_address,sup_tel,sup_tax,sup_branch)");
				$this->data['tb_pay_status_pob_pay_by_option_list'] = $this->Pob->returnOptionList("tb_pay_status", "name", "name");
				$this->data['tb_pob_status_pob_status_option_list'] = $this->Pob->returnOptionList("tb_pob_status", "pob_name", "pob_name");
				$options['attributes'] = array('pr_name', 'pr_id', 'pr_price', 'pr_unit', 'pr_qty', 'pr_remark');
				$this->data['detail_tb_prs_list_pob_pr_id_ref_option_list'] = $this->Pob->returnOptionList("tb_prs_list", "pr_ref", "pr_ref", $options);
				$options['attributes'] = array('prb_id', 'prb_price', 'prb_unit');
				$this->data['detail_tb_product_buy_pob_name_option_list'] = $this->Pob->returnOptionList("tb_product_buy", "prb_name", "prb_name", $options);

				$this->data['detail_record_pob_ref'] = ci_encrypt($results['id']);

				$detail_list = $this->Pob->loadDetailList($results['id']);
				$this->data['detail_list'] = $this->setDetailDataListFormat($detail_list);
				$this->data['input_start_row_detail'] = 2;
				$this->render_view('ceosofts/pob/edit_view');
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

			$post['pob_by'] = $this->session->userdata('pob_by');
			$post['pob_edit_by'] = $this->session->userdata('pob_edit_by');
			$post['pob_edit_date'] = $this->session->userdata('pob_edit_date');

			$result = $this->Pob->update($post);
			if ($result == false) {
				$message = $this->Pob->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Pob->error_message;
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
			$result = $this->Pob->delete($post);
			if ($result == false) {
				$message = $this->Pob->error_message;
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
	 * Detail List Default Validation
	 * see also https://www.codeigniter.com/userguide3/libraries/form_validation.html
	 */
	public function formValidateDetail()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('pob_ref', 'อ้างอิงใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pob_pr_id_ref', 'อ้างอิง id ใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pob_id', 'หมายเลขสินค้า', 'trim|required');
		$frm->set_rules('pob_name', 'รายการสินค้า', 'trim|required');
		$frm->set_rules('pob_price', 'ราคาสินค้า', 'trim|required|decimal');
		$frm->set_rules('pob_unit', 'หน่วยสินค้า', 'trim|required');
		$frm->set_rules('pob_qty', 'จำนวน', 'trim|required|decimal');
		$frm->set_rules('pob_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('pob_ref');
			$message .= form_error('pob_pr_id_ref');
			$message .= form_error('pob_id');
			$message .= form_error('pob_name');
			$message .= form_error('pob_price');
			$message .= form_error('pob_unit');
			$message .= form_error('pob_qty');
			$message .= form_error('pob_remark');
			return $message;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Default Validation for Update
	 * see also https://www.codeigniter.com/userguide3/libraries/form_validation.html
	 */
	public function formValidateDetailUpdate()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules('pob_ref', 'อ้างอิงใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pob_pr_id_ref', 'อ้างอิง id ใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pob_id', 'หมายเลขสินค้า', 'trim|required');
		$frm->set_rules('pob_name', 'รายการสินค้า', 'trim|required');
		$frm->set_rules('pob_price', 'ราคาสินค้า', 'trim|required|decimal');
		$frm->set_rules('pob_unit', 'หน่วยสินค้า', 'trim|required');
		$frm->set_rules('pob_qty', 'จำนวน', 'trim|required|decimal');
		$frm->set_rules('pob_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('pob_ref');
			$message .= form_error('pob_pr_id_ref');
			$message .= form_error('pob_id');
			$message .= form_error('pob_name');
			$message .= form_error('pob_price');
			$message .= form_error('pob_unit');
			$message .= form_error('pob_qty');
			$message .= form_error('pob_remark');
			return $message;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Create new detail list record
	 */
	public function save_detail_list()
	{

		$message = '';
		$message .= $this->formValidateDetail();

		$post = $this->input->post(NULL, TRUE);
		$ref_field = ci_decrypt($post['pob_ref']);
		if ($ref_field == '') {
			$message .= "- รหัสเชื่อมโยงตารางที่ใช้สำหรับเพิ่มรายการไม่ถูกต้อง";
		} else {
			$post['pob_ref'] = $ref_field;
		}

		if ($message != '') {
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {

			$id = $this->Pob->save_detail_list($post);
			$encrypt_id = ci_encrypt($id);
			$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>';

			$json = json_encode(array(
				'is_successful' => TRUE,
				'encrypt_id' =>  $encrypt_id,
				'message' => $message
			));
			echo $json;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Load Detail List data to form
	 * @param String encrypt id
	 */
	public function edit_list($encrypt_id = '')
	{
		$items = array();
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$message = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$success = false;
		} else {
			$results = $this->Pob->load_detail_record($id);
			if (empty($results)) {
				$message = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$success = false;
			} else {
				$success = true;
				$message = '';
				$items = $this->setPreviewFormatDetail($results);
				$items['csrf_field'] = insert_csrf_field(true);
			}
		}
		$json = json_encode(array(
			'is_successful' => $success,
			'message' => $message,
			'data' => $items
		));

		echo $json;
	}

	public function checkDetailRecordKey($data)
	{
		$error = '';
		$id = ci_decrypt($data['encrypt_id']);
		if ($id == '') {
			$error .= '- รหัส id';
		}
		return $error;
	}

	// ------------------------------------------------------------------------

	/**
	 * Update Detail List Record
	 */
	public function update_list()
	{
		$message = '';
		$message .= $this->formValidateDetailUpdate();
		$post = $this->input->post(NULL, TRUE);
		$ref_field = ci_decrypt($post['pob_ref']);
		if ($ref_field == '') {
			$message .= "- รหัสเชื่อมโยงตารางที่ใช้สำหรับเพิ่มรายการไม่ถูกต้อง";
		} else {
			$post['pob_ref'] = $ref_field;
		}

		$error_pk_id = $this->checkDetailRecordKey($post);
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

			$result = $this->Pob->save_detail_list($post);
			if ($result == false) {
				$message = $this->Pob->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Pob->error_message;
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
	 * Delete Detail List Record
	 */
	public function del_list()
	{
		$delete_remark = $this->input->post('delete_remark', TRUE);
		$message = '';
		if ($delete_remark == '') {
			$message .= 'ระบุเหตุผล';
		}

		$post = $this->input->post(NULL, TRUE);
		$error_pk_id = $this->checkDetailRecordKey($post);
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
			$result = $this->Pob->delete_list($post);
			if ($result == false) {
				$message = $this->Pob->error_message;
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
	 * Load Detail List
	 */
	public function load_detail($encrypt_id)
	{

		$tbody = '';
		$ref_id = ci_decrypt($encrypt_id);
		$data = $this->Pob->loadDetailList($ref_id);
		if (!empty($data)) {
			$data['detail_list'] = $this->setDetailDataListFormat($data);
			$template = '{detail_list}
					<tr id="list_row_{record_number}">
						<td style="text-align:center;">[{record_number}]</td>
						<td>{detail_id}</td>
						<td>{detail_pob_ref}</td>
						<td>{detailPobPrIdRefPrRef}</td>
						<td>{detail_pob_id}</td>
						<td>{detailPobNamePrbName}</td>
						<td>{detail_pob_price}</td>
						<td>{detail_pob_unit}</td>
						<td>{detail_pob_qty}</td>
						<td class="text-right">{fx_detail_ราคารวม}</td>
						<td>{detail_pob_remark}</td>
						<td>
							<div class="btn-group pull-right">
								<button 
									class="btn-edit-list-row my-tooltip btn btn-warning btn-sm" 
									data-toggle="tooltip" title="แก้ไขข้อมูล" 
									data-url-encrypt-id="{detail_url_encrypt_id}" 
									 data-id = "{detail_encrypt_id}" data-row-number="{record_number}">
									<i class="fa fa-edit"></i> แก้ไข
								</button>
								<a href="javascript:void(0);" class="btn-delete-list-row my-tooltip btn btn-danger btn-sm"
									data-toggle="tooltip" title="ลบรายการนี้"
									 data-id = "{detail_encrypt_id}" data-row-number="{record_number}">
									<i class="fa fa-trash"></i> ลบ
								</a>
							</div>
					</tr>
					{/detail_list}';
			$tbody = $this->parser->parse_string($template, $data, TRUE);



			$tbody = htmlspecialchars($tbody);
		}

		$json = json_encode(array(
			'is_successful' => TRUE,
			'tbody' => $tbody, 'fx_detail_grand_ราคารวม' => $this->data['fx_detail_grand_ราคารวม']
		));
		echo $json;
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
			$data[$i]['pob_date'] = setThaiDate($data[$i]['pob_date']);
			$data[$i]['pob_price'] = number_format($data[$i]['pob_price'], 2);
			$data[$i]['pob_pay_date'] = setThaiDate($data[$i]['pob_pay_date']);
			$data[$i]['pob_edit_date'] = setThaiDate($data[$i]['pob_edit_date']);
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


		$titleRow = $this->table('tb_prs')->get_array('id, pr_id')->where("pr_id = '$data[pob_pr_ref]'");
		if (!empty($titleRow)) {
			$pobPrRefId = $titleRow['id'];
			$pobPrRefPrId = $titleRow['pr_id'];
		} else {
			$pobPrRefId = '';
			$pobPrRefPrId = '';
		}
		$this->data['pobPrRefId'] = $pobPrRefId;
		$this->data['pobPrRefPrId'] = $pobPrRefPrId;


		$titleRow = $this->table('tb_supplier')->get_array('sup_name, sup_contact, sup_address, sup_tel, sup_tax, sup_branch')->where("sup_name = '$data[pob_sup]'");
		if (!empty($titleRow)) {
			$pobSupSupName = $titleRow['sup_name'];
			$pobSupSupContact = $titleRow['sup_contact'];
			$pobSupSupAddress = $titleRow['sup_address'];
			$pobSupSupTel = $titleRow['sup_tel'];
			$pobSupSupTax = $titleRow['sup_tax'];
			$pobSupSupBranch = $titleRow['sup_branch'];
		} else {
			$pobSupSupName = '';
			$pobSupSupContact = '';
			$pobSupSupAddress = '';
			$pobSupSupTel = '';
			$pobSupSupTax = '';
			$pobSupSupBranch = '';
		}
		$this->data['pobSupSupName'] = $pobSupSupName;
		$this->data['pobSupSupContact'] = $pobSupSupContact;
		$this->data['pobSupSupAddress'] = $pobSupSupAddress;
		$this->data['pobSupSupTel'] = $pobSupSupTel;
		$this->data['pobSupSupTax'] = $pobSupSupTax;
		$this->data['pobSupSupBranch'] = $pobSupSupBranch;


		$pobPayByName = $this->table('tb_pay_status')->get_value('name')->where("name = '$data[pob_pay_by]'");
		$this->data['pobPayByName'] = $pobPayByName;


		$pobStatusPobName = $this->table('tb_pob_status')->get_value('pob_name')->where("pob_name = '$data[pob_status]'");
		$this->data['pobStatusPobName'] = $pobStatusPobName;

		$this->data['detail_pob_ref'] = urlencode(encrypt($data['id']));

		$this->data['record_id'] = $data['id'];
		$this->data['record_pob_id'] = $data['pob_id'];
		$this->data['record_pob_pr_ref'] = $data['pob_pr_ref'];
		$this->data['record_pob_date'] = $data['pob_date'];
		$this->data['record_pob_sup'] = $data['pob_sup'];
		$this->data['record_pob_project_name'] = $data['pob_project_name'];
		$this->data['record_pob_price'] = $data['pob_price'];
		$this->data['record_pob_pay_by'] = $data['pob_pay_by'];
		$this->data['record_pob_pay_date'] = $data['pob_pay_date'];
		$this->data['record_pob_status'] = $data['pob_status'];
		$this->data['record_pob_by'] = $data['pob_by'];
		$this->data['record_pob_edit_by'] = $data['pob_edit_by'];
		$this->data['record_pob_edit_date'] = $data['pob_edit_date'];

		$this->data['record_pob_date'] = setThaiDate($data['pob_date']);
		$this->data['record_pob_price'] = number_format($data['pob_price'], 2);
		$this->data['record_pob_pay_date'] = setThaiDate($data['pob_pay_date']);
		$this->data['record_pob_edit_date'] = setThaiDate($data['pob_edit_date']);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Pob_list_pdf');

		$results = $this->Pob->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);
		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_pob");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_pob");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/pob/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Pob_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Pob->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขใบเสนอซื้อ');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'อ้างอิงใบเสนอซื้อ');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'วันที่ใบเสนอซื้อ');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ชื่อผู้จำหน่าย');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'ชื่อโครงการ');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'ราคารวม');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'จ่ายโดย');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'วันที่นัดจ่าย');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'สถานะ');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'ผู้จัดทำเอกสาร');

		// END SECTION 1

		// set header bold
		$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

		// set Row
		$rowCount = 2;
		foreach ($data_lists as $row) {

			// ***** SECTION 2 *****

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueExplicit('A' . $rowCount, $row['pob_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['pobPrRefId'] . ' ' . $row['pobPrRefPrId'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['pob_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowCount, $row['pobSupSupName'] . ' ' . $row['pobSupSupContact'] . ' ' . $row['pobSupSupAddress'] . ' ' . $row['pobSupSupTel'] . ' ' . $row['pobSupSupTax'] . ' ' . $row['pobSupSupBranch'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowCount, $row['pob_project_name'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('F' . $rowCount, $row['pob_price']);
			$sheet->setCellValueExplicit('G' . $rowCount, $row['pobPayByName'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('H' . $rowCount, $row['pob_pay_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('I' . $rowCount, $row['pobStatusPobName'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('J' . $rowCount, $row['pob_by'], PHPExcel_Cell_DataType::TYPE_STRING);


			$rowCount++;
		}

		foreach (range('A', 'K') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		$filename = "Pob_list" . date("Y-m-d-H-i-s") . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');
	}

	/**
	 * SET array data of detail table list
	 */
	private function setDetailDataListFormat($lists_data, $start_row = 0)
	{
		$grand_total_ราคารวม = 0;
		$data = $lists_data;
		$count = count($lists_data);
		for ($i = 0; $i < $count; $i++) {
			$start_row++;
			$data[$i]['record_number'] = $start_row;
			$pk1 = $data[$i]['id'];
			$data[$i]['detail_url_encrypt_id'] = urlencode(encrypt($pk1));

			if ($pk1 != '') {
				$pk1 = ci_encrypt($pk1);
			}
			$data[$i]['detail_encrypt_id'] = $pk1;

			$data[$i]['detail_id'] = $data[$i]['id'];
			$data[$i]['detail_pob_ref'] = $data[$i]['pob_ref'];
			$data[$i]['detail_pob_pr_id_ref'] = $data[$i]['pob_pr_id_ref'];
			$data[$i]['detail_pob_id'] = $data[$i]['pob_id'];
			$data[$i]['detail_pob_name'] = $data[$i]['pob_name'];
			$data[$i]['fx_detail_ราคารวม'] = $data[$i]['pob_price'] * $data[$i]['pob_qty'];
			$data[$i]['detail_pob_price'] = $data[$i]['pob_price'];
			$data[$i]['detail_pob_unit'] = $data[$i]['pob_unit'];
			$data[$i]['detail_pob_qty'] = $data[$i]['pob_qty'];
			$data[$i]['detail_pob_remark'] = $data[$i]['pob_remark'];

			//FUNCTION
			$data[$i]['detail_pob_price'] = number_format($data[$i]['pob_price'], 2);
			$data[$i]['detail_pob_qty'] = number_format($data[$i]['pob_qty'], 2);

			$grand_total_ราคารวม += $data[$i]['fx_detail_ราคารวม'];
			$data[$i]['fx_detail_ราคารวม'] = number_format($data[$i]['fx_detail_ราคารวม'], 2);
		}

		$this->data['fx_detail_grand_ราคารวม'] = number_format($grand_total_ราคารวม, 2);

		return $data;
	}

	/**
	 * SET array detail list
	 */
	private function setPreviewFormatDetail($row_data)
	{
		$data = $row_data;

		$pk1 = $data['id'];
		$data['detail_recode_url_encrypt_id'] = urlencode(encrypt($pk1));

		if ($pk1 != '') {
			$pk1 = ci_encrypt($pk1);
		}
		$data['detail_encrypt_id'] = $pk1;

		$pobPrIdRefPrRef = $this->table('tb_prs_list')->get_value('pr_ref')->where("pr_ref = '$data[pob_pr_id_ref]'");
		$data['pobPrIdRefPrRef'] = $pobPrIdRefPrRef;


		$pobNamePrbName = $this->table('tb_product_buy')->get_value('prb_name')->where("prb_name = '$data[pob_name]'");
		$data['pobNamePrbName'] = $pobNamePrbName;

		$data['detail_encrypt_pob_ref'] = urlencode(encrypt($data['pob_ref']));

		$data['detail_record_id'] = $data['id'];
		$data['detail_record_pob_ref'] = $data['pob_ref'];
		$data['detail_encrypt_pob_ref'] = ci_encrypt($data['pob_ref']);
		$data['detail_record_pob_pr_id_ref'] = $data['pob_pr_id_ref'];
		$data['detail_record_pob_id'] = $data['pob_id'];
		$data['detail_record_pob_name'] = $data['pob_name'];
		$data['detail_record_pob_price'] = $data['pob_price'];
		$data['detail_record_pob_unit'] = $data['pob_unit'];
		$data['detail_record_pob_qty'] = $data['pob_qty'];
		$data['detail_record_pob_remark'] = $data['pob_remark'];

		$data['detail_record_pob_price'] = number_format($data['pob_price'], 2);
		$data['detail_record_pob_qty'] = number_format($data['pob_qty'], 2);


		return $data;
	}
}
/*---------------------------- END Controller Class --------------------------------*/
