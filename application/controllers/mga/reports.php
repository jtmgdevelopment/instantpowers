<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends MY_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'mga/reports/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'mga/mga_crud_model', 'mga' );
		$this->load->model( 'mga/mga_report_model', 'reports' );
		$this->load->model( 'mga/bail_agency_model', 'bail' );
		$this->load->model( 'transmissions/transmissions_model' , 't' );
		$this->load->model( 'powers/power_model', 'p' );
		$this->load->model( 'premium/premium_crud_model', 'premium' );
		$this->load->model( 'insurance/insurance_crud_model', 'i' );
		$this->load->model( 'agent/master_reports/agents_report_model', 'agent_report' );
		$this->load->model( 'agent/crud_model', 'agent' );
		
		
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


	public function agent_current_report()
	{
		$view 	= 'agent_current_report';
		$frm 	= $this->sfa();
		$d 		= array();
		
		$master_agent = $this->agent->get_master_agent( array( 'agency_id' => $frm[ 'bail_agency' ] ) );
		
		$params = array(
			'mek' 					=> $master_agent->mek,
			'transmitter_id' 		=> $this->mek,
			'row'					=> true
		);

		$premium = $this->premium->get_premiums( $params );


		//get the power
		$params = array( 
			'mga_id' 			=> $this->mek, 
			'premium'			=> $premium[ 'premium' ],
			'buf'				=> $premium[ 'buf' ],
			'mek'				=> $master_agent->mek		
		);
		
		$d = array(
			'report' 	=> $this->agent_report->get_powers_for_master_report( $params ),
			'premium'	=> $premium[ 'premium' ],
			'buf'		=> $premium[ 'buf' ]
		);			

		$d[ 'totals' ] = $this->agent_report->get_master_report_total( $d[ 'report' ] );
		$d[ 'groups' ] = $this->agent_report->get_grouped_powers_for_master_report( $params, $master_agent->mek );
				
		
		$this->template->write('title', 'Reports');
		$this->template->write('sub_title', 'Below you will find your report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();				
	}

	public function list_agencies()
	{
		$view = 'list_agencies';
		$d = array(
			'path' 		=> '/mga/reports/agent_current_report',
			'agencies' 	=> $this->bail->list_agencies( $this->mek )
		);		

		$params = array(
			'data'      => $this->bail->list_agencies( $this->mek ),
			'default' 	=> 'Select Bail Agency',
			'id_opt' 	=> 'bail_agency_id',
			'val_opt'	=> 'agency_name'
		);

		$d[ 'agencies' ] = $this->create_sub_select_array( $params ); 	
		

		$this->template->write('title', 'Current Reports');
		$this->template->write('sub_title', 'Please select the agency you would like to view');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	}


	public function view_agency_mar_report( $report_id, $agency_mek )
	{
		
		$view = 'view_agency_mar_report';


		//set the params to get the premiums
		$params = array(
			'mek' 					=> $agency_mek,
			'transmitter_id' 		=> $this->mek,
			'row'					=> true
		);
		
		//get the premiums
		$premium = $this->premium->get_premiums( $params );
		
		
		
		if( ! count( $premium ) )
		{
			$msg = 'You will need to set a premium/BUF for this insurance company before you can generate a mga report. Please navigate to "Edit Account" to add this';
			$url = safe_url( '/mga/reports', 'index' );		
			$this->set_message( $msg, 'info', $url );
		}


		//get the power
		$params = array( 
			'premium'			=> $premium[ 'premium' ],
			'buf'				=> $premium[ 'buf' ],
			'mek'				=> $this->mek,
			'premium'			=> $premium,
			'report_id'			=> $report_id,
			'archived'			=> true,
			'reported'			=> true
		
		);
		
		
		
		$d = array(
			'report'         => $this->reports->get_powers_for_mga_report( $params ),
			'premium'        => $premium[ 'premium' ],
			'buf'            => $premium[ 'buf' ],
			'agency_name'    => $premium[ 'agency_name' ],
			'sub_agent'      => 0,
			'mek'            => $this->mek,
			'report_id'		 => $report_id
		);			
		
		
		$d[ 'totals' ] = $this->reports->get_master_report_total( $d[ 'report' ] );



		$d[ 'groups' ] = $this->reports->get_grouped_powers_for_master_report( $params );

	

		$this->template->write('title', 'Reports');
		$this->template->write('sub_title', 'Below you will find your report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}


	public function get_bail_agency_reports()
	{
		$d = $this->sfa();
		$d = array(
			'reports' 		=> $this->reports->list_reports_by_agency( array( 'mek' => $d[ 'bail_agencies' ] , 'mga_id' => $this->mek ) ),
			'agency_mek'	=> $d[ 'bail_agencies' ]
		);		
		

		$view = 'get_bail_agency_reports';
		$this->template->write('title', 'Agency Reports');
		$this->template->write('sub_title', 'Below you will find the agencies reports');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	}
	
	public function choose_bail_agency()
	{
		$agencies = $this->bail->list_agencies( $this->mek );
	
		$opts = array(
			'data' 		=> $agencies,
			'id_opt'	=> 'mek',
			'val_opt'	=> 'agency_name'		
		);
		
		$d = array(
			'agencies' => $this->create_sub_select_array( $opts )
		);
		
		
		$view = 'choose_bail_agency';
		$this->template->write('title', 'Choose Bail Agency');
		$this->template->write('sub_title', 'Choose Bail Agency to list reports from');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	}
	
	
	public function print_power_copy( $trans_id, $power_id )
	{
		
		$this->load->model( 'powers/power_model' , 'power' );
		$this->load->model( 'agent/crud_model', 'agent' );
		$this->load->library( 'Print_Center' );
				
		$agent = $this->agent->get_agent_by_power( array( $power_id ) );
		
		
		$d = array(
			'transmission'	=> $this->t->get_transmission( $agent->mek, $trans_id ),
			'p' 			=> $this->p->get_power( array( 'power_id' => $power_id ) ),
		);
		
		
		$filename = strtolower( str_replace( ' ', '_', $d[ 'transmission' ]->agency_name ) );


		$this->print_center->print_power( $d[ 'p' ], $filename );
		
	}
	
	
	public function view_power( $trans_id, $power_id )
	{
		
		$this->load->model( 'powers/power_model' , 'power' );
		$this->load->model( 'agent/crud_model', 'agent' );
		$this->load->helper( array( 'power_helper', 'html_helper' ) );
	
				
		$agent = $this->agent->get_agent_by_power( array( $power_id ) );
		
		
		$d = array(
			'transmission'	=> $this->t->get_transmission( $agent->mek, $trans_id ),
			'p' 			=> $this->p->get_power( array( 'power_id' => $power_id ) ),
			'agent' 		=> $agent,
			'power_id' 		=> $power_id
		);
		
		
		$filename = strtolower( str_replace( ' ', '_', $d[ 'transmission' ]->agency_name ) );
		
		$file_path = '/agent/reports/power_template/' . $filename;		
		
		$d[ 'filename' ] = $filename;	

						
		$this->load->view( $file_path, $d );		
	}

	
	public function view_detailed_agent_power_history( $power_id )
	{
	
		$view = 'power_detail';
		
		$this->load->model( 'powers/power_model' , 'power' );
		$this->load->model( 'agent/reports', 'agent_report' );

		$d = array(
			'power' 	=> $this->agent_report->get_agent_detailed_power( array( 'power_id' => $power_id ) ),
			'power_id'	=> $power_id,
			'power_details' => $this->power->get_power( array( 'power_id' => $power_id ) )
		);
		
		$d[ 'status'] =  $d['power'][0]['key'];
		

		$this->template->write('title', 'Power History');
		$this->template->write('sub_title', 'Detailed Power History');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
		
	}
	
	
	public function list_power_history( $agency_id, $status = NULL )
	{
		$d = array(
			'history' => $this->reports->list_powers_by_agency( $agency_id, $status, $this->mek ),
			'agency_id'	=> $agency_id
		);
		
		$view = 'power_history';

		$this->template->write('title', 'Power History');
		$this->template->write('sub_title', 'View The Power History For this bail agency');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

		
		
	}
	
	
	public function process_power_history()
	{
		if( $this->reports->validate_power_history_frm() )
		{
			$d 		= $this->sfa();			
			
			$url 	= safe_url( '/mga/reports', 'list_power_history', array( $d[ 'bail_agency' ] ) );
			redirect( $url );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->choose_agency();
		}

	}
	
	public function choose_agency()
	{
		$view 	= 'choose_agency';
		$d		= array(
			'agencies' => $this->bail->list_agencies( $this->mek )
		);		

		$params = array(
			'data'            => $this->bail->list_agencies( $this->mek ),
			'default' 	=> 'Select Bail Agency',
			'id_opt' 	=> 'bail_agency_id',
			'val_opt'	=> 'agency_name'
		);
		
		
		$d[ 'agencies' ] = $this->create_sub_select_array( $params ); 	
		
		$this->template->write('title', 'Choose Bail Agency');
		$this->template->write('sub_title', 'select the bail agency');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	}
	


	public function choose_ins_company()
	{
		
		$view = 'choos_ins_company';
		$d = array(
			'process_url'    => '/mga/reports/process_past_mga_report'
		);

		$params = array(
			'data'            => $this->mga->get_insurance_companies( $this->mek ),
			'default' 	=> 'Select Insurance Company',
			'id_opt' 	=> 'insurance_agency_id',
			'val_opt'	=> 'agency_name'
		);
		
		
		
		$d[ 'ins' ] = $this->create_sub_select_array( $params ); 	

		$this->template->write('title', 'View Past MGA Report');
		$this->template->write('sub_title', 'select the insurance agency');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}	


	public function process_past_mga_report()
	{
		if( $this->reports->validate_new_mga_report_frm() )
		{
			$d 		= $this->sfa();			
			$url 	= safe_url( '/mga/reports', 'view_past_mar', array( $d[ 'ins_company' ] ) );
			redirect( $url );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->choose_ins_company();
		}
	}


	public function view_mar_report( $report_id, $ins_id, $report_number )
	{
		
		$view = 'view_mar_report';


		//set the params to get the premiums
		$params = array(
			'mek' 					=> $this->mek,
			'transmitter_id' 		=> $ins_id,
			'row'					=> true
		);
		
		//get the premiums
		$premium = $this->premium->get_premiums( $params );
		
		if( ! count( $premium ) )
		{
			$msg = 'You will need to set a premium/BUF for this insurance company before you can generate a mga report. Please navigate to "Edit Account" to add this';
			$url = safe_url( '/mga/reports', 'index' );		
			$this->set_message( $msg, 'info', $url );
		}


		//get the power
		$params = array( 
			'ins_company_id' 	=> $ins_id, 
			'premium'			=> $premium[ 'premium' ],
			'buf'				=> $premium[ 'buf' ],
			'mek'				=> $this->mek,
			'premium'			=> $premium,
			'archived'			=> true,
			'report_id'			=> $report_id
		
		);
		
		$d = array(
			'report'         => $this->reports->get_powers_for_mga_report( $params ),
			'ins_id'         => $ins_id,
			'premium'        => $premium[ 'premium' ],
			'buf'            => $premium[ 'buf' ],
			'agency_name'    => $premium[ 'agency_name' ],
			'sub_agent'      => 0,
			'mek'            => $this->mek,
			'report_id'		 => $report_id
		);			
		
		
		$d[ 'totals' ] = $this->reports->get_master_report_total( $d[ 'report' ] );



		$d[ 'groups' ] = $this->reports->get_grouped_powers_for_master_report( $params );

		

		$this->template->write('title', 'Reports');
		$this->template->write('sub_title', 'Below you will find your report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}

	public function view_past_mar( $ins_id )
	{
		
		$view = 'view_past_mar';
		$ins_agent = $this->i->get_insurance_agent( array( 'ins_id' => $ins_id ) );

		$d = array(
			'reports' => $this->reports->get_report_list( array( 'mek' => $this->mek, 'ins_id' => $ins_agent->mek ) )
		);

		$this->template->write('title', 'Reports Cpanal');
		$this->template->write('sub_title', 'Please Choose Your Report Action');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}


	public function index()
	{
		$view = 'index';
		$d = array();

		$this->template->write('title', 'Reports Cpanal');
		$this->template->write('sub_title', 'Please Choose Your Report Action');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
	
	public function transmit_mga_report( $ins_id )
	{
		
		//set the params to get the premiums
		$params = array(
			'mek' 					=> $this->mek,
			'transmitter_id' 		=> $ins_id,
			'row'					=> true
		);
		
		
		//get the premiums
		$premiums= $this->premium->get_premiums( $params );

		
		
		//create report record
		$params = array( 'mek' => $this->mek, 'ins_id' => $ins_id,  'premium' => $premiums );

		$this->reports->create_report_record( $params );	
		
		$msg = 'You successfully transmitted your master report';
		$url = '/mga/reports';
		$this->set_message( $msg, 'done', $url );
		
		
	}
	
	
	public function submit_mga_agent_report( $ins_id )
	{

		$view = 'submit_mga_report';		
	
		$d = array(
			'sub_agent'	=> false,
			'ins_id'	=> $ins_id		
		);			

		//set the params to get the premiums
		$params = array(
			'mek' 					=> $this->mek,
			'transmitter_id' 		=> $ins_id,
			'row'					=> true
		);
		
		
		//get the premiums
		$d[ 'ins' ] = $this->premium->get_premiums( $params );

		
		$title 			= 'Submit MGA Report';
		
		
		
		$this->template->write('title', $title);
		$this->template->write('sub_title', 'Are you ready to transmit report?');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}
	
	public function generate_mga_report( $ins_company_id )
	{

		$ins_agent = $this->i->get_insurance_agent( array( 'ins_id' => $ins_company_id ) );
		
		//set the params to get the premiums
		$params = array(
			'mek' 					=> $this->mek,
			'transmitter_id' 		=> $ins_agent->mek,
			'row'					=> true
		);
		
		//get the premiums
		$premium = $this->premium->get_premiums( $params );
		
		if( ! count( $premium ) )
		{
			$msg = 'You will need to set a premium/BUF for this insurance company before you can generate a mga report. Please navigate to "Edit Account" to add this';
			$url = safe_url( '/mga/reports', 'index' );		
			$this->set_message( $msg, 'info', $url );
		}


		//get the power
		$params = array( 
			'ins_company_id' 	=> $ins_agent->mek, 
			'premium'			=> $premium[ 'premium' ],
			'buf'				=> $premium[ 'buf' ],
			'mek'				=> $this->mek,
			'premium'			=> $premium
		
		);
		
		$d = array(
			'report'         => $this->reports->get_powers_for_mga_report( $params ),
			'ins_id'         => $ins_agent->mek,
			'premium'        => $premium[ 'premium' ],
			'buf'            => $premium[ 'buf' ],
			'agency_name'    => $premium[ 'agency_name' ],
			'sub_agent'      => 0,
			'mek'            => $this->mek
		);			
		

		$d[ 'totals' ] = $this->reports->get_master_report_total( $d[ 'report' ] );

		$d[ 'groups' ] = $this->reports->get_grouped_powers_for_master_report( $params );

		$view = 'generate_mga_report';
		
		$this->template->write('title', 'MGA Report');
		$this->template->write('sub_title', 'Below you will find your report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
	
	public function process_new_mga_report()
	{
		if( $this->reports->validate_new_mga_report_frm() )
		{
			$d 		= $this->sfa();			
			$url 	= safe_url( '/mga/reports', 'generate_mga_report', array( $d[ 'ins_company' ] ) );
			redirect( $url );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->mga_report();
		}
	}
	
	public function mga_report()
	{
		
		$view = 'choos_ins_company';
		$d = array(
			'process_url'    => '/mga/reports/process_new_mga_report'
		);

		$params = array(
			'data'            => $this->mga->get_insurance_companies( $this->mek ),
			'default' 	=> 'Select Insurance Company',
			'id_opt' 	=> 'insurance_agency_id',
			'val_opt'	=> 'agency_name'
		);
		
		
		
		$d[ 'ins' ] = $this->create_sub_select_array( $params ); 	

		$this->template->write('title', 'generate a MGA Report');
		$this->template->write('sub_title', 'select the insurance agency you would like to send this report to');
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

