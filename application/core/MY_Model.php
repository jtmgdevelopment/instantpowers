<?php

class MY_Model extends CI_Model {

   public function __construct()
	{
		parent::__construct();
		
		if(ENVIRONMENT == 'development'  || ENVIRONMENT == 'devlocal')
		{
			$this->output->enable_profiler(TRUE);
			
			
			require_once(realpath( './application/third_party/kint/Kint.class.php' ));			
		} 
	}

	protected function mysql_date_format($date)
	{
		if( strlen($date) )
		{
			return date( 'Y-m-d H:i:s', strtotime($date));
		}
		
		return NULL;
		
	}
	
	protected function now()
	{
		
		return date( 'Y-m-d H:i:s');	
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



	protected function generate_password ($length = 8)
  {

    // start with a blank password
    $password = "";

    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
  
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
      $length = $maxlength;
    }
	
    // set up a counter for how many characters are in the password so far
    $i = 0; 
    
    // add random characters to $password until $length is reached
    while ($i < $length) { 

      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        
      // have we already used this character in $password?
      if (!strstr($password, $char)) { 
        // no, so it's OK to add it onto the end of whatever we've already got...
        $password .= $char;
        // ... and increase the counter by one
        $i++;
      }

    }

    // done!
    return $password;

  }
  
	protected function remove_keys( $array, $keys )
	{
		foreach( $keys as $key ) unset( $array[ $key ] );
		
		return $array;
	}
	
	protected function get_keys( $a )
	{
		$keys = '';
		$a = array_keys( $a );
		for( $i = 0; $i < count( $a ); $i++ )
		{
		
			$keys .= "'" . $a[ $i ] . "', ";
			
		}
		
		die( $keys );
	}


	
	protected function get_value( $array, $key )
	{
		$array = ( array ) $array;
		
		if( isset($array[ $key ] ) && strlen( $array[ $key ] ) > 0 )
		{
			return $array[ $key ]; 	
		}
		
		return NULL;
		
		//return ( isset($array[ $key ] ) && strlen( $array[ $key ] ) > 1 ? $array[ $key ] : NULL );
	}	
	


}