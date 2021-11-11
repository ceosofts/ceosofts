<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Forgot.php ]
 */
class Forgot extends CI_Controller 
{

	private $data;
	private $per_page;
	private $breadcrumb_data;
	private $left_sidebar_data;
	private $another_js;
	private $another_css;

	public function __construct()
	{
		parent::__construct();
		
		$data['base_url'] = base_url();
		$data['site_url'] = site_url();

		$data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$data['csrf_cookie_name'] = $this->config->item('csrf_cookie_name');
		$data['csrf_protection_field'] = insert_csrf_field(true);
		
		$this->data = $data;
		$this->breadcrumb_data = $data;
		$this->left_sidebar_data = $data;

		$this->another_js .= '<script src="'. base_url('assets/themes/sb-admin/vendor/chart.js/Chart.min.js').'"></script>';
		$this->another_js .= '<script src="'. base_url('assets/themes/sb-admin/js/sb-admin-charts.min.js').'"></script>';
	}

	// ------------------------------------------------------------------------

	/**
	 * Render this controller page
	 * @param String path of controller
	 * @param Integer total record
	 */
	private function render_view($path)
	{
		$this->data['left_sidebar'] = $this->parser->parse('includes/left_sidebar_view', $this->left_sidebar_data, TRUE);
		$this->data['breadcrumb_list'] = $this->parser->parse('includes/breadcrumb_view', $this->breadcrumb_data, TRUE);
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;
		$this->parser->parse('includes/homepage_view', $this->data);
	}
	
	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Forgot password', 'class' => 'active', 'url' => '#'),
		);

		$this->render_view('forgot-password.html');
	}

}
/*---------------------------- END Controller Class --------------------------------*/