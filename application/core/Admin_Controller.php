<?php


class Admin_Controller extends MY_Controller {

   public function __construct()
	{
		parent::__construct();


		if ( ! $this->session->userdata('logged_in') && $this->session->userdata('role') != 'admin')
        {
			$this->session->set_flashdata('message', 'You are not logged in!! You do not have access to this page!');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('/login','location');
			return;
        }


		if ( $this->session->userdata('role') != 'admin')
        {
			$this->session->set_flashdata('message', 'You do not have access to this page!');
			$this->session->set_flashdata('message_type', 'error');
			
			$url = '/' . $this->session->userdata('role') . '/' . 'cpanel';
			
			redirect( $url, 'location');	
        }
	}

}