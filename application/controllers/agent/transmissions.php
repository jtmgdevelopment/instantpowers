<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transmissions extends Agent_Controller {

	private $view;
	private $mek;

	public function __construct()
	{
		parent::__construct();
		$this->view = 'agent/transmissions/';
		$this->mek	= $this->session->userdata( 'mek' );
		$this->load->model( 'transmissions/transmissions_model' , 't' );
		$this->load->model( 'credits/credits_model', 'c' );
		$this->load->model( 'powers/power_model', 'p' );
		$this->template->add_js( '_assets/js/agent/transmissions.js' );
		$this->template->add_js( '_assets/js/libs/tablesorter/jquery.tablesorter.min.js' );	
		$this->template->add_js( '_assets/js/libs/tablesorter/jquery.tablesorter.pager.js' );	
		
		$script = "
			$(document).ready(function() { 
		    	$('table.tablesorter') 
			    	.tablesorter({widthFixed: false}) 
				    .tablesorterPager({container: $('#pager')}); 
				    
				$( '#loadmore' ).click( function(){
					
					var divs = $( 'div.hidden' );
					
					if( divs.length == 0 ) $( '#loadmore' ).hide();	
					
					divs.each( function( index, obj ){
						var obj = $( obj );
						obj.show().removeClass( 'hidden' );
						if( index == 4 )
						{
							return false;
						}
					});	
				});
			
			}); 			
		"; 
		
		$this->template->add_js( $script, 'embed' );
		$this->session->unset_userdata( 'batch_id' );
	}




	public function index( $message = NULL )
	{
		$d = array(
			'transmissions'	=> $this->t->get_transmissions( $this->mek, NULL, TRUE ) 
		);
		
		
		
		if( $message ) $d['show_message'] = true;	
			
		$this->template->write('title', 'Manage Transmissions');
		$this->template->write('sub_title', 'Use this admin to manage your transmissions');
		$this->template->write_view('content', $this->view . 'index', $d);
		$this->template->render();

	}
	
	public function view( $trans_id, $type = 'inventory' )
	{
		
		$this->session->unset_userdata( 'batch' );		
			
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->mek, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id, NULL, $type ),
			'mek'			=> $this->mek
		);
	
		if( $d['transmission']->paid == 'Not Paid' ) show_error( 'You do not have access to the transmission.', 403 );		
		
		
		$this->template->write('title', 'View Transmission');
		$this->template->write('sub_title', 'Your transmission is below');
		$this->template->write_view('content', $this->view . 'view', $d);
		$this->template->render();		
		
	}
	
	
	public function purchase( $tid )
	{
		$credits = $this->c->get_credits( $this->mek );
		if( $credits->credit_count < 8 ) 
			exit( json_encode( array( 'error' => true, 'message' => 'You currently have ' . $credits->credit_count . ' credits, Please purchase more credits.' ) ) );	
		
		$this->c->update_credits_amount( $this->mek,  8, $credits->credit_count );
		$this->t->mark_transmission_paid( $tid, $this->mek );
		
		exit( json_encode( array( 'error' => false ) ) );	
		
	}
}