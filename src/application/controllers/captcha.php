<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha extends CI_Controller {
	public function index() {	
		$this->load->library('kcaptcha');
		$this->kcaptcha->view();
	}
}

?>