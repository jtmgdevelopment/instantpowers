<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transmissions extends Admin_Controller {

	private $view;
	private $mek;

	public function __construct()
	{
		parent::__construct();
		$this->view = 'admin/transmissions/';
		$this->mek	= $this->session->userdata( 'mek' );
		$this->load->model( 'admin/transmission_model', 't' );

//		$this->template->add_js( '_assets/js/credits/credits.js' );

	}


	public function index()
	{

		$data = array(
		
		);
			
		$this->template->write('title', 'Manage Transmissions');
		$this->template->write('sub_title', 'Use this admin to manage your transmissions');
		$this->template->write_view('content', $this->view . 'index', $data);
		$this->template->render();

	}

	
	public function process_prefix_frm()
	{
		
		if( $this->t->validate_prefix_frm() )
		{
			$this->t->save_prefix( $this->mek );
			$msg = 'You successfully create a power prefix';
			$this->set_message( $msg, 'done', '/admin/transmissions/power_prefixes' );
			
		}	
		else
		{
			
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->power_prefixes();
			
		}
		
	}


	public function power_prefixes()
	{

		$data = array(
			'prefixes'	=> $this->t->get_prefixes()
		);
			
		$this->template->write('title', 'Manage Power Prefixes');
		$this->template->write('sub_title', 'Use this admin to manage power prefixes');
		$this->template->write_view('content', $this->view . 'power_prefixes', $data);
		$this->template->render();

	}

}

