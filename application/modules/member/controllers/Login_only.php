<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login controller class
 */
class Login_only extends CRUD_Controller
{
    private $expire_hr;
    private $another_js;
    private $another_css;

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->expire_hr = 1;
        $this->another_js = $this->add_js_modules('member/login.js'); //ข้อความเตือนเวลาใส่รหัสไม่ถูกต้อง
    }

    //ปรับแต่งตาม Template ที่ใช้งาน
    protected function render_view($path)
    {
        $template_name = 'sb-admin-bs4';

        // $this->data['top_navbar'] = $this->parser->parse('template/' . $template_name . '/top_navbar_view', $this->top_navbar_data, TRUE);
        // $this->data['left_sidebar'] = $this->parser->parse('template/' . $template_name . '/left_sidebar_view', $this->left_sidebar_data, TRUE);
        // $this->data['breadcrumb_list'] = $this->parser->parse('template/' . $template_name . '/breadcrumb_view', $this->breadcrumb_data, TRUE);

        $this->data['csrf_protection'] = $this->data['csrf_protection_field'];
        $this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);

        $this->data['another_css'] = $this->another_css;
        $this->data['another_js'] = $this->another_js;
        $this->parser->parse('template/' . $template_name . '/homepage_only_view', $this->data); //ไปที่หน้า login
    }

    public function index($msg = NULL)
    {
        $this->breadcrumb_data['breadcrumb'] = array(
            array('title' => 'เข้าสู่ระบบ', 'class' => 'active', 'url' => '#'),
        );
        $this->render_view('login_only_view');
    }

    public function process()
    {
        $frm = $this->form_validation;

        //   $frm->set_rules('ci_login_email', 'อีเมลผู้ใช้งาน', 'trim|required|valid_email');
        $frm->set_rules('ci_login_email', 'อีเมลผู้/ชื่อใช้งาน', 'trim|required');
        $frm->set_rules('ci_login_password', 'รหัสผ่าน', 'trim|required');

        $frm->set_message('required', 'กรุณากรอก %s');
        $frm->set_message('valid_email', 'กรุณาตรวจสอบรูปแบบอีเมลให้ถูกต้อง');

        if ($frm->run() == FALSE) {
            $message  = '';
            $message .= form_error('gen_email');
            $message .= form_error('gen_password');
            $data = array(
                'is_successful' => false,
                'message' => $message
            );
        } else {
            // Load the model
            $this->load->model('Login_model');
            // Validate the user can login
            $result = $this->Login_model->validate();
            // Now we verify the result
            $data = array();
            if (!$result) {
                $data['message'] = 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้งครับ.';
                $data['is_successful'] = false;
            } else {
                $data['message'] = '';
                $data['is_successful'] = true;
                $data['redirect_url'] = $this->session->userdata('redirect_url');
                $this->session->set_userdata('redirect_url', '');
                // redirect('dashboard');
            }
        }
        echo json_encode($data);
    }
}
