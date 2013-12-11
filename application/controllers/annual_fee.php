<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class annual_fee extends MY_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'annual_fee/';
		$this->mek		= $this->session->userdata( 'mek' );

		$this->load->model( 'agent/annual_fee_model', 'a' );	

	}

	public function process_fee_frm()
	{
		
		if( $this->a->validate_fee_frm() )
		{
			
			$ret = $this->a->purchase_annual_fee();
	
			if( $ret[ 'success' ]  )
			{
				$this->session->set_userdata( 'annual_fee', true );		
				$msg = 'You successfully paid your annual fee!';
				$url = '/agent/transmissions/';
				$this->set_message( $msg, 'done', $url );
			}		
			
			
			$msg = '<div class="msg error">' . $ret[ 'error' ] . ' Please try again' . '</div>';
			$this->template->write('errors', $msg );		
			$this->index();

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
		$d = array();

		$this->template->write('title', 'Agent Annual Fee');
		$this->template->write('sub_title', 'Instant Powers requires an agent annual fee');
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

