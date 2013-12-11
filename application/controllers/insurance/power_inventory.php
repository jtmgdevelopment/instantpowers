<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class power_inventory extends Insurance_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'insurance/power_inventory/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'insurance/power_inventory_model', 'p' );
		$this->load->model( 'powers/power_model', 'power' );
		$this->load->model( 'powers/power_history_model', 'history' );
		$this->load->model( 'mga/mga_crud_model', 'mga' );
		$this->load->model( 'power_prefixes/prefix_crud_model' , 'prefix' );
		
		$this->load->helper('html');				
		$this->load->helper('power');		
		$this->template->add_js( '_assets/js/agent/transmissions.js' );
		$this->template->add_js( '_assets/js/libs/tablesorter/jquery.tablesorter.min.js' );	
		$this->template->add_js( '_assets/js/libs/tablesorter/jquery.tablesorter.pager.js' );	
		
		$script = "
			$(document).ready(function() { 
		    	$('table.tablesorter') 
			    	.tablesorter({widthFixed: false}) 
				    .tablesorterPager({container: $('#pager')}); 
			}); 			
		"; 
		
		$this->template->add_js( $script, 'embed' );
		

	}


	public function process_mga()
	{
		
		
	}

	public function view_mga()
	{
			
		$view = 'mga_inventory';
		$d = array(
			'agencies' => $this->mga->get_mga_admins( array( 'active' => true ) )
		);

		$vars = array(
			'default' 	=> 'Select MGA',
			'data'		=> $d[ 'agencies' ],
			'id_opt'	=> 'mek',
			'val_opt'	=> 'name_company'
			
		);

		$d[ 'agencies' ] = $this->create_sub_select_array( $vars );
		
		
	
		$this->template->write('title', 'Choose Bail Agency');
		$this->template->write('sub_title', 'Choose the bail agency in which you would like to list their powers');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}


	public function view_history( $power_id, $bail_agency )
	{
		$d = array(
			'history' 		=> $this->history->get_power_history( $power_id ),
			'bail_agency' 	=> $bail_agency
		);
		

		$view = 'view_history';	
		$this->template->write('title', 'View Power History');
		$this->template->write('sub_title', 'Below you will find the history of this power');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}
	
	

	public function process_void_frm()
	{
		$d = $this->sfa();
		
		$this->power->void_power();	
		$msg = 'You successfully voided the power';
		$this->set_message( $msg, 'done', '/insurance/power_inventory/process_bail_bonds_agency/inventory/' . $d[ 'bail_agency' ] );
		
		
	}

	public function void_power( $power_id, $bail_agency )
	{
		$d = array(
			'power_id' 		=> $power_id,
			'bail_agency'	=> $bail_agency
		);
		
		$view = 'void_power';	
		$this->template->write('title', 'Void Power');
		$this->template->write('sub_title', 'Are you sure you want to void this power?');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}


	public function view_power( $power_id, $bail_agency, $hide = NULL )
	{
		
		$d = array(
			'p' 		=> $this->power->get_power( array( 'power_id' => $power_id ) ),
			'bail_agency' 	=> $bail_agency

		);

		if( count( $d[ 'p' ] ) == 0 )
		{
			$msg = 'This power was never executed, there is no information to view.';
			$this->set_message( $msg, 'info', '/insurance/power_inventory/process_bail_bonds_agency/inventory/' . $d[ 'bail_agency' ] );
			
		}
		if( isset( $hide ) ) $d[ 'hide' ] = true;
		
		$this->load->model( 'insurance/ins_agency_model', 'ins' );
		
		$ins = $this->ins->get_insurance_company_by_transmission( $d[ 'p' ][ 'transmission_id' ] );

		$filename = strtolower( str_replace( ' ', '_', $ins->agency_name ) );
		
		$file_path = 'power_template/' . $filename . '_power';		
		
		
		$this->load->view( $this->view . $file_path, $d );				
			
	}

	public function process_bail_bonds_agency( $status = NULL, $agency = NULL )
	{
	
		$view				= 'list_powers';
		$d 					= $this->sfa();
		$d[ 'bail_agency' ] = ( isset( $agency ) ? $agency : $d[ 'bail_agency' ] );		
		$d[ 'status' ]		= $status;
		$d[ 'mek' ] 		= $this->mek;
		$d[ 'powers' ] 		= $this->p->list_powers_by_agency( $d );
		$d[ 'controller' ] 	= '/insurance/power_inventory';
		$d[ 'method' ] 		= 'process_bail_bonds_agency';
		
		
		$d[ 'prefixes' ]	= $this->prefix->get_prefixes( 
										array( 	'active' 				=> 1, 
												'insurance_agency_id'	=> $this->session->userdata( 'insurance_agency_id')  
											)	 
										);

		
		$this->template->write('title', 'Available Powers');
		$this->template->write('sub_title', 'Below you will find all available powers for this agency');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}


	public function index()
	{
		$this->load->model( 'insurance/ins_agency_model', 'agency' );
		
		$view = 'index';
		$d = array(
			'agencies' 		=> $this->p->get_bail_agencies( array( 'mek' => $this->mek ) ),
			'ins_agencies'  => $this->agency->list_mgas()
		);

		foreach( $d[ 'ins_agencies' ] as $ins )
		{			
			$d[ 'agencies' ][] = array(
				'bail_agency_id' 	=> $ins[ 'mek' ],
				'agency_name' 		=> $ins[ 'company_name' ]
			);			
		}
		
		$vars = array(
			'default' 	=> 'Select A Bail Agency/MGA',
			'data'		=> $d[ 'agencies' ],
			'id_opt'	=> 'bail_agency_id',
			'val_opt'	=> 'agency_name'
			
		);

		$d[ 'agencies' ] = $this->create_sub_select_array( $vars );
		
		
		$this->template->write('title', 'Choose Bail Agency/MGA');
		$this->template->write('sub_title', 'Choose the bail agency/MGA in which you would like to list their powers');
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

