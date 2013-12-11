<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage extends Secured_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'defendant/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->load->model( 'defendant/defendant_crud_model' , 'd' );
		$this->load->helper('state');
		$this->load->helper('html');				
	

	}
	
	public function save()
	{
		$d = $this->sfa();
		
		if( ! $this->d->save( $d ) )
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->edit( $d[ 'power_id' ] );	
		}
		else
		{
			
			$msg = 'You successfully saved this information';
			$this->set_message( $msg, 'done', '/defendant/manage/view/' . $d[ 'power_id' ] );
			
		}
	
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
	
	public function edit( $power_id )
	{
		
		$view = 'edit';
		$d = array(
			'defendant' => $this->d->get( array( 'power_id' => $power_id ) ),
			'power_id'	=> $power_id
		
		);

		$this->template->write('title', 'Edit Defendant');
		$this->template->write('sub_title', 'You will find the defendant&rsquo;s information below.');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}
	
	
	public function view( $power_id )
	{
		
		
 		$view = 'view';
		$d = array(
			'defendant' => $this->d->get( array( 'power_id' => $power_id ) ),
			'power_id'	=> $power_id
		
		);

		$this->template->write('title', 'View Defendant');
		$this->template->write('sub_title', 'You will find the defendant&rsquo;s information below.');
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

