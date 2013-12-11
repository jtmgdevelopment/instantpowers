<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cpanel extends Insurance_Controller {

	private $view;
	private $mek;

	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'insurance/insurance_crud_model', 'i' );
		$this->view   = 'insurance/prefixes/';
		$this->mek    = $this->session->userdata( 'mek' );
		$agency_id    = $this->i->get_insurance_agent( array( 'mek' => $this->mek ) )->insurance_agency_id;
		$this->session->set_userdata( 'insurance_agency_id', $agency_id );
		}


	public function index()
	{

		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'What would you like to do?');
		$this->template->write_view('content', 'insurance/index');
		$this->template->render();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */