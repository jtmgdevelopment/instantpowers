<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_clerks extends Admin_Controller {

	private $view;


	public function __construct()
	{
		parent::__construct();
		$this->view = 'admin/manage_members/clerk/';
		$this->load->model('admin/clerk_model', 'c' );
		$this->template->add_js( '_assets/js/admin/clerk.js' );
	}


	public function index()
	{
		$data = array(
			'agents' => $this->c->get_clerks()
		);
	
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'Use this admin to add/edit/delete clerk of courts');
		$this->template->write_view('content', $this->view . 'index', $data);
		$this->template->render();
	}
	
	public function add_clerk()
	{	
		$data = array(
			'clerk' 	=> array()
		);
		
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'Use the form below to add an clerk of courts');
		$this->template->write_view('content', $this->view . 'add_edit_clerk', $data);
		$this->template->render();		
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
	
	public function deactivate_clerk( $mek )
	{
		$this->c->deactivate_clerk( $mek );
		$msg = 'You successfully deactivated this clerk';
		$this->set_message($msg, 'done', '/admin/manage_clerk/' );
	}

	public function activate_clerk( $mek )
	{
		$this->c->activate_clerk( $mek );
		$msg = 'You successfully activated this clerk';
		$this->set_message($msg, 'done', '/admin/manage_clerk/' );
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */