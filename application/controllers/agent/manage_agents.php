<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_agents extends Agent_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'agent/manage_agents/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');	

		$this->load->model( 'agent/crud_model', 'a' );
		$this->load->model( 'insurance/insurance_crud_model', 'i' );
		$this->load->model( 'premium/premium_crud_model', 'p' );
		$script = '
			$(document).ready(function() { 
				$(".zip").mask("99999");
				$(".phone").mask("(999) 999-9999");
			    $(".ssn").mask("999-99-9999");
			}); 			
		'; 
		
		$this->template->add_js( $script, 'embed' );
	

	}
	
	public function add_premiums( $mek, $ins )
	{
		
		$d = array(
			'premium' => array( 
				array(
					'premium' 	=> '0.00',
					'buf' 		=> '0.00'
				) 
			),
			'ins'		=> $ins,
			'premium_id'=> 0, 	
			'mek'		=> $mek
		);
		
		$view = 'edit_premium';
		
		$this->template->write('title', 'Premium Information');
		$this->template->write('sub_title', 'Below you will can add premium information for the agent');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}
	
	public function edit_premiums( $mek, $premium_id, $ins )
	{
		
		$d = array(
			'premium' 	=> $this->p->get_premiums( array( 'premium_id' => $premium_id ) ),
			'ins'		=> $ins,
			'premium_id'=> $premium_id,
			'mek'		=> $mek
		);
		
		
		$view = 'edit_premium';
		
		$this->template->write('title', 'Premium Information');
		$this->template->write('sub_title', 'Below you will find this agent&rsquo;s premium information');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	}

	public function list_contract_rates_by_agent( $mek, $ins )
	{
		$params = array(
			'mek'					=> $mek,
			'transmitter_id' 		=> $ins
		);
		

		$d = array(
			'premiums' 	=> $this->p->get_premiums( $params ),
			'agent'		=> $this->a->get_sub_agents( array( 'sub_mek' => $mek ) ),
			'vars'		=> $params			
		);

		
		$view = 'list_agents_premium';
		
		$this->template->write('title', 'Premium Information');
		$this->template->write('sub_title', 'Below you will find this agent&rsquo;s premium information');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}
	


	public function process_ins_contracts_frm()
	{

		$d = $this->sfa();
		if( $this->a->validate_ins_contract_frm() )
		{
			
			$url = $this->view . 'list_contract_rates_by_agent/' . $d[ 'mek' ] . '/' . $d[ 'ins_agency' ];
			redirect( $url );
		}
		else
		{
			
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->list_contract_rates( $d['mek'] );			
		}		
		
		
		
	}

	public function list_contract_rates( $mek )
	{

		$view = 'list_ins_agency_for_contract_rates';
		
		$ins = $this->a->get_transmission_agencies( $this->mek );

		$params = array(
			'data'		=> $ins,
			'id_opt'	=> 'mek',
			'val_opt'	=> 'company',
			'default'	=> 'Select Transmitting Company'
		);		

		$d = array(
			'ins'	=> $this->create_sub_select_array( $params ),
			'mek'	=> $mek
		);

		$this->template->write('title', 'Choose Insurance Company');
		$this->template->write('sub_title', 'Use this admin to set the contract per insurance company');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}

	public function process_add()
	{
		$d = $this->sfa();
		if( $this->a->validate_sub_agent_add() )
		{
			$this->a->add_sub_agent( $this->mek );
			$msg = 'Agent successfully added.';
			$this->set_message( $msg, 'done', $this->view );
		}
		else
		{
			
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->add( $d['mek'] );			
		}		
		
	}



	public function process_edit()
	{
		$d = $this->sfa();
		if( $this->a->validate_sub_agent_edit() )
		{
			$this->a->update_sub_agent( $d );
			$msg = 'Agent successfully updated.';
			$this->set_message( $msg, 'done', $this->view );
		}
		else
		{
			
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->edit( $d['mek'] );			
		}		
		
	}

	public function add()
	{
		
		$view = 'add';
		$d = array(		
			'agent' => array()
		);
		
		$this->template->write('title', 'Add Sub Agent');
		$this->template->write('sub_title', 'Use this admin to add this sub agent');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}



	public function edit( $mek )
	{
		
		$view = 'edit';
		$d = array(
			'agent' => ( array ) $this->a->get_sub_agents( array( 'sub_mek' => $mek ) )
		);
		
		$this->template->write('title', 'Edit Sub Agent');
		$this->template->write('sub_title', 'Use this admin to edit this sub agent');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}

	public function process_activate( $mek )
	{
		
		$this->a->activate_agent( array( 'mek' => $mek ) );
		$msg = 'This agent has been activated';
		$this->set_message( $msg, 'done' , $this->view . '/index' );	
		
	}
	
	
	public function process_deactivate( $mek )
	{
		$this->a->deactivate_agent( array( 'mek' => $mek ) );
		$msg = 'This agent has been deactivated';
		$this->set_message( $msg, 'done' , $this->view . '/index' );	
		
	}

	public function activate( $mek )
	{
		$view = 'activate';
		$d = array(
			'sub_agent' => $this->a->get_sub_agents( array( 'sub_mek' => $mek ) )
		);

		$this->template->write('title', 'Activate Sub Agent');
		$this->template->write('sub_title', 'Use this admin to activate this sub agent');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}
	
	public function deactivate( $mek )
	{
		$view = 'deactivate';
		
		$d = array(
			'sub_agent' => $this->a->get_sub_agents( array( 'sub_mek' => $mek ) )
		);

		$this->template->write('title', 'Deactivate Sub Agent');
		$this->template->write('sub_title', 'Use this admin to deactivate this sub agent');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}


	public function index()
	{
		$view = 'index';
		$d = array(
			'sub_agents' => $this->a->get_sub_agents( array( 'mek' => $this->mek ) )
		);

		$this->template->write('title', 'Manage Sub Agents');
		$this->template->write('sub_title', 'Use this admin to manage your sub agents');
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

