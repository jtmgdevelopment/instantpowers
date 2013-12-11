<?php
define('TIME', date('Y-m-d G:i:s'));

class MY_Controller extends CI_Controller {

   public function __construct()
	{
		parent::__construct();
		
		
		if(ENVIRONMENT == 'development' || ENVIRONMENT == 'testing' || ENVIRONMENT == 'devlocal')
		{
			$this->output->enable_profiler(TRUE);
			require_once(realpath( './application/third_party/kint/Kint.class.php' ));			
		} 

	}
	
	
	protected function sfa()
	{
		
		$form_values = array();
		
		foreach( $_POST as $key => $data )  		
		{	
			$form_values[ $key ] = $this->input->post( $key );
			$this->form_validation->set_rules($key, $key, 'trim|xss_clean|prep_for_form');
		}
		
		$form_values['ip'] = $this->input->ip_address();
		
		return $form_values;		
	}
	
	protected function now()
	{
		
		return date( 'Y-m-d H:i:s');	
	}
	
	public function d($var)
	{
		print_r($var);
		exit();
	}	


	protected function save($model, $method, $message, $redirect, $show_errors = TRUE)
	{
		$this->load->model($model);	
		$response = $this->$model->$method();

		if( ! strlen($message)) $message = 'Your information has been successfully updated';
		
		if($response['success'])
		{
			$this->set_message($message, 'success', $redirect);
		}
		else
		{
			if($show_errors) $this->template->write_view('errors', 'includes/form_errors', $response);	
		}
	}
	
	
	
	
	protected function set_message($message, $message_type, $redirect = NULL)
	{
		$this->session->set_flashdata('message_type', $message_type);
		$this->session->set_flashdata('message', $message);
		if($redirect) redirect($redirect, 'location');
	}
	
	
	protected function set_errors($e)
	{
		return  '<div class="msg error"><ul class="nostyle">' . $e . '</ul></div>';
		
	}



	protected function set_fields( $data, $name )
	{

		return  ( strlen($e) > 0 ? $e : set_field( $name ) );
		
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
	
	/*
		data array
		id key
		value key
		starting select opt
		pass in the following array
		
		array(
			'data' 		=> 'array',
			'id_opt'	=> 'id',
			'val_opt'	=> 'value',
			'default'	=> 'default value'
		);
	*/
	
	
	public function create_sub_select_array(  array $a = NULL )
	{
		$z =  (  array_key_exists('default', $a ) ? array('' => $a[ 'default' ] ) : array() );		
		foreach( $a[ 'data' ] as $val ) $z[ $val[ $a[ 'id_opt' ] ] ] = $val[ $a[ 'val_opt' ] ];		
		return $z;		
	}



	/*
		role_access
		* this will restrict roles on the method level
		- resticted_role
		- role
	*/

	public function role_access( $restricted_role, $role )
	{
		if( $restricted_role == $role )  show_404();
		
		return;
	}	




	
}