<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Lists.php ]
 */
class Lists extends ADMIN_Controller
{

	private $per_page;
	private $top_navbar_data;

	public function __construct()
	{
		parent::__construct();
		$this->per_page = 30;
		$this->num_links = 6;
		$this->uri_segment = 4;
		$this->load->model('member/Members_list_model', 'Members_list');

		$js_url = 'assets/js_modules/members/lists.js?ft=' . filemtime('assets/js_modules/members/lists.js');
		$this->another_js = '<script src="' . base_url($js_url) . '"></script>';
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
		$this->session->unset_userdata($this->Members_list->session_name . '_search_field');
		$this->session->unset_userdata($this->Members_list->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Lists', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Members_list->session_name . '_search_field' => $search_field, $this->Members_list->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Members_list->session_name . '_search_field');
			$value = $this->session->userdata($this->Members_list->session_name . '_value');
		}

		$start_row = $this->uri->segment(4, '0');
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
			}
			$this->Members_list->order_field = $field;
			$this->Members_list->order_sort = $sort;
		}
		$results = $this->Members_list->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('member/lists');
		$pagination = $this->create_pagination($page_url . '/index', $search_row);
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
		$this->data['current_page_offset'] = $start_row;
		$this->data['start_row']	= $start_row + 1;
		$this->data['end_row']	= $end_row;
		$this->data['order_by']	= $order_by;
		$this->data['total_row']	= $total_row;
		$this->data['search_row']	= $search_row;
		$this->data['page_url']	= $page_url;
		$this->data['pagination_link']	= $pagination;
		$this->data['csrf_protection_field']	= insert_csrf_field(true);

		if ($this->is_admin()) {
			$this->data['page_section'] = $this->parser->parse_repeat('member/management/list_view', $this->data, TRUE);
		}

		$this->render_view(); //no page_content
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Lists', 'url' => site_url('member/lists')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Members_list->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง $id";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);
				$this->data['page_section'] = $this->parser->parse_repeat('member/management/preview_view', $this->data, TRUE);
				$this->render_view(); //no page_content
			}
		}
	}


	// ------------------------------------------------------------------------
	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Lists', 'url' => site_url('member/lists')),
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active')
		);
		$this->render_view('member/management/add_view');
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

		$frm->set_rules('email', 'อีเมล', 'trim|required');
		$frm->set_rules('prefix', 'คำนำหน้าชื่อ[1=นาย,2=นางสาว]', 'trim|required|is_natural');
		$frm->set_rules('firstname', 'ชื่อ', 'trim|required');
		$frm->set_rules('lastname', 'นามสกุล', 'trim|required');
		$frm->set_rules('line_id', 'ไอดี Line', 'trim|required');
		$frm->set_rules('tel_number', 'เบอร์โทรศัพท์', 'trim|required');
		$frm->set_rules('level', 'สิทธิ์การใช้งาน[1=ผู้ใช้งานทั่วไป,9=admin]', 'trim|required|is_natural');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('is_natural', '- %s ต้องระบุตัวเลขจำนวนเต็ม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('email');
			$message .= form_error('prefix');
			$message .= form_error('firstname');
			$message .= form_error('lastname');
			$message .= form_error('line_id');
			$message .= form_error('tel_number');
			$message .= form_error('level');
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

		$frm->set_rules('email', 'อีเมล', 'trim|required');
		$frm->set_rules('prefix', 'คำนำหน้าชื่อ', 'trim|required');
		$frm->set_rules('firstname', 'ชื่อ', 'trim|required');
		$frm->set_rules('lastname', 'นามสกุล', 'trim|required');
		$frm->set_rules('line_id', 'ไอดี Line', 'trim|required');
		$frm->set_rules('tel_number', 'เบอร์โทรศัพท์', 'trim|required');
		$frm->set_rules('level', 'สิทธิ์การใช้งาน[1=ผู้ใช้งานทั่วไป,9=admin]', 'trim|required|is_natural');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('is_natural', '- %s ต้องระบุตัวเลขจำนวนเต็ม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('email');
			$message .= form_error('prefix');
			$message .= form_error('firstname');
			$message .= form_error('lastname');
			$message .= form_error('line_id');
			$message .= form_error('tel_number');
			$message .= form_error('level');
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

			$id = $this->Members_list->create($post);
			$encrypt_id = encrypt($id);
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
	 * Load data to form
	 * @param String encrypt id
	 */
	public function edit($encrypt_id = '')
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Lists', 'url' => site_url('member/lists')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Members_list->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง $id";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);
				$this->setPreviewFormat($results);
				$this->render_view('member/management/edit_view');
			}
		}
	}

	// ------------------------------------------------------------------------
	public function checkRecordKey($data)
	{
		$error = '';
		$userid = checkEncryptData($data['encrypt_userid']);
		if ($userid == '') {
			$error .= '- รหัส userid';
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

			$result = $this->Members_list->update($post);
			if ($result == false) {
				$message = $this->Members_list->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Members_list->error_message;
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
			$result = $this->Members_list->delete($post);
			if ($result == false) {
				$message = $this->Members_list->error_message;
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
			$pk1 = $data[$i]['userid'];
			$data[$i]['url_encrypt_id'] = urlencode(encrypt($pk1));

			if ($pk1 != '') {
				$pk1 = encrypt($pk1);
			}
			$data[$i]['encrypt_userid'] = $pk1;
			$data[$i]['preview_prefix'] = $this->setPrefixSubject($data[$i]['prefix']);
			$data[$i]['preview_level'] = $this->setLevelSubject($data[$i]['level']);
			$data[$i]['create_datetime'] = setThaiDate($data[$i]['create_datetime']);
			$data[$i]['modify_datetime'] = setThaiDate($data[$i]['modify_datetime']);
		}
		return $data;
	}

	/**
	 * SET choice subject
	 */
	private function setLevelSubject($value)
	{
		$subject = '';
		switch ($value) {
			case 1:
				$subject = 'ผู้ใช้งานทั่วไป';
				break;
			case 9:
				$subject = 'Admin';
				break;
			default:
				$subject = 'ผู้ใช้งานทั่วไป';
				break;
		}
		return $subject;
	}

	/**
	 * SET choice subject
	 */
	private function setPrefixSubject($value)
	{
		$subject = '';
		switch ($value) {
			case 1:
				$subject = 'นาย';
				break;
			case 2:
				$subject = 'นางสาว';
				break;
			default:
				$subject = 'นาย';
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

		$pk1 = $data['userid'];
		$this->data['recode_url_encrypt_id'] = urlencode(encrypt($pk1));

		if ($pk1 != '') {
			$pk1 = encrypt($pk1);
		}
		$this->data['encrypt_userid'] = $pk1;

		$this->data['record_userid'] = $data['userid'];
		$this->data['record_email'] = $data['email'];

		$this->data['preview_prefix'] = $this->setPrefixSubject($data['prefix']);
		$this->data['record_prefix'] = $data['prefix'];

		$this->data['record_firstname'] = $data['firstname'];
		$this->data['record_lastname'] = $data['lastname'];
		$this->data['record_line_id'] = $data['line_id'];
		$this->data['record_tel_number'] = $data['tel_number'];
		$this->data['record_password'] = $data['password'];

		$this->data['preview_level'] = $this->setLevelSubject($data['level']);
		$this->data['record_level'] = $data['level'];

		$this->data['record_create_datetime'] = $data['create_datetime'];
		$this->data['record_create_user_id'] = $data['create_user_id'];
		$this->data['record_modify_datetime'] = $data['modify_datetime'];
		$this->data['record_modify_user_id'] = $data['modify_user_id'];

		$this->data['record_create_datetime'] = setThaiDate($data['create_datetime']);
		$this->data['record_modify_datetime'] = setThaiDate($data['modify_datetime']);
	}
}
/*---------------------------- END Controller Class --------------------------------*/