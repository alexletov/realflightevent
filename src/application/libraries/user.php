<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User {
	var $CI;
	var $login;
	var $id;
	var $permissions;
	
	public function __construct()
    {
		$this->CI =& get_instance();
		if(!($user = $this->CI->session->userdata('user')))
			$user = $this->CI->input->post('user');
		if(!($password = $this->CI->session->userdata('password')))
			$password = md5($this->CI->input->post('password'));
		$query = $this->CI->db->query("SELECT * FROM users WHERE login = ? AND password = ?", array($user, $password));
		if($query->num_rows() < 1) {
			$id=0;
		}
		else {
			$this->CI->session->set_userdata(array(
                   'user'  => $user,
                   'password' => $password
               ));
			$row = $query->first_row();
			$this->id = $row->id;
			$this->user = $row->login;
			//Getting the permissions
			$query->free_result();
			$query = $this->CI->db->query("SELECT * FROM permissions WHERE uid = ?", array($this->id));
			foreach ($query->result() as $row) {
			   $this->permissions[strtolower($row->permission)] = 1;
			}			
		}
    }
	
	function check_permission($permission) {
		if(isset($this->permissions[strtolower($permission)]))
			return TRUE;
		else
			return FALSE;		
	}
	
	function check_admin() {		
		$this->CI->load->library('uri');
		if($this->CI->uri->rsegment(1) != 'login') {
			$this->CI->load->helper('url');
			$this->CI->session->set_userdata(array('login_referrer' => current_url()));
		}
		return $this->check_permission('admin');
	}
	
	function logged_in() {
		if($this->id == 0)
		{	
			return FALSE;
		}
		else
			return TRUE;
	}
}
?>