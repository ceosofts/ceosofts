<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Pr_model Class
 * @date 2021-09-03
 */
class Pr_model extends MY_Model
{

	private $running_options;
	private $my_table;
	public $session_name;
	public $order_field;
	public $order_sort;

	public $order_by;
	public $where_condition;

	public $owner_record;

	public function __construct()
	{
		parent::__construct();
		$this->my_table = 'tb_pr';
		$this->set_table_name($this->my_table);
		$this->order_field = '';
		$this->order_sort = '';

		$this->order_by = '';
		$this->where_condition = '';


		$options = array();
		$options['pr_id'] = array('format' => 1, 'type' => 'PR', 'digit' => 4);
		$this->running_options = $options;
	}


	public function exists($data)
	{
		$id = checkEncryptData($data['id']);
		$this->set_table_name($this->my_table);
		$this->set_where("$this->my_table.id = $id");
		return $this->count_record();
	}


	public function load($id)
	{
		$this->set_table_name($this->my_table);
		$this->set_where("$this->my_table.id = $id");
		$lists = $this->load_record();
		return $lists;
	}


	public function create($post)
	{

		$data = array(
			'pr_id' => $post['pr_id'],
			'pr_date' => setDateToStandard($post['pr_date']),
			'pr_sup' => $post['pr_sup'],
			'pr_project_name' => $post['pr_project_name'],
			'pr_status' => $post['pr_status']
		);
		$this->set_table_name($this->my_table);
		return $this->add_record($data);
	}


	/**
	 * List all data
	 * @param $start_row	Number offset record start
	 * @param $per_page	Number limit record perpage
	 */
	public function read($start_row = FALSE, $per_page = FALSE)
	{
		$search_field 	= $this->session->userdata($this->session_name . '_search_field');
		$value 	= $this->session->userdata($this->session_name . '_value');
		$value 	= trim($value);

		$where = $this->where_condition;
		$order_by = $this->order_by;
		if ($this->order_field != '') {
			$order_field = $this->order_field;
			$order_sort = $this->order_sort;
			$order_by = ($order_by != '' ? ', ' : '') . " $this->my_table.$order_field $order_sort";
		}

		if ($search_field != '' && $value != '') {
			$search_method_field = "$this->my_table.$search_field";
			$search_method_value = '';
			if ($search_field == 'id') {
				if (!is_numeric($value)) {
					$value = 0;
				}
				$value = $value + 0;
				$search_method_value = "= $value";
			}
			$where	.= ($where != '' ? ' AND ' : '') . " $search_method_field $search_method_value ";
			if ($order_by == '') {
				$order_by = ($order_by != '' ? ', ' : '') . " $this->my_table.$search_field";
			}
		}
		$this->set_table_name($this->my_table);
		$total_row = $this->count_record();
		$search_row = $total_row;
		if ($where != '') {
			$this->db->join('tb_supplier AS tb_supplier_1', "$this->my_table.pr_sup = tb_supplier_1.sup_name", 'left');

			$this->set_where($where);
			$search_row = $this->count_record();
		}
		$offset = $start_row;
		$limit = $per_page;
		$this->set_order_by($order_by);
		if ($offset != FALSE) {
			$this->set_offset($offset);
		}
		if ($limit != FALSE) {
			$this->set_limit($limit);
		}
		$this->db->select("$this->my_table.*, tb_supplier_1.sup_name AS prSupSupName, tb_supplier_1.sup_contact AS prSupSupContact, tb_supplier_1.sup_address AS prSupSupAddress, tb_supplier_1.sup_tel AS prSupSupTel, tb_supplier_1.sup_tax AS prSupSupTax, tb_supplier_1.sup_branch AS prSupSupBranch
				");
		$this->db->join('tb_supplier AS tb_supplier_1', "$this->my_table.pr_sup = tb_supplier_1.sup_name", 'left');

		$list_record = $this->list_record();
		$data = array(
			'total_row'	=> $total_row,
			'search_row'	=> $search_row,
			'list_data'	=> $list_record
		);
		return $data;
	}

	public function update($post)
	{
		$data = array(
			'pr_id' => $post['pr_id'],
			'pr_date' => setDateToStandard($post['pr_date']),
			'pr_sup' => $post['pr_sup'],
			'pr_project_name' => $post['pr_project_name'],
			'pr_status' => $post['pr_status'],
			'pr_status_date' => date('Y-m-d'),
			'pr_edit_date' => date('Y-m-d')
		);

		if (!empty($data)) {
			$id = checkEncryptData($post['encrypt_id']);
			$this->set_table_name($this->my_table);
			$this->set_where("$this->my_table.id = $id");
			return $this->update_record($data);
		} else {
			$this->error_message = 'ไม่พบข้อมูลที่เปลี่ยนแปลง';
		}
	}


	public function delete($post)
	{
		$id = checkEncryptData($post['encrypt_id']);
		$this->set_table_name($this->my_table);
		$this->set_where("$this->my_table.id = $id");
		return $this->delete_record();
	}


	public function set_running_number($field)
	{
		$running_number = '';
		$options = $this->running_options[$field];
		$format	= $options['format'];
		$type	= $options['type']; //Don't Trim() value from TYPE
		$digit	= $options['digit'];

		$year = substr(date('Y') + 543, -2);
		$month = date('m');
		$sql_cond = '';
		if ($format == 1) { //{PO}YYMMNNNNN
			$prefix = $type . $year . $month;
			$len = mb_strlen($prefix, 'utf-8');
			$sql_cond = "LEFT($field, $len) = '$prefix'";
		} elseif ($format == 2) { //YYMM{PO}NNNNN
			$prefix = $year . $month . $type;
			$len = mb_strlen($prefix, 'utf-8');
			$sql_cond = "LEFT($field, $len) = '$prefix'";
		} elseif ($format == 3) { //{PO}NNNNN/YY
			$len = mb_strlen($type, 'utf-8');
			$sql_cond = "LEFT($field, $len) = '$type' AND SUBSTRING_INDEX($field, '/', -1) = '$year'";
		} elseif ($format == 4) { //YY{PO}NNNNN
			$prefix = $year . $type;
			$len = mb_strlen($prefix, 'utf-8');
			$sql_cond = "LEFT($field, $len) = '$prefix'";
		} elseif ($format == 5) { //{PO}NNNNN
			$prefix = $type;
			$len = mb_strlen($prefix, 'utf-8');
			$sql_cond = "LEFT($field, $len) = '$prefix'";
		}
		$this->set_table_name($this->my_table);
		$this->set_where("$sql_cond");
		$this->set_order_by("LENGTH($field) DESC, $field DESC");
		$this->set_limit(1);
		$row = $this->load_record();
		$last_number = 0;
		if (!empty($row)) {
			$last_number = $row[$field];
		}

		$max_id = substr($last_number, -$digit);
		$max_id = (int)$max_id + 1;
		$next_id = substr('00000000' . $max_id, -$digit);

		switch ($format) {
			case 1:
				$running_number = $type . $year . $month . $next_id;
				break;
			case 2:
				$running_number = $year . $month . $type . $next_id;
				break;
			case 3:
				$running_number = $type . $next_id . '/' . $year;
				break;
			case 4:
				$running_number = $year . $type . $next_id;
				break;
			case 5:
				$running_number = $type . $next_id;
				break;
		}
		return $running_number;
	}


	public function loadDetailList($master_ref_id)
	{
		$this->set_table_name('tb_pr_list');
		$this->db->select("tb_pr_list.*, tb_product_buy_1.pr_name AS detailPrNamePrName");
		$this->db->join('tb_product_buy AS tb_product_buy_1', "tb_pr_list.pr_name = tb_product_buy_1.pr_name", 'left');
		$this->set_where("pr_ref = '$master_ref_id'");
		return $this->list_record();
	}



	public function load_detail_record($id)
	{
		$this->set_table_name('tb_pr_list');
		$this->set_where("id = $id");
		return $this->load_record();
	}

	public function save_detail_list($post)
	{
		$this->set_table_name('tb_pr_list');
		$data = array(
			'pr_ref' => $post['pr_ref'], 'pr_id' => $post['pr_id'], 'pr_name' => $post['pr_name'], 'pr_price' => str_replace(",", "", $post['pr_price']), 'pr_unit' => $post['pr_unit'], 'pr_qty' => str_replace(",", "", $post['pr_qty']), 'pr_remark' => $post['pr_remark']
		);

		if ($post['encrypt_id'] != '') {
			$id = checkEncryptData($post['encrypt_id']);
			$this->set_where("id = $id");
			return $this->update_record($data);
		} else {
			return $this->add_record($data);
		}
	}


	public function delete_list($post)
	{
		$this->set_table_name('tb_pr_list');
		$id = checkEncryptData($post['encrypt_id']);
		$this->set_where("id = $id");
		return $this->delete_record();
	}


	public function search_table($table, $conditions)
	{
		if ($conditions['search_value'] == '') {
			return array();
		}
		$this->set_table_name($table);
		$field1 = $conditions['field_value'];
		$field2 = $conditions['field_text'];
		$field_condition = $conditions['field_condition'];

		if (is_array($field1)) {
			$all_field1 = implode(',', $field1);
			$field1 = "CONCAT_WS(' ', $all_field1) AS field_value";
		} else {
			$field1 = "$field1 AS field_value";
		}

		if (is_array($field2)) {
			$all_field2 = implode(',', $field2);
			$field2 = "CONCAT_WS(' ', $all_field2) AS field_title";
		} else {
			$field2 = "$field2 AS field_title";
		}

		if (is_array($field_condition)) {
			$all_field = implode(',', $field_condition);
			$field_condition =  "CONCAT_WS('', $all_field)";
		}
		$select = "$field1, $field2, $field_condition AS field_search";

		$search_value = $conditions['search_value'];

		$search_string = "";
		$search_method = "";
		switch ($conditions['search_method']) {
			case 'equal':
				$single_qoute = "'";
				if ($search_value[0] == "0") {
					$single_qoute = "'";
				} else {
					if (is_numeric($search_value)) {
						$single_qoute = "";
					}
				}

				$search_method = '=';
				$search_string = "{$single_qoute}{$search_value}{$single_qoute}";
				break;
			case 'contain':
				$search_method = 'LIKE';
				$search_string = "'%{$search_value}%'";
				$search_value = str_replace('.', '', str_replace(' ', '', $search_value));
				break;
			case 'start_with':
				$search_method = 'LIKE';
				$search_string = "'{$search_value}%'";
				break;
			case 'end_with':
				$search_method = 'LIKE';
				$search_string = "'%{$search_value}'";
				break;
		}
		$where = "$field_condition $search_method $search_string";
		$this->set_select_field("$select");
		$this->set_where("$where");
		return $this->list_record();
	}
}
/*---------------------------- END Model Class --------------------------------*/