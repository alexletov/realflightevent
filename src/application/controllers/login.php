<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	 public function index() {
		 if($this->user->logged_in()) {
			$ref = $this->session->userdata('login_referrer');
			$this->load->helper('url');
			if(isset($ref) && $ref != '')
				redirect($ref); 
			else
		 		redirect('/');
		 }
		 $this->smartylib->assign('title', 'Login');
		 $this->smartylib->display('login.tpl');
	 }
	 
	 public function logout() {
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('password');
		$this->session->unset_userdata('login_referrer');
	 }
}

?>
