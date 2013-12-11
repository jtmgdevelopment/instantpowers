<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class activity extends Insurance_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'insurance/activity/';
		$this->mek		= $this->session->userdata( 'mek' );
		
		$this->load->model( 'agency/agency_crud_model', 'a' );
		$this->load->model( 'agency/agency_activity_model', 'act' );
		$this->load->model( 'agent/master_reports/agents_report_model', 'report' );
		$this->load->model( 'agent/crud_model', 'agent' );
		
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
	
	public function view_activity( $agency_id )
	{
		
		$d = array(
			'activity' => $this->act->get_agency_activity( array( 'agency_id' => $agency_id ) )
		);	
		
		$view = 'view_power_activity';
		
		$this->template->write('title', 'Choose Agency');
		$this->template->write('sub_title', 'Choose the Agency you would like to view');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}
	
	
	public function process_choose_agency_frm()
	{
		if( $this->act->validate_agency_frm() )
		{
			$d = $this->sfa();
			$url = safe_url( '/insurance/activity', 'view_activity', array( $d[ 'bail_agency' ] ) );
			redirect( $url );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->index();
		}
		
	}

	public function index()
	{
		$view = 'index';
		$agencies = $this->a->get_agency_by_ins( array( 'ins_agent_id' => $this->mek ) );
		
		$params = array( 
			'data' 		=> $agencies,
			'default'	=> 'Please select Bail Agency',
			'id_opt'	=> 'bail_agency_id',
			'val_opt'	=> 'agency_name'
		);
		
			 
		$d = array(
			'agencies' => $this->create_sub_select_array( $params )
		);

		$this->template->write('title', 'Choose Agency');
		$this->template->write('sub_title', 'Choose the Agency you would like to view');
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

