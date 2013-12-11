<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class manage_insurance extends Admin_Controller {



	private $view;





	public function __construct()

	{
		parent::__construct();
		$this->view = 'admin/manage_members/insurance/';
		$this->load->model('admin/insurance_model', 'i' );
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');		
		$this->template->add_js( '_assets/js/admin/ins.js' );
	}


	public function edit_ins_admin( $mek )
	{
		$view = 'add_edit_agent';
		
		$d = array(
			'agent' 		=> $this->i->get_agent( array( 'mek' => $mek ) ),
			'no_pass'		=> true,
			'update'		=> true
		);

		$this->template->write('title', 'Edit Insurance Admins');
		$this->template->write('sub_title', 'Edit Insurance');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();
		
	}



	public function index()

	{

		$data = array(

			'agents' => $this->i->get_agents()

		);

	

		$this->template->write('title', 'Control Panel');

		$this->template->write('sub_title', 'Use this admin to add/edit/delete insurance agents');

		$this->template->write_view('content', $this->view . 'index', $data);

		$this->template->render();

	}

	

	public function add_agent()

	{	

		$data = array(
			'agent' 	=> array(),
			'agency'	=> array(),
			'no_pass'		=> false,
			'update'		=> false
		);

		$this->template->write('title', 'Control Panel');

		$this->template->write('sub_title', 'Use the form below to add an insurance agent');

		$this->template->write_view('content', $this->view . 'add_edit_agent', $data);

		$this->template->render();		

	}







	public function process_agent_frm()

	{	

		$mek = $this->input->post( 'mek' );

		

		if( $this->i->validate_agent_frm() )

		{

			//save the form

			if( ! strlen( $mek ) ) $this->i->send_agent_info();

			$this->i->save_agent( $mek );

			//write message

			$msg = 'You successfully saved this agent';

			//set message and redirect	

			$this->set_message( $msg, 'success', '/admin/manage_insurance' );

		}

		else

		{

			//write errors

			$this->template->write( 'errors', $this->set_errors(validation_errors()));

			//load view	
			if( strlen( $mek ) ) $this->edit_ins_admin( $mek );

			else $this->add_agent();

		}

	}

	

	public function deactivate_agent( $mek )

	{

		$this->i->deactivate_agent( $mek );

		$msg = 'You successfully deactivated this agent';

		$this->set_message($msg, 'done', '/admin/manage_insurance/' );

	}



	public function activate_agent( $mek )

	{

		$this->i->activate_agent( $mek );

		$msg = 'You successfully activated this agent';

		$this->set_message($msg, 'done', '/admin/manage_insurance/' );

	}

	

}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */