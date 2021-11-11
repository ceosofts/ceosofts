<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Regis.php ]
 */
class Regis extends CRUD_Controller
{

	private $another_js;
	private $another_css;
	private $expire_hr;

	public function __construct()
	{
		parent::__construct();

		//$js_url = 'assets/js/register.js';
		//$this->another_js = '<script src="'. base_url($js_url) .'"></script>';
		$this->another_js = $this->add_js_modules('member/register.js');
		$this->expire_hr = 1;
	}

	protected function render_view($path)
	{
		$template_name = 'sb-admin-bs4';
		$this->data['top_navbar'] = $this->parser->parse('template/' . $template_name . '/top_navbar_view', $this->top_navbar_data, TRUE);
		$this->data['left_sidebar'] = $this->parser->parse('template/' . $template_name . '/left_sidebar_view', $this->left_sidebar_data, TRUE);
		$this->data['breadcrumb_list'] = $this->parser->parse('template/' . $template_name . '/breadcrumb_view', $this->breadcrumb_data, TRUE);

		$this->data['csrf_protection'] = $this->data['csrf_protection_field'];
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);

		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;

		$this->parser->parse('template/' . $template_name . '/homepage_view', $this->data);
	}

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'ลงทะเบียน', 'class' => 'active', 'url' => '#'),
		);

		$this->render_view('regis_view');
	}


	public function save()
	{
		$this->load->library('form_validation');
		$frm = $this->form_validation;

		$frm->set_rules(
			'reg_email',
			'อีเมล',
			'trim|required|valid_email|is_unique[tb_members.email]',
			array('is_unique' => 'อีเมลที่ระบุนี้ ได้ใช้สมัครสมาชิกไปแล้วไม่สามารถใช้ซ้ำได้.<br/>หากลืมรหัสผ่านคลิกที่นี่ <a href="' . site_url('member/forgot_password') . '">ลืมรหัสผ่าน</a>')
		);
		$frm->set_rules('reg_fname', 'ชื่อ', 'trim|required');
		$frm->set_rules('reg_lname', 'นามสกุล', 'trim|required');

		$frm->set_message('required', 'กรุณากรอก %s');
		$frm->set_message('valid_email', 'กรุณาตรวจสอบรูปแบบอีเมลให้ถูกต้อง');

		if ($frm->run() == FALSE) {
			$message  = '';
			$message .= form_error('reg_username');
			$message .= form_error('reg_email');
			$message .= form_error('reg_fname');
			$message .= form_error('reg_lname');
			$json = json_encode(array(
				'is_successful' => FALSE,
				'message' => $message
			));
			echo $json;
		} else {
			$this->load->model('member/Regis_model', 'Regis_model');
			$post = $this->input->post(NULL, TRUE);

			$result = $this->Regis_model->add($post);
			if ($result) {
				if ($this->send_confirm_mail($post['reg_email']) == true) {
					$message = 'สมัครสมาชิกเรียบร้อย กรุณาตรวจสอบกล่องจดหมาย ในอีเมลของท่านเพื่อยืนยันการลงทะเบียน';
				} else {
					$message = 'ระบบไม่สามารถส่งอีเมลเพื่อยืนยันตัวตนได้ในขณะนี้';
				}

				$json = array(
					'is_successful' => TRUE,
					'message' => $message
				);
			} else {
				$json = array(
					'is_successful' => FALSE,
					'message' => '<strong>เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้</strong>'
				);
			}
			echo json_encode($json);
		}
	}

	private function send_confirm_mail($email)
	{
		$this->load->model('Login_model');
		$this->load->library('email');
		$this->load->library('encryption');

		$row = $this->Login_model->check_email($email);
		if (empty($row)) {
			$message = 'ไม่พบอีเมลที่ระบุ กรุณาตรวจสอบอีเมลให้ถูกต้องค่ะ.';
		} else {

			$time = date('Y-m-d H:i:s');
			$key = $time . $row['email'] . $row['firstname'];
			$key_md5 = md5($key);
			$key_encrypt = $this->encryption->encrypt($key_md5);
			$key_encode = md5($key_encrypt);

			$url = site_url('member/forgot_password/re_pass/' . $key_encode);
			$rand_pass = mt_rand(10000000, 99999999);

			$to = $row['email'];
			$subject = 'กรุณายืนยันการลงทะเบียน';

			//Email content
			$message = '<h1>กรุณายืนยันการลงทะเบียน</h1>';
			$message .= '<p>เรียนคุณ ' . $row['firstname'] . '  ' . $row['lastname'] . '</p>';
			$message .= '<p>อีเมลฉบับนี้ส่งมาจากระบบลงทะเบียน หากท่านต้องการยืนยันการทำรายการ กรุณาคลิกที่ลิงค์ด้านล่างนี้เพื่อสิ้นสุดขั้นตอนยืนยันการลงทะเบียน</p>';

			$message .= '<h3>》 <a href="' . $url . '" target="_blank">ยืนยันการลงทะเบียน</a></h3>';
			$message .= $url;

			$message .= '<p>รหัสยืนยัน : <b>' . $rand_pass . '</b></p><br/>';

			$message .= '<p>หมายเหตุ : ลิงค์นี้จะหมดอายุใน ' . $this->expire_hr . ' ชั่วโมง</p>';
			$message .= '<p>และหากท่านไม่สามารถคลิกลิงค์เพื่อเปิดหน้าเว็บได้ 
							<br/>ให้ทำการคัดลอก URL ด้านบนนี้ไปวางบนช่อง Address Bar เพื่อเปิดหน้าเว็บสำหรับยืนยันการสมัครสมาชิก</p>';

			$data = array(
				'encrypt_id' => $key_encode,
				'email' => $row['email'],
				'userid' => $row['userid'],
				'random_pass' => $rand_pass,
				'active_time' => $time
			);
			if ($this->Login_model->insert_forgot($data)) {
				//Send email
				if ($this->email->send_mail($to, $subject, $message)) {
					$status = true;
				} else {
					$status = false;
					if ($this->email->send_gmail($to, $subject, $message)) {
						$status = true;
					} else {
						$message = 'ระบบไม่สามารถส่งอีเมลเพื่อยืนยันตัวตนได้ในขณะนี้!!';

						$this->Login_model->delete_forgot($key_encode);
					}
				}
			}
		}
		return $status;
	}
}
/*---------------------------- END Controller Class --------------------------------*/
