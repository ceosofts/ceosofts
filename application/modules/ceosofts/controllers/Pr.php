<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Pr.php ]
 */
class Pr extends CRUD_Controller
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
		$this->load->model('ceosofts/Pr_model', 'Pr');
		$this->Pr->session_name = 'ceosofts_pr';

		$this->data['page_url'] = site_url('ceosofts/pr');

		$this->data['page_title'] = 'CEO Softs';

		$js_url = 'assets/js_modules/ceosofts/pr.js?ft=' . filemtime('assets/js_modules/ceosofts/pr.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
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
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
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
		$this->session->unset_userdata($this->Pr->session_name . '_search_field');
		$this->session->unset_userdata($this->Pr->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Pr', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Pr->session_name . '_search_field' => $search_field, $this->Pr->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Pr->session_name . '_search_field');
			$value = $this->session->userdata($this->Pr->session_name . '_value');
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
			$this->Pr->order_field = $field;
			$this->Pr->order_sort = $sort;
		}
		$results = $this->Pr->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/pr');
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

		$this->render_view('ceosofts/pr/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Pr', 'url' => site_url('ceosofts/pr')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Pr->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);

				$detail_list = $this->Pr->loadDetailList($results['id']);
				$this->data['detail_list'] = $this->setDetailDataListFormat($detail_list);
				$this->render_view('ceosofts/pr/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	// ------------------------------------------------------------------------
	/**
	 * Reload running number
	 */
	public function reload_runninng()
	{
		$field = $this->input->post('field', TRUE);
		echo $this->Pr->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$pr_id_running = $this->Pr->set_running_number('pr_id');
		$this->data['source_pr_id'] = $pr_id_running;

		$pr_by = $this->session->userdata('pr_by');
		$this->data['source_pr_by'] = $pr_by;

		$pr_edit_by = $this->session->userdata('pr_edit_by');
		$this->data['source_pr_edit_by'] = $pr_edit_by;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Pr', 'url' => site_url('ceosofts/pr')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$this->data['tb_supplier_pr_sup_option_list'] = $this->Pr->returnOptionList("tb_supplier", "sup_name", "CONCAT_WS(' - ', sup_name,sup_contact,sup_address,sup_tel,sup_tax,sup_branch)");
		$options['attributes'] = array('pr_id', 'pr_price', 'pr_unit');
		$this->data['detail_tb_product_buy_pr_name_option_list'] = $this->Pr->returnOptionList("tb_product_buy", "pr_name", "pr_name", $options);
		$this->setFormAddData();

		$this->data['fx_detail_grand_total_price'] = number_format(0, 2);

		$this->render_view('ceosofts/pr/add_view');
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

		$frm->set_rules('pr_id', 'หมายเลขใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pr_date', 'วันที่ใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pr_sup', 'ชื่อผู้จำหน่าย', 'trim|required');
		$frm->set_rules('pr_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('pr_status', 'สถานะ[1=เสนอพิจารณา, 2=รอพิจารณา, 3=อนุมัติ, 4=ไม่อนุมัติ]', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');


		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('pr_id');
			$message .= form_error('pr_date');
			$message .= form_error('pr_sup');
			$message .= form_error('pr_project_name');
			$message .= form_error('pr_status');
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

		$frm->set_rules('pr_id', 'หมายเลขใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pr_date', 'วันที่ใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pr_sup', 'ชื่อผู้จำหน่าย', 'trim|required');
		$frm->set_rules('pr_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('pr_status', 'สถานะ[1=เสนอพิจารณา, 2=รอพิจารณา, 3=อนุมัติ, 4=ไม่อนุมัติ]', 'trim|required');
		$frm->set_rules('pr_status_date', 'วันที่แก้ไขสถานะ', 'trim|required');
		$frm->set_rules('pr_edit_date', 'วันที่แก้ไข', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');


		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('pr_id');
			$message .= form_error('pr_date');
			$message .= form_error('pr_sup');
			$message .= form_error('pr_project_name');
			$message .= form_error('pr_status');
			$message .= form_error('pr_status_date');
			$message .= form_error('pr_edit_date');
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

			$post['pr_by'] = $this->session->userdata('pr_by');
			$post['pr_edit_by'] = $this->session->userdata('pr_edit_by');

			$encrypt_id = '';
			$id = $this->Pr->create($post);
			if ($id != '') {
				$success = TRUE;
				$encrypt_id = ci_encrypt($id);
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Pr->error_message;
			}

			$json = json_encode(array(
				'is_successful' => $success,
				'encrypt_id' =>  $encrypt_id,
				'pr_ref_encrypt_id' =>  $encrypt_id,
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
			array('title' => 'Pr', 'url' => site_url('ceosofts/pr')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Pr->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_pr_id'] = '';
				$this->data['source_pr_by'] = $this->session->userdata('pr_by');
				$this->data['source_pr_edit_by'] = $this->session->userdata('pr_edit_by');

				$this->setPreviewFormat($results);

				$this->data['record_pr_date'] = setThaiDate($results['pr_date']);
				$this->data['record_pr_status_date'] = setThaiDate($results['pr_status_date']);
				$this->data['record_pr_edit_date'] = setThaiDate($results['pr_edit_date']);

				$this->data['tb_supplier_pr_sup_option_list'] = $this->Pr->returnOptionList("tb_supplier", "sup_name", "CONCAT_WS(' - ', sup_name,sup_contact,sup_address,sup_tel,sup_tax,sup_branch)");
				$options['attributes'] = array('pr_id', 'pr_price', 'pr_unit');
				$this->data['detail_tb_product_buy_pr_name_option_list'] = $this->Pr->returnOptionList("tb_product_buy", "pr_name", "pr_name", $options);

				$this->data['detail_record_pr_ref'] = ci_encrypt($results['id']);

				$detail_list = $this->Pr->loadDetailList($results['id']);
				$this->data['detail_list'] = $this->setDetailDataListFormat($detail_list);
				$this->render_view('ceosofts/pr/edit_view');
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

			$post['pr_by'] = $this->session->userdata('pr_by');
			$post['pr_edit_by'] = $this->session->userdata('pr_edit_by');

			$result = $this->Pr->update($post);
			if ($result == false) {
				$message = $this->Pr->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Pr->error_message;
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
			$result = $this->Pr->delete($post);
			if ($result == false) {
				$message = $this->Pr->error_message;
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

		$frm->set_rules('pr_ref', 'อ้างอิงใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pr_id', 'หมายเลขสินค้า', 'trim|required');
		$frm->set_rules('pr_name', 'รายการสินค้า', 'trim|required');
		$frm->set_rules('pr_price', 'ราคาสินค้า', 'trim|required|decimal');
		$frm->set_rules('pr_unit', 'หน่วยสินค้า', 'trim|required');
		$frm->set_rules('pr_qty', 'จำนวน', 'trim|required|decimal');
		$frm->set_rules('pr_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('pr_ref');
			$message .= form_error('pr_id');
			$message .= form_error('pr_name');
			$message .= form_error('pr_price');
			$message .= form_error('pr_unit');
			$message .= form_error('pr_qty');
			$message .= form_error('pr_remark');
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

		$frm->set_rules('pr_ref', 'อ้างอิงใบเสนอซื้อ', 'trim|required');
		$frm->set_rules('pr_id', 'หมายเลขสินค้า', 'trim|required');
		$frm->set_rules('pr_name', 'รายการสินค้า', 'trim|required');
		$frm->set_rules('pr_price', 'ราคาสินค้า', 'trim|required|decimal');
		$frm->set_rules('pr_unit', 'หน่วยสินค้า', 'trim|required');
		$frm->set_rules('pr_qty', 'จำนวน', 'trim|required|decimal');
		$frm->set_rules('pr_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('pr_ref');
			$message .= form_error('pr_id');
			$message .= form_error('pr_name');
			$message .= form_error('pr_price');
			$message .= form_error('pr_unit');
			$message .= form_error('pr_qty');
			$message .= form_error('pr_remark');
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
		$ref_field = ci_decrypt($post['pr_ref']);
		if ($ref_field == '') {
			$message .= "- รหัสเชื่อมโยงตารางที่ใช้สำหรับเพิ่มรายการไม่ถูกต้อง";
		} else {
			$post['pr_ref'] = $ref_field;
		}

		if ($message != '') {
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {

			$id = $this->Pr->save_detail_list($post);
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
			$results = $this->Pr->load_detail_record($id);
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
		$ref_field = ci_decrypt($post['pr_ref']);
		if ($ref_field == '') {
			$message .= "- รหัสเชื่อมโยงตารางที่ใช้สำหรับเพิ่มรายการไม่ถูกต้อง";
		} else {
			$post['pr_ref'] = $ref_field;
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

			$result = $this->Pr->save_detail_list($post);
			if ($result == false) {
				$message = $this->Pr->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Pr->error_message;
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
			$result = $this->Pr->delete_list($post);
			if ($result == false) {
				$message = $this->Pr->error_message;
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
		$data = $this->Pr->loadDetailList($ref_id);
		if (!empty($data)) {
			$data['detail_list'] = $this->setDetailDataListFormat($data);
			$template = '{detail_list}
					<tr id="list_row_{record_number}">
						<td style="text-align:center;">[{record_number}]</td>
						<td>{detail_id}</td>
						<td>{detail_pr_ref}</td>
						<td>{detail_pr_id}</td>
						<td>{detailPrNamePrName}</td>
						<td>{detail_pr_price}</td>
						<td>{detail_pr_unit}</td>
						<td>{detail_pr_qty}</td>
						<td class="text-right">{fx_detail_total_price}</td>
						<td>{detail_pr_remark}</td>
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
			'tbody' => $tbody, 'fx_detail_grand_total_price' => $this->data['fx_detail_grand_total_price']
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
			$data[$i]['preview_pr_status'] = $this->setPrStatusSubject($data[$i]['pr_status']);
			$data[$i]['pr_date'] = setThaiDate($data[$i]['pr_date']);
			$data[$i]['pr_status_date'] = setThaiDate($data[$i]['pr_status_date']);
			$data[$i]['pr_edit_date'] = setThaiDate($data[$i]['pr_edit_date']);
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
	private function setPrStatusSubject($value)
	{
		$subject = '';
		switch ($value) {
			case '1':
				$subject = 'เสนอพิจารณา';
				break;
			case '2':
				$subject = 'รอพิจารณา';
				break;
			case '3':
				$subject = 'อนุมัติ';
				break;
			case '4':
				$subject = 'ไม่อนุมัติ';
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


		$titleRow = $this->table('tb_supplier')->get_array('sup_name, sup_contact, sup_address, sup_tel, sup_tax, sup_branch')->where("sup_name = '$data[pr_sup]'");
		if (!empty($titleRow)) {
			$prSupSupName = $titleRow['sup_name'];
			$prSupSupContact = $titleRow['sup_contact'];
			$prSupSupAddress = $titleRow['sup_address'];
			$prSupSupTel = $titleRow['sup_tel'];
			$prSupSupTax = $titleRow['sup_tax'];
			$prSupSupBranch = $titleRow['sup_branch'];
		} else {
			$prSupSupName = '';
			$prSupSupContact = '';
			$prSupSupAddress = '';
			$prSupSupTel = '';
			$prSupSupTax = '';
			$prSupSupBranch = '';
		}
		$this->data['prSupSupName'] = $prSupSupName;
		$this->data['prSupSupContact'] = $prSupSupContact;
		$this->data['prSupSupAddress'] = $prSupSupAddress;
		$this->data['prSupSupTel'] = $prSupSupTel;
		$this->data['prSupSupTax'] = $prSupSupTax;
		$this->data['prSupSupBranch'] = $prSupSupBranch;

		$this->data['detail_pr_ref'] = urlencode(encrypt($data['id']));

		$this->data['record_id'] = $data['id'];
		$this->data['record_pr_id'] = $data['pr_id'];
		$this->data['record_pr_date'] = $data['pr_date'];
		$this->data['record_pr_sup'] = $data['pr_sup'];
		$this->data['record_pr_project_name'] = $data['pr_project_name'];
		$this->data['preview_pr_status'] = $this->setPrStatusSubject($data['pr_status']);
		$this->data['record_pr_status'] = $data['pr_status'];
		$this->data['record_pr_status_date'] = $data['pr_status_date'];
		$this->data['record_pr_by'] = $data['pr_by'];
		$this->data['record_pr_edit_by'] = $data['pr_edit_by'];
		$this->data['record_pr_edit_date'] = $data['pr_edit_date'];

		$this->data['record_pr_date'] = setThaiDate($data['pr_date']);
		$this->data['record_pr_status_date'] = setThaiDate($data['pr_status_date']);
		$this->data['record_pr_edit_date'] = setThaiDate($data['pr_edit_date']);
	}

	/**
	 * SET array data of detail table list
	 */
	private function setDetailDataListFormat($lists_data, $start_row = 0)
	{
		$grand_total_total_price = 0;
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
			$data[$i]['detail_pr_ref'] = $data[$i]['pr_ref'];
			$data[$i]['detail_pr_id'] = $data[$i]['pr_id'];
			$data[$i]['detail_pr_name'] = $data[$i]['pr_name'];
			$data[$i]['fx_detail_total_price'] = $data[$i]['pr_price'] * $data[$i]['pr_qty'];
			$data[$i]['detail_pr_price'] = $data[$i]['pr_price'];
			$data[$i]['detail_pr_unit'] = $data[$i]['pr_unit'];
			$data[$i]['detail_pr_qty'] = $data[$i]['pr_qty'];
			$data[$i]['detail_pr_remark'] = $data[$i]['pr_remark'];

			//FUNCTION
			$data[$i]['detail_pr_price'] = number_format($data[$i]['pr_price'], 2);
			$data[$i]['detail_pr_qty'] = number_format($data[$i]['pr_qty'], 2);

			$grand_total_total_price += $data[$i]['fx_detail_total_price'];
			$data[$i]['fx_detail_total_price'] = number_format($data[$i]['fx_detail_total_price'], 2);
		}

		$this->data['fx_detail_grand_total_price'] = number_format($grand_total_total_price, 2);

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

		$prNamePrName = $this->table('tb_product_buy')->get_value('pr_name')->where("pr_name = '$data[pr_name]'");
		$data['prNamePrName'] = $prNamePrName;

		$data['detail_encrypt_pr_ref'] = urlencode(encrypt($data['pr_ref']));

		$data['detail_record_id'] = $data['id'];
		$data['detail_record_pr_ref'] = $data['pr_ref'];
		$data['detail_encrypt_pr_ref'] = ci_encrypt($data['pr_ref']);
		$data['detail_record_pr_id'] = $data['pr_id'];
		$data['detail_record_pr_name'] = $data['pr_name'];
		$data['detail_record_pr_price'] = $data['pr_price'];
		$data['detail_record_pr_unit'] = $data['pr_unit'];
		$data['detail_record_pr_qty'] = $data['pr_qty'];
		$data['detail_record_pr_remark'] = $data['pr_remark'];

		$data['detail_record_pr_price'] = number_format($data['pr_price'], 2);
		$data['detail_record_pr_qty'] = number_format($data['pr_qty'], 2);


		return $data;
	}
}
/*---------------------------- END Controller Class --------------------------------*/
