<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function safe_url( $class, $function, $params = array()  )
{
	$CI =& get_instance();
	
	if( ENVIRONMENT == 'development' || ENVIRONMENT == 'testing' || ENVIRONMENT == 'devlocal' ) return $class . '/' . $function . '/' . implode( '/' , $params ); 
	
	
		
	return $CI->mza_secureurl->setSecureUrl_encode( $class, $function, $params );
}
