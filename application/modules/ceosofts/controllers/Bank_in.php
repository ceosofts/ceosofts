<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Bank_in.php ]
 */
class Bank_in extends MEMBER_Controller
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
		$this->load->model('ceosofts/Bank_in_model', 'Bank_in');
		$this->Bank_in->session_name = 'ceosofts_bank_in';

		$this->data['page_url'] = site_url('ceosofts/bank_in');

		$this->data['page_title'] = 'CEO Softs';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');

		$js_url = 'assets/js_modules/ceosofts/bank_in.js?ft=' . filemtime('assets/js_modules/ceosofts/bank_in.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Bank_in', 'class' => 'active', 'url' => '#'),
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
		$this->session->unset_userdata($this->Bank_in->session_name . '_search_field');
		$this->session->unset_userdata($this->Bank_in->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Bank_in', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Bank_in->session_name . '_search_field' => $search_field, $this->Bank_in->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Bank_in->session_name . '_search_field');
			$value = $this->session->userdata($this->Bank_in->session_name . '_value');
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
			$this->Bank_in->order_field = $field;
			$this->Bank_in->order_sort = $sort;
		}
		$results = $this->Bank_in->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/bank_in');
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

		$this->render_view('ceosofts/bank_in/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Bank_in', 'url' => site_url('ceosofts/bank_in')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Bank_in->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);
				$this->render_view('ceosofts/bank_in/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Bank_in_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Bank_in->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_bank_in");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_bank_in");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/bank_in/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Bank_in_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Bank_in->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/bank_in/preview_view_excel', $data, true);

		$filename = "Bank_in_preview" . date("Y-m-d-H-i-s") . "";
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
		echo $this->Bank_in->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$bank_in_id_running = $this->Bank_in->set_running_number('bank_in_id');
		$this->data['source_bank_in_id'] = $bank_in_id_running;

		$bank_in_edit_by = $this->session->userdata('bank_in_edit_by');
		$this->data['source_bank_in_edit_by'] = $bank_in_edit_by;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Bank_in', 'url' => site_url('ceosofts/bank_in')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$this->data['tb_bookbank_bank_in_name_option_list'] = $this->Bank_in->returnOptionList("tb_bookbank", "bank_cus_name", "CONCAT_WS(' - ', bank_cus_name,bank_name,bank_branch,bank_number)");
		$this->setFormAddData();
		$this->render_view('ceosofts/bank_in/add_view');
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

		$frm->set_rules('bank_in_id', 'หมายเลขรายการ', 'trim|required');
		$frm->set_rules('bank_in_date', 'วันที่ทำการ', 'trim|required');
		$frm->set_rules('bank_in_name', 'ชื่อบัญชี', 'trim|required');
		$frm->set_rules('bank_in_balance_before', 'ยอดก่อนฝาก', 'trim|required|decimal');
		$frm->set_rules('bank_in_price', 'ยอดทำรายการ', 'trim|required|decimal');
		$frm->set_rules('bank_in_balance_after', 'คงเหลือ', 'trim|required|decimal');
		$frm->set_rules('bank_in_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('bank_in_id');
			$message .= form_error('bank_in_date');
			$message .= form_error('bank_in_name');
			$message .= form_error('bank_in_balance_before');
			$message .= form_error('bank_in_price');
			$message .= form_error('bank_in_balance_after');
			$message .= form_error('bank_in_remark');
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

		$frm->set_rules('bank_in_id', 'หมายเลขรายการ', 'trim|required');
		$frm->set_rules('bank_in_date', 'วันที่ทำการ', 'trim|required');
		$frm->set_rules('bank_in_name', 'ชื่อบัญชี', 'trim|required');
		$frm->set_rules('bank_in_balance_before', 'ยอดก่อนฝาก', 'trim|required|decimal');
		$frm->set_rules('bank_in_price', 'ยอดทำรายการ', 'trim|required|decimal');
		$frm->set_rules('bank_in_balance_after', 'คงเหลือ', 'trim|required|decimal');
		$frm->set_rules('bank_in_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('bank_in_id');
			$message .= form_error('bank_in_date');
			$message .= form_error('bank_in_name');
			$message .= form_error('bank_in_balance_before');
			$message .= form_error('bank_in_price');
			$message .= form_error('bank_in_balance_after');
			$message .= form_error('bank_in_remark');
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

			$post['bank_in_edit_by'] = $this->session->userdata('bank_in_edit_by');

			$encrypt_id = '';
			$id = $this->Bank_in->create($post);
			if ($id != '') {
				$success = TRUE;
				$encrypt_id = ci_encrypt($id);
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Bank_in->error_message;
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
			array('title' => 'Bank_in', 'url' => site_url('ceosofts/bank_in')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Bank_in->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_bank_in_id'] = '';
				$this->data['source_bank_in_edit_by'] = $this->session->userdata('bank_in_edit_by');

				$this->setPreviewFormat($results);

				$this->data['record_bank_in_date'] = setThaiDate($results['bank_in_date']);

				$this->data['tb_bookbank_bank_in_name_option_list'] = $this->Bank_in->returnOptionList("tb_bookbank", "bank_cus_name", "CONCAT_WS(' - ', bank_cus_name,bank_name,bank_branch,bank_number)");
				$this->render_view('ceosofts/bank_in/edit_view');
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

			$post['bank_in_edit_by'] = $this->session->userdata('bank_in_edit_by');

			$result = $this->Bank_in->update($post);
			if ($result == false) {
				$message = $this->Bank_in->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Bank_in->error_message;
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
			$result = $this->Bank_in->delete($post);
			if ($result == false) {
				$message = $this->Bank_in->error_message;
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
			$data[$i]['bank_in_date'] = setThaiDate($data[$i]['bank_in_date']);
			$data[$i]['bank_in_balance_before'] = number_format($data[$i]['bank_in_balance_before'], 2);
			$data[$i]['bank_in_price'] = number_format($data[$i]['bank_in_price'], 2);
			$data[$i]['bank_in_balance_after'] = number_format($data[$i]['bank_in_balance_after'], 2);
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


		$titleRow = $this->table('tb_bookbank')->get_array('bank_cus_name, bank_name, bank_branch, bank_number')->where("bank_cus_name = '$data[bank_in_name]'");
		if (!empty($titleRow)) {
			$bankInNameBankCusName = $titleRow['bank_cus_name'];
			$bankInNameBankName = $titleRow['bank_name'];
			$bankInNameBankBranch = $titleRow['bank_branch'];
			$bankInNameBankNumber = $titleRow['bank_number'];
		} else {
			$bankInNameBankCusName = '';
			$bankInNameBankName = '';
			$bankInNameBankBranch = '';
			$bankInNameBankNumber = '';
		}
		$this->data['bankInNameBankCusName'] = $bankInNameBankCusName;
		$this->data['bankInNameBankName'] = $bankInNameBankName;
		$this->data['bankInNameBankBranch'] = $bankInNameBankBranch;
		$this->data['bankInNameBankNumber'] = $bankInNameBankNumber;

		$this->data['record_id'] = $data['id'];
		$this->data['record_bank_in_id'] = $data['bank_in_id'];
		$this->data['record_bank_in_date'] = $data['bank_in_date'];
		$this->data['record_bank_in_name'] = $data['bank_in_name'];
		$this->data['record_bank_in_balance_before'] = $data['bank_in_balance_before'];
		$this->data['record_bank_in_price'] = $data['bank_in_price'];
		$this->data['record_bank_in_balance_after'] = $data['bank_in_balance_after'];
		$this->data['record_bank_in_remark'] = $data['bank_in_remark'];
		$this->data['record_bank_in_edit_by'] = $data['bank_in_edit_by'];

		$this->data['record_bank_in_date'] = setThaiDate($data['bank_in_date']);
		$this->data['record_bank_in_balance_before'] = number_format($data['bank_in_balance_before'], 2);
		$this->data['record_bank_in_price'] = number_format($data['bank_in_price'], 2);
		$this->data['record_bank_in_balance_after'] = number_format($data['bank_in_balance_after'], 2);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Bank_in_list_pdf');

		$results = $this->Bank_in->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);
		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_bank_in");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_bank_in");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/bank_in/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Bank_in_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Bank_in->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขรายการ');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'วันที่ทำการ');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'ชื่อบัญชี');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ยอดก่อนฝาก');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'ยอดทำรายการ');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'คงเหลือ');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'หมายเหตุ');

		// END SECTION 1

		// set header bold
		$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

		// set Row
		$rowCount = 2;
		foreach ($data_lists as $row) {

			// ***** SECTION 2 *****

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueExplicit('A' . $rowCount, $row['bank_in_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['bank_in_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['bankInNameBankCusName'] . ' ' . $row['bankInNameBankName'] . ' ' . $row['bankInNameBankBranch'] . ' ' . $row['bankInNameBankNumber'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('D' . $rowCount, $row['bank_in_balance_before']);
			$sheet->SetCellValue('E' . $rowCount, $row['bank_in_price']);
			$sheet->SetCellValue('F' . $rowCount, $row['bank_in_balance_after']);
			$sheet->setCellValueExplicit('G' . $rowCount, $row['bank_in_remark'], PHPExcel_Cell_DataType::TYPE_STRING);


			$rowCount++;
		}

		foreach (range('A', 'H') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		$filename = "Bank_in_list" . date("Y-m-d-H-i-s") . ".xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');
	}
}
/*---------------------------- END Controller Class --------------------------------*/
