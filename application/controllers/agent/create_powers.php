<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class create_powers extends Agent_Controller {

	private $view;
	private $mek;
	private $master_id;
	private $role;

	public function __construct()
	{
		
		parent::__construct();
			
		$this->role 	= $this->session->userdata( 'role' );
		$this->view 	= 'agent/powers/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->images	= realpath( './uploads/images/' );
		$this->load->helper('state');
		$this->load->helper('html');				
		$this->load->helper('power');		

		
		$this->load->model( 'transmissions/transmissions_model' , 't' );
		$this->load->model( 'credits/credits_model', 'c' );
		$this->load->model( 'powers/power_model', 'p' );
		$this->load->model( 'agent/crud_model', 'b' );
		$this->load->model( 'jail/jail_crud_model', 'j' );
		$this->load->model( 'power_prefixes/prefix_crud_model', 'prefix' );
	
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');		
		$this->template->add_js( '_assets/js/powers/powers.js' );

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
	
		
		$this->master_id = $this->mek;
		
		if( $this->role == 'sub_agent' )
		{
			$m = $this->b->get_sub_agent_master( array( 'sub_mek' => $this->mek ) );
			$this->master_id = $m->master_id;	
		}
	
	

	}
	
	
	public function edit_powers_list( $trans_id, $power_id )
	{
		
		$raw_powers 	= $this->p->get_saved_power();
		
		
		$parsed_powers 	= $this->p->parse_saved_powers( $raw_powers[ 'powers' ] ); 		
		
		$view 			= 'edit_power_list';
		
		foreach( $parsed_powers as $p => $i ){
			
			$parsed_powers[ $p ][ 'prefix_name' ] = $this->prefix->get_prefix_name( $i );
			
		}	
		
		$d = array(
			'powers' 	=> $parsed_powers,
			'trans_id'	=> $trans_id,
			'power_id'	=> $power_id
		);
		
		$this->template->write('title', 'Edit Powers');
		$this->template->write('sub_title', 'Choose the power you want to edit');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		


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
	START EXECUTE A POWER
*/

	//STEP ONE - CREATE THE GENERAL POWER INFORMATION
	public function execute( $trans_id, $power_id, $edit = NULL, $saved_power_id = NULL )
	{

		$view = 'index';
		$d = array(
			
			'transmission'	=> $this->t->get_transmission( $this->master_id, $trans_id ),
			'powers'		=> $this->p->get_powers( NULL, $power_id ),
			'power_status'	=> $this->p->get_power_status()	,
			'power'			=> array(),
			'trans_id'		=> $trans_id,
			'power_id'		=> $power_id,
			'sp'			=> $this->p->get_saved_power()
		);
		
		
		$this->check_transmission( $d['transmission']->paid );
		
		
		if( $d[ 'powers' ]->status == 'Inventory Bond' ) $view = 'create_power';
		
		if( isset( $edit ) )
		{
			$powers = $this->p->parse_saved_powers( $d[ 'sp' ][ 'powers' ] );		 
			
			$d[ 'power' ] = $powers[ $saved_power_id ];
			$d[ 'edit'	] = $saved_power_id;
			
		}

		
		$this->template->write('title', 'View Power');
		$this->template->write('sub_title', 'Please the following fill in the required information to complete this power');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	
	
	}


	//PROCESS STEP ONE
	public function process_step_one()
	{
		$d = $this->sfa();
		if( $this->p->validate_step_one() )
		{
			$this->p->save_general_power_info();	
			
			$vars = $d[ 'trans_id' ] . '/' . $d[ 'power_id' ];

			//redirect the user to the the defendant page if the select to add a defendant
			if( isset( $_POST[ 'add_defendant'] ) ) redirect( '/agent/create_powers/step_two/' . $vars );
			//redirect the user to the summary page
			else redirect( '/agent/create_powers/summary/' . $vars );
				
		}
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			if( isset( $d[ 'edit'] ) )
			{
				$this->execute( $d[ 'trans_id' ], $d[ 'power_id' ],  'TRUE', $d[ 'edit' ] );				
			}
			else
			{
				$this->execute( $d[ 'trans_id' ], $d[ 'power_id' ] );				
			}
		}
	}

	
	public function step_two( $trans_id, $power_id )
	{
		
			
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->master_id, $trans_id ),		
			'sp'			=> $this->p->get_saved_power(),
			'trans_id'		=> $trans_id,
			'power_id'		=> $power_id
		);
		
		$this->check_transmission( $d['transmission']->paid );

		$this->template->write('title', 'Defendant Information');
		$this->template->write('sub_title', 'Please add in the defendant information');
		$this->template->write_view('content', $this->view . 'create_defendant', $d);
		$this->template->render();		
	
	}

	//process step 2
	public function process_step_two()
	{
		if( $this->p->validate_step_two() )
		{
			$this->p->save_defendant_info();	
			$d 		= $this->sfa();
			$vars 	= $d[ 'trans_id' ] . '/' . $d[ 'power_id' ];
			redirect( '/agent/create_powers/summary/' . $vars );
		}
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->step_two(  $d[ 'trans_id' ], $d[ 'power_id' ]  );				
		}
	}


	public function summary( $trans_id, $power_id )
	{	
		$this->check_batch();
	
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->master_id, $trans_id ),
			'sp'			=> $this->p->get_saved_power(),
			'trans_id'		=> $trans_id,
			'power_id'		=> $power_id
		);
		$d[ 'power_count' ]	= count( (array ) $d[ 'sp' ][ 'powers' ] );

		
		$this->check_transmission( $d['transmission']->paid );

		$this->template->write('title', 'View Power');
		$this->template->write('sub_title', 'Please choose how to complete your power');
		$this->template->write_view('content', $this->view . 'summary', $d);
		$this->template->render();		
	
	}




	public function batch_powers()
	{
		$args = array(
			'mek' 	=> $this->mek,
			'key'	=> 'inventory',
			'paid'	=> 'paid',
			'role'	=> $this->role
		);
				
		$d = array( 
			'powers' 		=> $this->p->get_all_powers( $args ),
			'sp'			=> $this->p->get_saved_power()
		);
		
		$d[ 'parsed_powers' ] 	= $this->p->parse_saved_powers( $d[ 'sp' ][ 'powers' ] );
		$d[ 'powers' ] 			= $this->p->strip_used_powers( $d[ 'powers' ], $d[ 'parsed_powers' ] );

		$this->template->write('title', 'Choose A Power To Batch');
		$this->template->write('sub_title', 'Please choose another power to batch');
		$this->template->write_view('content', $this->view . 'add_power_batch', $d);
		$this->template->render();		
		
		
	}


	public function view_power( $trans_id, $power_id )
	{
		
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->master_id, $trans_id ),
			'sp'			=> $this->p->get_saved_power(),
			'trans_id'		=> $trans_id,
			'agent'			=> $this->b->get_agents( $this->mek ),
			'power_id'		=> $power_id,
			'role'			=> $this->role
		);
		

		$power = $this->p->get_power_before_execute(  $power_id );
	
		if( $power[ 'transferred_sub' ] == 'yes' )
		{
			$agent = $this->b->get_sub_agent_by_power( array( $power_id ) );
			$mek = $agent->mek;
			
			$d[ 'agent' ] = $this->b->get_agents( $mek );
		} 
		
		
		$d[ 'parsed_powers' ] 		= $this->p->parse_saved_powers( $d[ 'sp' ][ 'powers' ] );
		$d[ 'parsed_defendant' ] 	= $this->p->parse_saved_defendant( $d[ 'sp' ][ 'defendant' ] );
		
		
		$filename = strtolower( str_replace( ' ', '_', $d[ 'transmission' ]->agency_name ) );
		
		$file_path = 'power_template/' . $filename;		
		
		
		$d[ 'filename' ] = $filename;	
		
		$this->load->view( $this->view . $file_path, $d );		
	}

	
	public function print_power( $trans_id, $power_id, $filename = NULL )
	{
		$ids = implode( ',' , $this->p->save_offline_power() );

		$power = $this->p->get_power( array( 'power_id' => $power_id ) );
		
		$mek = $this->mek;
		
		if( $power[ 'transferred_sub' ] == 'yes' )
		{
			$agent = $this->b->get_sub_agent_by_power( array( $power_id ) );
			$mek = $agent->mek;
		} 

		
		
		$url = '/_tasks/' . $filename . '_print_power.cfm?powers=' .  $ids . '&mek=' . $this->mek;
		redirect( $url );
	} 

	public function print_power_copy(  $power_id )
	{
		
		$this->load->library( 'Print_Center' );
		$this->load->model( 'agent/crud_model', 'a' );

		$power 		= $this->p->get_power( array( 'power_id' => $power_id ) );
		
		$trans 		= $this->t->get_transmission( null, $power[ 'transmission_id' ] );
		$filename 	= strtolower( str_replace( ' ', '_', $trans->agency_name ) );
		
		
		if( $power[ 'transferred_sub' ] == 'yes' )
		{		
			$agent = $this->a->get_agents( $power[ 'sub_mek' ]);

			$power[ 'agent_first_name' ] 	= $agent->first_name;
			$power[ 'agent_last_name' ] 	= $agent->first_name;
			$power[ 'address' ] 			= $agent->address;
			$power[ 'city' ] 				= $agent->city;
			$power[ 'zip' ] 				= $agent->zip;
			$power[ 'license_number' ]		= $agent->license_number;
			$power[ 'agency_name' ]			= $agent->company;
		}

		$this->print_center->print_power( $power, $filename );	

	} 


	public function execute_power( $trans_id, $power_id )
	{
		
		
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->master_id, $trans_id ),
			'agent'			=> $this->b->get_agents( $this->mek ),
			'jails'			=> $this->j->create_select_array(),
			'sp'			=> $this->p->get_saved_power(),
			'trans_id'		=> $trans_id,
			'power_id'		=> $power_id,
			'role'			=> $this->role
		);
		
		
		if( ! count( $d[ 'sp' ] ) ) $this->set_message( 'This power has either been executed or cancelled', 'info' , '/agent/power_inventory' );
		
		$d[ 'powers' ] 				= $this->p->parse_saved_powers( $d[ 'sp' ][ 'powers' ] );
		$d[ 'parsed_defendant' ] 	= $this->p->parse_saved_defendant( $d[ 'sp' ][ 'defendant' ] );

		
		if( $this->role == 'sub_agent' )
		{
			$d[ 'credits' ] = $this->c->get_credits( $this->master_id );
			if( $d[ 'credits']->credit_count == 0  )
			{
				$this->p->delete_saved_power( $trans_id, $power_id );
				$this->set_message( 'Your master agent has 0 credits, in order to proceed, the master agent will need to purchase more credits', 'error', '/agent/power_inventory' );
			}  
		}
		else
		{
			$d[ 'credits' ] = $this->c->get_credits( $this->mek );
			if( $d[ 'credits']->credit_count == 0 )
			{
				$this->p->delete_saved_power( $trans_id, $power_id );	
				$this->set_message( 'You have 0 credits, please purchase more credits', 'error', '/agent/manage_credits' );
			}  
		}		
		
		
		
		$this->check_transmission( $d['transmission']->paid );
		
		$this->template->write('title', 'Send Power Electronically');
		$this->template->write('sub_title', 'Please fill out the form below to send this power electronically to the prison of your choice.');
		$this->template->write_view('content', $this->view . 'execute_power', $d);
		$this->template->render();		
		
	}
	

	public function process_execute_power_frm()
	{
		if( $this->p->validate_execution_power() )
		{
			$d = $this->sfa();
			
			$this->session->set_userdata( 'jail_id', $d[ 'jail_name' ] );
			
			redirect( '/photo/epower_photo.html' );	

		}	
		else
		{
			$trans_id 	= $this->input->post( 'trans_id' );
			$pek		= $this->input->post( 'pek' );
			$prefix_id	= $this->input->post( 'prefix_id' );			
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->execute_power( $trans_id, $pek );		
		}
	}
	

	public function process_photo()
	{
		$photo = end( explode( '/', $this->input->post( 'photo' ) ) );
		
		$this->session->set_userdata( 'security_image', $photo  );		
		
		exit( json_encode( 'done' ) );
	}

	public function send_powers()
	{
		$d 		= $this->sfa();
		$photo 	= $this->images . '\\' . $this->session->userdata( 'security_image' );
		
		$this->p->save_power();
		$credits = $this->c->get_credits( $this->mek );
		$this->c->update_credits_amount( $this->mek, 1, $credits->credit_count );
		$this->p->send_notifications( $this->mek, $photo );	
		
		$msg = 'Your transmission was successfully sent!';
		
		if( $this->role == 'sub_agent' ) $this->set_message( $msg, 'done', '/agent/power_inventory' );
		$this->set_message( $msg, 'done', '/agent/transmissions' );
		
	}


	public function cancel_power( $trans_id, $power_id )
	{
		$this->p->delete_saved_power( $trans_id, $power_id );
		
		if( $this->role == 'sub_agent' ) redirect( '/agent/power_inventory' );
		
		redirect( '/agent/transmissions' );		
	}


	/*START DISCHARGE A POWER*/

	
	public function process_discharge_frm()
	{
		$d = $this->sfa();
		if( $this->p->validate_discharge_frm() )
		{
			$this->p->discharge_power();	
			$msg = 'You successfully discharged the power';
			$this->set_message( $msg, 'done', '/agent/transmissions/view/' . $this->input->post( 'trans_id' ) );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->discharge( $d[ 'trans_id' ], $d[ 'power_id' ] );
		}
	}
	
	
	
	
	public function discharge( $trans_id, $power_id )
	{
		
		$view = 'discharge_power';
		$d = array(
			'power_id'	=> $power_id,
			'trans_id'	=> $trans_id	
		);

		$this->template->write('title', 'Discharge Power');
		$this->template->write('sub_title', 'The following form will discharge this power');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

		
	}


	/*END DISCHARGE A POWER*/


	/*START VOIDING A POWER*/
	
	public function process_void_frm()
	{
		$d = $this->sfa();
		
		if( $this->p->validate_void_frm() )
		{
			$this->p->void_power();	
			$msg = 'You successfully voided the power';
			$url = '/agent/transmissions/view/' . $this->input->post( 'trans_id' );
			
			if( isset( $d[ 'redirect' ] ) ) $url = '/agent/reports/power_history';
			
			$this->set_message( $msg, 'done', $url );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->void( $d[ 'trans_id' ], $d[ 'power_id' ] );
		}
	}


	public function void( $trans_id, $power_id, $power_details = NULL  )
	{
		
		$view = 'void_power';
		$d = array(
			'power_id'	=> $power_id,
			'trans_id'	=> $trans_id
		);
		
		if( isset( $power_details ) ) $d[ 'power_details' ] = true;
		
		$this->template->write('title', 'Void Power');
		$this->template->write('sub_title', 'The following form will void this power');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

		
	}


	/*END VOIDING A POWER*/

	public function view_history( $power_id )
	{
		
		$d = array(
			'history' => $this->p->get_power_history( $power_id )
		);
		
		$this->template->write('title', 'View Power History');
		$this->template->write('sub_title', 'Your power history is below');
		$this->template->write_view('content', $this->view . 'history', $d);
		$this->template->render();		
		
	}
	

	
/*
	UTILITY METHODS
*/	
	
	private function check_transmission( $trans )
	{
		if( $trans == 'Not Paid' ) show_error( 'You do not have access to this power.', 403 );				
	}
	
	private function check_batch()
	{
		if( ! $this->session->userdata( 'batch_id' ) ) 
		{
			redirect( '/agent/transmissions/' );				
		}
	}
}
