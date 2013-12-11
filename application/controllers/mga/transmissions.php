<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transmissions extends MGA_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'mga/transmissions/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'credits/credits_model', 'c' );
		
		$this->load->model( 'mga/mga_transmission_model', 't' );
		$this->load->model( 'mga/bail_agency_model', 'b' );
		$this->load->model( 'agent/crud_model', 'a' );
		$this->template->add_js( '_assets/js/mga/transmissions.js' );

	

	}
	

	public function process_recoup( $trans_id )
	{
		
		$this->t->recoup_transmission( $trans_id );		
		$msg 	= 'You successfully recouped this transmission. These powers have been set to void';
		$url	= '/mga/transmissions/';
		$this->set_message( $msg, 'done', $url );
		
	}

	
	public function recoup( $trans_id )
	{
		$view = 'recoup';
		$d = array( 'trans_id' => $trans_id );	
			
		$this->template->write('title', 'Recoup Transmission');
		$this->template->write('sub_title', 'Are you sure you want to recoup this transmission from the bail agent?');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();				
		
	}
	
	
	public function accept_transmission( $trans_id )
	{
		
		$this->t->accept_transmission( $trans_id );		
		$msg 	= 'You successfully accepted this transmission. You can now transfer the full transmission or transfer by individual powers.';
		$url	= '/mga/transmissions/';
		$this->set_message( $msg, 'done', $url );
		
	}
	
	
	public function process_transfer()
	{
		$d = $this->sfa();
		
		if( $this->t->validate_transfer_frm() )
		{
			$this->t->transfer_transmission_to_agent( $this->mek );
			
			$msg 	= 'You successfully transferred this transmission';
			$url	= '/mga/transmissions/';
			$this->set_message( $msg, 'done', $url );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->transfer_transmission( $d[ 'trans_id' ] );
		}
		
		
	}

	public function transfer_transmission( $trans_id )
	{
		$view = 'transfer_transmission';
		$d = array(
			'trans_id' 	=> $trans_id,
			'agents'	=> $this->b->list_agencies( $this->mek )
		);		
		$d[ 'agents' ] = $this->create_sub_select_array( array( 'data' => $d[ 'agents' ], 'id_opt' => 'bail_agency_id', 'val_opt' => 'agency_name', 'default' => 'Choose Agency' ) ); 
		
		

		$this->template->write('title', 'Transfer Transmissions');
		$this->template->write('sub_title', 'Choose the agent that you would like to tranfer to');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();				
	}




	public function index( $message = NULL )
	{
		$view = 'index';
		
		$d = array( 'transmissions' => $this->t->get_mga_transmissions( $this->mek ) );

		if( $message ) $d['show_message'] = true;	


		$this->template->write('title', 'Your Transmissions');
		$this->template->write('sub_title', 'Below you will find your available Transmissions');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}

	public function purchase( $tid )
	{
		$credits = $this->c->get_credits( $this->mek );
		if( $credits->credit_count < 8 ) 
			exit( json_encode( array( 'error' => true, 'message' => 'You currently have ' . $credits->credit_count . ' credits, Please purchase more credits.' ) ) );	
		
		$this->c->update_credits_amount( $this->mek,  8, $credits->credit_count, true );
		$this->t->mark_transmission_paid( $tid, $this->mek );
		
		exit( json_encode( array( 'error' => false ) ) );	
		
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

