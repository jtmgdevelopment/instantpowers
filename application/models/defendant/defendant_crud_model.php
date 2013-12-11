<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	public function validate_sub_agent_history_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
	
		$this->form_validation->set_rules('name', 'Full Name', 'required|trim');		
		$this->form_validation->set_rules('email', 'Email', 'required|email|trim');		
		$this->form_validation->set_rules('subject', 'Subject', 'required|trim');
		$this->form_validation->set_rules('message', 'Message', 'required|trim');


		return $this->form_validation->run();
		
		
	}



*/

class defendant_crud_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	public function save( $d )
	{	
	
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('defendant_fname', 'Defendant First Name', 'required|trim');
		$this->form_validation->set_rules('defendant_lname', 'Defendant Last Name', 'required|trim');
		
		if( ! $this->form_validation->run() ) return false;
	
		$defendant_info = array(
			'first_name'		=> $this->get_value( $d, 'defendant_fname' ),
			'last_name'			=> $this->get_value( $d, 'defendant_lname' ),
			'email'				=> $this->get_value( $d, 'defendant_email' ),
			'ssn'				=> $this->get_value( $d, 'defendant_social_security_number' ),
			'dob'				=> $this->get_value( $d, 'defendant_dob' ),
			'address'			=> $this->get_value( $d, 'defendant_address' ),
			'city'				=> $this->get_value( $d, 'defendant_city' ),
			'state'				=> $this->get_value( $d, 'defendant_state' ),
			'zip'				=> $this->get_value( $d, 'defendant_zip' ),
			'phone'				=> $this->get_value( $d, 'defendant_phone' ),
			'dl'				=> $this->get_value( $d, 'defendant_dl' )
		);
		
		$indemnitor = array(
			'first_name'		=> $this->get_value( $d, 'indemnitor_first_name' ),
			'last_name'			=> $this->get_value( $d, 'indemnitor_last_name' ),
			'email'				=> $this->get_value( $d, 'indemnitor_email' ),
			'ssn'				=> $this->get_value( $d, 'indemnitor_social_security_number' ),
			'dob'				=> $this->get_value( $d, 'indemnitor_dob' ),
			'address'			=> $this->get_value( $d, 'indemnitor_address' ),
			'city'				=> $this->get_value( $d, 'indemnitor_city' ),
			'state'				=> $this->get_value( $d, 'indemnitor_state' ),
			'zip'				=> $this->get_value( $d, 'indemnitor_zip' ),
			'phone'				=> $this->get_value( $d, 'indemnitor_phone' ),
			'dl'				=> $this->get_value( $d, 'indemnitor_dl' )
		);
		
		$collateral = array(
			'type'				=> $this->get_value( $d, 'collateral_type' ),
			'owner'				=> $this->get_value( $d, 'collateral_owner' ),
			'amount'			=> $this->get_value( $d, 'collateral_amount' ),
			'desc'				=> $this->get_value( $d, 'collateral_description' )
		);
		
		
		
		$this->db->update( 'power_details_defendant' , $defendant_info, array( 'power_id' => $d[ 'power_id' ] ) );
		$this->db->update( 'power_details_indemnitor' , $indemnitor, array( 'power_id' => $d[ 'power_id' ] ) );		
		$this->db->update( 'power_details_collateral' , $collateral, array( 'power_id' => $d[ 'power_id' ] ) );		
		
		return true;
	}
	
	
	
	public function get( array $args )
	{
		
		$sql = '
			SELECT 
			concat( pdd.first_name, " ", pdd.last_name ) as defendant_name, pdd.first_name as defendant_fname, pdd.last_name as defendant_lname,
			pdd.email as defendant_email, pdd.ssn as defendant_ssn, pdd.dob as defendant_dob, pdd.address as defendant_address, pdd.city  as defendant_city, 
			pdd.state as defendant_state, pdd.zip  as defendant_zip, pdd.phone  as defendant_phone, pdd.dl as defendant_dl,
			

			concat( pdi.first_name, " ", pdi.last_name ) as indemnitor_name, pdi.first_name as indemnitor_fname, pdi.last_name as indemnitor_lname,
			pdi.email as indemnitor_email, pdi.ssn as indemnitor_ssn, pdi.dob as indemnitor_dob, pdi.address as indemnitor_address, pdi.city  as indemnitor_city, 
			pdi.state as indemnitor_state, pdi.zip  as indemnitor_zip, pdi.phone  as indemnitor_phone, pdi.dl as indemnitor_dl,
			
			pdc.type, pdc.owner, pdc.amount, pdc.desc
			
			FROM power_details_defendant as pdd
			INNER JOIN power_details_collateral as pdc
				ON pdc.power_id = pdd.power_id
			INNER JOIN power_details_indemnitor as pdi
				ON pdi.power_id = pdd.power_id
			WHERE 1 = 1
			AND pdd.power_id = ?
		';
		
		
		return $this->db->query( $sql, array( $args[ 'power_id' ] ) )->row_array();
	
		
		
	}

}