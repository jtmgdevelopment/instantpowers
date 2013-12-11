<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class premium_crud_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	public function validate_premium_pts_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');			
		$this->form_validation->set_rules('premium', 'Premium Points', 'required|numeric|trim');		
		$this->form_validation->set_rules('buf', 'BUF Points', 'required|numeric|trim');		
		return $this->form_validation->run();
			
	}

	
	public function validate_ins_choose_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');			
		$this->form_validation->set_rules('ins_company', 'Insurance Company', 'required|check_ins_premium_add|trim');		
		return $this->form_validation->run();
			
	}
	
	
	/*
		SAVE PREMIUM PTS
		- MEK
	*/

	
	public function save_premium_pts( array $a = NULL )
	{
		$d = $this->sfa();
		
		if( $d[ 'premium_id' ] > 0 ) $this->update_premium_pts( $d );
		else $this->insert_premium_pts( $d );	

		return true;		
	}
	
	public function update_premium_pts( array $a )
	{
		$data = array(
			'premium' 	=> $a[ 'premium' ],
			'buf'		=> $a[ 'buf' ]
		);	
		
		$where = array(
			'premium_id' 			=> $a[ 'premium_id' ],
			'insurance_agency_id' 	=> $a[ 'ins' ]		
		);
		
		$this->db->trans_start();
			$this->db->update( 'premiums', $data, $where );
		$this->db->trans_complete();
			
	}
	
	public function insert_premium_pts( array $a )
	{
		
		$data = array(
			'mek'					=> $a[ 'mek' ],
			'insurance_agency_id' 	=> $d[ 'ins' ],
			'premium'				=> $d[ 'premium' ],
			'buf'					=> $d[ 'buf' ],
			'date_created'			=> $this->now()
		
		);
		
		$this->db->trans_start();
			$this->db->insert( 'premiums', $data );
		$this->db->trans_complete();
		
	}
	
	
	/*
		GET PREMIUMS
		- mek
		- insurance_agency_id
		- premium ID
	*/
	
	public function get_premiums( array $a = NULL )
	{
		$sql = '
			SELECT p.premium_id, p.mek, p.insurance_agency_id, premium, buf, active, agency_name
			FROM premiums AS p
			INNER JOIN insurance_agency AS i 
				ON i.insurance_agency_id = p.insurance_agency_id
			WHERE 1 = 1	
		';
		
		if( isset( $a[ 'premium_id'] ) ) $sql .= ' AND premium_id = ' . $this->db->escape( $a[ 'premium_id' ] );
		
		if( isset( $a[ 'insurance_agency_id'] ) ) $sql .= ' AND i.insurance_agency_id = ' . $this->db->escape( $a[ 'insurance_agency_id' ] );
		if( isset( $a[ 'mek'] ) ) $sql .= ' AND mek = ' . $this->db->escape( $a[ 'mek' ] );		
		
		
		$q =  $this->db->query( $sql );
		
		if( isset( $a[ 'row' ] ) )	return $q->row_array();		
		
		return $q->result_array();
	}




}