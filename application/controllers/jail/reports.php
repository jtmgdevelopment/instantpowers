<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Jail_Controller {

	private $view;
	private $mek;
	private $jail_id;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'jail/reports/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'jail/jail_report_model', 'reports' );
		$this->load->model( 'jail/jail_crud_model', 'crud' );

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


	public function voided_powers()
	{
		$view = 'view_voided_powers';
		
		$d = array(
			'voided_powers'	=> $this->reports->get_voided_powers( $this->mek )
		
		);


		$this->template->write('title', 'Voided Powers Report');
		$this->template->write('sub_title', 'Below you will find your voided powers in descending order');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}

	public function index()
	{
		$view = 'index';
		$d = array();

		$this->template->write('title', 'Reports');
		$this->template->write('sub_title', 'Please choose the report you would like to view');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
	
	public function view_accepted_powers( $batch_id )
	{


		
		$view = 'view_accepted_powers';
		$d = array(
			'reports' => $this->reports->get_accepted_powers( $batch_id )
		);
			
		$this->template->write('title', 'View Accepted Powers');
		$this->template->write('sub_title', 'Below you will find the accepted powers for this report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}
	
	public function generate_daily_accepted_report()
	{
		$jail = $this->crud->get_jail( array( 'mek' => $this->mek ) );
		
		$this->reports->generate_daily_accepted_report( $jail->jail_id );		
		
		$view = 'confirm_daily_accepted_powers';
		$d = array();
		
		$this->template->write('title', 'Daily Accepted Powers');
		$this->template->write('sub_title', 'Your report will be emailed to you as soon as it is batching.');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	
	}
	
	
	public function daily_accepted_powers()
	{
		
		
		$jail = $this->crud->get_jail( array( 'mek' => $this->mek ) );
		
		$view = 'daily_accepted_powers';
		$params = array(
			'jail_id' => $jail->jail_id
		);
		$d = array(
			'reports' => $this->reports->get_accepted_power_reports( $params )
		);


		$this->template->write('title', 'Daily Accepted Powers');
		$this->template->write('sub_title', 'Below you will find the daily accepted powers');
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

