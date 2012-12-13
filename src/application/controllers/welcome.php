<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$this->smartylib->assign('page', 'main');
		$this->smartylib->assign('title', 'Moscow RFE 2012');
		$this->_display('announce.tpl');
	}
	
	public function controllers()
	{
		$this->smartylib->assign('page', 'controllers');
		$this->smartylib->assign('title', 'Controllers');
		$this->_display('commingsoon.tpl');
	}
	
	public function briefing()
	{
		$this->smartylib->assign('title', 'Pilot briefing');
		$this->smartylib->assign('page', 'briefing');
		$this->_display('commingsoon.tpl');
	}
	
	public function organisers()
	{
		$this->smartylib->assign('title', 'Oragnisers');
		$this->smartylib->assign('page', 'organisers');
		$this->_display('announce.tpl');
	}
	
	private function _display($module) {
		$this->smartylib->display('header.tpl');
		$this->smartylib->display('menu.tpl');
		$this->smartylib->display($module);
		$this->smartylib->display('footer.tpl');
	}
}