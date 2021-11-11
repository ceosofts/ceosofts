<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Bank.php ]
 */
class Bank extends MEMBER_Controller
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
		$this->load->model('ceosofts/Bank_model', 'Bank');
		$this->Bank->session_name = 'ceosofts_bank';

		$this->data['page_url'] = site_url('ceosofts/bank');

		$this->data['page_title'] = 'CEO Softs';

		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');

		$js_url = 'assets/js_modules/ceosofts/bank.js?ft=' . filemtime('assets/js_modules/ceosofts/bank.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Bank', 'class' => 'active', 'url' => '#'),
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
		$this->session->unset_userdata($this->Bank->session_name . '_search_field');
		$this->session->unset_userdata($this->Bank->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Bank', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Bank->session_name . '_search_field' => $search_field, $this->Bank->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Bank->session_name . '_search_field');
			$value = $this->session->userdata($this->Bank->session_name . '_value');
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
			$this->Bank->order_field = $field;
			$this->Bank->order_sort = $sort;
		}
		$results = $this->Bank->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/bank');
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

		$this->render_view('ceosofts/bank/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Bank', 'url' => site_url('ceosofts/bank')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Bank->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);
				$this->render_view('ceosofts/bank/preview_view');
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
		echo $this->Bank->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$bank_id_running = $this->Bank->set_running_number('bank_id');
		$this->data['source_bank_id'] = $bank_id_running;

		$bank_edit_by = $this->session->userdata('bank_edit_by');
		$this->data['source_bank_edit_by'] = $bank_edit_by;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Bank', 'url' => site_url('ceosofts/bank')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$this->data['tb_bookbank_bank_cus_name_option_list'] = $this->Bank->returnOptionList("tb_bookbank", "bank_cus_name", "CONCAT_WS(' - ', bank_cus_name,bank_name,bank_branch,bank_number)");
		$this->setFormAddData();
		$this->render_view('ceosofts/bank/add_view');
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

		$frm->set_rules('bank_id', 'หมายเลขรายการ', 'trim|required');
		$frm->set_rules('bankout_date', 'วันที่', 'trim|required');
		$frm->set_rules('bank_cus_name', 'ชื่อบัญชี', 'trim|required');
		$frm->set_rules('bank_balance_before', 'ยอดก่อนฝาก-ถอน', 'trim|required|decimal');
		$frm->set_rules('bank_action', 'ทำรายการ[1=ฝาก, 2=ถอน]', 'trim|required');
		$frm->set_rules('bank_price', 'ยอดฝาก-ถอน', 'trim|required|decimal');
		$frm->set_rules('bank_balance_after', 'คงเหลือ', 'trim|required|decimal');
		$frm->set_rules('bank_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('bank_id');
			$message .= form_error('bankout_date');
			$message .= form_error('bank_cus_name');
			$message .= form_error('bank_balance_before');
			$message .= form_error('bank_action');
			$message .= form_error('bank_price');
			$message .= form_error('bank_balance_after');
			$message .= form_error('bank_remark');
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

		$frm->set_rules('bank_id', 'หมายเลขรายการ', 'trim|required');
		$frm->set_rules('bankout_date', 'วันที่', 'trim|required');
		$frm->set_rules('bank_cus_name', 'ชื่อบัญชี', 'trim|required');
		$frm->set_rules('bank_balance_before', 'ยอดก่อนฝาก-ถอน', 'trim|required|decimal');
		$frm->set_rules('bank_action', 'ทำรายการ[1=ฝาก, 2=ถอน]', 'trim|required');
		$frm->set_rules('bank_price', 'ยอดฝาก-ถอน', 'trim|required|decimal');
		$frm->set_rules('bank_balance_after', 'คงเหลือ', 'trim|required|decimal');
		$frm->set_rules('bank_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('bank_id');
			$message .= form_error('bankout_date');
			$message .= form_error('bank_cus_name');
			$message .= form_error('bank_balance_before');
			$message .= form_error('bank_action');
			$message .= form_error('bank_price');
			$message .= form_error('bank_balance_after');
			$message .= form_error('bank_remark');
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

			$post['bank_edit_by'] = $this->session->userdata('bank_edit_by');

			$encrypt_id = '';
			$id = $this->Bank->create($post);
			if ($id != '') {
				$success = TRUE;
				$encrypt_id = ci_encrypt($id);
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Bank->error_message;
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
			array('title' => 'Bank', 'url' => site_url('ceosofts/bank')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Bank->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_bank_id'] = '';
				$this->data['source_bank_edit_by'] = $this->session->userdata('bank_edit_by');

				$this->setPreviewFormat($results);

				$this->data['record_bankout_date'] = setThaiDate($results['bankout_date']);

				$this->data['tb_bookbank_bank_cus_name_option_list'] = $this->Bank->returnOptionList("tb_bookbank", "bank_cus_name", "CONCAT_WS(' - ', bank_cus_name,bank_name,bank_branch,bank_number)");
				$this->render_view('ceosofts/bank/edit_view');
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

			$post['bank_edit_by'] = $this->session->userdata('bank_edit_by');

			$result = $this->Bank->update($post);
			if ($result == false) {
				$message = $this->Bank->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Bank->error_message;
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
			$result = $this->Bank->delete($post);
			if ($result == false) {
				$message = $this->Bank->error_message;
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
			$data[$i]['preview_bank_action'] = $this->setBankActionSubject($data[$i]['bank_action']);
			$data[$i]['bankout_date'] = setThaiDate($data[$i]['bankout_date']);
			$data[$i]['bank_balance_before'] = number_format($data[$i]['bank_balance_before'], 2);
			$data[$i]['bank_price'] = number_format($data[$i]['bank_price'], 2);
			$data[$i]['bank_balance_after'] = number_format($data[$i]['bank_balance_after'], 2);
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
	private function setBankActionSubject($value)
	{
		$subject = '';
		switch ($value) {
			case '1':
				$subject = 'ฝาก';
				break;
			case '2':
				$subject = 'ถอน';
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


		$titleRow = $this->table('tb_bookbank')->get_array('bank_cus_name, bank_name, bank_branch, bank_number')->where("bank_cus_name = '$data[bank_cus_name]'");
		if (!empty($titleRow)) {
			$bankCusNameBankCusName = $titleRow['bank_cus_name'];
			$bankCusNameBankName = $titleRow['bank_name'];
			$bankCusNameBankBranch = $titleRow['bank_branch'];
			$bankCusNameBankNumber = $titleRow['bank_number'];
		} else {
			$bankCusNameBankCusName = '';
			$bankCusNameBankName = '';
			$bankCusNameBankBranch = '';
			$bankCusNameBankNumber = '';
		}
		$this->data['bankCusNameBankCusName'] = $bankCusNameBankCusName;
		$this->data['bankCusNameBankName'] = $bankCusNameBankName;
		$this->data['bankCusNameBankBranch'] = $bankCusNameBankBranch;
		$this->data['bankCusNameBankNumber'] = $bankCusNameBankNumber;

		$this->data['record_id'] = $data['id'];
		$this->data['record_bank_id'] = $data['bank_id'];
		$this->data['record_bankout_date'] = $data['bankout_date'];
		$this->data['record_bank_cus_name'] = $data['bank_cus_name'];
		$this->data['record_bank_balance_before'] = $data['bank_balance_before'];
		$this->data['preview_bank_action'] = $this->setBankActionSubject($data['bank_action']);
		$this->data['record_bank_action'] = $data['bank_action'];
		$this->data['record_bank_price'] = $data['bank_price'];
		$this->data['record_bank_balance_after'] = $data['bank_balance_after'];
		$this->data['record_bank_remark'] = $data['bank_remark'];
		$this->data['record_bank_edit_by'] = $data['bank_edit_by'];

		$this->data['record_bankout_date'] = setThaiDate($data['bankout_date']);
		$this->data['record_bank_balance_before'] = number_format($data['bank_balance_before'], 2);
		$this->data['record_bank_price'] = number_format($data['bank_price'], 2);
		$this->data['record_bank_balance_after'] = number_format($data['bank_balance_after'], 2);
	}
}
/*---------------------------- END Controller Class --------------------------------*/
