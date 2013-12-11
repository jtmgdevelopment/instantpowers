<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Agent_Controller {

	private $view;
	private $mek;
	private $role;
	
	public function __construct()
	{
		parent::__construct();
		$this->view = 'agent/reports/';
		$this->mek	= $this->session->userdata( 'mek' );
		$this->role	= $this->session->userdata( 'role' );
		
		$this->load->model( 'transmissions/transmissions_model' , 't' );
		$this->load->model( 'credits/credits_model', 'c' );
		$this->load->model( 'powers/power_model', 'p' );
		$this->load->model( 'agent/crud_model', 'a' );
		$this->load->model( 'premium/premium_crud_model', 'premium' );
		$this->load->model( 'insurance/insurance_crud_model', 'i' );
		$this->load->model( 'insurance/ins_agency_model', 'ins' );
		$this->load->model( 'power_prefixes/prefix_crud_model' , 'prefix' );
		$this->load->model( 'mga/mga_crud_model' , 'mga' );
		
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

		$this->master_id = $this->mek;
		
		if( $this->role == 'sub_agent' )
		{
			$m = $this->a->get_sub_agent_master( array( 'sub_mek' => $this->mek ) );
			$this->master_id = $m->master_id;	
		}

	}


	public function process_report_totals_by_date()
	{
		$a = $this->sfa();
			
		$d = array(
			'report_totals' => $this->agent_report->view_report_totals_by_date( $a ),
			'start_date'	=> $a[ 'start_date' ],
			'end_date'		=> $a[ 'end_date' ]
		);		
		
		$view = 'list_report_totals_by_date';
		
		$this->template->write('title', 'Agent History');
		$this->template->write('sub_title', 'Agents Power History');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
		
		
	}
	
	
	public function view_report_totals_by_date( $ins_id, $mek )
	{
		$d = array(
			'mek'		=> $mek,
			'ins_id'	=> $ins_id
		);

		$params = array(
			'ins_id'	=> $this->i->get_insurance_companies_by_agent( array( 'mek' => $ins_id ) )
		);
		
		$d[ 'ins_id' ] = $params[ 'ins_id' ][ 0 ][ 'insurance_agency_id' ];
		
		
		$view = 'view_report_totals_by_date';
		
		$this->template->write('title', 'Agent History');
		$this->template->write('sub_title', 'Agents Power History');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
		
	}
	
	public function list_sub_agent_reports( $sub_agent, $ins_id )
	{
		$params = array(
			'mek'		=> $sub_agent,
			'ins_id'	=> $ins_id
		);
		
		
		
		
		$params[ 'transmitting_type' ] = $this->agent_report->transmitting_type( $params );
		
		$d = array(
			'reports' 			=> $this->agent_report->list_archived_mar_reports( $params ),
			'sub_agent_current' => true,
			'sub_mek'			=> $sub_agent,
			'ins_id'			=> $ins_id
		);
		
		
		$view			= 'view_past_mar_list';
		$title 			= 'Past Master Agent Reports';
		$sub_title		= 'Below you will find your sub agent reports for the current year';
		$this->template->write('title', $title);
		$this->template->write('sub_title', $sub_title);
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
			
	}
	
	
	public function process_sub_agent_mar()
	{
		if( $this->agent_report->validate_sub_agent_mar_frm() )
		{
			$d = $this->sfa();
			redirect( '/agent/reports/list_sub_agent_reports/' . $d[ 'sub_agent' ] . '/' . $d[ 'ins_company' ] );
		}
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->view_sub_agent_reports();		
		}
		
			
		
	}
	
	public function view_sub_agent_reports()
	{
		
		$view = 'sub_agent_reports/select_agent';
		
		$d = array(	
			'agents' => $this->a->create_sub_select_array( $this->mek )
		);


		$params = array(
			'data' 		=> $this->a->get_transmission_agencies(  $this->master_id ),
			'default' 	=> 'Select Transmitting Company',
			'id_opt' 	=> 'mek',
			'val_opt'	=> 'company'
		);
		
		
		$d[ 'ins' ] = $this->create_sub_select_array( $params ); 	
		
		
		$this->template->write('title', 'View Sub Agent Reports');
		$this->template->write('sub_title', 'Choose the agent you would like to view');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}
	
	
	
	public function view_mar_report( $report_id, $ins_id, $report_num, $sub_id = NULL )
	{
		

		if( ! ctype_digit( $ins_id ) ) $transmitter = $this->mga->get_mga_admins( array( 'mek' => $ins_id, 'obj' => true ) );
		else $transmitter = $this->i->get_insurance_agent( array( 'ins_id' => $ins_id ) );
		
		
		$params = array(
			'mek' 					=> $this->mek,
			'transmitter_id' 		=> $transmitter->mek,
			'row'					=> true
		);
		
		
 		if( isset( $sub_id ) ) $params[ 'mek' ] = $sub_id;


		$premium = $this->premium->get_premiums( $params );
		
		if( ! count( $premium ) )
		{
			$msg = 'You will need to set a premium/BUF for this insurance company before you can generate a master report. Please navigate to "Edit Account" to add this';
			$url = safe_url( '/agent/reports', 'master_agent_report' );		
			$this->set_message( $msg, 'info', $url );
		}
		
		
		//get the power
		$params = array( 
			'ins_company_id' 	=> $ins_id, 
			'premium'			=> $premium[ 'premium' ],
			'buf'				=> $premium[ 'buf' ],
			'mek'				=> $this->mek,
			'archived'			=> true,
			'report_id'			=> $report_id
		);
		
		if( isset( $sub_id ) ) 
		{
			$params[ 'mek' ] = $sub_id;
			$params[ 'sub_agent' ] = true;
		}
		
		$transmitting_type = $this->agent_report->transmitting_type( array( 'ins_id' => $ins_id ) );
		
		$d = array(
			'report' 	=> $this->agent_report->get_powers_for_master_report( $params ),
			'ins'		=> $this->i->get_insurance_agent( array( 'ins_id' => $ins_id ) ),
			'premium'	=> $premium[ 'premium' ],
			'buf'		=> $premium[ 'buf' ],
			'report_num'=> $report_num,
			'report_id'	=> $report_id,
			'mek'		=> $this->mek,
			'type'		=> $transmitting_type	
		);			
		
		
		if( $transmitting_type == 'mga' ) $d[ 'ins' ] = $this->mga->get_mga_admins( array( 'mek' => $ins_id, 'obj' => true  ) );
		
		$d[ 'totals' ] = $this->agent_report->get_master_report_total( $d[ 'report' ] );
		$d[ 'groups' ] = $this->agent_report->get_grouped_powers_for_master_report( $params );
		
		
		
		$view = 'master_agent_report_archive_view';
		
		$title 			= 'Master Agent Report ';
		$d[ 'content' ] = 'Choose the insurance company in which you would like to view your Sub Agent Report';		
		
		if( $this->role == 'sub_agent' || isset( $sub_id ) )
		{
			$title 			= 'Sub Agent Report ';
			$d[ 'content' ] = 'Choose the insurance company in which you would like to view your Sub Agent Report';
			$view			= 'sub_agent_report_archive_view';
			$d 				= $this->agent_report->generate_sub_agent_totals( $d );
			$d[ 'is_sub' ] 	= true;	
			$d[ 'mek' ] 	= $sub_id;
			
		}		
		
		$this->template->write('title', $title . $report_num);
		$this->template->write('sub_title', 'Below you will find your report ' . $report_num);
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}
	
	
	public function process_archived_ins_company_frm()
	{
		$f = $this->sfa();	
		
		$params = array(
			'ins_id'	=> $this->i->get_insurance_companies_by_agent( array( 'mek' => $f['ins_company'] ) )
		);
		
			
		if( count( $params[ 'ins_id' ] ) ){
			$params[ 'ins_id' ] = $params[ 'ins_id' ][ 0 ][ 'insurance_agency_id' ];
		}
		else
		{
			$params[ 'ins_id' ] = $f[ 'ins_company' ];
		}		
		
		$transmitting_type = $this->agent_report->transmitting_type( $params );
		
		$params = array(
			'ins_id'             => $params[ 'ins_id' ],
			'mek'                => $this->mek,
			'transmitting_type'  => $transmitting_type
		);		
	
		
		$d = array(
			'reports' 	=> $this->agent_report->list_archived_mar_reports( $params ),
			'ins_id'	=> $f[ 'ins_company' ],
			'sub_mek'	=> NULL
		);
		
		$view	= 'view_past_mar_list';


		$title 			= 'Past Master Agent Reports';
		$sub_title		= 'Below you will find your master agent reports for the current year';
		$d[ 'content' ] = 'Choose the insurance company in which you would like to view your Master Agent Report';
		
		if( $this->role == 'sub_agent' )
		{
			$title 			= 'Past Master Agent Reports';
			$sub_title		= 'Below you will find your sub agent reports for the current year';
			$d[ 'content' ] = 'Choose the insurance company in which you would like to view your Sub Agent Report';
			$d[ 'sub_mek' ] = $this->mek;
		}
		
		
		
		$this->template->write('title', $title);
		$this->template->write('sub_title', $sub_title);
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
	
	
	
	public function view_past_mar()
	{

		$params = array(
			'data' 		=> $this->a->get_transmission_agencies(  $this->master_id ),
			'default' 	=> 'Select Transmitting Company',
			'id_opt' 	=> 'mek',
			'val_opt'	=> 'company'
		);

		
		$d[ 'ins' ] = $this->create_sub_select_array( $params ); 	
		$view	= 'view_past_mar';


		$title 			= 'Past Master Agent Reports';
		$d[ 'content' ] = 'Choose the transmitting company in which you would like to view your Master Agent Report';
		
		if( $this->role == 'sub_agent' )
		{
			$title 			= 'Past Master Agent Reports';
			$d[ 'content' ] = 'Choose the transmitting company in which you would like to view your Sub Agent Report';
		}

		
		$this->template->write('title', $title);
		$this->template->write('sub_title', 'Choose the transmitting company');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}



	public function transmit_master_report( $ins_id, $is_mga, $trans_id = NULL, $is_online_payment = false )
	{
		

		//set the params to get the premiums
		$params = array(
			'mek' 					=> $this->mek,
			'transmitter_id' 		=> $ins_id,
			'row'					=> true
		);
		
		
		//get the premiums
		$premiums= $this->premium->get_premiums( $params );


		if( $premiums[ 'is_mga' ] != 'MGA' )
		{			
			$ins = $this->i->get_insurance_companies_by_agent( array( 'mek' => $ins_id ) );
			$ins_id = $ins[ 0 ][ 'insurance_agency_id'];			
		}
		
		//create report record
		$params = array( 'mek' => $this->mek, 'ins_id' => $ins_id, 'role' => $this->role, 'is_mga' => $is_mga, 'premium' => $premiums );
		
		$params[ 'premium' ] = $premiums[ 'premium' ];
		$params[ 'buf' ]	= $premiums[ 'buf' ];
		
		$params[ 'trans_id' ] 		= $trans_id;
		$params[ 'online_payment' ] = $is_online_payment;
		
		

		$this->agent_report->create_report_record( $params );	
		
		$msg = 'You successfully transmitted your master report';
		$url = '/agent/reports';
		$this->set_message( $msg, 'done', $url );
		
	}
	
	public function submit_master_agent_report( $ins_id, $amount = NULL )
	{
		$view = 'submit_master_agent_report';		
	
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

		
		if( $this->role == 'sub_agent' )
		{
			$d[ 'sub_agent' ] = true;	
			
		}

		$title 			= 'Submit Master Agent Report';
		
		if( $this->role == 'sub_agent' )
		{
			$title 			= 'Submit Sub Agent Report';
		}
		
		$d[ 'amount' ] = $amount;
		
		$this->template->write('title', $title);
		$this->template->write('sub_title', 'Are you ready to transmit report?');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}



	public function generate_master_report( $ins_id, $mek = NULL )
	{
		
		if( isset( $mek ) )
		{
			 $this->mek 	= $mek;
			 $this->role 	= 'sub_agent';	
		}
		//check to see if the agent has	premium/BUF
		$view = 'master_agent_report_view';		
		
		//set the params to get the premiums
		$params = array(
			'mek' 					=> $this->mek,
			'transmitter_id' 		=> $ins_id,
			'row'					=> true
		);
		
		$transmitting_type = $this->agent_report->transmitting_type( array( 'ins_id' => $ins_id ) );
		
		//get the premiums
		$premium = $this->premium->get_premiums( $params );
		 	
		if( ! count( $premium ) )
		{
			$msg = 'You will need to set a premium/BUF for this insurance company before you can generate a master report. Please navigate to "Edit Account" to add this';
			$url = safe_url( '/agent/reports', 'master_agent_report' );		
			$this->set_message( $msg, 'info', $url );
		}
		
		//get the power
		$params = array( 
			'ins_company_id' 	=> $ins_id, 
			'premium'			=> $premium[ 'premium' ],
			'buf'				=> $premium[ 'buf' ],
			'mek'				=> $this->mek
		
		);
		
		if( $premium[ 'is_mga' ] == 'MGA' )
		{			
			$params[ 'mga_id' ] = $params[ 'ins_company_id' ];
			unset( $params[ 'ins_company_id' ] );			
		}
		
		
		if( $this->role == 'sub_agent' )
		{
			$params[ 'sub_agent' ] = true;	
			
		}
		
		
		$d = array(
			'report' 	=> $this->agent_report->get_powers_for_master_report( $params ),
			'ins_id'	=> $ins_id,
			'premium'	=> $premium[ 'premium' ],
			'buf'		=> $premium[ 'buf' ],
			'agency_name' => $premium[ 'agency_name' ],
			'sub_agent'	=> 0,
			'type'		=> $transmitting_type
		);			
		
		
		if( $this->role == 'sub_agent' )
		{
			$d[ 'sub_agent' ] = 1;	
			
		}
		
		if( isset( $mek ) ) $d[ 'hide_btns' ] = true;
		
		
		$d[ 'totals' ] = $this->agent_report->get_master_report_total( $d[ 'report' ] );
		
		$params = array(
			'ins_company_id' 	=> $ins_id,
			'mek'				=> $this->mek
		);

		if( $premium[ 'is_mga' ] == 'MGA' )
		{			
			$params[ 'mga_id' ] = $params[ 'ins_company_id' ];
			unset( $params[ 'ins_company_id' ] );			
		}
		
				
		$d[ 'groups' ] = $this->agent_report->get_grouped_powers_for_master_report( $params, $this->mek, $this->role );


		$title 			= 'Master Agent Report';
		$d[ 'content' ] = 'Choose the insurance company in which you would like to view your Master Agent Report';
		
		if( $this->role == 'sub_agent' )
		{
			$title 			= 'Sub Agent Report';
			$view			= 'sub_agent_report_view';
			$d 				= $this->agent_report->generate_sub_agent_totals( $d );
			$d[ 'content' ] = 'Choose the insurance company in which you would like to view your Sub Agent Report';
			
		}


		
		if( $this->role == 'sub_agent' )
		{
			$params[ 'sub_agent' ] = true;	
			
		}
		
		
		$d[ 'mek' ] = $this->mek;
		
		
		$this->template->write('title', $title);
		$this->template->write('sub_title', 'Below you will find your report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		


	}


	public function process_ins_company_frm()
	{
		if( $this->agent_report->validate_ins_choose_frm() )
		{
			$d 		= $this->sfa();			
			$url 	= safe_url( '/agent/reports', 'generate_master_report', array( $d[ 'ins_company' ] ) );
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
			'data' 		=> $this->a->get_transmission_agencies(  $this->master_id ),
			'default' 	=> 'Select Transmitting Company',
			'id_opt' 	=> 'mek',
			'val_opt'	=> 'company'
		);
		
		
		
		$d[ 'ins' ] = $this->create_sub_select_array( $params ); 	
		
		$title 			= 'Master Agent Report';
		$sub_title 		= 'Generate A Master Agent Report';
		$d[ 'content' ] = 'Choose the transmitting company in which you would like to generate the Master Agent Report';
		
		
		if( $this->role == 'sub_agent' )
		{
			$title 			= 'Sub Agent Report';
			$sub_title 		= 'Generate A Sub Agent Report';
			$d[ 'content' ] = 'Choose the transmitting company in which you would like to generate the Sub Agent Report';
		}
		
		$this->template->write('title', $title);
		$this->template->write('sub_title', $sub_title);
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	
		
		
	}
	
	
	public function power_history( $filter = NULL )
	{
		$view = 'power_history';		
		$d = array(
			'history' 	=> $this->agent_report->get_power_history( array( 'mek' => $this->mek, 'role' => $this->role, 'filter' => $filter ) ),
			'mek'		=> $this->mek
			
		);	

		$d[ 'prefixes' ]= $this->prefix->get_prefix_by_agent( array( 'mek' => $this->mek ) );

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
		$this->set_message( $msg, 'done' , '/agent/reports/view_sub_agent_credit_usage' );
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




	public function view_power( $trans_id, $power_id )
	{
		
		$this->load->model( 'powers/power_model' , 'power' );
		$this->load->helper( array( 'power_helper', 'html_helper' ) );
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->master_id, $trans_id ),
			'p' 	=> $this->p->get_power( array( 'power_id' => $power_id ) ),
			'agent' => $this->a->get_agents( $this->mek ),
			'power_id' => $power_id
		);
		
		if( $d[ 'p' ][ 'transferred_sub' ] == 'yes' )
		{		
		//	$d[ 'agent' ] = $this->a->get_agents( $d[ 'p' ][ 'sub_mek' ]);
			
		}
		
		
		$filename = strtolower( str_replace( ' ', '_', $d[ 'transmission' ]->agency_name ) );
		
		$file_path = 'power_template/' . $filename;		
		
		$d[ 'filename' ] = $filename;	
			
		$this->load->view( $this->view . $file_path, $d );		
	}



	
	public function view_detailed_agent_power_history( $power_id, $sub_mek, $hide = NULL )
	{
		$view = 'sub_agent_power_detail';
		$this->load->model( 'powers/power_model' , 'power' );
		$d = array(
			'power' 	=> $this->agent_report->get_agent_detailed_power( array( 'power_id' => $power_id ) ),
			'sub_mek'	=> $sub_mek,
			'power_id'	=> $power_id,
			'hide'		=> $hide,
			'power_details' => $this->power->get_power( array( 'power_id' => $power_id, 'role' => $this->session->userdata( 'role' ) ) )
		);
		
		$d[ 'status'] =  $d['power'][0]['key'];
		

		$this->template->write('title', 'Agent History');
		$this->template->write('sub_title', 'Detailed Power History');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
		
	}
	
	
	
	
	
	
	public function view_sub_agent_history( $sub_mek, $status = NULL )
	{
		$view = 'list_sub_agent_powers';
		$d = array(
			'powers' 	=> $this->agent_report->get_sub_agent_powers( array( 'mek' => $sub_mek, 'status' => $status ) ),
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
			redirect( '/agent/reports/view_sub_agent_history/' . $d[ 'sub_agent' ]);
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
		$this->template->write('sub_title', 'Select the agent in which you would like to view their history');
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

