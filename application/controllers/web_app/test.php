<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class test extends MY_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'master_agent/powers/';
		$this->mek		= $this->session->userdata( 'mek' );

		$this->load->model( 'web_app/app_agent_model', 'a' );

	}

	public function login_user()
	{
		
		$d = $this->sfa();
		
		if( $d[ 'username' ] == 'jgonzalez' )
		{
			$data = array(
				'logged_in'	=> true,
				'username'	=> 'jgonzalez',
				'email'		=> 'jgozalez@jtmgdevelopment.com'
			);	
			
			exit( json_encode( $data ) );
		}
		else
		{
			$data = array(
				'logged_in'	=> false
				);	
			
			exit( json_encode( $data ) );
		}	
		
	}


	public function index()
	{
		
		$out = $this->a->get_agents();

		exit( json_encode( $out ) );

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

