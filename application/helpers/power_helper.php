<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('power_get_prefix')) {
	
	function power_get_prefix( $key ) {
		$CI =& get_instance();
		$CI->load->database();

		$q = $CI->db->select('prefix' )->get_where( 'power_prefix', array( 'prefix_id' => $key ) )->row_array();



		return $q[ 'prefix' ];
	}
}

?>