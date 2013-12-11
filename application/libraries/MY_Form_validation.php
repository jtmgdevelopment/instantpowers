<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class MY_Form_validation extends CI_Form_validation {
   
	var $CI;

	function __construct()
	{
		parent::__construct();
		// Copy an instance of CI so we can use the entire framework.
		$this->CI =& get_instance();
		
		$this->CI->load->library('form_validation');
		$this->CI->load->database();
		$this->CI->load->library('cc_validation');
	
	}

	function check_power_transfer_amount( $str, $t )
	{
	
		$value 		= intval( $str );
		$max_value 	= intval( $t );
		
		if( $value > $max_value )
		{
			
			$this->CI->form_validation->set_message('check_power_transfer_amount', 'The amount of powers exceeds the available total powers you have. Please try again.');
			return FALSE;
			
		}
		return TRUE;
		
	}

	function check_ins_premium_add( $str )
	{
		
		$mek = $this->CI->session->userdata( 'mek' );
		
		$sql = '
			SELECT premium_id
			FROM premiums
			WHERE 1 = 1 
			AND transmitter_id = ? 
			AND mek = ?
		';
		
		
		$q = $this->CI->db->query( $sql, array( $str, $mek ) )->num_rows();
		
		if( $q > 0 ) 
		{
			$this->CI->form_validation->set_message('check_ins_premium_add', 'You have already added a premium to this transmitting company. If you need to edit this premium, please navigate the edit premium form.');
			return FALSE;
			
		}
		
		return TRUE;
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
	
	function check_prefix($str)
	{

		$query = $this->CI->db->get_where('power_prefix', array('prefix' => $str));
		
		if($query->num_rows() > 0)
		{
			$this->CI->form_validation->set_message('check_prefix', $str . ' prefix is already in use, please try another');
			return FALSE;
				
		}
		return TRUE;
		
	}
	
	
	
	
	function check_power_availability($power1, $power2)
	{
		$start 	= $this->CI->input->post('power_start');
		$end 	= $this->CI->input->post('power_end');
		$prefix	= $this->CI->input->post('power_prefix');
		
		
	
		$sql = '
			select * from power
			where pek between ? and ? and prefix_id = ?
			
		';
		//--and power_prefix = ?
		
		$query = $this->CI->db->query($sql, array($start, $end, $prefix ) );		
		
		if( $query->num_rows() )
		{
			$this->CI->form_validation->set_message('check_power_availability', 'The powers you specified are already in use, please try again');
			return FALSE;
		}
		return true;
	}



	function card_number_valid ($card_number) {
		
		$response = $this->CI->cc_validation->validateCreditcard_number($card_number);
		
		if( $response['status'] == 'false')
		{
		
			$this->CI->form_validation->set_message('card_number_valid', 'Your credit card number is invalid, please try again');
			return FALSE;
		}
		
		return TRUE;
	}


	
}