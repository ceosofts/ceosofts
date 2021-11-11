<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Charts.php ]
 */
class Charts extends CRUD_Controller
{

	private $per_page;
	private $another_js;
	private $another_css;

	public function __construct()
	{
		parent::__construct();
		$this->per_page = 2;
		$this->num_links = 6;
		$this->uri_segment = 4;

		$data['page_url'] = '';
		$data['page_title'] = 'CEO Softs';
	}

	// ------------------------------------------------------------------------

	/**
	 * Index of controller
	 */
	public function index()
	{
		$this->breadcrumb_data['breadcrumb'] = array(
			array('title' => 'Charts', 'class' => 'active', 'url' => '#'),
		);

		$this->another_js .= '<script src="' . base_url('assets/themes/sb-admin-bs4/vendor/chart.js/Chart.min.js') . '"></script>';
		$this->another_js .= '<script src="' . base_url('assets/themes/sb-admin-bs4/js/demo/chart-area-demo.js') . '"></script>';
		$this->another_js .= '<script src="' . base_url('assets/themes/sb-admin-bs4/js/demo/chart-bar-demo.js') . '"></script>';
		$this->another_js .= '<script src="' . base_url('assets/themes/sb-admin-bs4/js/demo/chart-pie-demo.js') . '"></script>';

		$this->render_view('example_pages/sb-admin-bs4/charts');
	}

	// ------------------------------------------------------------------------

	/**
	 * Render this controller page
	 * @param String path of controller
	 * @param Integer total record
	 */
	private function render_view($path)
	{
		$this->data['top_navbar'] = $this->parser->parse('template/sb-admin-bs4/top_navbar_view', $this->top_navbar_data, TRUE);
		$this->data['left_sidebar'] = $this->parser->parse('template/sb-admin-bs4/left_sidebar_view', $this->left_sidebar_data, TRUE);
		$this->data['breadcrumb_list'] = $this->parser->parse('template/sb-admin-bs4/breadcrumb_view', $this->breadcrumb_data, TRUE);
		$this->data['page_content'] = $this->parser->parse_repeat($path, $this->data, TRUE);
		$this->data['another_css'] = $this->another_css;
		$this->data['another_js'] = $this->another_js;
		$this->parser->parse('template/sb-admin-bs4/homepage_view', $this->data);
	}
}
/*---------------------------- END Controller Class --------------------------------*/
