<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_credits extends Master_Agent_Controller {

	private $view;
	private $mek;

	public function __construct()
	{
		parent::__construct();
		$this->view = 'master_agent/manage_credits/';
		$this->mek	= $this->session->userdata( 'mek' );

		$this->load->model( 'credits/credits_model', 'c' );
		$this->template->add_js( '_assets/js/credits/credits.js' );

	}


	public function index()
	{
		
		
		$data = array(
			'credits'		=> $this->c->get_credits( $this->mek ),
			'transactions'	=> $this->c->get_credit_history( $this->mek )
		);
			
		$this->template->write('title', 'Manage Credits');
		$this->template->write('sub_title', 'Use this admin to manage your transmission credits');
		$this->template->write_view('content', $this->view . 'index', $data);
		$this->template->render();


	}
	
	
	
	public function add_credits()
	{
	
		$this->template->write('title', 'Add Credits');
		$this->template->write('sub_title', 'Use the form below to add credits');
		$this->template->write_view('content', $this->view . 'add_credits');
		$this->template->render();
	
	}

	
	public function process_credits_frm()
	{
		if( $this->c->validate_credits_frm() )
		{
			$ret = $this->c->purchase_credits( $this->mek );
			
			
			if( $ret[ 'success' ]  )
			{
				$msg = 'Your purchase was successful. Your credits are now available to use';
				$this->set_message( $msg, 'done', '/master_agent/manage_credits');	
				return true;	
			}		
			
			
			$msg = $ret[ 'error' ] . ' Please try again';
			$this->template->write('errors', $msg );		
			$this->add_credits();
		}		
		else
		{
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->add_credits();
		}
	
	}
	
	

	public function process_clerk_frm()
	{	
		$mek = $this->input->post( 'mek' );
		
		if( $this->c->validate_clerk_frm() )
		{
			//save the form
			if( ! strlen( $mek ) ) $this->c->send_clerk_info();
			$this->c->save_clerk( $mek );
			//write message
			$msg = 'You successfully saved this clerk';
			//set message and redirect	
			$this->set_message( $msg, 'success', '/admin/manage_clerks' );
		}
		else
		{
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			//load view	
			if( strlen( $mek ) ) $this->edit_clerk( $mek );
			else $this->add_clerk();
		}
	}
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */