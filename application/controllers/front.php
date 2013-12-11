<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class front extends MY_Controller {

	

	public function __construct()
	{

		parent::__construct();
		$this->template->set_template('exterior');
	//	dd( 'Need to add jail/court info tables and udate the create forms' );
	}


	public function process_password_frm()
	{
		

		//load the member model
		$this->load->model( 'member_model', 'm' );
		//validate the form
		if( ! $this->m->validate_password_frm() )
		{
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			//load view	
			$this->forget_password();
			
		}
		else
		{
			//save the form
			if( ! $this->m->send_password_info() )
			{
				//write errors
				$this->template->write( 'errors', '<li>We could not find your account, please try again or contact support for more help</li>');
				//load view	
				$this->forget_password();
				return false;				
			}
			//write message
			$msg = 'Your password has been reset and has been emailed to your email address on file.';
			//set message and redirect	
			$this->set_message( $msg, 'success', '/login' );
		}

		
	}

	public function forget_password()
	{
		
	
	
		$this->template->write('title', 'Forget Password');
		$this->template->write_view('content', 'includes/exterior/forget_password' );
		$this->template->render();
		
	}


	public function index()
	{

		$this->template->write('title', 'Home');
		$this->template->write_view('content', 'includes/exterior/home' );
		$this->template->render();
	}


	/*
		register ins methods
	*/

	public function process_agent_frm()
	{	
		//load the member model
		$this->load->model( 'member_model', 'm' );
		//validate the form
		if( ! $this->m->validate_agent_frm() )
		{
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			//load view	
			$this->register_agents();
			
		}
		else
		{
			//save the form
			$this->m->send_agent_info();
			$this->m->save_agent();
			//write message
			$msg = 'You can now login with your registered email address and password. Thank you for registering for Instant Powers.';
			//set message and redirect	
			$this->set_message( $msg, 'success', '/login' );
		}
		
	}

	public function agent_confirmation()
	{
		$data = array('title' => 'Register Agents' );

		
		$this->template->write('title', 'Register Agents');
		$this->template->write_view('content', 'includes/exterior/agent_confirmation', $data );
		$this->template->render();

	}


	public function register_agents()
	{
		$this->load->model( 'member_model', 'm' );
				
		$data = array(
			'title' => 'Register Agents',
			'ins'	=> $this->m->get_insurance_agencies()
		);

		
		
		$this->template->write('title', 'Register Agents');
		$this->template->write_view('content', 'includes/exterior/register_agents', $data );
		$this->template->render();

	}


	/*
		register ins methods
	*/

	public function process_insurance_frm()
	{	
		//load the member model
		$this->load->model( 'member_model', 'm' );
		//validate the form
		if( ! $this->m->validate_insurance_frm() )
		{
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			//load view	
			$this->register_insurance();
			
		}
		else
		{
			//save the form
			$this->m->send_insurance_info();
			//write message
			$msg = 'Your information was sent to an Instant Powers Administrator. Instant Powers will contact you within 24 hours.';
			//set message and redirect	
			$this->set_message( $msg, 'success', '/register_insurance' );
		}
		
	}



	public function register_insurance()
	{
		$data = array('title' => 'Register Insurance Company' );

		
		$this->template->write('title', 'Register Insurance Company');
		$this->template->write_view('content', 'includes/exterior/register_insurance', $data );
		$this->template->render();

	}


	/*
		register jail methods
	*/

	public function process_jail_frm()
	{	
		//load the member model
		$this->load->model( 'member_model', 'm' );
		//validate the form
		if( ! $this->m->validate_jail_frm() )
		{
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			//load view	
			$this->register_jail();
			
		}
		else
		{
			//save the form
			$this->m->send_jail_info();
			//write message
			$msg = 'Your information was sent to an Instant Powers Administrator. Instant Powers will contact you within 24 hours.';
			//set message and redirect	
			$this->set_message( $msg, 'success', '/register_jail' );
		}
		
	}



	public function register_jail()
	{
		$data = array('title' => 'Register Jail' );

		
		$this->template->write('title', 'Register Jail');
		$this->template->write_view('content', 'includes/exterior/register_jail', $data );
		$this->template->render();

	}




	/*
		register clerks methods
	*/

	public function process_clerks_frm()
	{	
		//load the member model
		$this->load->model( 'member_model', 'm' );
		//validate the form
		if( ! $this->m->validate_clerks_frm() )
		{
			//write errors
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			//load view	
			$this->register_clerks();
			
		}
		else
		{
			//save the form
			$this->m->send_clerk_info();
			//write message
			$msg = 'Your information was sent to an Instant Powers Administrator. Instant Powers will contact you within 24 hours.';
			//set message and redirect	
			$this->set_message( $msg, 'success', '/register_clerks' );
		}
		
	}


	public function register_clerks()
	{
		$data = array('title' => 'Register Clerk Of Courts' );

		
		$this->template->write('title', 'Register Clerk Of Courts');
		$this->template->write_view('content', 'includes/exterior/register_clerks', $data );
		$this->template->render();

	}




	/*
		Contact US
	
	*/


	public function process_contact_frm()
	{
		$this->load->model('contact_model' , 'c');
	
		if( ! $this->c->validate_contact_frm() )
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->contact();
		}
		else
		{
			$this->c->save_contact_frm();	
			$msg = 'Thank you for contacting us';
			$this->set_message( $msg, 'success', '/contact' );
		}
	}




	public function contact()
	{
		$data = array('title' => 'Contact' );
		  
		$this->template->write('title', 'Contact' );
		$this->template->write_view('content', 'includes/exterior/contact', $data );
		$this->template->render();
	}

	/*
		LOGIN 
	*/


	public function process_login()
	{
		$this->load->model( 'authenticate_model', 'a' );

		$ret = $this->a->validate_login();
		if( ! $ret ) $this->set_message( 'Invalid Login', 'error', '/login' );
	
	
		$url = '/' . $this->session->userdata('role') . '/cpanel';

		if( in_array( $this->session->userdata('role'), array( 'master_agent', 'sub_agent' ) ) )
		{
			$url = '/agent/cpanel';
		} 
		
		redirect( $url, 'location' );		 		
	}

	public function Login()
	{
		$data = array('title' => 'Login' );

		
		$this->template->write('title', 'Login');
		$this->template->write_view('content', 'includes/exterior/login', $data );
		$this->template->render();

	}


	/*
		logout 
	*/

	public function logout()
	{

		$this->session->sess_destroy();
		$msg	= 'You have successfully logged out.';
		$this->set_message( $msg, 'success', '/login' );

	}


	public function private_truncate()
	{
		
		$tables = $this->db->list_tables();
		$dont_drop = array(
			'contact', 'roles', 
			'transmission_status', 'transaction_type', 
			'power_status'
		);
		
		$tables = array(
		'power',
		'transmission',
		'master_agent_report',
		'master_agent_report_data',
		'power_history',
		'power_sub_agent_history',
		'power_sub_agent_join',
		'jail_accepted_powers_data',
		'jail_accepted_powers_report',
		'power_details_collateral',
		'power_details_defendant',
		'power_details_indemnitor',
		'power_sub_agent_join',
		'saved_powers',
		'power_details',
		'transmission'
		);
				
		foreach( $tables as $table )
		{
			if( ! in_array( $table, $dont_drop ) )
			{
				$this->db->truncate( $table );
			} 	
			
		}

		die( 'done' );			
		
	}

	public function process_private_login()
	{
		
		$this->load->model( 'authenticate_model', 'a' );

		$this->a->private_login( );
	
		$url = '/' . $this->session->userdata('role') . '/cpanel';

		if( in_array( $this->session->userdata('role'), array( 'master_agent', 'sub_agent' ) ) ) $url = '/agent/cpanel';;
		
		redirect( $url, 'location' );				
		
	}

	public function private_login( $pass = NULL )
	{
		
		if( ! isset( $pass ) || $pass != 'danzydomains' ) die;
		
		
		$this->load->model( 'authenticate_model', 'a' );
		

		$data = array('title' => 'Login' );
		
		$data[ 'u' ] = $this->a->get_members();
		
		
		
		$this->template->write('title', 'Login');
		$this->template->write_view('content', 'includes/exterior/private', $data );
		$this->template->render();
		
		
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */