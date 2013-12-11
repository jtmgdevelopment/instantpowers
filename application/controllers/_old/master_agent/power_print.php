<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class power_print extends Master_Agent_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'master_agent/powers/';
		$this->mek		= $this->session->userdata( 'mek' );

		$this->load->model( 'powers/power_history_model', 'p' );
	}


	public function index()
	{
		$view = '';
		$d = array();

		$this->template->write('title', '');
		$this->template->write('sub_title', '');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
	
	
	/*
		PRINT_POWER
		* ARGUMENTS
			- power_id
			- trans_id
			- prefix_id
	*/
	
	public function print_copy( string $power_id, string $trans_id, string $prefix_id, string $mek )
	{	
	
		$log = 'Power printed by Master Agent';
		$this->p->set_power_history( array( 'pek' => $power_id, 'prefix_id' => $prefix_id, 'mek' => $mek, 'log' => $log ) );	
		$url = '/generate_power_pdf.cfm?power=' .  $power_id . '&trans_id=' . $trans_id . '&batch=0&prefix_id=' . $prefix_id . '&mek=' . $mek;		
		redirect( $url );
	
	}
}
