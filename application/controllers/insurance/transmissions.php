<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transmissions extends Insurance_Controller {

	private $view;
	private $mek;
	private $agency_id;

	public function __construct()
	{
		parent::__construct();
		$this->view = 'insurance/transmissions/';
		$this->mek	= $this->session->userdata( 'mek' );
		$this->agency_id = $this->session->userdata( 'insurance_agency_id' );
		
		$this->load->model( 'insurance/transmissions_model', 't' );
		$this->load->model( 'agent/crud_model', 'agent' );
		$this->load->model( 'agency/agency_crud_model' , 'agency' );
		$this->load->model( 'mga/mga_crud_model', 'mga' );
		$this->template->add_js( '_assets/js/insurance/insurance.js' );

	}

	public function get_max_power( $prefix )
	{
		exit( $this->t->get_max_power( $prefix ) );
		
		
	}

	/*
		CREATE TRANSMISSIONS
	*/

	
	public function view_mga_transmissions()
	{
		
		$data = array(
			'transmissions' => $this->t->get_mga_transmissions( $this->mek )
		);
			
		$this->template->write('title', 'Manage Transmissions');
		$this->template->write('sub_title', 'Use this admin to manage your transmissions');
		$this->template->write_view('content', $this->view . 'view_mga_transmissions', $data);
		$this->template->render();
		
	}


	public function save_mga_transmissions()
	{
		
		$batch = array_unique( $this->session->userdata( 'batch_trans' ), SORT_REGULAR );
		
		
		$trans_id = $this->t->create_transmission( $this->mek, $batch, TRUE );
		
		foreach( $batch as $arr )
		{			
			$this->t->save_transmission( $this->mek, $arr, $trans_id, TRUE );
		}
		
		
		$this->session->unset_userdata( 'batch_trans' );		
		$msg = 'You successfully create a transmissions';
		$this->set_message( $msg, 'done', '/insurance/transmissions' );
		
		
	}
	
	
	public function mga_process_create_frm()
	{
		if( $this->t->validate_mga_create_frm() )
		{
			$this->t->batch_transmission( array( 'mga' => true ) );
			
			$msg = 'You successfully create a transmissions';
			$this->set_message( $msg, 'done', '/insurance/transmissions/confirm_transmission/mga' );
			
		}
		else	
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));	
			$this->create_mga();			
		}	
		
		
	}
	
	public function create_mga()
	{

		$this->load->model( 'insurance/insurance_crud_model', 'ins' );
		
		$ins_company = $this->ins->get_insurance_companies_by_agent( array( 'mek' => $this->session->userdata( 'mek' ), 'row' => true ) );
		
		$sub = array(
			'data' 		=> $this->mga->get_mga_admins( array( 'active' => true, 'insurance_agency_id' => $ins_company->insurance_agency_id  ) ),
			'id_opt'	=> 'mek',
			'val_opt'	=> 'name_company',
			'default'	=> 'Select MGA'
		);

		$d = array(
			'mga' 		=> $this->create_sub_select_array( $sub ),
			'prefixes'	=> $this->t->get_prefixes( $this->agency_id ),
		);
	
		$batch = $this->session->userdata( 'batch_trans' );
		
		if( count( $batch ) )
		{
			$mga = $this->mga->get_mga_admins( array( 'mek' => $batch[ 0 ][ 'agent_id' ] ) );
			$d[ 'agent' ] 	 	= $mga[ 'full_name' ]; 	
			$d[ 'agent_id' ]	= $mga[ 'mek' ];
			$d[ 'exp_date' ] 	= $batch[ 0 ][ 'exp_date' ];
		}	
		
		$view = 'mga_create';
		$this->template->write('title', 'Create Transmission');
		$this->template->write('sub_title', 'Use the form below to create a transmission');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();

	}

	
	/*
		CREATE TRANSMISSIONS
	*/


	public function choose()
	{

		$d = array();
		$view = 'choose';
		$this->template->write('title', 'Create Transmission');
		$this->template->write('sub_title', 'Choose the type of transmission you would like to create');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();
		
		
	}


	public function process_recoup( $trans_id )
	{
		$this->t->recoup_powers( $trans_id );	
		
		$msg = 'Transmission has been recouped';
		$this->set_message( $msg, 'done', '/insurance/transmissions' );
		
	}

	public function recoup( $trans_id )
	{
		$d = array( 'powers' => $this->t->get_inventory_powers_from_transmission( $trans_id ), 'trans_id' => $trans_id );
		$view = 'recoup_powers';
		$this->template->write('title', 'Recoup Transmission');
		$this->template->write('sub_title', 'The below powers will be set to "Void"');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();
		
		
	}


	public function cancel()
	{
			
		$this->session->unset_userdata( 'batch_trans' );
		
		$msg = 'Transmissions have been cancelled';
		$this->set_message( $msg, 'info', '/insurance/transmissions' );
		
	}

	public function save_transmissions()
	{
		
		$batch = array_unique( $this->session->userdata( 'batch_trans' ), SORT_REGULAR );
		
		
		$trans_id = $this->t->create_transmission( $this->mek, $batch );
		
		foreach( $batch as $arr )
		{			
			$this->t->save_transmission( $this->mek, $arr, $trans_id );
		}
		
		
		$this->session->unset_userdata( 'batch_trans' );		
		$msg = 'You successfully create a transmissions';
		$this->set_message( $msg, 'done', '/insurance/transmissions' );
		
		
	}

	
	
	public function index()
	{

		$data = array(
			'transmissions' => $this->t->get_transmissions( $this->mek )
		);
			
		$this->template->write('title', 'Manage Transmissions');
		$this->template->write('sub_title', 'Use this admin to manage your transmissions');
		$this->template->write_view('content', $this->view . 'index', $data);
		$this->template->render();

	}
	
	public function confirm_transmission( $mga = NULL )
	{
		$view 	= 'confirm_transmission';
		$batch 	= $this->session->userdata( 'batch_trans' );
		
		
		$d = array(
			'temp_batch' => $this->t->format_batch( $batch ),
			'mga'		 => $mga
			
		);
		
		$this->template->write('title', 'Confirm Transmission');
		$this->template->write('sub_title', 'Add a new transmission or submit transmission');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();
		
	}
	
	
	
	public function process_create_frm()
	{
		if( $this->t->validate_create_frm() )
		{
			$this->t->batch_transmission();

			$msg = 'You successfully create a transmissions';
			$this->set_message( $msg, 'done', '/insurance/transmissions/confirm_transmission' );
		}
		else	
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));	
			$this->create();			
		}	

		
	}
	

	public function create()
	{
		$agencies 	= $this->agency->get_agency_by_ins( array( 'ins_agent_id' => $this->mek ) );

		$params = array( 
			'data' 		=> $agencies,
			'default'	=> 'Please select Bail Agency',
			'id_opt'	=> 'bail_agency_id',
			'val_opt'	=> 'agency_name'
		);
		
			 
		$data = array(
			'agencies' => $this->create_sub_select_array( $params ),
			'prefixes'	=> $this->t->get_prefixes( $this->agency_id ),
			'mga'		=> $this->mga->get_mga_admins()
		);



		
		$batch = $this->session->userdata( 'batch_trans' );
		
		if( count( $batch ) )
		{
			$data[ 'agent' ] = $this->agent->get_master_agent( array( 'mek' => $batch[ 0 ][ 'agent_id' ] ) ); 	
			$data[ 'exp_date' ] = $batch[ 0 ][ 'exp_date' ];
		}	
			
		$this->template->write('title', 'Create A Transmission');
		$this->template->write('sub_title', 'Use this admin to create a transmission');
		$this->template->write_view('content', $this->view . 'create', $data);
		$this->template->render();

	}

	public function get_agent( $agency_id = 0 )
	{
		$ret = json_encode( array( 'name' => 'Select Bail Agency First' ) );
		
		if( $agency_id > 0 )
		{
			$ret = json_encode( $this->t->get_agent_name( $agency_id ) );	
		}
		
		exit( $ret );
	}

}

