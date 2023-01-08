<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Quotation.php ]
 */
class Quotation extends MEMBER_Controller
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
		$this->load->model('ceosofts/Quotation_model', 'Quotation');
		$this->Quotation->session_name = 'ceosofts_quotation';

		$this->data['page_url'] = site_url('ceosofts/quotation');

		$this->data['page_title'] = 'CEO Softs';
		$this->data['user_prefix_name']	= $this->session->userdata('user_prefix_name');
		$this->data['user_firstname']		= $this->session->userdata('user_firstname');
		$this->data['user_lastname']		= $this->session->userdata('user_lastname');

		$js_url = 'assets/js_modules/ceosofts/quotation.js?ft=' . filemtime('assets/js_modules/ceosofts/quotation.js');
		$this->another_js .= '<script src="' . base_url($js_url) . '"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Quotation', 'class' => 'active', 'url' => '#'),
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
		$this->session->unset_userdata($this->Quotation->session_name . '_search_field');
		$this->session->unset_userdata($this->Quotation->session_name . '_value');

		$this->search();
	}

	// ------------------------------------------------------------------------

	/**
	 * Search data
	 */
	public function search()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Quotation', 'class' => 'active', 'url' => '#'),
		);
		if (isset($_POST['submit'])) {
			$search_field =  $this->input->post('search_field', TRUE);
			$value = $this->input->post('txtSearch', TRUE);
			$arr = array($this->Quotation->session_name . '_search_field' => $search_field, $this->Quotation->session_name . '_value' => $value);
			$this->session->set_userdata($arr);
		} else {
			$search_field = $this->session->userdata($this->Quotation->session_name . '_search_field');
			$value = $this->session->userdata($this->Quotation->session_name . '_value');
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
			$this->Quotation->order_field = $field;
			$this->Quotation->order_sort = $sort;
		}
		$results = $this->Quotation->read($start_row, $per_page);
		$total_row = $results['total_row'];
		$search_row = $results['search_row'];
		$list_data = $this->setDataListFormat($results['list_data'], $start_row);


		$page_url = site_url('ceosofts/quotation');
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

		$this->render_view('ceosofts/quotation/list_view');
	}

	// ------------------------------------------------------------------------

	/**
	 * Preview Data
	 * @param String encrypt id
	 */
	public function preview($encrypt_id = "")
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Quotation', 'url' => site_url('ceosofts/quotation')),
			array('title' => 'แสดงข้อมูลรายละเอียด', 'url' => '#', 'class' => 'active')
		);
		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแสดงข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Quotation->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->setPreviewFormat($results);

				$detail_list = $this->Quotation->loadDetailList($results['id']);
				$this->data['detail_list'] = $this->setDetailDataListFormat($detail_list);

				// คำนวณ VAT ok ทำงานได้ดี
				$total_price = $this->data['order_total_price']; 
				$total_vat = 0;
				$product_price = $total_price;
				$grand_total = $total_price;

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

				$this->render_view('ceosofts/quotation/preview_view');
			}
		}
	}


	// ------------------------------------------------------------------------

	public function preview_print_pdf($encrypt_id = "")
	{
		// load PDF library
		$this->load->library('ceosofts/Quotation_preview_pdf');

		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Quotation->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$detail_list = $this->Quotation->loadDetailList($results['id']);
		$data_lists = $this->setDetailDataListFormat($detail_list);

		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_quotation");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_quotation");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/quotation/preview_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Quotation_list.pdf', 'I');
	}

	public function preview_export_excel($encrypt_id = "")
	{
		$id = ci_decrypt(urldecode($encrypt_id));
		$results = $this->Quotation->load($id);
		$this->setPreviewFormat($results);
		$data_lists = array();
		$detail_list = $this->Quotation->loadDetailList($results['id']);
		$data_lists = $this->setDetailDataListFormat($detail_list);

		$this->data['detail_list'] = $data_lists;
		$data = $this->data;

		$table	=  $this->parser->parse_repeat('ceosofts/quotation/preview_view_excel', $data, true);

		$filename = "Quotation_preview" . date("Y-m-d-H-i-s") . "";
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
		echo $this->Quotation->set_running_number($field);
	}


	// ------------------------------------------------------------------------
	/**
	 * set default input for add form
	 */
	public function setFormAddData()
	{
		$quo_id_running = $this->Quotation->set_running_number('quo_id');
		$this->data['source_quo_id'] = $quo_id_running;

		$quo_by = $this->session->userdata('quo_by');
		$this->data['source_quo_by'] = $quo_by;

		$quo_edit_by = $this->session->userdata('quo_edit_by');
		$this->data['source_quo_edit_by'] = $quo_edit_by;
	}

	/**
	 * Add form
	 */
	public function add()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Quotation', 'url' => site_url('ceosofts/quotation')), //ข้อความหัวบรรทัดในหน้าและ Link ไปหน้า Home
			array('title' => 'เพิ่มข้อมูล', 'url' => '#', 'class' => 'active') //ข้อความหัวกระดาษ
		);
		$this->data['tb_customer_quo_cus_option_list'] = $this->Quotation->returnOptionList("tb_customer", "cus_name", "CONCAT_WS(' - ', cus_name,cus_contact,cus_address,cus_tel,cus_tax,cus_branch)");
		//ฟังก์ชั่น ดึงข้อมูลลูกค้า
		$this->data['tb_quotation_status_quo_status_option_list'] = $this->Quotation->returnOptionList("tb_quotation_status", "stq_name", "stq_name");
		//ฟังกืชั่น ดึง-เก็บ สถานะใบเสนอราคา
		$options['attributes'] = array('prs_id', 'prs_price', 'prs_unit');
		//ฟังก์ชั่น ดึง-เก็บ ข้อมุลสถานะ ใบเสนอราคา
		$this->data['detail_tb_product_sale_quo_pro_name_option_list'] = $this->Quotation->returnOptionList("tb_product_sale", "prs_name", "prs_name", $options);
		//ฟังก์ชั่น ดึง-เก็บ ข้อมูลสินค้า
		$this->setFormAddData(); //ฟังก์ชั่น เก็บข้อมุล หมายเลขใบเสนอราคา คนทำ-คนแก้ ใบเสนอราคา

		// ราคารวมทั้งสิน ทั้งตอนเพิ่มข้อมูล และลบ ok work //ดึงค่ามาจาก file Quotation.js
		$this->data['fx_detail_grand_total_price'] = number_format(0, 2); 
		

		// added vat funtion

		//! คำนวณ VAT copy from web ยังไม่ work
		$total_price = $this->data['fx_detail_grand_total_price']; //ดึงค่ามาจาก file Quotation.js
		$total_vat = 0;
		$product_price = $total_price;
		$grand_total = $total_price;

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


		$this->render_view('ceosofts/quotation/add_view');
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

		$frm->set_rules('quo_id', 'หมายเลขใบเสนอราคา', 'trim|required');
		$frm->set_rules('quo_date', 'วันที่ใบเสนอราคา', 'trim|required');
		$frm->set_rules('quo_cus', 'ชื่อลูกค้า', 'trim|required');
		$frm->set_rules('quo_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('quo_status', 'สถานะ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('quo_id');
			$message .= form_error('quo_date');
			$message .= form_error('quo_cus');
			$message .= form_error('quo_project_name');
			$message .= form_error('quo_status');
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

		$frm->set_rules('quo_id', 'หมายเลขใบเสนอราคา', 'trim|required');
		$frm->set_rules('quo_date', 'วันที่ใบเสนอราคา', 'trim|required');
		$frm->set_rules('quo_cus', 'ชื่อลูกค้า', 'trim|required');
		$frm->set_rules('quo_project_name', 'ชื่อโครงการ', 'trim|required');
		$frm->set_rules('quo_price', 'ราคาสินค้ารวมทั้งสิ้น	', 'trim|required|decimal');
		$frm->set_rules('quo_status', 'สถานะ', 'trim|required');
		$frm->set_rules('quo_edit_date', 'วันที่แก้ไข', 'trim');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('quo_id');
			$message .= form_error('quo_date');
			$message .= form_error('quo_cus');
			$message .= form_error('quo_project_name');
			$message .= form_error('quo_price');
			$message .= form_error('quo_status');
			$message .= form_error('quo_edit_date');
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

			$post['quo_by'] = $this->session->userdata('quo_by');
			$post['quo_edit_by'] = $this->session->userdata('quo_edit_by');

			$encrypt_id = '';
			$id = $this->Quotation->create($post);
			if ($id != '') {
				$success = TRUE;
				$encrypt_id = ci_encrypt($id);
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>';
			} else {
				$success = FALSE;
				$message = 'Error : ' . $this->Quotation->error_message;
			}

			$json = json_encode(array(
				'is_successful' => $success,
				'encrypt_id' =>  $encrypt_id,
				'quo_ref_encrypt_id' =>  $encrypt_id,
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
			array('title' => 'Quotation', 'url' => site_url('ceosofts/quotation')),
			array('title' => 'แก้ไขข้อมูล', 'url' => '#', 'class' => 'active')
		);

		$encrypt_id = urldecode($encrypt_id);
		$id = ci_decrypt($encrypt_id);
		if ($id == "") {
			$this->data['message'] = "กรุณาระบุรหัสอ้างอิงที่ต้องการแก้ไขข้อมูล";
			$this->render_view('ci_message/warning');
		} else {
			$results = $this->Quotation->load($id);
			if (empty($results)) {
				$this->data['message'] = "ไม่พบข้อมูลตามรหัสอ้างอิง <b>$id</b>";
				$this->render_view('ci_message/danger');
			} else {
				$this->data['csrf_field'] = insert_csrf_field(true);

				$this->data['source_quo_id'] = '';
				$this->data['source_quo_by'] = $this->session->userdata('quo_by');
				$this->data['source_quo_edit_by'] = $this->session->userdata('quo_edit_by');

				$this->setPreviewFormat($results);

				$this->data['record_quo_date'] = setThaiDate($results['quo_date']);
				$this->data['record_quo_edit_date'] = setThaiDate($results['quo_edit_date']);

				$this->data['tb_customer_quo_cus_option_list'] = $this->Quotation->returnOptionList("tb_customer", "cus_name", "CONCAT_WS(' - ', cus_name,cus_contact,cus_address,cus_tel,cus_tax,cus_branch)");
				$this->data['tb_quotation_status_quo_status_option_list'] = $this->Quotation->returnOptionList("tb_quotation_status", "stq_name", "stq_name");
				$options['attributes'] = array('prs_id', 'prs_price', 'prs_unit');
				$this->data['detail_tb_product_sale_quo_pro_name_option_list'] = $this->Quotation->returnOptionList("tb_product_sale", "prs_name", "prs_name", $options);

				$this->data['detail_record_quo_ref'] = ci_encrypt($results['id']);

				$detail_list = $this->Quotation->loadDetailList($results['id']);
				$this->data['detail_list'] = $this->setDetailDataListFormat($detail_list);

				$this->data['fx_detail_grand_total_price'] = number_format(0, 2); 
				//!สถานะตอนนี้ รวมได้แต่ ต้องกด refresh ก่อน

				// คำนวณ VAT ok ทำงานได้ดี
				$total_price = $this->data['order_total_price']; //! ดึงข้อมูลมาจากไหน ???
				$total_vat = 0;
				$product_price = $this->data['order_total_price'];
				$grand_total = $total_price;

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

				$this->render_view('ceosofts/quotation/edit_view');
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

			$post['quo_by'] = $this->session->userdata('quo_by');
			$post['quo_edit_by'] = $this->session->userdata('quo_edit_by');

			$result = $this->Quotation->update($post);
			if ($result == false) {
				$message = $this->Quotation->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Quotation->error_message;
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
			$result = $this->Quotation->delete($post);
			if ($result == false) {
				$message = $this->Quotation->error_message;
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

		$frm->set_rules('quo_ref', 'อ้างอิงใบเสนอราคา', 'trim|required');
		$frm->set_rules('quo_pro_id', 'หมายเลขสินค้า', 'trim|required');
		$frm->set_rules('quo_pro_name', 'รายการสินค้า', 'trim|required');
		$frm->set_rules('quo_pro_price', 'ราคาสินค้า', 'trim|required|decimal');
		$frm->set_rules('quo_pro_unit', 'หน่วยสินค้า', 'trim|required');
		$frm->set_rules('quo_pro_qty', 'จำนวน', 'trim|required|decimal');
		$frm->set_rules('quo_pro_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('quo_ref');
			$message .= form_error('quo_pro_id');
			$message .= form_error('quo_pro_name');
			$message .= form_error('quo_pro_price');
			$message .= form_error('quo_pro_unit');
			$message .= form_error('quo_pro_qty');
			$message .= form_error('quo_pro_remark');
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

		$frm->set_rules('quo_ref', 'อ้างอิงใบเสนอราคา', 'trim|required');
		$frm->set_rules('quo_pro_id', 'หมายเลขสินค้า', 'trim|required');
		$frm->set_rules('quo_pro_name', 'รายการสินค้า', 'trim|required');
		$frm->set_rules('quo_pro_price', 'ราคาสินค้า', 'trim|required|decimal');
		$frm->set_rules('quo_pro_unit', 'หน่วยสินค้า', 'trim|required');
		$frm->set_rules('quo_pro_qty', 'จำนวน', 'trim|required|decimal');
		$frm->set_rules('quo_pro_remark', 'หมายเหตุ', 'trim|required');

		$frm->set_message('required', '- กรุณากรอก %s');
		$frm->set_message('decimal', '- %s ต้องระบุตัวเลขทศนิยม');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('quo_ref');
			$message .= form_error('quo_pro_id');
			$message .= form_error('quo_pro_name');
			$message .= form_error('quo_pro_price');
			$message .= form_error('quo_pro_unit');
			$message .= form_error('quo_pro_qty');
			$message .= form_error('quo_pro_remark');
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
		$ref_field = ci_decrypt($post['quo_ref']);
		if ($ref_field == '') {
			$message .= "- รหัสเชื่อมโยงตารางที่ใช้สำหรับเพิ่มรายการไม่ถูกต้อง";
		} else {
			$post['quo_ref'] = $ref_field;
		}

		if ($message != '') {
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {

			$id = $this->Quotation->save_detail_list($post);
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
			$results = $this->Quotation->load_detail_record($id);
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
		$ref_field = ci_decrypt($post['quo_ref']);
		if ($ref_field == '') {
			$message .= "- รหัสเชื่อมโยงตารางที่ใช้สำหรับเพิ่มรายการไม่ถูกต้อง";
		} else {
			$post['quo_ref'] = $ref_field;
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

			$result = $this->Quotation->save_detail_list($post);
			if ($result == false) {
				$message = $this->Quotation->error_message;
				$ok = FALSE;
			} else {
				$message = '<strong>บันทึกข้อมูลเรียบร้อย</strong>' . $this->Quotation->error_message;
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
			$result = $this->Quotation->delete_list($post);
			if ($result == false) {
				$message = $this->Quotation->error_message;
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
		$data = $this->Quotation->loadDetailList($ref_id);
		if (!empty($data)) {
			$data['detail_list'] = $this->setDetailDataListFormat($data);
			$template = '{detail_list}
					<tr id="list_row_{record_number}">
						<td style="text-align:center;">[{record_number}]</td>
						<td>{detail_id}</td>
						<td>{detail_quo_ref}</td>
						<td>{detail_quo_pro_id}</td>
						<td>{detailQuoProNamePrsName}</td>
						<td>{detail_quo_pro_price}</td>
						<td>{detail_quo_pro_unit}</td>
						<td>{detail_quo_pro_qty}</td>
						<td class="text-right">{fx_detail_total_price}</td>
						<td>{detail_quo_pro_remark}</td>
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
			$data[$i]['quo_date'] = setThaiDate($data[$i]['quo_date']);
			$data[$i]['quo_price'] = number_format($data[$i]['quo_price'], 2);
			$data[$i]['quo_edit_date'] = setThaiDate($data[$i]['quo_edit_date']);
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


		$titleRow = $this->table('tb_customer')->get_array('cus_name, cus_contact, cus_address, cus_tel, cus_tax, cus_branch')->where("cus_name = '$data[quo_cus]'");
		if (!empty($titleRow)) {
			$quoCusCusName = $titleRow['cus_name'];
			$quoCusCusContact = $titleRow['cus_contact'];
			$quoCusCusAddress = $titleRow['cus_address'];
			$quoCusCusTel = $titleRow['cus_tel'];
			$quoCusCusTax = $titleRow['cus_tax'];
			$quoCusCusBranch = $titleRow['cus_branch'];
		} else {
			$quoCusCusName = '';
			$quoCusCusContact = '';
			$quoCusCusAddress = '';
			$quoCusCusTel = '';
			$quoCusCusTax = '';
			$quoCusCusBranch = '';
		}
		$this->data['quoCusCusName'] = $quoCusCusName;
		$this->data['quoCusCusContact'] = $quoCusCusContact;
		$this->data['quoCusCusAddress'] = $quoCusCusAddress;
		$this->data['quoCusCusTel'] = $quoCusCusTel;
		$this->data['quoCusCusTax'] = $quoCusCusTax;
		$this->data['quoCusCusBranch'] = $quoCusCusBranch;


		$quoStatusStqName = $this->table('tb_quotation_status')->get_value('stq_name')->where("stq_name = '$data[quo_status]'");
		$this->data['quoStatusStqName'] = $quoStatusStqName;

		$this->data['detail_quo_ref'] = urlencode(encrypt($data['id']));

		$this->data['record_id'] = $data['id'];
		$this->data['record_quo_id'] = $data['quo_id'];
		$this->data['record_quo_date'] = $data['quo_date'];
		$this->data['record_quo_cus'] = $data['quo_cus'];
		$this->data['record_quo_project_name'] = $data['quo_project_name'];
		$this->data['record_quo_price'] = $data['quo_price'];
		$this->data['record_quo_status'] = $data['quo_status'];
		$this->data['record_quo_by'] = $data['quo_by'];
		$this->data['record_quo_edit_by'] = $data['quo_edit_by'];
		$this->data['record_quo_edit_date'] = $data['quo_edit_date'];

		$this->data['record_quo_date'] = setThaiDate($data['quo_date']);
		$this->data['record_quo_price'] = number_format($data['quo_price'], 2);
		$this->data['record_quo_edit_date'] = setThaiDate($data['quo_edit_date']);
	}

	public function print_pdf()
	{
		// load excel library
		$this->load->library('ceosofts/Quotation_list_pdf');

		$results = $this->Quotation->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);
		$data['data_list'] = $data_lists;

		$pdf = new FPDI('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$font = 'thsarabun';
		$pdf->font = $font;

		$pdf->SetCreator("");
		$pdf->SetAuthor("");
		$pdf->SetTitle("ตารางแสดงรายการ ข้อมูล tb_quotation");
		$pdf->SetSubject("ตารางแสดงรายการ ข้อมูล tb_quotation");

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(10, 10, 10);
		$pdf->SetHeaderMargin(0);
		$pdf->SetTopMargin(15);
		$pdf->SetFooterMargin(0);

		$pdf->SetFont($font, '', 16);

		// Add a page
		$pdf->AddPage("P");

		$html = $this->parser->parse_repeat('ceosofts/quotation/list_view_pdf', $data, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		$pdf->lastPage();

		$pdf->Output('Quotation_list.pdf', 'I');
	}

	public function export_excel()
	{
		// load excel library
		$this->load->library('ceosofts/Excel');

		$results = $this->Quotation->read();
		$data_lists = $this->setDataListFormat($results['list_data'], 0);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);

		// set Header ***** SECTION 1 ***** 
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'หมายเลขใบเสนอราคา');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'วันที่ใบเสนอราคา');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'ชื่อลูกค้า');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ชื่อโครงการ');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'ราคาสินค้ารวมทั้งสิ้น	');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'สถานะ');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'ผู้จัดทำเอกสาร');

		// END SECTION 1

		// set header bold
		$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

		// set Row
		$rowCount = 2;
		foreach ($data_lists as $row) {

			// ***** SECTION 2 *****

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->setCellValueExplicit('A' . $rowCount, $row['quo_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowCount, $row['quo_date'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowCount, $row['quoCusCusName'] . ' ' . $row['quoCusCusContact'] . ' ' . $row['quoCusCusAddress'] . ' ' . $row['quoCusCusTel'] . ' ' . $row['quoCusCusTax'] . ' ' . $row['quoCusCusBranch'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowCount, $row['quo_project_name'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->SetCellValue('E' . $rowCount, $row['quo_price']);
			$sheet->setCellValueExplicit('F' . $rowCount, $row['quoStatusStqName'], PHPExcel_Cell_DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('G' . $rowCount, $row['quo_by'], PHPExcel_Cell_DataType::TYPE_STRING);


			$rowCount++;
		}

		foreach (range('A', 'H') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}


		$filename = "Quotation_list" . date("Y-m-d-H-i-s") . ".xlsx";
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
		$total_price = 0; // คิดราคารวม copy มาจาก web

		$grand_total_total_price = 0; //มีอยู่เดิมอยู่แล้ว...แต่เหมือนกับซ้ำกันกับที่ copy มาจาก web

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
			$data[$i]['detail_quo_ref'] = $data[$i]['quo_ref'];
			$data[$i]['detail_quo_pro_id'] = $data[$i]['quo_pro_id'];
			$data[$i]['detail_quo_pro_name'] = $data[$i]['quo_pro_name'];
			$data[$i]['fx_detail_total_price'] = $data[$i]['quo_pro_price'] * $data[$i]['quo_pro_qty']; // ราคาสินค้ารวมของแต่ล่ะ item
			$data[$i]['detail_quo_pro_price'] = $data[$i]['quo_pro_price'];
			$data[$i]['detail_quo_pro_unit'] = $data[$i]['quo_pro_unit'];
			$data[$i]['detail_quo_pro_qty'] = $data[$i]['quo_pro_qty'];
			$data[$i]['detail_quo_pro_remark'] = $data[$i]['quo_pro_remark'];

			//FUNCTION
			$data[$i]['detail_quo_pro_price'] = number_format($data[$i]['quo_pro_price'], 2);
			$data[$i]['detail_quo_pro_qty'] = number_format($data[$i]['quo_pro_qty'], 2);
			$grand_total_total_price += $data[$i]['fx_detail_total_price']; //มีอยู่เดิมอยู่แล้ว...แต่เหมือนกับซ้ำกันกับที่ copy มาจาก web >>> ราคาสินค้ารวมทั้งสิ้น

			//added vat FUNCTION
			$total_price += $data[$i]['fx_detail_total_price']; //from youtube >>> ราคาสินค้ารวมทั้งสิ้น เหมือนจะซ้ำกันกับตัวบน
			//end vat FUNCTION

			$data[$i]['fx_detail_total_price'] = number_format($data[$i]['fx_detail_total_price'], 2); //ของเดิม แปลงตัวเลข ราคารวมสินค้า >>>จากแต่ล่ะรายการ


		}

		//added vat FUNCTION
		$this->data['order_total_price'] = $total_price; //from youtube
		//end vat FUNCTION

		$this->data['fx_detail_grand_total_price'] = number_format($grand_total_total_price, 2); 
		//แปลงตัวเลข ราคาสินค้ารวมทั้งสิ้น

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

		$quoProNamePrsName = $this->table('tb_product_sale')->get_value('prs_name')->where("prs_name = '$data[quo_pro_name]'");
		$data['quoProNamePrsName'] = $quoProNamePrsName;

		$data['detail_encrypt_quo_ref'] = urlencode(encrypt($data['quo_ref']));

		$data['detail_record_id'] = $data['id'];
		$data['detail_record_quo_ref'] = $data['quo_ref'];
		$data['detail_encrypt_quo_ref'] = ci_encrypt($data['quo_ref']);
		$data['detail_record_quo_pro_id'] = $data['quo_pro_id'];
		$data['detail_record_quo_pro_name'] = $data['quo_pro_name'];
		$data['detail_record_quo_pro_price'] = $data['quo_pro_price'];
		$data['detail_record_quo_pro_unit'] = $data['quo_pro_unit'];
		$data['detail_record_quo_pro_qty'] = $data['quo_pro_qty'];
		$data['detail_record_quo_pro_remark'] = $data['quo_pro_remark'];

		$data['detail_record_quo_pro_price'] = number_format($data['quo_pro_price'], 2);
		$data['detail_record_quo_pro_qty'] = number_format($data['quo_pro_qty'], 2);


		return $data;
	}
}
/*---------------------------- END Controller Class --------------------------------*/
