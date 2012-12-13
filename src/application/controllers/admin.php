<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	 public function __construct() {
		parent::__construct();
        // Here we must check !login!
		if(!$this->user->check_admin()) {
			$this->load->helper('url');
			redirect('/login');
		}	
	}
	
	public function index() {
		$this->smartylib->assign('title', 'ADMIN::MAIN');
		$this->_display('main.tpl');		
	}
	
	public function events() {
		$this->load->model("Booking");
		$events = $this->Booking->get_all_events();
		$this->smartylib->assign('title', 'Event List');
		$this->smartylib->assign('events', $events);
		$this->_display('events.tpl');
	}
	
	public function editevent($id) {
		
	}
	
	private function _display($module) {
		$this->smartylib->display('header.tpl');
		$this->smartylib->display('admin_menu.tpl');
		$this->smartylib->display('admin/'.$module);
		$this->smartylib->display('footer.tpl');
	}
}

?>
