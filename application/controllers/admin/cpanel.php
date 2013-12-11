<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cpanel extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

	

	}


	public function index()
	{
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'What would you like to do?');
		$this->template->write_view('content', 'admin/index');
		$this->template->render();


	}
	
	
	public function manage_members()
	{
		
		$this->template->write('title', 'Control Panel');
		$this->template->write('sub_title', 'What would you like to do?');
		$this->template->write_view('content', 'admin/manage_members/index');
		$this->template->render();

		
	}
	
	
	public function truncate()
	{
		
		$tables = $this->db->list_tables();
		$dont_drop = array(
			'contact', 'roles', 
			'transmission_status', 'transaction_type', 
			'power_status', 'power_prefix'
		);
		
		
				
		foreach( $tables as $table )
		{
			if( ! in_array( $table, $dont_drop ) )
			{
				//$this->db->truncate( $table );
			} 	
			
		}

		die( 'done' );			
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */