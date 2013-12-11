<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cpanel extends Agent_Controller {



	public function __construct()
	{
		parent::__construct();
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'What would you like to do?');
		$this->template->write_view('content', 'agent/index');
		$this->template->render();
			
	}
	
	


	public function index()
	{


	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */