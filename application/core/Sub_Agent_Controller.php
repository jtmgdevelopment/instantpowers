<?php


class Sub_Agent_Controller extends MY_Controller {

   public function __construct()
	{
		parent::__construct();

		$lastActivity 	= $this->session->userdata('last_activity');
		$time			= time();
		$diff			= ( $time - $lastActivity ) % 60; 
		if( $diff > 600 )
		{
			 redirect( '/logout', 'location' );
		}

		if ( ! $this->session->userdata('logged_in') && $this->session->userdata('role') != 'sub_agent')
        {
			$this->session->set_flashdata('message', 'You are not logged in!! You do not have access to this page!');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('/login','location');
			return;
        }


		if ( $this->session->userdata('role') != 'sub_agent')
        {
			$this->session->set_flashdata('message', 'You do not have access to this page!');
			$this->session->set_flashdata('message_type', 'error');
			
			$url = '/' . $this->session->userdata('role') . '/' . 'cpanel';
			
			redirect( $url, 'location');	
        }
		
		if( ! $this->session->userdata( 'run_expiration' ) )
		{
			// create a new cURL resource
			$ch = curl_init();
	
			// set URL and other appropriate options
			curl_setopt($ch, CURLOPT_URL, "http://instantpowers.com/_tasks/expire_transmissions.cfm");
			curl_setopt($ch, CURLOPT_HEADER, 0);
	
			// grab URL and pass it to the browser
			curl_exec($ch);
	
			// close cURL resource, and free up system resources
			curl_close($ch);

			$this->session->set_userdata( 'run_expiration', true );
		}
		
		
	}

}