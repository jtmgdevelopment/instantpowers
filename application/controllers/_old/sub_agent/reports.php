<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Sub_Agent_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'sub_agent/reports/';
		$this->mek		= $this->session->userdata( 'mek' );

		$this->load->model( 'agent/master_reports/agents_report_model', 'agent_report' );

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

	public function view_detailed_sub_agent_power_history( $pek, $prefix_id, $sub_mek )
	{
		$view = 'sub_agent_power_detail';
		
		$d = array(
			'power' 	=> $this->agent_report->get_sub_agent_detailed_power( array( 'pek' => $pek, 'prefix_id' => $prefix_id) ),
			'sub_mek'	=> $sub_mek
		);
		
		$d[ 'status'] =  $d['power'][0]['key'];

	
		$this->template->write('title', 'Agent History');
		$this->template->write('sub_title', 'Detailed Power History');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
		
	}
	

	public function index()
	{
		$view = 'index';
		$d = array();

		$this->template->write('title', 'Power History');
		$this->template->write('sub_title', 'View your power history');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
	
	
	public function power_history()
	{
		$view = 'list_sub_agent_powers';
		$d = array(
			'powers' 	=> $this->agent_report->get_sub_agent_powers( array( 'mek' => $this->mek ) ),
			'sub_mek'	=> $this->mek
		);		

		
		$this->template->write('title', 'Power History');
		$this->template->write('sub_title', 'Your Power History Report');
		$this->template->write_view('content', $this->view .  $view, $d);
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

