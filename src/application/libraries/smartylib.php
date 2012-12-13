<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "smarty/Smarty.class.php";

class Smartylib extends Smarty {
	
	public function __construct()
    {
		parent::__construct();
		$this->template_dir = "templates/tpl/";
		$this->compile_dir  = "templates/compile/";
    }
}
?>