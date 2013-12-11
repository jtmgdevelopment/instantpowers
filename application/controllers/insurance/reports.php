<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Insurance_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'insurance/reports/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'agency/agency_crud_model', 'a' );
		$this->load->model( 'agent/master_reports/agents_report_model', 'report' );
		$this->load->model( 'mga/mga_report_model', 'mga_report' );
		$this->load->model( 'premium/premium_crud_model', 'p' );
		$this->load->model( 'agent/crud_model', 'agent' );
		$this->load->model( 'mga/mga_crud_model', 'mga' );
		$this->load->model( 'insurance/insurance_crud_model', 'i' );
		$this->load->model( 'insurance/ins_report_model', 'ins_report' );

		$this->agency_id = $this->session->userdata( 'insurance_agency_id' );
		

		$this->template->add_js( '/_assets/js/insurance/print_powers.js' );
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
	
	
	public function list_liability()
	{
		$d = $this->sfa();

		$data = array(
			'list' => $this->ins_report->list_liability( $d ),
			'total' => $this->ins_report->list_liability_total( $d )
		);

		$view = 'list_liability';
		$this->template->write('title', 'Agency Liability');
		$this->template->write('sub_title', 'Below you will find the liability for this agency');
		$this->template->write_view('content', $this->view . $view, $data);
		$this->template->render();		
			
	}
	
	
	public function select_agency_liability()
	{

		$mgas = $this->mga->get_mga_admins( array( 'active' => true, 'insurance_agency_id' => $this->agency_id  ) );
		$agencies = $this->a->get_agency_by_ins( array( 'ins_agent_id' => $this->mek ) );
		
		$build = array();
		
		foreach( $mgas as $mga )
		{
			$build[] = array(
				'mek' => 'MGA-' . $mga[ 'mek' ],
				'name' => $mga[ 'name_company' ] . ' MGA'
			);
		}

		foreach( $agencies as $agency )
		{
			$build[] = array(
				'mek' 	=> $agency[ 'bail_agency_id' ],
				'name' => $agency[ 'agency_name' ] . ' Bail Agency'
			);
		}
		$sub = array(
			'data' 		=> $build,
			'id_opt'	=> 'mek',
			'val_opt'	=> 'name'		
		);
				
		$d = array(
			'path' 		=> '/insurance/reports/list_liability',
			'agencies' 	=> $this->create_sub_select_array( $sub )
			
		);
		
		$view = 'select_agency';
		$this->template->write('title', 'Select Agency');
		$this->template->write('sub_title', 'Please Choose the agency you would like to view the liability for');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}

	public function view_archived_mga( $ins_id, $mga_id, $report_id )
	{
		
		$view = 'view_mga_report';


		//set the params to get the premiums
		$params = array(
			'mek' 					=> $mga_id,
			'transmitter_id' 		=> $ins_id,
			'row'					=> true
		);
		
		//get the premiums
		$premium = $this->p->get_premiums( $params );
		
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
			'mek'				=> $mga_id,
			'premium'			=> $premium,
			'archived'			=> true,
			'report_id'			=> $report_id
		
		);
		
		$d = array(
			'report'         => $this->mga_report->get_powers_for_mga_report( $params ),
			'ins_id'         => $ins_id,
			'premium'        => $premium[ 'premium' ],
			'buf'            => $premium[ 'buf' ],
			'agency_name'    => $premium[ 'agency_name' ],
			'sub_agent'      => 0,
			'mek'            => $mga_id,
			'report_id'		 => $report_id
		);			
		
		
		$d[ 'totals' ] = $this->mga_report->get_master_report_total( $d[ 'report' ] );



		$d[ 'groups' ] = $this->mga_report->get_grouped_powers_for_master_report( $params );
		
		

		$this->template->write('title', 'Reports Cpanal');
		$this->template->write('sub_title', 'Please Choose Your Report Action');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}



	
	
	public function list_mga_reports( $mga_id )
	{
		$d = array(
			'archive' 	=> $this->mga_report->get_report_list( array( 'mek' => $mga_id, 'ins_id' => $this->mek ) ),
			'mga'		=> $this->mga->get_mga_admins( array( 'mek' => $mga_id ) ) ,
			'ins_id'	=> $this->mek,
			'mek'		=> $mga_id
		);
		
		$view = 'list_archive_mga_reports';
		
		
		$this->template->write('title', 'Reports');
		$this->template->write('sub_title', 'Below you will find the reports for this mga agency');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}
	
	public function process_mga_choose_agency_frm()
	{

		$d = $this->sfa();
		
		
		if( $this->mga_report->validate_ins_mga_report_frm())
		{

			redirect( '/insurance/reports/list_mga_reports/' . $d[ 'mga_agency' ] );
		}
		else
		{
			
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->mar_choose_mga();			
		}
		
		
		
	}

	public function mar_choose_mga()
	{
		$view = 'mga_choose_agency';
	
		$this->load->model( 'insurance/insurance_crud_model', 'ins' );
		
		$ins_company = $this->ins->get_insurance_companies_by_agent( array( 'mek' => $this->session->userdata( 'mek' ), 'row' => true ) );
		
		$sub = array(
			'data' 		=> $this->mga->get_mga_admins( array( 'active' => true, 'insurance_agency_id' => $ins_company->insurance_agency_id  ) ),
			'id_opt'	=> 'mek',
			'val_opt'	=> 'name_company',
			'default'	=> 'Select MGA'
		);

		$d = array(
			'mga' 		=> $this->create_sub_select_array( $sub )		
		);
		
	
		$this->template->write('title', 'Reports');
		$this->template->write('sub_title', 'Choose the MGA agency you would like to view');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	
	}


	public function view_prior_years( $ins_id, $mek )
	{
		$this->load->model( 'insurance/insurance_crud_model', 'ins' );
		
		$ins_company = $this->ins->get_insurance_companies_by_agent( array( 'mek' => $this->session->userdata( 'mek' ), 'row' => true ) );
		
		$d = array(
			'archive' 		=> $this->report->list_archived_mar_reports( array( 'transmitting_type' => 'ins', 'ins_id' => $ins_id, 'mek' => $mek, 'company_id'	=> $ins_company->insurance_agency_id, 'show_all' => true ) ),
			'ins_id'		=> $this->session->userdata( 'mek' ),
			'mek'			=> $mek
			
		);
		$view = 'list_archive_mar_reports';
		
		$this->template->write('title', 'MAR Report Archive');
		$this->template->write('sub_title', 'Below you will find archived MAR reports from this year');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

		
		
	}


	public function view_archived_mar( $ins_id, $mek, $report_id, $agency_id )
	{
	
	
		
		$d 		= $this->sfa();
		$ins 	= $this->i->get_insurance_companies_by_agent( array( 'mek' => $this->mek, 'row' => true ) );
		$agent	= $this->agent->get_master_agent( array( 'agency_id' => $agency_id ) );
		
		$params = array( 
			'insurance_agency_id' 	=> $ins->insurance_agency_id, 
			'mek' 					=> $agent->mek,
			'row'					=> true
		);
			
		$premiums = $this->p->get_premiums( $params );
		
		$params = array(
			'ins_company_id' 	=> $ins->insurance_agency_id,
			'mek'				=> $agent->mek,
			'premium'			=> $premiums[ 'premium' ],
			'buf'				=> $premiums[ 'buf' ],
			'archived'			=> true,
			'report_id'			=> $report_id
		);
	
		$d = array(
			'report' 	=> $this->report->get_powers_for_master_report( $params ),
			'groups'	=> $this->report->get_grouped_powers_for_master_report( $params ),
			'premium'	=> $premiums[ 'premium' ],
			'buf'		=> $premiums[ 'buf' ],
			'mek'		=> $agent->mek,
			'ins_id'	=> $this->mek,
			'agent'		=> $agent,
			'archived'	=> true,
			'report_id'	=> $report_id
		);	
			
		$d[ 'totals' ] = $this->report->get_master_report_total( $d[ 'report' ] );
		
		$view = 'view_mar_report';
		
		
		$this->template->write('title', 'MAR Report');
		$this->template->write('sub_title', 'Below you will find the ARCHIVED MAR Report');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
	}

	public function view_past_mar_reports( $ins_id, $mek )
	{
		


		
		$d = array(
			'archive' 	=> $this->report->list_archived_mar_reports( array( 'transmitting_type' => 'ins', 'ins_id' => $ins_id, 'mek' => $mek ) ),
			'ins_id'	=> $ins_id,
			'mek'		=> $mek
		);
		
		
		$view = 'list_archive_mar_reports';
		
		
		
		$this->template->write('title', 'MAR Report Archive');
		$this->template->write('sub_title', 'Below you will find archived MAR reports from this year');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
			
	}


	public function process_mar_choose_agency_frm()
	{
		$d 		= $this->sfa();
		$ins 	= $this->i->get_insurance_companies_by_agent( array( 'mek' => $this->mek, 'row' => true ) );
		$agent	= $this->agent->get_master_agent( array( 'agency_id' => $d[ 'bail_agency' ] ) );
		$d 		= $this->sfa();
		
		
		
		$params = array( 
			'insurance_agency_id' 	=> $ins->insurance_agency_id, 
			'mek' 					=> $agent->mek,
			'row'					=> true
		);
			
		$premiums = $this->p->get_premiums( $params );
		
		if( ! count( $premiums ) )
		{
			$msg = 'This agent has not set up their reporting account. Please check back later.';
			$this->set_message( $msg, 'info', '/insurance/reports' );
			
		} 		

		$params = array(
			'ins_company_id' 	=> $ins->insurance_agency_id,
			'mek'				=> $agent->mek,
			'premium'			=> $premiums[ 'premium' ],
			'buf'				=> $premiums[ 'buf' ]
		);
		
		
		$d = array(
			'report' 	=> $this->report->get_powers_for_master_report( $params ),
			'premium'	=> $premiums[ 'premium' ],
			'buf'		=> $premiums[ 'buf' ],
			'mek'		=> $agent->mek,
			'ins_id'	=> $this->mek,
			'agent'		=> $agent,
			'report_id'	=> 0
		);	
	
		
		$d[ 'totals' ] = $this->report->get_master_report_total( $d[ 'report' ] );
		$d[ 'groups' ] = $this->report->get_grouped_powers_for_master_report( array( 'mek' => $agent->mek, 'ins_company_id' => $ins->insurance_agency_id ), $agent->mek, 'master_agent' );
		$view = 'view_mar_report';
		

		$this->template->write('title', 'MAR Report');
		$this->template->write('sub_title', 'Below you will find the CURRENT MAR report (Not Submitted Yet)');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		

	}


	public function mar_choose_agency()
	{
		$view = 'mar_choose_agency';
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

		$this->template->write('title', 'Reports');
		$this->template->write('sub_title', 'Choose the bail agency you would like to view');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	}


	public function print_power( $power_id, $trans_id, $hide = NULL )
	{
		
		$this->load->model( 'insurance/insurance_crud_model', 'ins' );
		
		$ins = $this->ins->get_insurance_agent( array( 'ins_id' => $this->session->userdata( 'insurance_agency_id' ) ) );
	
		$filename = strtolower( str_replace( ' ', '_', $ins->agency_name ) );
	

		$url = '/_tasks/' . $filename . '_print_power.cfm?powers=' .  $power_id . '&mek=' . $this->mek;		
		
		if( isset( $hide ) ) $url .= '&hide=1';
		
		redirect( $url );
	} 

	
	public function print_power_copies()
	{	
		$this->load->library('encryption');
		$d = $this->sfa();
		
		$data = array(
			'username' 	=> 'curllogin',
			'password'	=> $this->encryption->encode( 'password' ) 
		);	
		
		$this->load->library( 'curl' );
		$this->curl->create('/curl/curl_login');	
		$this->curl->post( $data );
		$this->curl->execute();

		$data[ 'report_id' ] 	= $d[ 'report_id' ];
		$data[ 'mek' ] 			= $d[ 'mek' ];
		$data[ 'email' ]		= $this->session->userdata( 'email' );
		
		
		$this->curl->create('/curl/print_powers');	
		$this->curl->post( $data );
		$this->curl->execute();

		$this->curl->create('/curl/end_session');	
		$this->curl->execute();
		
		exit(json_encode(array('success' => true )));

		
	}

	public function index()
	{
		$view = 'index';
		$d = array();

		$this->template->write('title', 'Reports');
		$this->template->write('sub_title', 'Choose the report you would like to view');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	}
}
