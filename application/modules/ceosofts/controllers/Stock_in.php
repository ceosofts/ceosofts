<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Stock_in.php ]
 */
class Stock_in extends MEMBER_Controller
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
		$this->load->model('ceosofts/Stock_in_model', 'Stock_in');
		$this->Stock_in->session_name = 'ceosofts_stock_in';

		$this->data['page_url'] = site_url('ceosofts/stock_in');

		$this->data['page_title'] = 'CEO Softs';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');

		$js_url = 'assets/js_modules/ceosofts/stock_in.js?ft=' . filemtime('assets/js_modules/ceosofts/stock_in.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Stock_in', 'class' => 'active', 'url' => '#'),
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
			if ($this->session->userdata('user_level') >= 1 && $this->session->userdata('user_department_id') == 13 || 11 || 12) {
				$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
			} else {
				$this->data['alert_message'] = 'เฉพาะผู้ใช้งานระดับ <b>ผู้ใช้งานทั่วไป</b> และ เฉพาะผู้ใช้งานแผนก <b>คลังสินค้า</b>';
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
		$this->session->unset_userdata($this->Stock_in->session_name . '_search_field');
		$this->session->unset_userdata($this->Stock_in->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Stock_in', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Stock_in->session_name . '_search_field' => $search_field, $this->Stock_in->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Stock_in->session_name . '_search_field');
			$value = $this->session->userdata($this->Stock_in->session_name . '_value');
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
			$this->Stock_in->order_field = $field;
			$this->Stock_in->order_sort = $sort;
		}
		$results = $this->Stock_in->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/stock_in');
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

		$this->render_view('ceosofts/stock_in/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Stock_in', 'url' => site_url('ceosofts/stock_in')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Stock_in->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);

				$detail_list = $this->Stock_in->loadDetailList($results['id']);
				$this->data['detail_list'] = $this->setDetailDataListFormat($detail_list);
				$this->render_view('ceosofts/stock_in/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Stock_in_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Stock_in->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$detail_list = $this->Stock_in->loadDetailList($results['id']);
		$data_lists = $this->setDetailDataListFormat($detail_list);

		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_stock_in");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_stock_in");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/stock_in/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Stock_in_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Stock_in->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$detail_list = $this->Stock_in->loadDetailList($results['id']);
		$data_lists = $this->setDetailDataListFormat($detail_list);

		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/stock_in/preview_view_excel', $data, true);

		$filename = "Stock_in_preview" . date("Y-m-d-H-i-s") . "";
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
		echo $this->Stock_in->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$sti_id_running = $this->Stock_in->set_running_number('sti_id');
		$this->data['source_sti_id'] = $sti_id_running;

		$sti_by = $this->session->userdata('sti_by');
		$this->data['source_sti_by'] = $sti_by;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Stock_in', 'url' => site_url('ceosofts/stock_in')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$this->data['tb_supplier_sti_sup_option_list'] = $this->Stock_in->returnOptionList("tb_supplier", "sup_name", "sup_name");
		$this->data['tb_quotation_sti_project_name_option_list'] = $this->Stock_in->returnOptionList("tb_quotation", "quo_project_name", "quo_project_name");
		$options['attributes'] = array('prb_id', 'prb_unit');
		$this->data['detail_tb_product_buy_sti_name_option_list'] = $this->Stock_in->returnOptionList("tb_product_buy", "prb_name", "prb_name", $options);
		$this->setFormAddData();
		$this->render_view('ceosofts/stock_in/add_view');
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

		$frm->set_rules('sti_id', 'หมายเลขสินค้านำเข้า', 'trim|required');
		$frm->set_rules('sti_date', 'วันที่ใบสินค้านำเข้า', 'trim|required');
		$frm->set_rules('sti_sup', 'ชื่อผู้จำหน่าย', 'trim|required');
		$frm->set_rules('sti_project_name', 'ชื่อโครงการ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');


		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('sti_id');
			$message .= form_error('sti_date');
			$message .= form_error('sti_sup');
			$message .= form_error('sti_project_name');
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

		$frm->set_rules('sti_id', 'หมายเลขสินค้านำเข้า', 'trim|required');
		$frm->set_rules('sti_date', 'วันที่ใบสินค้านำเข้า', 'trim|required');
		$frm->set_rules('sti_sup', 'ชื่อผู้จำหน่าย', 'trim|required');
		$frm->set_rules('sti_project_name', 'ชื่อโครงการ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');


		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('sti_id');
			$message .= form_error('sti_date');
			$message .= form_error('sti_sup');
			$message .= form_error('sti_project_name');
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

			$post['sti_by'] = $this->session->userdata('sti_by');

			$encrypt_id = '';
			$id = $this->Stock_in->create($post);
			if ($id != '') {
				$success = TRUE;
				$encrypt_id = ci_encrypt($id);
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Stock_in->error_message;
			}

			$json = json_encode(array(
				'is_successful' => $success,
				'encrypt_id' =>  $encrypt_id,
				'sti_ref_encrypt_id' =>  $encrypt_id,
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
			array('title' => 'Stock_in', 'url' => site_url('ceosofts/stock_in')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Stock_in->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_sti_id'] = '';
				$this->data['source_sti_by'] = $this->session->userdata('sti_by');

				$this->setPreviewFormat($results);

				$this->data['record_sti_date'] = setThaiDate($results['sti_date']);

				$this->data['tb_supplier_sti_sup_option_list'] = $this->Stock_in->returnOptionList("tb_supplier", "sup_name", "sup_name");
				$this->data['tb_quotation_sti_project_name_option_list'] = $this->Stock_in->returnOptionList("tb_quotation", "quo_project_name", "quo_project_name");
				$options['attributes'] = array('prb_id', 'prb_unit');
				$this->data['detail_tb_product_buy_sti_name_option_list'] = $this->Stock_in->returnOptionList("tb_product_buy", "prb_name", "prb_name", $options);

				$this->data['detail_record_sti_ref'] = ci_encrypt($results['id']);

				$detail_list = $this->Stock_in->loadDetailList($results['id']);
				$this->data['detail_list'] = $this->setDetailDataListFormat($detail_list);
				$this->render_view('ceosofts/stock_in/edit_view');
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

			$post['sti_by'] = $this->session->userdata('sti_by');

			$result = $this->Stock_in->update($post);
			if ($result == false) {
				$message = $this->Stock_in->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Stock_in->error_message;
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
			$result = $this->Stock_in->delete($post);
			if ($result == false) {
				$message = $this->Stock_in->error_message;
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

		$frm->set_rules('sti_ref', 'อ้างอิงใบนำเข้าสินค้า', 'trim|required');
		$frm->set_rules('sti_id', 'หมายเลขสินค้า', 'trim|required');
		$frm->set_rules('sti_name', 'รายการสินค้า', 'trim|required');
		$frm->set_rules('sti_unit', 'หน่วยสินค้า', 'trim|required');
		$frm->set_rules('sti_qty', 'จำนวน', 'trim|required|decimal');
		$frm->set_rules('sti_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('sti_ref');
			$message .= form_error('sti_id');
			$message .= form_error('sti_name');
			$message .= form_error('sti_unit');
			$message .= form_error('sti_qty');
			$message .= form_error('sti_remark');
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

		$frm->set_rules('sti_ref', 'อ้างอิงใบนำเข้าสินค้า', 'trim|required');
		$frm->set_rules('sti_id', 'หมายเลขสินค้า', 'trim|required');
		$frm->set_rules('sti_name', 'รายการสินค้า', 'trim|required');
		$frm->set_rules('sti_unit', 'หน่วยสินค้า', 'trim|required');
		$frm->set_rules('sti_qty', 'จำนวน', 'trim|required|decimal');
		$frm->set_rules('sti_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('sti_ref');
			$message .= form_error('sti_id');
			$message .= form_error('sti_name');
			$message .= form_error('sti_unit');
			$message .= form_error('sti_qty');
			$message .= form_error('sti_remark');
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
		$ref_field = ci_decrypt($post['sti_ref']);
		if ($ref_field == '') {
			$message .= "- รหัสเชื่อมโยงตารางที่ใช้สำหรับเพิ่มรายการไม่ถูกต้อง";
		} else {
			$post['sti_ref'] = $ref_field;
		}

		if ($message != '') {
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {

			$id = $this->Stock_in->save_detail_list($post);
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
			$results = $this->Stock_in->load_detail_record($id);
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
		$ref_field = ci_decrypt($post['sti_ref']);
		if ($ref_field == '') {
			$message .= "- รหัสเชื่อมโยงตารางที่ใช้สำหรับเพิ่มรายการไม่ถูกต้อง";
		} else {
			$post['sti_ref'] = $ref_field;
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

			$result = $this->Stock_in->save_detail_list($post);
			if ($result == false) {
				$message = $this->Stock_in->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Stock_in->error_message;
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
			$result = $this->Stock_in->delete_list($post);
			if ($result == false) {
				$message = $this->Stock_in->error_message;
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
		$data = $this->Stock_in->loadDetailList($ref_id);
		if (!empty($data)) {
			$data['detail_list'] = $this->setDetailDataListFormat($data);
			$template = '{detail_list}
					<tr id="list_row_{record_number}">
						<td style="text-align:center;">[{record_number}]</td>
						<td>{detail_id}</td>
						<td>{detail_sti_ref}</td>
						<td>{detail_sti_id}</td>
						<td>{detailStiNamePrbName}</td>
						<td>{detail_sti_unit}</td>
						<td>{detail_sti_qty}</td>
						<td>{detail_sti_remark}</td>
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
			'tbody' => $tbody
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
			$data[$i]['sti_date'] = setThaiDate($data[$i]['sti_date']);
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


		$stiSupSupName = $this->table('tb_supplier')->get_value('sup_name')->where("sup_name = '$data[sti_sup]'");
		$this->data['stiSupSupName'] = $stiSupSupName;


		$stiProjectNameQuoProjectName = $this->table('tb_quotation')->get_value('quo_project_name')->where("quo_project_name = '$data[sti_project_name]'");
		$this->data['stiProjectNameQuoProjectName'] = $stiProjectNameQuoProjectName;

		$this->data['detail_sti_ref'] = urlencode(encrypt($data['id']));

		$this->data['record_id'] = $data['id'];
		$this->data['record_sti_id'] = $data['sti_id'];
		$this->data['record_sti_date'] = $data['sti_date'];
		$this->data['record_sti_sup'] = $data['sti_sup'];
		$this->data['record_sti_project_name'] = $data['sti_project_name'];
		$this->data['record_sti_by'] = $data['sti_by'];

		$this->data['record_sti_date'] = setThaiDate($data['sti_date']);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Stock_in_list_pdf');

		$results = $this->Stock_in->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);
		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_stock_in");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_stock_in");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/stock_in/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Stock_in_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Stock_in->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขสินค้านำเข้า');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'วันที่ใบสินค้านำเข้า');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'ชื่อผู้จำหน่าย');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ชื่อโครงการ');

		// END SECTION 1

		// set header bold
		$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

		// set Row
		$rowCount = 2;
		foreach ($data_lists as $row) {

			// ***** SECTION 2 *****

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueExplicit('A' . $rowCount, $row['sti_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['sti_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['stiSupSupName'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowCount, $row['stiProjectNameQuoProjectName'], PHPExcel_Cell_DataType::TYPE_STRING);


			$rowCount++;
		}

		foreach (range('A', 'E') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		$filename = "Stock_in_list" . date("Y-m-d-H-i-s") . ".xlsx";
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
			$data[$i]['detail_sti_ref'] = $data[$i]['sti_ref'];
			$data[$i]['detail_sti_id'] = $data[$i]['sti_id'];
			$data[$i]['detail_sti_name'] = $data[$i]['sti_name'];
			$data[$i]['detail_sti_unit'] = $data[$i]['sti_unit'];
			$data[$i]['detail_sti_qty'] = $data[$i]['sti_qty'];
			$data[$i]['detail_sti_remark'] = $data[$i]['sti_remark'];

			//FUNCTION
			$data[$i]['detail_sti_qty'] = number_format($data[$i]['sti_qty'], 2);
		}
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

		$stiNamePrbName = $this->table('tb_product_buy')->get_value('prb_name')->where("prb_name = '$data[sti_name]'");
		$data['stiNamePrbName'] = $stiNamePrbName;

		$data['detail_encrypt_sti_ref'] = urlencode(encrypt($data['sti_ref']));

		$data['detail_record_id'] = $data['id'];
		$data['detail_record_sti_ref'] = $data['sti_ref'];
		$data['detail_encrypt_sti_ref'] = ci_encrypt($data['sti_ref']);
		$data['detail_record_sti_id'] = $data['sti_id'];
		$data['detail_record_sti_name'] = $data['sti_name'];
		$data['detail_record_sti_unit'] = $data['sti_unit'];
		$data['detail_record_sti_qty'] = $data['sti_qty'];
		$data['detail_record_sti_remark'] = $data['sti_remark'];

		$data['detail_record_sti_qty'] = number_format($data['sti_qty'], 2);


		return $data;
	}
}
/*---------------------------- END Controller Class --------------------------------*/
