<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class power_inventory extends Sub_Agent_Controller {

	private $view;
	private $mek;

	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'sub_agent/powers/power_inventory/';
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
		
		$script = "
			$(document).ready(function() { 
		    	$('table.tablesorter') 
			    	.tablesorter({widthFixed: false}) 
				    .tablesorterPager({container: $('#pager')}); 
			}); 			
		"; 

	}


	
	public function index( $type = 'inventory' )
	{

		$view = 'index';
		$d = array(
			'inventory' => $this->p->get_sub_agent_inventory( array( 'mek' => $this->mek , 'key' => $type ) ),
			'type' => $type
		
		);
		$this->session->unset_userdata( 'print' );

		$this->template->write('title', 'Power Inventory');
		$this->template->write('sub_title', 'Your Current Inventory');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		

	}
}

