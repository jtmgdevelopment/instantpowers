<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_agencies extends Insurance_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'insurance/manage_agencies/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'insurance/ins_agency_model', 'a' );
	}


	public function index()
	{
		$view = 'index';
		$d    = array();


		$this->template->write('title', 'Manage Bail Agencies');
		$this->template->write('sub_title', 'Here you can manage the bail agencies that can accept your transmissions');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
	
	public function add_agency_to_insurance( $mek )
	{
		$validate = $this->a->verify_direct_relationship( $mek, $this->session->userdata( 'insurance_agency_id') );
		
		if( $validate > 0 ) $this->set_message( 'This agency already has a direct relationship with one of your MGA companies', 'error', '/insurance/manage_agencies/' );
		
		$this->a->add_agency_to_insurance( $mek );		
		$this->set_message( 'This agency has been successfully added', 'done', '/insurance/manage_agencies/' );
	}
	
	public function show_agency( $d )
	{
		$view = 'show_agency';
		$data = array(
			'agency' => $this->a->get_agency( $d[ 'license_number' ] )	
		); 
		
		if( count( $data[ 'agency' ] ) == 0) $this->set_message( 'There are no agency by that license number', 'error', '/insurance/manage_agencies/add_agency' );

		
		
		$this->template->write('title', 'Pending Add');
		$this->template->write('sub_title', 'Below you will find the agency you are about to add');
		$this->template->write_view('content', $this->view . $view, $data);
		$this->template->render();		
		
	}

	public function process_add_agency_frm()
	{
		if( $this->a->validate_add_agency_frm() )
		{
			$d = $this->sfa();	
			$this->show_agency( $d );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->add_agency();
		}
		
	}
	
	
	
	public function add_agency()
	{
		
		$view = 'add_agency';
		$d    = array();


		$this->template->write('title', 'Manage Bail Agencies');
		$this->template->write('sub_title', 'Here you can manage the bail agencies that can accept your transmissions');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	}

	public function list_agencies()
	{
		
		$view = 'list_agencies';
		$d    = array(
			'agencies' => $this->a->list_agencies()
		);


		$this->template->write('title', 'Listed Bail Agencies');
		$this->template->write('sub_title', 'Below you will find your current bail agencies');
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

