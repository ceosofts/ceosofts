<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
	* [ Controller File name : Forgot_password.php ]
*/
class Forgot_password extends CRUD_Controller {
	
	private $expire_hr;
	private $another_css;
	private $another_js;
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Login_model');
		$this->another_js = $this->add_js_modules('member/forgot_password.js');
		$this->expire_hr = 1;
	}
	
	protected function render_view($path)
	{
		$template_name = 'sb-admin-bs4';
		
		$this->data['top_navbar'] = $this->parser->parse('template/'.$template_name.'/top_navbar_view', $this->top_navbar_data, TRUE);
		$this->data['left_sidebar'] = $this->parser->parse('template/'.$template_name.'/left_sidebar_view', $this->left_sidebar_data, TRUE);
		$this->data['breadcrumb_list'] = $this->parser->parse('template/'.$template_name.'/breadcrumb_view', $this->breadcrumb_data, TRUE);
		
		$this->data['csrf_protection'] = $this->data['csrf_protection_field'];
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
		
		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;
		$this->parser->parse('template/'.$template_name.'/homepage_view', $this->data);
	}
	
	/**
		* Index of controller
	*/
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
						array('title' => 'ลืมรหัสผ่าน', 'class' => 'active', 'url' => '#'),
		);
		
		$this->render_view('forgot_view');
	}
	
	public function get_key_encode($data)
    {
		$this->load->library('encryption');
		$time = date('Y-m-d H:i:s');
		$key = $time . $data['email'] . $data['firstname'];
		$key_md5 = md5($key);
		$key_encrypt = $this->encryption->encrypt($key_md5);
		return md5($key_encrypt);
	}

	public function process()
    {
        $status = false;
        $message = '';
		
		$this->load->library('form_validation');
        $frm = $this->form_validation;
        $frm->set_rules('forgot_email', 'อีเมล', 'trim|required|valid_email');
      
        $frm->set_message('valid_email', 'กรุณาตรวจสอบรูปแบบอีเมลให้ถูกต้อง');
        $frm->set_message('required', 'กรุณากรอก %s');

        if ($frm->run() == FALSE) {
            $message = form_error('forgot_email');
            $status = false;
        } else {
            $data = array();
            $email = $this->input->post('forgot_email', TRUE);
            $this->load->model('Login_model');
            $row = $this->Login_model->check_email($email);
            if(empty($row)){
                $message = "ไม่พบอีเมลที่ระบุ $email กรุณาตรวจสอบอีเมลให้ถูกต้องด้วยครับ.";
            }else{                    
                //Load email library
                $this->load->library('email');
				
				$time = date('Y-m-d H:i:s');
                $key_encode = $this->get_key_encode($row);

                $url = site_url('member/forgot_password/re_pass/' . $key_encode);
                $rand_pass = mt_rand(10000000,99999999); 

                $to = $row['email'];
                $subject = 'ยืนยัน การเปลี่ยนแปลงรหัสผ่าน';

                //Email content
                $message = '<h1>ยืนยันการเปลี่ยนแปลงรหัสผ่าน</h1>';
                $message .= '<p>เรียนคุณ '. $row['firstname'] . '  ' . $row['lastname'] .'</p>';
                $message .= '<p>หากท่านต้องการเปลี่ยนแปลงรหัสผ่าน คลิกที่ลิงค์ด้านล่างนี้</p>';

                $message .= '<h3>》 <a href="'. $url .'" target="_blank">รีเซ็ตรหัสผ่าน</a></h3>';
                $message .= $url;

                $message .= '<p><u>รหัสยืนยัน</u> : <b>'. $rand_pass .'</b></p><br/>';

                $message .= '<p>หมายเหตุ : ลิงค์นี้จะหมดอายุใน '. $this->expire_hr .' ชั่วโมง</p>';
                $message .= '<p>และหากท่านไม่สามารถคลิกลิงค์เพื่อเปิดหน้าเว็บได้ 
                                <br/>ให้ทำการคัดลอก URL ด้านบนนี้ไปวางบนช่อง Address Bar เพื่อเปิดหน้าเว็บสำหรับเปลี่ยนแปลงรหัสผ่าน</p>';


                $data = array(
                            'encrypt_id' => $key_encode,
                            'email' => $row['email'],
                            'userid' => $row['userid'],
                            'random_pass' => $rand_pass,
                            'active_time' => $time
                );
                if($this->Login_model->insert_forgot($data)){
                    //Send email
                    if ($this->email->send_mail($to, $subject, $message)){
                        $status = true;
                    }else{
						
						if ($this->email->send_gmail($to, $subject, $message)){
							$status = true;
						}else{
							$message = 'ไม่สามารถส่งอีเมลได้ในขณะนี้!!';
							
							$this->Login_model->delete_forgot($key_encode);
						}
                    }
                }else{
                    $message = 'ไม่สามารถสร้างรหัสสำหรับเปลี่ยนแปลงข้อมูลได้!!';
                }
            }
        }
        
        $data = array(
                        'message' => $message,
                        'is_successful' => $status
        );
        echo json_encode($data);
    }
	
	public function re_pass($key='', $rand_pass = '')
    {
        $this->load->model('Login_model');
		
		$this->breadcrumb_data['breadcrumb'] = array(
						array('title' => 'ล็อกอิน', 'class' => 'active', 'url' => site_url('member/login')),
						array('title' => 'ลืมรหัสผ่าน', 'class' => 'active', 'url' => '#'),
		);
		
		$user_full_name = '';
        $error = '';
        $expire = '';
        $url = '';
        $row = $this->Login_model->get_reset_data($key);
        if(!empty($row)){
			$user_id = $row['userid'];
			$this->data['encrypt_member_id'] = encrypt($row['userid']);
			$this->data['encrypt_member_email'] = encrypt($row['email']);

            $date1 = new DateTime($row['active_time']);
            $date2 = new DateTime(date('Y-m-d H:i:s'));
            $diff = $date2->diff($date1);
            $reset_time = (($diff->h * 60) + $diff->i + ($diff->s/60)) / 60;
            if($reset_time > $this->expire_hr){
                $url = base_url(uri_string());
                $expire = '<b>สร้างเมื่อ : '. setDateToThai($row['active_time']) .'</b> (ลิงค์หมดอายุในเวลา '. $this->expire_hr .' ชั่วโมง)';
                $error = '- ลิงค์หน้านี้หมดอายุแล้วครับ กรุณา Reset รหัสผ่านใหม่อีกครั้ง -';
            }else{
				$member = $this->Login_model->load_user($user_id);
				$user_full_name = '(<span class="text-secondary"> '.$member['firstname'] . ' ' . $member['lastname'].' </span>)';
            }
        }else{
			if($key == ''){
				$key = '(ไม่ระบุรหัสยืนยัน)';
			}
            $error = "ไม่พบข้อมูลรหัสยืนยัน <b><span class='text-primary'>$key</span></b> กรุณาตรวจสอบ URL";
        }
		
        $this->data['error_url']    = $url;
        $this->data['error_message'] = $error;
        $this->data['expire']       = $expire;
        $this->data['reset_data']   = $row;
        $this->data['forgot_key']   = $key;
		$this->data['rand_pass']   	= $rand_pass;
		$this->data['user_full_name']   	= $user_full_name;
		
		$rand_pass_remark = '';
		$rand_pass_readonly = '';
		if($rand_pass != ''){
			$rand_pass_remark = 'd-none';
			$rand_pass_readonly = 'readonly';
		}
		$this->data['rand_pass_remark'] = $rand_pass_remark;
		$this->data['rand_pass_readonly'] = $rand_pass_readonly;
		
		
        $this->render_view('reset_pass_view');

        $this->Login_model->clear_forgot();
    }

    public function process_reset()
    {
        $status = false;
        $message = '';

		$this->load->helper('member_login');
		$this->load->library('form_validation');
        $frm = $this->form_validation;
		
		$frm->set_rules('member_id', 'ไอดีสมาชิก', 'trim|required');
        $frm->set_rules('new_pass', 'รหัสผ่านใหม่', 'trim|required');
        $frm->set_rules('confirm_code', 'รหัสยืนยัน 8 หลัก', 'trim|required');

        $frm->set_message('required', 'กรุณากรอก %s');

        if ($frm->run() == FALSE) {
            $message = form_error('member_id');
			$message .= form_error('new_pass');
            $message .= form_error('confirm_code');
            $status = false;
        } else {            
			$userid = ci_decrypt($this->input->post('member_id', TRUE));
			$new_pass1 = $this->input->post('new_pass1', TRUE);
			$new_pass = $this->input->post('new_pass', TRUE);
			
			if($new_pass != $new_pass1){
				$status = false;
				$message = 'กรุณายืนยันรหัสผ่านให้ตรงกัน';
			}else{

				$email = ci_decrypt($this->input->post('refkey2', TRUE));
				$referral_code = genReferralCode($email, $userid);

				$data = array(
								'password2' => $new_pass
								,'referral_code' => $referral_code
				);
				
				$result = $this->Login_model->reset_password($userid, $data);
				if($result == false){
					$message = 'ไม่สามารถดำเนินการได้ ';
					$status = FALSE;
				}else{
					
					$key_encode = $this->input->post('key', TRUE);
					$this->Login_model->delete_forgot($key_encode);
					
					$message = '<strong>เปลี่ยนข้อมูลรหัสผ่านเรียบร้อย</strong>';
					$status = TRUE;
				}
				
			}//match
        }
		
        $data = array(
            'message' => $message,
            'is_successful' => $status
        );
		
        echo json_encode($data);
    }
	
	public function question()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
						array('title' => 'ลืมรหัสผ่าน', 'class' => 'active', 'url' => '#'),
		);
		$this->render_view('forgot_question_view');
	}
	
	public function load_question()
	{
		$status = false;
        $message = '';
		
		$this->load->library('form_validation');
        $frm = $this->form_validation;
        $frm->set_rules('forgot_birthday', 'อีเมล', 'trim|required');
		$frm->set_rules('forgot_username', 'อีเมล', 'trim|required');
      
        $frm->set_message('valid_email', 'กรุณาตรวจสอบรูปแบบอีเมลให้ถูกต้อง');
        $frm->set_message('required', 'กรุณากรอก %s');

        if ($frm->run() == FALSE) {
            $message = form_error('forgot_username');
			$message .= form_error('forgot_birthday');
            $status = false;
        } else {
            $data = array();
			
            $username = $this->input->post('forgot_username', TRUE);
			$birthday = $this->input->post('forgot_birthday', TRUE);
			$birthday = setDateToStandard($birthday);
			
            $this->load->model('Login_model');
			$row = $this->Login_model->forgot_question($username);
            if(empty($row)){
				$message = "ไม่พบคำถามของผู้ใช้งาน : $username ";
            }else{
                $question = '';
				$exist = $this->Login_model->check_user_forgot($username, $birthday);
				if($exist){
					$status = true;
					$message = $row['question'];
				}else{
					$message = "User หรือ วันเดือนปีเกิด ไม่ถูกต้อง กรุณาตรวจสอบอีกครั้งครับ.";
				}
            }
        }
        
        $data = array(
                        'message' => $message,
                        'is_successful' => $status
        );
        echo json_encode($data);
	}
	
	public function process_question()
    {
        $status = false;
        $message = '';
		
		$username = $this->input->post('forgot_username', TRUE);
		$birthday = $this->input->post('forgot_birthday', TRUE);
		$birthday = setDateToStandard($birthday);
		
		$this->load->model('Login_model');
		$row = $this->Login_model->check_user_forgot($username, $birthday);
		if(empty($row)){
			$message = "User หรือ วันเดือนปีเกิด ไม่ถูกต้อง กรุณาตรวจสอบอีกครั้งครับ.";
		}else{
			$member_data = $row;
			
			$question = '';
			if($row = $this->Login_model->forgot_question($username)){
				$answer = $row['answer'];//password hash
				
				$forgot_answer = $this->input->post('forgot_answer', TRUE);
				$forgot_md5 = $this->Login_model->encrypt_md5_salt($forgot_answer);
				if (password_verify($forgot_md5, $answer)){
					
					$time = date('Y-m-d H:i:s');
					$rand_pass = mt_rand(10000000,99999999);
					$key_encode = $this->get_key_encode($member_data);

					$data = array(
								'encrypt_id' => $key_encode,
								'email' => $member_data['email'],
								'userid' => $member_data['userid'],
								'random_pass' => $rand_pass,
								'active_time' => $time
					);
					if($this->Login_model->insert_forgot($data)){
						$status = true;
						$data = array(
										'message' => $message,
										'is_successful' => $status,
										'key_encode' => $key_encode,
										'random_pass' => $rand_pass

						);
						echo json_encode($data);
						return;
					}
				}else{
					$message = "$forgot_answer : ไม่ตรงกับคำตอบที่คุณกำหนดไว้ครับ";
				}
			}else{
				$message = "ไม่พบคำถามของผู้ใช้งาน : $username ";
			}
		}
        
        $data = array(
                        'message' => $message,
                        'is_successful' => $status,
        );
        echo json_encode($data);
    }
	
}
/*---------------------------- END Controller Class --------------------------------*/
