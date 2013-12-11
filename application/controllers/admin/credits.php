<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class credits extends Admin_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'admin/credits/';
		$this->mek		= $this->session->userdata( 'mek' );

	

	}

	public function process_credits_frm()
	{
		$this->load->model( 'admin/agent/credits_model', 'credits' );		

		if( $this->credits->validate_credits_frm() )
		{
			$this->credits->save_credits( $this->sfa() );
			$msg = 'You successfully add credits to this user';
			$this->set_message( $msg, 'done', '/admin/cpanel' );
		}
		else
		{
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->index();
		}
		
	}

	public function index()
	{
		
		$this->load->model( 'agent/crud_model', 'agent' );
		
		
		
		$view = 'index';
		
		$params = array(
			'data' 		=> $this->agent->get_master_agent(),
			'id_opt'	=> 'mek',
			'val_opt'	=> 'full_name',
			'default'	=> 'Select Agent'
		);

		$d[ 'agents' ] = $this->create_sub_select_array( $params );
		
				
		$this->template->write('title', 'Add Credits');
		$this->template->write('sub_title', 'Use the form below to add credits to users.');
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

