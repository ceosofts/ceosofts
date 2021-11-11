<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class CRUD_Controller extends CI_Controller
{

	public $data;
	public $top_navbar_data;
	public $breadcrumb_data;
	public $left_sidebar_data;
	private $admin_level;

	private $table_name_get;
	private $table_field_get;
	private $is_get_row;

	public function __construct($database = '')
	{
		parent::__construct();
		$this->is_get_row = false;

		$this->admin_level = 9; //Admin
		$template_name = 'template/sb-admin-bs4';
		$data['user_username']		= $this->session->userdata('user_username');
		$data['user_prefix']		= $this->session->userdata('user_prefix');
		$data['user_firstname']		= $this->session->userdata('user_firstname');
		$data['user_lastname']		= $this->session->userdata('user_lastname');

		if ($this->session->userdata('login_validated') == true) {
			$login_active_class = '';
			$login_inactive_class = 'd-none';
		} else {
			$login_active_class = 'd-none';
			$login_inactive_class = '';
		}
		$data['login_active_class'] = $login_active_class;
		$data['login_inactive_class'] = $login_inactive_class;

		$data['base_url'] = base_url();
		$data['site_url'] = site_url();
		$data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$data['csrf_cookie_name'] = $this->config->item('csrf_cookie_name');
		$data['csrf_protection_field'] = insert_csrf_field(true);

		$this->data = $data;
		$this->top_navbar_data = $data;
		$this->breadcrumb_data = $data;
		$this->left_sidebar_data = $data;

		$this->data['page_title'] = 'CEO Softs';

		$admin_menu = '';

		if ($this->session->userdata('user_level') == $this->admin_level) {
			$admin_left_view = "$template_name/admin_left_sidebar_view";
			$admin_menu = $this->parser->parse($admin_left_view, $this->data, TRUE);

			$top_navbar = '<a class="dropdown-item" href="' . site_url('member/management') . '">จัดการข้อมูลสมาชิก</a>
							<div class="dropdown-divider"></div>';
			$this->top_navbar_data['admin_top_menu'] = $top_navbar;
		}

		$other_permission_menu = '';
		if ($this->session->userdata('user_level') == 2) {
			$other_permission_menu .= '<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
				<a class="nav-link" href="' . site_url('demo/teacher') . '">
					<i class="fa fa-users" aria-hidden="true"></i>
					<span class="nav-link-text">ข้อมูลอาจารย์</span>
				</a>
			</li>';
		}

		//เพิ่ม if() เช็คเพิ่ม
		//$other_permission_menu .= 'NEW MENU';

		$this->left_sidebar_data['other_permission_menu'] = $other_permission_menu;
		$this->left_sidebar_data['admin_left_menu'] = $admin_menu;
	}

	protected function add_js_modules($js_path)
	{
		$js_url = 'assets/js_modules/' . $js_path . '?ft=' . filemtime('assets/js_modules/' . $js_path);
		return '<script src="' . base_url($js_url) . '"></script>';
	}

	protected function check_is_login()
	{
		return $this->session->userdata('login_validated');
	}

	protected function table($tb_name)
	{
		$this->table_name_get = $tb_name;
		return $this;
	}

	protected function get_value($field_name)
	{
		$this->table_field_get = $field_name;
		$this->is_get_row = false;
		return $this;
	}

	protected function get_array($field_name)
	{
		$this->table_field_get = $field_name;
		$this->is_get_row = true;
		return $this;
	}

	protected function where($condition)
	{
		$this->db->select($this->table_field_get);
		$this->db->where($condition);
		if ($qry = $this->db->get_where($this->table_name_get)) {
			if ($row = $qry->row_array()) {
				if ($this->is_get_row === true) {
					return $row;
				} else {
					return $row[$this->table_field_get];
				}
			}
		}
	}
}
