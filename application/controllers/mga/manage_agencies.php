<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_agencies extends MGA_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'mga/manage_agencies/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'mga/bail_agency_model', 'a' );
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
	
	public function add_agency_to_insurance()
	{
		$d = $this->sfa();
		
		$validate = $this->a->verify_direct_relationship( $this->mek, $d[ 'agency' ], $d[ 'company' ] );
		
		
		if( $validate > 0 ) $this->set_message( 'This agency already has a direct relationship with one of your insurance companies', 'error', '/mga/manage_agencies/' );

	
		$this->a->add_agency_to_mga( $d[ 'agency' ]	, $this->mek );		
		$this->set_message( 'This agency has been successfully added', 'done', '/mga/manage_agencies/' );
	}
	
	public function show_agency( $d )
	{
		$view = 'show_agency';


		$this->load->model( 'mga/mga_crud_model', 'crud' );
		$ins = $this->crud->get_insurance_companies( $this->mek );

		$ins_d = array(
			'data' 		=> $ins,
			'id_opt'	=> 'insurance_agency_id',
			'val_opt'	=> 'company'
		);
	
		$data = array(
			'agency'	 	=> $this->a->get_agency( $d[ 'license_number' ], $this->mek ),
			'ins_drop' 		=> $this->create_sub_select_array(  $ins_d )
		); 
		
		if( count( $data[ 'agency' ] ) == 0) $this->set_message( 'There are no agency by that license number', 'error', '/mga/manage_agencies/add_agency' );


		
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
			'agencies' => $this->a->list_agencies( $this->mek )
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

