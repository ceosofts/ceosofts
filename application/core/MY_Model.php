<?php

/**
 * A base model with a series of CI Generator
 * @link http://phpcodemania.blogspot.com
 * @copyright Copyright (c) 2018, SONGCHAI SAETERN
 */
class MY_Model extends CI_Model
{
	private $_table_name;
	private $_select_field;
	private $_where;
	private $_order_by;
	private $_offset;
	private $_limit;
	private $admin_level;

	public $error_message;
	public $log_remark;

	public $summary;
	public $summary_hor;

	/**
	 * Initialise the model, load database with session or default
	 */
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('use_default_database') == FALSE) {
			// If change new DB
			$session_new_db = $this->session->userdata('session_new_db');
			if ($session_new_db != '') {
				$this->config->load("new_database");
				$db_config = $this->config->item('new_db'); // Load default config
				$db_config['database'] = $session_new_db;   // Set new database name
				$this->db = $this->load->database($db_config, TRUE);    // Connect new database
			}
		}

		$this->set_default();
		$this->log_remark = '';
		$this->admin_level = 9; //Admin
	}

	/**
	 * Clear parameter
	 */
	private function set_default()
	{
		$this->_select_field = '';
		$this->_where      = '';
		$this->_order_by   = '';
		$this->_offset     = '';
		$this->_limit      = '';
	}

	/**
	 * Count reord
	 * @return Number of record
	 */
	public function count_record()
	{
		$num = 0;
		$this->set_query_parameter();
		if ($query = $this->db->get($this->_table_name)) {
			$num = $query->num_rows();
		}
		return $num;
	}

	/**
	 * List all record with condition
	 * !!DON'T USE $this->db->from('xxxx') while call this Function
	 * Must set table with $this->set_table_name('xxxx');
	 * @return Array multiple record
	 */
	public function list_record()
	{
		$data = array();
		$this->set_query_parameter();
		$this->db->from($this->_table_name);
		if ($query = $this->db->get()) {
			$data = $query->result_array();
		}
		return $data;
	}

	/**
	 * Get Running number
	 * @param array $field String 
	 * @return Strng of last number
	 */
	public function running_number()
	{
		if ($this->_where == '') {
			return 'Choose WHERE Clause for load record data';
		} else {
			$this->set_query_parameter();
			$query = $this->db->get_where($this->_table_name);
			return $query->row_array();
		}
	}

	/**
	 * C = Create Record
	 * @param array $data
	 * @return Integer of new id record
	 */
	public function add_record($data = array())
	{
		$this->db->set($data);
		$query = $this->db->insert($this->_table_name);
		if ($this->db->insert_id()) {
			return $this->db->insert_id();
		} else {
			return $query;
		}
	}

	/**
	 * R = Read Record Data
	 * @return Array on record
	 */
	public function load_record()
	{
		if ($this->_where == '') {
			return 'Choose WHERE Clause for load record data';
		} else {
			$this->set_query_parameter();
			$query = $this->db->get_where($this->_table_name);
			return $query->row_array();
		}
	}

	/**
	 * U = Update record data
	 * @param array $data
	 */
	public function update_record($data = array())
	{
		if ($this->_where == '') {
			$this->error_message = 'Choose WHERE Clause for Update / Delet';
			return false;
		} else {
			$this->log_edit_history();

			$this->set_query_parameter();
			$this->db->set($data);
			$results = $this->db->update($this->_table_name);
			return $results;
		}
	}

	/**
	 * D = Delete record
	 */
	public function delete_record()
	{
		if ($this->_where == '') {
			return 'Choose WHERE Clause for Update / Delet';
		} else {
			//Move to LOG
			if ($this->log_delete()) {
				//Delete Record
				$this->set_query_parameter();
				return $this->db->delete($this->_table_name);
			} else {
				$this->error_message = 'Could not create LOG';
			}
		}
	}

	private function log_edit_history()
	{
		$n = 0;
		if ($pk_field = $this->get_primary_key()) {
			//จะทำงานเมื่อพบ PRIMARY Key เท่านั้น
			$pk_field_name = $pk_field;
			$num_pk = 1;
			if (is_array($pk_field)) {
				$num_pk = count($pk_field);
				if ($num_pk > 1) { //if array
					$pk_field_name = implode(',', $pk_field); //ใช้กับ CONCAT_WS(',', {$log_table_pk})
				}
			}

			$log_edit_remark = '';
			if ($this->log_remark != '') {
				$log_edit_remark = $this->log_remark . ' : ';
			}
			$log_edit_remark .= $this->input->post('edit_remark', TRUE);


			$n = 0;
			$this->set_query_parameter();
			$this->db->select($pk_field_name); //หา ID เท่านั้น  ไม่ต้องเก็บข้อมูล
			$query = $this->db->get($this->_table_name);
			foreach ($query->result_array() as $row) {
				if ($num_pk > 1) {
					$pk_value = array();
					foreach ($pk_field as $pk_name) {
						$pk_value[] = isset($row[$pk_name]) ? $row[$pk_name] : '';
					}
					$log_table_id = implode(',', $pk_value);
				} else {
					$log_table_id = isset($row[$pk_field]) ? $row[$pk_field] : '';
				}

				$data = array(
					'log_edit_remark' => mb_substr($log_edit_remark, 0, 50, 'UTF-8'), 'log_edit_table' => $this->_table_name, 'log_edit_table_pk_name' => $pk_field_name, 'log_edit_table_pk_value' => $log_table_id, 'log_edit_condition' => mb_substr($this->_where, 0, 100, 'UTF-8'), 'log_edit_user' => $this->session->userdata('user_id') //App User
					, 'log_edit_datetime' => date('Y-m-d H:i:s'), 'log_login_id' => $this->session->userdata('login_id')
				);
				$this->db->set($data);
				$this->db->insert('tb_ci_log_history');
				$n++;
			}
			return $n;
		}
	}

	private function log_delete()
	{
		//table, del condition, data
		$n = 0;
		if ($pk_field = $this->get_primary_key()) {

			$log_del_remark = $this->input->post('delete_remark', TRUE);

			$pk_field_name = $pk_field;
			$num_pk = 1;
			if (is_array($pk_field)) {
				$num_pk = count($pk_field);
				if ($num_pk > 1) { //if array
					$pk_field_name = implode(',', $pk_field); //ใช้กับ CONCAT_WS(',', {$log_table_pk})
				}
			}

			//จะทำงานเมื่อพบ PRIMARY Key เท่านั้น
			$this->set_query_parameter();
			$query = $this->db->get($this->_table_name);
			foreach ($query->result_array() as $row) {
				if ($num_pk > 1) {
					$pk_value = array();
					foreach ($pk_field as $pk_name) {
						$pk_value[] = isset($row[$pk_name]) ? $row[$pk_name] : '';
					}
					$log_table_id = implode(',', $pk_value);
				} else {
					$log_table_id = isset($row[$pk_field]) ? $row[$pk_field] : '';
				}

				$log_record_data = json_encode($row);

				$data = array(
					'log_del_remark' => mb_substr($log_del_remark, 0, 50, 'UTF-8'), 'log_table_name' => $this->_table_name, 'log_del_condition' => mb_substr($this->_where, 0, 100, 'UTF-8'), 'log_table_pk_name' => $pk_field_name, 'log_table_pk_value' => $log_table_id, 'log_record_data' => $log_record_data, 'create_user_id' => $this->session->userdata('user_id') //App User
					, 'create_datetime' => date('Y-m-d H:i:s'), 'log_login_id' => $this->session->userdata('login_id')
				);
				$this->db->set($data);
				$this->db->insert('tb_ci_log_delete');
				$n++;
			}
		}
		return $n;
	}

	private function get_primary_key()
	{
		$sql = "SHOW KEYS FROM $this->_table_name WHERE Key_name = 'PRIMARY'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 1) {
			$all_field = array();
			foreach ($query->result() as $row) {
				$all_field[] = $row->Column_name;
			}
			return $all_field;
		} else {
			$row = $query->row();
			if (!empty($row)) {
				return $row->Column_name;
			}
		}
	}

	/**
	 * Set table name from model
	 * @param String $table_name
	 */
	public function set_table_name($table_name)
	{
		$this->_table_name = $table_name;
		$this->set_default(); //clear any condition
	}

	/**
	 * Set table name from model
	 * @param String $table_name
	 */
	public function set_select_field($fields_name)
	{
		$this->_select_field = $fields_name;
	}

	/**
	 * Set condition for query
	 * @param string $where_string
	 */
	public function set_where($where_string)
	{
		$this->_where = $where_string;
	}

	public function show_where()
	{
		echo $this->_where;
	}


	/**
	 * Set order by of query
	 * @param string $order_by
	 */
	public function set_order_by($order_by)
	{
		$this->_order_by = $order_by;
	}

	/**
	 * Set start fetch row
	 * @param Integer $start_row
	 */
	public function set_offset($start_row)
	{
		$this->_offset = $start_row;
	}

	/**
	 * Set limit fetch row
	 * @param Integer $limit
	 */
	public function set_limit($limit)
	{
		$this->_limit = $limit;
	}

	/**
	 * Set condition before query
	 */
	public function set_query_parameter()
	{
		if ($this->_select_field != '') {
			$this->db->select($this->_select_field);
		}
		if ($this->_where != '') {
			$this->db->where($this->_where);
		}
		if ($this->_order_by != '') {
			$this->db->order_by($this->_order_by);
		}
		if ($this->_offset != '') {
			$this->db->offset($this->_offset);
		}
		if ($this->_limit != '') {
			$this->db->limit($this->_limit);
		}
	}

	/**
	 * Helper function
	 */
	public function getValueOf($table, $field_select, $where_string = '')
	{
		if ($where_string != '') $where_string = "WHERE " . $where_string;
		$sql = "SELECT $field_select FROM $table $where_string LIMIT 1";

		$this->db->db_debug = FALSE;
		if ($qry = $this->db->query($sql)) {
			if ($row = $qry->row_array()) {
				return $row[$field_select];
			}
		}
	}

	public function getRowOf($table, $field_select = '*', $where_string = '')
	{
		if ($where_string != '') $where_string = "WHERE " . $where_string;
		$sql = "SELECT $field_select FROM $table $where_string LIMIT 1";
		if ($qry = $this->db->query($sql)) {
			return $qry->row_array();
		}
	}


	public function createOptionList($table, $field_value, $field_text, $condition = array())
	{
		$where = '';
		if (isset($condition['where'])) {
			$where = "WHERE " . $condition['where'];
		}

		$join = '';
		if (isset($condition['join'])) {
			$join = $condition['join'];
		}

		if (isset($condition['order_by'])) {
			$order_by = $condition['order_by'];
		} else {
			$order_by = $field_text;
		}

		$ret = false;
		if (isset($condition['return'])) {
			$ret = $condition['return'];
		}

		$select_value = '';
		if (isset($condition['active'])) {
			$select_value = $condition['active'];
		}

		$field_attributes = '';
		if (isset($condition['attributes'])) {
			foreach ($condition['attributes'] as $field) {
				if ($field != $field_value && $field != $field_text) {
					$field_attributes .= ', ' . $field;
				}
			}
		}

		$list = '';
		$order_by = 'ORDER BY ' . $order_by;
		$sql = "SELECT $field_value, $field_text $field_attributes FROM $table $join $where $order_by";
		$qry = $this->db->query($sql);
		foreach ($qry->result_array() as $row) {
			$selected = '';
			if ($select_value == $row[$field_value]) {
				$selected = 'selected="selected"';
			}

			$attributes = '';
			if (isset($condition['attributes'])) {
				foreach ($condition['attributes'] as $field) {
					$attributes .= ' data-' . $field . '="' . $row[$field] . '"';
				}
			}

			$option = '<option ' . $attributes . ' value="' . $row[$field_value] . '" ' . $selected . '>' . $row[$field_text] . '</option>';
			if ($ret == true) {
				$list .= $option;
			} else {
				echo $option;
			}
		}

		if ($ret == true) {
			return $list;
		}
	}

	public function returnOptionList($table, $field_value, $field_text, $condition = array())
	{
		$condition['return'] = true;
		return $this->createOptionList($table, $field_value, $field_text, $condition);
	}

	public function isAdmin()
	{
		if ($this->session->userdata('user_level') == $this->admin_level) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Create Data for group summary
	 * $this->summary : table_name, vertical_id, vertical_name, horizontal_id, summary_field, other_select, join_condition, where_condition
	 */
	private function get_query_data()
	{
		$table_name = $this->summary['table_name'];
		$vertical_id = $this->summary['vertical_id'];
		$vertical_name = $this->summary['vertical_name'];
		$horizontal_id = $this->summary['horizontal_id'];
		$summary_field = $this->summary['summary_field'];

		$other_select = '';
		if (isset($this->summary['other_select']) && $this->summary['other_select'] != '') {
			$other_select = ', ' . $this->summary['other_select'];
		}

		$join = '';
		$where = '';
		if (isset($this->summary['join_condition']) && $this->summary['join_condition'] != '') {
			$join = $this->summary['join_condition'];
		}
		if (isset($this->summary['where_condition']) && $this->summary['where_condition'] != '') {
			if (strtoupper(substr(trim($this->summary['where_condition']), 0, 5)) != 'WHERE') {
				$where .= "WHERE ";
			}
			$where .= $this->summary['where_condition'];
		}

		$data = array();
		$sql = "SELECT  
					$vertical_id, 
					$vertical_name, 
					$horizontal_id, 
					SUM($summary_field) AS total_num
					$other_select
				FROM $table_name
				$join
				$where
				GROUP BY $vertical_id, $horizontal_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 1) {
			// Group data by vertical_id and horizontal_id
			$ver_id = $this->split_end($vertical_id);
			$hor_id = $this->split_end($horizontal_id);
			foreach ($query->result_array() as $row) {
				//set default data
				if (!isset($data[$row[$ver_id]])) {
					$data[$row[$ver_id]] = $row;
				}
				$data[$row[$ver_id]]['sum'][$row[$hor_id]] = $row['total_num'];
			}
		}
		return $data;
	}

	/**
	 * Create name list for thead
	 * $this->summary_hor : table, id, name, join_condition, where_condition
	 */
	private function report_group_hor_list()
	{
		$data = array();

		$table 	= $this->summary_hor['table'];
		$id 	= $this->summary_hor['id'];
		$name 	= $this->summary_hor['name'];

		$join = '';
		$where = '';
		if (isset($this->summary_hor['join_condition']) && $this->summary_hor['join_condition'] != '') {
			$join = $this->summary_hor['join_condition'];
		}
		if (isset($this->summary_hor['where_condition']) && $this->summary_hor['where_condition'] != '') {
			$where = $this->summary_hor['where_condition'];
		}

		$hor_col_id = $this->split_end($this->summary['horizontal_id']);

		$sql = "SELECT $id AS $hor_col_id, $name FROM $table $join $where";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 1) {
			$data = $query->result_array();
		}
		return $data;
	}

	private function split_end($field)
	{
		$split = explode('.', $field);
		if (count($split)) {
			$name = end($split);
		} else {
			$name = $field;
		}
		$name = str_replace('`', '', $name);
		$name = str_replace('`', '', $name);
		return $name;
	}

	/**
	 * Create data list for Horizontal report with JOIN table
	 */
	public function summary_group_hor()
	{
		// Data
		$summary_data = $this->get_query_data();

		// Group name list
		$horizontal_list = $this->report_group_hor_list();

		/*
		echo '<pre>';
		print_r($summary_data);
		echo '</pre>';
		*/

		$hor_col_id = $this->split_end($this->summary['horizontal_id']);
		$hor_col_name = $this->split_end($this->summary_hor['name']);

		$grand_total = 0;
		$summary_list = array();
		$summary_column_group = array();
		if (!empty($summary_data)) {
			foreach ($summary_data as $id => $row) {
				//set default
				$summary_list[$id] = $row;

				//group data
				$total = 0;
				$hor_num_list = '';
				foreach ($horizontal_list as $item) {
					if (isset($row['sum'][$item[$hor_col_id]])) {
						$num = $row['sum'][$item[$hor_col_id]];
						$num_td = $num;
					} else {
						$num_td = '';
						$num = 0;
					}
					$hor_num_list .= '<td>' . $num_td . '</td>';
					$total += $num;

					if (!isset($summary_column_group[$item[$hor_col_id]])) {
						$summary_column_group[$item[$hor_col_id]] = 0;
					}
					$summary_column_group[$item[$hor_col_id]] += $num;
				}

				$summary_list[$id]['sum_td_list'] = $hor_num_list;
				$summary_list[$id]['sub_total'] = $total;

				$grand_total += $total;

				unset($summary_list[$id]['sum']);
			}
		}

		$sum_column = '';
		$thead_list = '';
		$colspan = 0;
		if (!empty($horizontal_list)) {
			$no = 0;
			foreach ($horizontal_list as $item) {
				$no++;
				$thead_list .= '<th title="' . $item[$hor_col_name] . '">' . $no . '</th>';

				$total = 0;
				if (isset($summary_column_group[$item[$hor_col_id]])) {
					$total = $summary_column_group[$item[$hor_col_id]];
				}
				$sum_column .= '<td title="' . $item[$hor_col_name] . '">' . $total . '</td>';

				$colspan++;
			}
		}

		$summary = array(
			'colspan' => $colspan,
			'thead_list' => $thead_list,
			'data_list' => $summary_list,
			'sum_column' => $sum_column,
			'grand_total' => $grand_total
		);

		return $summary;
	}
}
