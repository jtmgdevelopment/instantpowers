<?php


class Jail_Controller extends MY_Controller {

   public function __construct()
	{
		parent::__construct();


		if ( ! $this->session->userdata('logged_in') && $this->session->userdata('role') != 'jail')
        {
			$this->session->set_flashdata('message', 'You are not logged in!! You do not have access to this page!');
			$this->session->set_flashdata('message_type', 'error');
			
			redirect('/login','location');
			return;
        }
		

		if ( $this->session->userdata('role') != 'jail')
        {
			$this->session->set_flashdata('message', 'You do not have access to this page!');
			$this->session->set_flashdata('message_type', 'error');
			
			$url = '/' . $this->session->userdata('role') . '/' . 'cpanel';
			
			redirect( $url, 'location');	
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