<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pay_premium extends MY_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'agent/pay_premium/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'agent/pay_premium_model', 'premium' );
	

	}

	public function process_report_premium()
	{

		$d = $this->sfa();
		
		
		$ret = $this->premium->pay_premium( $d );
		
		
		
		//$ret = array( 'success' => true, 'trans_id' => 12345 );
		
		if( $ret[ 'success' ]  )
		{
			//redirect to the transmit report page
			$msg = 'You successfully paid your premium fee and submitted this report';
			$url = '/agent/reports/transmit_master_report/' . $d[ 'ins_id' ] . '/' . $d[ 'is_mga' ] . '/' . $ret[ 'trans_id' ] . '/true';
			$this->set_message( $msg, 'done', $url );
			
		}		
		
		$msg = '<div class="msg error">' . $ret[ 'error' ] . ' Please try again' . '</div>';
		$this->template->write('errors', $msg );		
		$this->pay_report_premium( $d[ 'ins_id' ], $d[ 'is_mga' ], $d[ 'amount' ] );

		
		
	}

	public function process()
	{
		
		$d = $this->sfa();
		
		$ret = $this->premium->pay_premium( $d );

		if( $ret[ 'success' ]  )
		{
			$msg = 'You successfully paid your premium fee!';
			$url = '/agent/transmissions/';
			$this->set_message( $msg, 'done', $url );
		}		
		
		
		$msg = '<div class="msg error">' . $ret[ 'error' ] . ' Please try again' . '</div>';
		$this->template->write('errors', $msg );		
		$this->index();
		
	}

	public function confirm()
	{

		if( $this->premium->validate_fee_frm() )
		{
			$d = $this->sfa();
			
			$view = 'confirm';
			$this->template->write('title', 'Confirm Payment Information');
			$this->template->write('sub_title', 'Please confirm the payment information below');
			$this->template->write_view('content', $this->view . $view, $d);
			$this->template->render();		

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

		$this->template->write('title', 'Pay Premium');
		$this->template->write('sub_title', 'Use the form below to pay the premium owed.');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}


	public function confirm_report_premium()
	{
		$d = $this->sfa();

		if( $this->premium->validate_report_premium_frm() )
		{			
			$view = 'confirm_report_premium';
			$this->template->write('title', 'Confirm Payment Information');
			$this->template->write('sub_title', 'Please confirm the payment information below');
			$this->template->write_view('content', $this->view . $view, $d);
			$this->template->render();		

		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->pay_report_premium( $d[ 'ins_id' ], $d[ 'is_mga' ], $d[ 'hidden_amount' ] );
		}
		
	}


	public function pay_report_premium( $ins_id, $is_mga, $amount )
	{
		
		$view = 'pay_report_premium';
		$d = array(
			'ins_id' 	=> $ins_id,
			'is_mga' 	=> $is_mga,
			'amount' 	=> $amount
		);

		$this->template->write('title', 'Pay Report Premium');
		$this->template->write('sub_title', 'Use the form below to pay the premium owed.');
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

