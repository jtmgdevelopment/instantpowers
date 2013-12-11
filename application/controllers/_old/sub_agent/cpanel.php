<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cpanel extends Sub_Agent_Controller {



	public function __construct()
	{
		parent::__construct();
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'What would you like to do?');
		$this->template->write_view('content', 'sub_agent/index');
		$this->template->render();

	

	}


	public function index()
	{


	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */