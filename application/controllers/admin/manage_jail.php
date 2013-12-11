<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_jail extends Admin_Controller {

	private $view;


	public function __construct()
	{
		parent::__construct();
		$this->view = 'admin/manage_members/jail/';
		$this->load->model('admin/jail_model', 'j' );
		$this->load->model('jail/jail_crud_model', 'jail' );
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');		
		$this->template->add_js( '_assets/js/admin/jail.js' );
	}


	public function edit_jail_admin( $mek )
	{
		$view = 'add_edit_jail';
		
		$d = array(
			'jail_admin' 	=> $this->jail->get_jail( array( 'mek' => $mek ) ),
			'no_pass'		=> true,
			'update'		=> true
		);

		$this->template->write('title', 'Edit Jail Admins');
		$this->template->write('sub_title', 'Edit Jain');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();
		
	}



	public function index()
	{
		$data = array(
			'jail_admins' => $this->j->get_jail_admins()
		);
	
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'Use this admin to add/edit/delete jail administrators');
		$this->template->write_view('content', $this->view . 'index', $data);
		$this->template->render();
	}
	
	public function add_jail_admin()
	{	
		$data = array(
			'jail_admin' 	=> array(),
			'no_pass'		=> false,
			'update'		=> false

		);
		
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'Use the form below to add an jail_admin');
		$this->template->write_view('content', $this->view . 'add_edit_jail', $data);
		$this->template->render();		
	}



	public function process_jail_admin_frm()
	{	
		$mek = $this->input->post( 'mek' );
		
		if( $this->j->validate_jail_admin_frm() )
		{
			
			
			//save the form
			if( ! strlen( $mek ) ) $this->j->send_jail_admin_info();
			$this->j->save_jail_admin( $mek );
			//write message
			$msg = 'You successfully saved this jail administrator';
			//set message and redirect	
			$this->set_message( $msg, 'done', '/admin/manage_jail' );
		}
		else
		{
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			//load view	
			if( strlen( $mek ) ) $this->edit_jail_admin( $mek );
			else $this->add_jail_admin();
		}
	}
	
	public function deactivate_jail_admin( $mek )
	{
		$this->j->deactivate_jail_admin( $mek );
		$msg = 'You successfully deactivated this jail admin';
		$this->set_message($msg, 'done', '/admin/manage_jail/' );
	}

	public function activate_jail_admin( $mek )
	{
		$this->j->activate_jail_admin( $mek );
		$msg = 'You successfully activated this jail admin';
		$this->set_message($msg, 'done', '/admin/manage_jail/' );
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */