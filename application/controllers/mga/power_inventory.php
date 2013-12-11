<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class power_inventory extends MGA_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'mga/power_inventory/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'power_prefixes/prefix_crud_model', 'prefix' );
		$this->load->model( 'mga/mga_power_inventory_model','pim' );
		$this->load->model( 'agent/crud_model', 'a' );
		$this->load->model( 'mga/bail_agency_model', 'b' );
		$this->load->model( 'agency/agency_crud_model', 'agency' );


		$this->load->helper('state');
		$this->load->helper('html');		
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');	
		$this->template->add_js( '_assets/js/libs/tablesorter/jquery.tablesorter.min.js' );	
		$this->template->add_js( '_assets/js/libs/tablesorter/jquery.tablesorter.pager.js' );	
		$this->template->add_js( '_assets/js/libs/underscore/underscore-min.js' );	
		$this->template->add_js( '_assets/js/mga/inventory.js' );	
		$script = "
			$(document).ready(function() { 
		    	$('table.tablesorter') 
			    	.tablesorter({widthFixed: false}) 
				    .tablesorterPager({container: $('#pager')}); 
			}); 			
		"; 
		
		$this->template->add_js( $script, 'embed' );
	

	}


	public function complete_transfer()
	{
		$data = $this->session->userdata( 'transfer' );		
		
		$this->pim->transfer_powers( $this->mek );
		
		$msg = 'You successfully transferred the powers to the agency';
		$this->set_message( $msg, 'done', '/mga/power_inventory' );
		
	}
	
	public function confirm_transfer( $d )
	{
		$data = array(
			'keys' => array_keys( $d ),
			'form' => $d,
			'agent'=> $this->agency->get_agency( array( 'bail_agency_id' => $d[ 'agencies' ] ) )
		);
		
		
		
		$data[ 'powers' ] = $this->pim->list_powers_to_transfer( $d, $this->mek );
		
		
		$this->session->set_userdata( 'transfer' , $data );
				
		$view = 'confirm_transfer';
		
		$this->template->write('title', 'Confirm Power Transfer');
		$this->template->write('sub_title', 'Confirm The Transfer Of Powers below');
		$this->template->write_view('content', $this->view . $view, $data);
		$this->template->render();		
	}



	public function process_transfer_powers()
	{
		
		if( $this->pim->validate_transfer( $this->mek ) )
		{
			$d = $this->sfa();
			$this->confirm_transfer( $d );

		}
		else
		{	
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->initiate_transfer();
			
		}
		
		
	}



	public function initiate_transfer()
	{
		
		$view = 'initiate_transfer';
		
		$d = array(
			'power_breakdown' => $this->pim->get_mga_power_breakdown( array( 'mek' => $this->mek ) ),
			'agents'	=> $this->b->list_agencies( $this->mek )
		);		
		$d[ 'agents' ] = $this->create_sub_select_array( array( 'data' => $d[ 'agents' ], 'id_opt' => 'bail_agency_id', 'val_opt' => 'agency_name', 'default' => 'Choose Agency' ) ); 
		
		
		
		$this->template->write('title', 'Power Transfer');
		$this->template->write('sub_title', 'Create The Transfer Of Powers below');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}


	public function process_recoup_powers()
	{
		$f = $this->sfa();	
		
		$this->pim->process_recoup( $f );
		
		
	}



	public function get_powers_to_recoup()
	{
		
		if( $this->pim->validate_recoup_frm() )
		{	
		
			$f = $this->sfa();
			
			$agent = $this->a->get_master_agent( array( 'agency_id' => $f[ 'bail_agency' ] ) );
			
			
					
			$d = array(
				'recoup' => $this->pim->get_inventory_powers_recoup( array( 'mek' => $this->mek,  'agent_id' => $agent->mek ) )
			);
			
			
			$view = 'list_powers_to_recoup';
			$this->template->write('title', 'Recoup Powers');
			$this->template->write('sub_title', 'The powers below can be recouped. ');
			$this->template->write_view('content', $this->view . $view, $d);
			$this->template->render();		

		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->recoup_powers();
		}
		
		
	}


	public function recoup_powers()
	{
		
		$view = 'choose_agent_recoup';
		
		$d = array(
			'agents'	=> $this->b->list_agencies( $this->mek )
		);		
		$d[ 'agents' ] = $this->create_sub_select_array( array( 'data' => $d[ 'agents' ], 'id_opt' => 'bail_agency_id', 'val_opt' => 'agency_name', 'default' => 'Choose Agency' ) ); 


		$this->template->write('title', 'Choose Agent');
		$this->template->write('sub_title', 'Choose the agent you would like to transfer powers to');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}

	public function process_transfer()
	{
		$this->pim->transfer_powers( $this->mek );	
		$msg 	= 'You successfully transferred powers to this agent.';
		$url	= '/mga/power_inventory/';
		$this->set_message( $msg, 'done', $url );
		
	}

	public function choose_agent()
	{
		
		$view = 'choose_agent';
		$d = array(
			'agents'	=> $this->b->list_agencies( $this->mek )
		);		
		$d[ 'agents' ] = $this->create_sub_select_array( array( 'data' => $d[ 'agents' ], 'id_opt' => 'bail_agency_id', 'val_opt' => 'agency_name', 'default' => 'Choose Agency' ) ); 


		$this->template->write('title', 'Choose Agent');
		$this->template->write('sub_title', 'Choose the agent you would like to transfer powers to');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}


	public function index( $message = NULL )
	{
		$view = 'index';
		$d = array(
			'inventory'	=> $this->pim->get_inventory( array( 'mek' => $this->mek ) ),
			'prefixes'	=> $this->prefix->get_prefixes(),
			'message'	=> $message,
			'power_breakdown' => $this->pim->get_mga_power_breakdown( array( 'mek' => $this->mek ) ),
		);


		$this->template->write('title', 'Power inventory');
		$this->template->write('sub_title', 'View your power inventory below');
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

