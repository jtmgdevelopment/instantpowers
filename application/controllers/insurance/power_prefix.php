<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class power_prefix extends Insurance_Controller {

	private $view;
	private $mek;
	private $agency_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'insurance/prefixes/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->agency_id = $this->session->userdata( 'insurance_agency_id' );
		$this->load->model( 'power_prefixes/prefix_crud_model' , 'p' );
	}

	public function change_status( $status )
	{
		$d = $this->sfa();
		$status = ( $status == 'deactivate' ? 0 : 1 );
		
		
		$this->p->update_prefix_status( $status, $d[ 'prefix_id' ] );
		exit( json_encode( array( 'ret' => 'true' ) ) );
	}

	public function index()
	{

		$view = 'manage_prefixes';
		$d = array(
			'prefixes' => $this->p->get_prefixes( array( 'agency_id' => $this->agency_id ) )
		);
		
		$this->template->add_js( '/_assets/js/insurance/prefix.js' );

		$this->template->write('title', 'Manage Power Prefixes');
		$this->template->write('sub_title', 'Manage Your Companies Prefixes Below');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}

	public function process_prefix_frm()
	{
		if( $this->p->validate_prefix_frm())
		{
			$d = array( 'mek' => $this->mek, 'agency_id' => $this->agency_id );
			$this->p->save_prefix( $d );
			$msg = 'You successfully created a prefix';
			$this->set_message( $msg, 'done', '/insurance/power_prefix/index' );	
		}
		else
		{
			
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->create();			
		}
			
		
	}


	public function create()
	{

		$view = 'power_prefixes';
		$d = array(
			'prefixes' => $this->p->get_prefixes( array( 'agency_id' => $this->agency_id ) )
		);


		$this->template->write('title', 'Manage Power Prefixes');
		$this->template->write('sub_title', 'Manage Your Companies Prefixes Below');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}

}

