<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Master_Agent_Controller {

	private $view;
	private $mek;

	public function __construct()
	{
		parent::__construct();
		$this->view = 'master_agent/reports/';
		$this->mek	= $this->session->userdata( 'mek' );
		$this->load->model( 'transmissions/transmissions_model' , 't' );
		$this->load->model( 'credits/credits_model', 'c' );
		$this->load->model( 'powers/power_model', 'p' );
		$this->load->model( 'agent/crud_model', 'a' );
		$this->load->model( 'premium/premium_crud_model', 'premium' );
		$this->load->model( 'insurance/insurance_crud_model', 'i' );
		
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

	public function transmit_master_report( $ins_id )
	{
		//create report record
		$params = array( 'mek' => $this->mek, 'ins_id' => $ins_id );
		$this->agent_report->create_report_record( $params );	
		
		$msg = 'You successfully transmitted your master report';
		$url = '/master_agent/reports';
		$this->set_message( $msg, 'done', $url );
		
	}
	
	public function submit_master_agent_report( $ins_id )
	{
		$view = 'submit_master_agent_report';		
	
		$d = array(
			'ins'		=> $this->i->get_insurance_agent( array( 'ins_id' => $ins_id ) )			
		);			
		
		
		$this->template->write('title', 'Submit Master Agent Report');
		$this->template->write('sub_title', 'Are you ready to transmit report?');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}



	public function generate_master_report( $ins_id )
	{
		//check to see if the agent has	premium/BUF
		$view = 'master_agent_report_view';		
		$params = array(
			'mek' 					=> $this->mek,
			'insurance_agency_id' 	=> $ins_id,
			'row'					=> true
		);
		$premium = $this->premium->get_premiums( $params );
	
		if( ! count( $premium ) )
		{
			$msg = 'You will need to set a premium/BUF for this insurance company before you can generate a master report. Please navigate to "Edit Account" to add this';
			$url = safe_url( '/master_agent/reports', 'master_agent_report' );		
			$this->set_message( $msg, 'info', $url );
		}
		
		//get the power
		$params = array( 
			'ins_company_id' 	=> $ins_id, 
			'premium'			=> $premium[ 'premium' ],
			'buf'				=> $premium[ 'buf' ],
			'mek'				=> $this->mek	
		);
		
		
		$d = array(
			'report' 	=> $this->agent_report->get_powers_for_master_report( $params ),
			'ins'		=> $this->i->get_insurance_agent( array( 'ins_id' => $ins_id ) ),
			'premium'	=> $premium[ 'premium' ],
			'buf'		=> $premium[ 'buf' ]		
		);			
	

		$d[ 'totals' ] = $this->agent_report->get_master_report_total( $d[ 'report' ] );
	
		$this->template->write('title', 'Master Agent Report');
		$this->template->write('sub_title', 'Below you will find your report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		


	}


	public function process_ins_company_frm()
	{
		if( $this->agent_report->validate_ins_choose_frm() )
		{
			$d 		= $this->sfa();			
			$url 	= safe_url( '/master_agent/reports', 'generate_master_report', array( $d[ 'ins_company' ] ) );
			redirect( $url );
		}
		else
		{

			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->master_agent_report();			
		}			
	}

	
	public function master_agent_report()
	{
		
		$view = 'master_agent_report';		
	
		$params = array(
			'data' 		=> $this->i->get_insurance_companies_by_bail_agent( array( 'mek' => $this->mek ) ),
			'default' 	=> 'Select An Insurance Company',
			'id_opt' 	=> 'insurance_agency_id',
			'val_opt'	=> 'agency_name'
		);
		
		$d[ 'ins' ] = $this->create_sub_select_array( $params ); 	
		
		$this->template->write('title', 'Master Agent Report');
		$this->template->write('sub_title', 'Generate A Master Agent Report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	
		
		
	}
	
	
	
	
	public function power_history()
	{
		$view = 'power_history';		
		$d = array(
			'history' 	=> $this->agent_report->get_power_history( array( 'mek' => $this->mek ) ),
			'mek'		=> $this->mek
			
		);	

		
		$this->template->write('title', 'Power History');
		$this->template->write('sub_title', 'Your Power History Report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}



	public function process_sub_agents_clear_credits()
	{
		$d = $this->sfa();	
		
		
		$this->agent_report->clear_sub_agent_credits( $d['clear'] );
		$msg = 'The selected sub agent credits have been cleared.';
		$this->set_message( $msg, 'done' , '/master_agent/reports/view_sub_agent_credit_usage' );
	}



	public function credit_usage_report( array $args )
	{
		$view = 'credit_usage_report';
		
		$d = array(
			'credits' 		=> $this->agent_report->get_sub_agent_credit_usage( $args ),
			'start_date' 	=> $args['startdate'],
			'end_date'		=> $args['enddate']
		);

		$this->template->write('title', 'Credit History');
		$this->template->write('sub_title', 'Sub Agent Credit History Report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
			
		
		
	}






	public function process_sub_agent_credit_usage()
	{
		if( $this->agent_report->validate_sub_agent_credit_usage() )
		{
			$d = $this->sfa();
			$args = array( 'mek' => $this->mek, 'startdate' => $d['start_date'], 'enddate' => $d['end_date'] );	
			$this->credit_usage_report( $args );
			return false;
		}
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->view_sub_agent_credit_usage();			
		}
	}
	






	public function view_sub_agent_credit_usage()
	{
		
		$view = 'sub_agent_credit_usage';
		
		$d = array(
		);

		$this->template->write('title', 'Credit History');
		$this->template->write('sub_title', 'Sub Agent Credit History');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
		
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
	
	
	
	
	
	
	public function view_sub_agent_history( $sub_mek )
	{
		$view = 'list_sub_agent_powers';
		$d = array(
			'powers' 	=> $this->agent_report->get_sub_agent_powers( array( 'mek' => $sub_mek ) ),
			'sub_mek'	=> $sub_mek
		);		
		
		
		$this->template->write('title', 'Agent History');
		$this->template->write('sub_title', 'Agents Power History');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}



	
	
	
	public function process_sub_agent_history()
	{
		
		if( $this->agent_report->validate_sub_agent_history_frm() )
		{
			$d = $this->sfa();
			redirect( '/master_agent/reports/view_sub_agent_history/' . $d[ 'sub_agent' ]);
		}
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->sub_agent_power_history();		
		}
	}
	





	public function sub_agent_power_history()
	{
		
		$view = 'sub_agent_power_history';
		$d = array(	
			'agents' => $this->a->create_sub_select_array( $this->mek )
		);
		
	
		$this->template->write('title', 'Sub Agent History');
		$this->template->write('sub_title', 'Power History');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	
	}


	public function index()
	{
		
		$view = 'index';
		$d = array(	
		);


		$this->template->write('title', 'Reports');
		$this->template->write('sub_title', 'Choose The Report You would Like To View');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

		
	}
}

