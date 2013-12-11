<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_mgas extends Insurance_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'insurance/manage_mgas/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'insurance/ins_agency_model', 'a' );
	}


	public function index()
	{
		$view = 'index';
		$d    = array();


		$this->template->write('title', 'Manage MGAs');
		$this->template->write('sub_title', 'Here you can manage the MGAs that can accept your transmissions');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
	
	public function add_agency_to_insurance( $mek )
	{
		$this->a->add_mga_to_insurance( $mek );		
		$this->set_message( 'This MGA has been successfully added', 'done', '/insurance/manage_mgas/' );
	}
	
	public function show_agency( $d )
	{
		$view = 'show_agency';
		$data = array(
			'agency' => $this->a->get_mga( $d[ 'email' ] )	
		); 
		if( count( $data[ 'agency' ] ) == 0) $this->set_message( 'There are no MGAs by that email address', 'error', '/insurance/manage_mgas/add_mga' );

		
		
		$this->template->write('title', 'Pending Add');
		$this->template->write('sub_title', 'Below you will find the MGA you are about to add');
		$this->template->write_view('content', $this->view . $view, $data);
		$this->template->render();		
		
	}

	public function process_add_agency_frm()
	{
		if( $this->a->validate_add_mga_frm() )
		{
			$d = $this->sfa();	
			$this->show_agency( $d );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->add_mga();
		}
		
	}
	
	
	
	public function add_mga()
	{
		
		$view = 'add_agency';
		$d    = array();


		$this->template->write('title', 'Manage MGAs');
		$this->template->write('sub_title', 'Here you can manage the MGAs that can accept your transmissions');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	}

	public function list_mgas()
	{
		
		$view = 'list_agencies';
		$d    = array(
			'agencies' => $this->a->list_mgas()
		);


		$this->template->write('title', 'Listed MGAs');
		$this->template->write('sub_title', 'Below you will find your current MGAs');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}
	
}

/*

		if( $this->p->validate_void_frm() )
		{
			$msg = 'You successfully voided the power';
			$this->set_message( $msg, 'done', '/master_agent/transmissions/view/' . $this->input->post( 'trans_id' ) );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
		}

*/

