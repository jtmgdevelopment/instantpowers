<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Print_Center {
	
	
    private $CI;


	/** 
	* Class Constructor
	*/
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	

	public function print_power( array $power, $filename )
	{
		$data = array(
			'power' => $power
		);
		$html = $this->CI->load->view('print/powers/' . $filename . '_power', $data, true );
		$file = pdf_create( $html, uniqid( 'power_' . $filename ), true );		

	}
	
}