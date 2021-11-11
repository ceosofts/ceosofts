
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* Author: Jorge Torres
 * Description: Login model class
 */
class Login_model extends CI_Model
{

    private $member_table;
    private $forgot_table;

    function __construct()
    {
        parent::__construct();

        $this->forgot_table = 'tb_members_pass_forgot';
        $this->member_table = 'tb_members';
    }

    public function encrypt_md5_salt($pass)
    {
        // admin
        // 123456 ($2y$11$7E1Dw5fgB1FifW0apMj8meNHQG9janZMxtnaWPC4niyulskCov5sa)
        $key1 = 'RTy4$58/*tdr#t';    //default = RTy4$58/*tdr#t
        $key2 = 'ci@gen#$_sdf';        //default = ci@mania#$_sdf

        $key_md5 = md5($key1 . $pass . $key2);
        $key_md5 = md5($key2 . $key_md5 . $key1);
        $sub1 = substr($key_md5, 0, 7);
        $sub2 = substr($key_md5, 7, 10);
        $sub3 = substr($key_md5, 17, 12);
        $sub4 = substr($key_md5, 29, 3);
        return md5($sub3 . $sub1 . $sub4 . $sub2);
    }

    public function secure_pass($pass)
    {
        $key_encrypt = $this->encrypt_md5_salt($pass);
        $options = array('cost' => 11);
        return password_hash($key_encrypt, PASSWORD_BCRYPT, $options);
    }

    public function validate()
    {
        $gen_email = $this->security->xss_clean($this->input->post('ci_login_email'));
        $password = $this->security->xss_clean($this->input->post('ci_login_password'));
        $key_encrypt = $this->encrypt_md5_salt($password);

        $this->db->where('email', $gen_email);
        $this->db->or_where('username', $gen_email); //ชื่อผู้ใช้
        $this->db->from($this->member_table);
        $query = $this->db->get();
        //echo $this->secure_pass($password);
        //echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            if ($row = $query->row()) {
                if (password_verify($key_encrypt, $row->password)) {
                    $data = array(
                        'user_id' => $row->userid,
                        'user_username' => $row->username,
                        'user_prefix' => $row->prefix,
                        'user_firstname' => $row->firstname,
                        'user_lastname' => $row->lastname,
                        'user_email' => $row->email,
                        'user_level' => $row->level,
                        'user_department_id' => $row->department_id,
                        'ci_mania_login' => TRUE,
                        'login_validated' => TRUE
                    );
                    $this->session->set_userdata($data);
                    return TRUE;
                }
            }
        }

        // If the previous process did not validate
        // then return false.
        return FALSE;
    }

    public function reset_password($member_id, $data)
    {
        $secure_pass = $this->secure_pass($data['password2']);
        $this->log_remark = 'Reset รหัสผ่าน';
        $referral_code = $data['referral_code'];

        $data = array(
            'password' => $secure_pass, 'referral_code' => $referral_code, 'modify_datetime' => date('Y-m-d H:i:s'), 'modify_user_id' => $this->session->userdata('user_id')
        );
        $this->db->where("userid = $member_id");
        $this->db->set($data);
        return $this->db->update($this->member_table);
    }

    public function load_user($userid)
    {
        $userid = $this->security->xss_clean($userid);
        $this->db->where('userid', $userid);
        $query = $this->db->get($this->member_table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function check_email($email)
    {
        $email = $this->security->xss_clean($email);
        $this->db->where('email', $email);
        $query = $this->db->get($this->member_table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function check_user_forgot($user, $birthday)
    {
        $user = $this->security->xss_clean($user);
        $birthday = $this->security->xss_clean($birthday);
        $this->db->where('username', $user);
        $this->db->where('birthday', $birthday);
        $query = $this->db->get($this->member_table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function forgot_question($user)
    {
        $user = $this->security->xss_clean($user);
        $this->db->where('username', $user);
        $query = $this->db->get('tb_members_question_forgot');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }

    public function insert_forgot($data)
    {
        if ($this->db->insert($this->forgot_table, $data)) {
            return true;
        }
    }

    public function delete_forgot($encrypt_id)
    {
        $this->db->where('encrypt_id', $encrypt_id);
        $this->db->delete($this->forgot_table);
    }

    public function get_reset_data($key)
    {
        $this->db->where('encrypt_id', $key);
        $query = $this->db->get($this->forgot_table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return array();
        }
    }

    //Clear 3 day ago
    public function clear_forgot()
    {
        $day_target = date('Y-m-d H:i:s', strtotime('-3 day', strtotime('now')));
        $this->db->where(" active_time < '$day_target' ");
        $this->db->limit(20);
        $this->db->delete($this->forgot_table);
    }
}
?>
