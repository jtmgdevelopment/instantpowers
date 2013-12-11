<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*

class MY_Form_validation extends CI_Form_validation {
   
	var $CI;

	function __construct()
	{
		parent::__construct();
		// Copy an instance of CI so we can use the entire framework.
		$this->CI =& get_instance();
		
		$this->CI->load->library('form_validation');
		$this->CI->load->database();
		
	}


	function username_check($str)
	{
		$query = $this->CI->db->get_where('security', array('username' => $str));
		
		if($query->num_rows() > 0)
		{
			$this->CI->form_validation->set_message('username_check', $str . ' username is already in use, please try another');
			return FALSE;
				
		}
		return TRUE;
		
	}

	function email_check($str)
	{
		$query = $this->CI->db->get_where('member', array('email' => $str));
		
		if($query->num_rows() > 0)
		{
			$this->CI->form_validation->set_message('email_check', $str . ' email is already in use, please try another');
			return FALSE;
				
		}
		return TRUE;
		
	}

	function compare_passwords($pass1, $pass2)
	{
		if( $pass1 != $pass2)
		{
			$this->CI->form_validation->set_message('compare_passwords', 'Your new password does not match your old one');
			return FALSE;
		}
		return TRUE;
	}
	
}
*/