<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * Member_profile_model Class
 * @date 2018-09-02
 */
class Member_profile_model extends MY_Model
{

	private $my_table;
	public $order_sort;
	public $order_field;

	public function __construct()
	{
		parent::__construct();
		$this->my_table = 'tb_members';
		$this->set_table_name($this->my_table);
		$this->order_field = '';
		$this->order_sort = '';
	}


	public function exists($data)
	{
		$userid = checkEncryptData($data['userid']);
		$this->set_where("userid = $userid");
		return $this->count_record();
	}

	public function load($id)
	{
		$this->set_where("userid = $id");
		return $this->load_record();
	}
	
	/**
	* List all data
	* @param $start_row	Number offset record start
	* @param $per_page	Number limit record perpage
	*/
	public function read($start_row, $per_page)
	{
		$search_field 	= $this->session->userdata('member_manage_search_field');
		$value 	= $this->session->userdata('member_manage_search_value');
		$value 	= trim($value);
		
		$where	= '';
		$order_by	= '';
		if($this->order_field != ''){
			$order_field = $this->order_field;
			$order_sort = $this->order_sort;
			$order_by	= " $this->my_table.$order_field $order_sort";
		}
		
		if($search_field != ''){
			$search_method_field = "$this->my_table.$search_field";
			$search_method_value = '';
			if($search_field == 'userid'){
				$value = $value + 0;
				$search_method_value = "= $value";				
			}
			if($search_field == 'fullname'){
				$search_method_value = "LIKE '%$value%'";				
			}
			if($search_field == 'lastname'){
				$search_method_value = "LIKE '%$value%'";				
			}
			$where	.= ($where != '' ? ' AND ' : '') . " $search_method_field $search_method_value "; 
			if($order_by == ''){
				$order_by	= " $this->my_table.$search_field";
			}
		}
		$total_row = $this->count_record();
		$search_row = $total_row;
		if ($where != '') {
			$this->set_where($where);
			$search_row = $this->count_record();
		}
		$offset = $start_row;
		$limit = $per_page;
		$this->set_order_by($order_by);
		$this->set_offset($offset);
		$this->set_limit($limit);
		$this->db->select("$this->my_table.*, tb_department_1.dpm_name AS departmentIdDepartmentName
				, tb_members_2.fullname AS createUserIdFullname, tb_members_2.lastname AS createUserIdLastname
				, _doc_tb_members_3.fullname AS modifyUserIdFullname, _doc_tb_members_3.lastname AS modifyUserIdLastname
				");
		$this->db->join('tb_department AS tb_department_1', "$this->my_table.department_id = tb_department_1.dpm_id", 'left');
		$this->db->join('tb_members AS tb_members_2', "$this->my_table.create_user_id = tb_members_2.userid", 'left');
		$this->db->join('tb_members AS _doc_tb_members_3', "$this->my_table.modify_user_id = _doc_tb_members_3.userid", 'left');

		$list_record = $this->list_record();
		$data = array(
				'total_row'	=> $total_row, 
				'search_row'	=> $search_row,
				'list_data'	=> $list_record
		);
		return $data;
	}
	
	/**
	 * Check by Email
	 */
	public function exists_user($username)
	{
		$username = trim($username);
		$this->set_where("username = '$username'");
		return $this->count_record();
	}	
	
	/**
	 * New register
	 */
	public function create($post)
	{
		if($this->exists_user($post['username'])){
			$this->error_message = 'ชื่อผู้ใช้ซ้ำกัน';
			return false;
		}else{
			$this->load->model('Login_model');
			
			$level 		= isset($post['level']) ? $post['level'] : '';
			$tel_number = isset($post['tel_number']) ? $post['tel_number'] : '';
			$line_id 	= isset($post['line_id']) ? $post['line_id'] : '';
			$password 	= isset($post['password']) ? $post['password'] : '';
			$prefix_name 	= isset($post['prefix_name']) ? $post['prefix_name'] : '';
			$department_id = isset($post['department_id']) ? $post['department_id'] : '';
			
			$data = array(
					 'prefix' => $prefix_name
					,'fullname' => $post['fullname']
					,'lastname' => $post['lastname']
					,'email' 	=> $post['email']
					,'username' => $post['username']
					,'password' => $this->Login_model->secure_pass($password)
					,'level' 	=> $level
					,'department_id' => $department_id
					,'tel_number' 		=> $tel_number
					,'line_id' 			=> $line_id
					,'create_date' 	=> date('Y-m-d H:i:s')
					,'create_user_id'  	=> $this->session->userdata('user_id')
			);
			return $this->add_record($data);
		}
	}

	public function update($post)
	{
		$data = array(
				 'email' 		=> $post['email']
				,'tel_number' 	=> $post['tel_number']
				,'line_id' 		=> $post['line_id']
				,'modify_date' 	=> date('Y-m-d')
				,'modify_user_id'  => $this->session->userdata('user_id') //App User
		);
		
		if(isset($post['void'])){
			$data['void'] = $post['void'];
		}
		
		if(isset($post['prefix_name'])){
			$data['prefix'] = $post['prefix_name'];
		}
		
		if(isset($post['fullname'])){
			$data['fullname'] = $post['fullname'];
		}
		
		if(isset($post['lastname'])){
			$data['lastname'] = $post['lastname'];
		}
		
		if(isset($post['level'])){
			$data['level'] = $post['level'];
		}
		
		if(isset($post['department_id'])){
			$data['department_id'] = $post['department_id'];
		}
		
		$userid = checkEncryptData($post['encrypt_userid']);
		$this->set_where("userid = $userid");
		return $this->update_record($data);
	}

    public function update_password($data, $member_id = NULL)
    {
		$this->load->model('Member_login_model', 'Login_model');
		
		if($member_id == NULL){
			$userid = $this->session->userdata('user_id');//App User
		}else{
			$userid = $member_id;
		}
		
        $conditions = array('userid' => $userid);
        $this->db->where($conditions);
        $query = $this->db->get($this->my_table);
        if($query->num_rows() > 0)
        {
			$username = '';
			if($row = $query->row()){
				$username = $row->username;
			}
			
			$old_pass = $data['uPasswordOld'];
			
			$check_pass = FALSE;
			if($member_id == NULL){//from member edit
				if($this->Login_model->db_validate($username, $old_pass) == TRUE){
					$check_pass = TRUE;
				}else{
					$this->error_message = "รหัสผ่านเดิมไม่ถูกต้อง กรุณาตรวจสอบ";
				}
			}else{
				if ($this->isAdmin() == TRUE) {
					$check_pass = TRUE;
				}
			}
			
			if($check_pass == TRUE){
				$new_pass = $this->Login_model->secure_pass($data['resetPassword2']);
				$this->log_remark = 'เปลี่ยนรหัสผ่าน';
				$data = array(
					  'password' 		=> $new_pass
					, 'modify_date' 	=> date('Y-m-d H:i:s')
					, 'modify_user_id' 	=> $userid
				);
				$this->set_where("userid = $userid");
				
				return $this->update_record($data);
			}else{
				$this->error_message = "ไม่ได้รับสิทธิ์แก้ไข กรุณาตรวจสอบ";
			}
        }else{
            $this->error_message = "ไม่พบรหัสผู้ใช้งาน กรุณาตรวจสอบ";
        }
    }

}
/*---------------------------- END Model Class --------------------------------*/