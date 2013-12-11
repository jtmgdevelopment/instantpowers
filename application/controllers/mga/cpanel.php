<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cpanel extends MGA_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'mga/';
		$this->mek		= $this->session->userdata( 'mek' );
		
		
	

	}


	public function index()
	{
		$view = 'index';
		$d = array();
		
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'What would you like to do?');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
}

