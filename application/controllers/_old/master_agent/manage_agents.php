<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_agents extends Master_Agent_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'master_agent/manage_agents/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');	

		$this->load->model( 'agent/crud_model', 'a' );
		$script = '
			$(document).ready(function() { 
				$(".zip").mask("99999");
				$(".phone").mask("(999) 999-9999");
			    $(".ssn").mask("999-99-9999");
			}); 			
		'; 
		
		$this->template->add_js( $script, 'embed' );
	

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

