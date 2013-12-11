<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_bail extends Admin_Controller {

	private $view;


	public function __construct()
	{
		parent::__construct();
		$this->view = 'admin/manage_members/bail/';
		$this->load->model( 'admin/bail_model', 'b' );
		$this->template->add_js( '_assets/js/admin/bail.js' );

	}


	public function index()
	{
		
		$data = array(
			'agents' => $this->b->get_agents()
		);
		
		
		
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'Use this admin to add/edit/delete bail agents');
		$this->template->write_view('content', $this->view . 'index', $data);
		$this->template->render();


	}
	
	public function deactivate_agent( $mek )
	{
		$this->b->deactivate_agent( $mek );
		$msg = 'You successfully deactivated this agent';
		$this->set_message($msg, 'done', '/admin/manage_bail/' );
	}

	public function activate_agent( $mek )
	{
		$this->b->activate_agent( $mek );
		$msg = 'You successfully activated this agent';
		$this->set_message($msg, 'done', '/admin/manage_bail/' );
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */