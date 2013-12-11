<?php


class Agent_Controller extends MY_Controller {

   public function __construct()
	{
		parent::__construct();

		$lastActivity 	= $this->session->userdata('last_activity');
		$time			= time();
		$diff			= ( $time - $lastActivity ) % 60; 


 		if( $diff > 600 )
		{
			$this->session->sess_destroy();
			redirect( '/logout', 'location' );
		}


		if ( ! $this->session->userdata('logged_in') && ! in_array( $this->session->userdata('role') , array( 'master_agent', 'sub_agent' ) ) )
        {
			$this->session->set_flashdata('message', 'You are not logged in!! You do not have access to this page!');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('/login','location');
			return;
        }
		
		if( ! $this->session->userdata( 'annual_fee' ) &&  in_array( $this->session->userdata('role') , array( 'master_agent', 'sub_agent' ) ) )
		{		
			$this->annual_fee_check();
		} 


		if (! in_array( $this->session->userdata('role') , array( 'master_agent', 'sub_agent' ) ) )
        {
			$this->session->set_flashdata('message', 'You do not have access to this page!');
			$this->session->set_flashdata('message_type', 'error');
			
			$url = '/' . $this->session->userdata('role') . '/' . 'cpanel';
			
			redirect( $url, 'location');	
        }
		
		
		if( ! $this->session->userdata( 'danzymember' ) )
		{
			$this->load->model( 'agent/crud_model', 'agent' );
			
			$ret = $this->agent->is_danzy_member( $this->session->all_userdata() );			
			
			if( $this->session->userdata( 'username' ) )
			{
				//$ret = true;
			}
			
			$this->session->set_userdata( 'danzymember', $ret );
		}
		
		if( ! $this->session->userdata( 'run_expiration' ) )
		{
			// create a new cURL resource
			$ch = curl_init();
	
			// set URL and other appropriate options
			curl_setopt($ch, CURLOPT_URL, "http://instantpowers.com/_tasks/expire_transmissions.cfm?username=" . $this->session->userdata( 'username' ) );
			curl_setopt($ch, CURLOPT_HEADER, 0);
	
			// grab URL and pass it to the browser
			curl_exec($ch);
	
			// close cURL resource, and free up system resources
			curl_close($ch);

			$this->session->set_userdata( 'run_expiration', true );
		
			//call the has paid methods
		
		
		}
		
		
	}


	private function annual_fee_check()
	{
		$this->load->model( 'agent/annual_fee_model', 'a' );
		$mek = $this->session->userdata( 'mek' );	
		
		$span = $this->a->check_fee_assessment( array( 'mek' => $mek ) );
		
		
		
		if( ! $span && is_bool( $span ) )
		{

			//hasn't paid yet, they will need to pay and set the bad flag
			$this->session->set_userdata( 'annual_fee', false );		
			$this->set_message( 'Please pay, before you proceed', 'info', '/annual_fee' );		

		}
		
		$span = ( int ) $span;
		
		if( $span > 365 )
		{
			//set the bad flag	
			$this->session->set_userdata( 'annual_fee', false );		
			$this->set_message( 'Please pay, before you proceed', 'info', '/annual_fee' );		
			
		}
		else if( $span < 365 )
		{
			
			//set the good flag	
			$this->session->set_userdata( 'annual_fee', true );		
			return true;
		}


		if( ! $this->session->userdata( 'annual_fee' ) )
		{
			$this->set_message( 'Please pay, before you proceed', 'info', '/annual_fee' );		
		} 

	}



	public function secure($url){
	   $data    = $this->mza_secureurl->setSecureUrl_decode($url);
	   
	   if($data != false){
    	  if (method_exists($this, trim($data['function']))){
        	 if(!empty($data['params'])){
            	return call_user_func_array(array($this, trim($data['function'])), $data['params']);
	         }else{
    	        return $this->$data['function']();
        	 }
	      }
	   }
	   show_404();
	}	

}