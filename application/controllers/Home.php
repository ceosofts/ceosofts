<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Dashboard.php ]
 */
class Home extends CRUD_Controller
{
    private $per_page;
    private $another_js;
    private $another_css;

    public function __construct()
    {
        parent::__construct();

        $this->another_js .= '<script src="' . base_url('assets/themes/sb-admin/vendor/chart.js/Chart.min.js') . '"></script>';
        $this->another_js .= '<script src="' . base_url('assets/themes/sb-admin/js/sb-admin-charts.min.js') . '"></script>';

        // $this->data['user_prefix_name']    = $this->session->userdata('user_prefix_name');
        // $this->data['user_firstname']        = $this->session->userdata('user_firstname');
        // $this->data['user_lastname']        = $this->session->userdata('user_lastname');

        // $js_url = 'assets/js_modules/ceosofts/bank.js?ft=' . filemtime('assets/js_modules/ceosofts/bank.js');
        // $this->another_js .= '<script src="' . base_url($js_url) . '"></script>';

    }

    // ------------------------------------------------------------------------

    /**
     * Index of controller
     */
    public function index()
    {
        // $this->breadcrumb_data['breadcrumb'] = array(
        //     array('title' => 'Bank', 'class' => 'active', 'url' => '#'),
        // );
        // if ($this->session->userdata('login_validated') == false) {
        //     $this->render_view('');
        //     return;
        // }
        $this->home();
    }

    // ------------------------------------------------------------------------

    /**
     * Render this controller page
     * @param String path of controller
     * @param Integer total record
     */
    private function render_view($path)
    {
        /*
		$this->data['left_sidebar'] = $this->parser->parse('includes/left_sidebar_view', $this->left_sidebar_data, TRUE);
		$this->data['breadcrumb_list'] = $this->parser->parse('includes/breadcrumb_view', $this->breadcrumb_data, TRUE);
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;
		$this->parser->parse('includes/homepage_view', $this->data);
		*/


        $this->data['top_navbar'] = $this->parser->parse('template/sb-admin-bs4/top_navbar_view', $this->top_navbar_data, TRUE);
        $this->data['left_sidebar'] = $this->parser->parse('template/sb-admin-bs4/left_sidebar_view', $this->left_sidebar_data, TRUE);
        $this->data['breadcrumb_list'] = $this->parser->parse('template/sb-admin-bs4/breadcrumb_view', $this->breadcrumb_data, TRUE);
        $this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);

        // if ($this->session->userdata('login_validated') == false) {
        //     $this->data['page_content'] = $this->parser->parse_repeat('member_permission.php', $this->data, TRUE);
        //     $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        //     $this->session->set_userdata('after_login_redirect', $current_url);
        // } else {
        //     // if ($this->session->userdata('user_level') >= 1 && $this->session->userdata('user_department_id') == 10 || 11 || 12) {
        //     if ($this->session->userdata('user_level') >= 1) {
        //         $this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
        //     } else {
        //         $this->data['alert_message'] = 'เฉพาะผู้ใช้งานระดับ <b>ผู้ใช้งานทั่วไป</b>';
        //         $this->data['page_content'] = $this->parser->parse_repeat('member_authen_permission.php', $this->data, TRUE);
        //     }
        // }

        $this->data['another_css'] = $this->another_css;
        $this->data['another_js'] = $this->another_js;
        $this->parser->parse('template/sb-admin-bs4/homepage_view', $this->data);
    }

    public function home()
    {
        $this->breadcrumb_data['breadcrumb'] = array();

        $this->render_view('home_message');
    }
}
/*---------------------------- END Controller Class --------------------------------*/