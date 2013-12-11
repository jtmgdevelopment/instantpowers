<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_mga extends Admin_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		$this->view = 'admin/manage_members/mga/';
		$this->load->model('mga/mga_crud_model', 'mga' );
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');		
		$this->template->add_js( '_assets/js/admin/mga.js' );
	}   


	public function process_mga_admin_frm()
	{
		$mek = $this->input->post( 'mek' );
		
		if( $this->mga->validate_mga_admin_frm() )
		{
			  
			
			//save the form
			if( ! strlen( $mek ) ) $this->mga->send_mga_admin_info();
			$this->mga->save_mga_admin( $mek );
			//write message
			$msg = 'You successfully saved this MGA administrator';
			//set message and redirect	
			$this->set_message( $msg, 'done', '/admin/manage_mga' );
		}
		else
		{
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			//load view	
			if( strlen( $mek ) ) $this->edit_mga_admin( $mek );
			else $this->add_mga_admin();
		}
		
		
	}

	public function add_mga_admin()
	{
		$view = 'add_edit_mga';
		$d = array(
			'mga_admin' => array(),
			'no_pass'	=> false
		);

		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'Use this admin to add/edit/delete MGA administrators');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}

	public function edit_mga_admin( $mek )
	{
		$view = 'add_edit_mga';
		
		$d = array(
			'mga_admin' => $this->mga->get_mga_admins( array( 'mek' => $mek ) ),
			'no_pass'	=> true
		);
		
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'Use this admin to add/edit/delete MGA administrators');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}


	public function index()
	{
		$view = 'index';
		$d = array(
			'mga_admins' => $this->mga->get_mga_admins()
		);



		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'Use this admin to add/edit/delete MGA administrators');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
	
	public function deactivate_mga_admin( $mek )
	{
		$this->mga->deactivate_mga_admin( $mek );
		$msg = 'You successfully deactivated this MGA admin';
		$this->set_message($msg, 'done', '/admin/manage_mga/' );
	}

	public function activate_mga_admin( $mek )
	{
		$this->mga->activate_mga_admin( $mek );
		$msg = 'You successfully activated this MGA admin';
		$this->set_message($msg, 'done', '/admin/manage_mga/' );
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

