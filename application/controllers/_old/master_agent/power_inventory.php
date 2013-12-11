<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class power_inventory extends Master_Agent_Controller {

	private $view;
	private $mek;

	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'master_agent/powers/power_inventory/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->images	= realpath( './uploads/images/' );		
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->load->model( 'transmissions/transmissions_model' , 't' );
		$this->load->model( 'powers/power_inventory_model', 'p' );
		$this->load->model( 'agent/crud_model', 'b' );
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');	
		$this->template->add_js( '_assets/js/libs/tablesorter/jquery.tablesorter.min.js' );	
		$this->template->add_js( '_assets/js/libs/tablesorter/jquery.tablesorter.pager.js' );	
		$this->template->add_js( '_assets/js/libs/underscore/underscore-min.js' );	
		$this->template->add_js( '_assets/js/powers/inventory.js' );	
		$script = "
			$(document).ready(function() { 
		    	$('table.tablesorter') 
			    	.tablesorter({widthFixed: false}) 
				    .tablesorterPager({container: $('#pager')}); 
			}); 			
		"; 
		
		$this->template->add_js( $script, 'embed' );
	}

	public function process_recoup_powers()
	{

		$d = $this->sfa();
		$powers = explode( ',' , $d['recoup'] );
		
		

		$this->p->save_recoup_powers( $powers );	
		$this->p->notify_sub_agent_recoup( $powers );
		
		return true;

	}


	public function recoup_powers()
	{
		
		$view = 'recoup_powers';
		
		$d = array(
			'transfers' => $this->p->get_sub_agent_powers( array( 'mek' => $this->mek ) )

		);

		$this->template->write('title', 'Recoup Powers');
		$this->template->write('sub_title', 'Current Powers Transferred Out');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}


	public function process_sub_agent_transfers_powers()
	{
		if( $this->p->validate_sub_agent_transfer_powers_frm() )
		{
			$this->p->save_transfer_powers();
			$this->p->notify_sub_agent_transfers();	
			$msg = 'You successfully transferred the powers to the sub agent';
			$this->set_message( $msg, 'done', '/master_agent/power_inventory' );
		}
		else
		{	
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->choose_sub_agent();
			
		}
		
		
	}


	public function choose_sub_agent()
	{
		
		$view = 'choose_sub_agent';
		
		$d = array(
			'transfer' 		=> $this->p->get_temp_transfer_powers(),
			'sub_agents' 	=> $this->b->create_sub_select_array(  $this->mek  )
		);


		$this->template->write('title', 'Power Inventory');
		$this->template->write('sub_title', 'Your Current Inventory');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		


		
	}

	
	public function process_transfer_powers()
	{
		$this->p->save_temp_transfer_powers();	
	}



	public function index( $message = NULL )
	{

		$view = 'index';
		$d = array(
			'inventory' => $this->p->get_inventory( array( 'mek' => $this->mek , 'key' => 'inventory' ) ),
			'message'	=> NULL
		
		);
		
		$this->session->unset_userdata( 'print' );
		
		if( $message ) $d[ 'message' ] = 'Powers successfully recouped.';
		
		$this->template->write('title', 'Power Inventory');
		$this->template->write('sub_title', 'Your Current Inventory');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		

	}
}

