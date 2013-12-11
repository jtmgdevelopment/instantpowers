<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class boilerplate extends MY_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'master_agent/powers/';
		$this->mek		= $this->session->userdata( 'mek' );

	

	}


	public function index()
	{
		$view = '';
		$d = array();

		$this->template->write('title', '');
		$this->template->write('sub_title', '');
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

