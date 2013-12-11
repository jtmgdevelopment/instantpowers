<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class insurance_crud_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	public function get_mgas_from_insurance_companies( $ins_id )
	{
		$sql = '
			select *
			from mga_insurance_join as mij
			inner join mgas as mga on mij.mga_id = mga.mek
			where mij.insurance_agency_id = ';
		
		$sql .= $this->db->escape( $ins_id );
		
		return $this->db->query( $sql )->result_array();
	}
	
	
	/*
		GET INSURANCE COMPANIES
		- MEK
	*/
	
	
	
	
	public function get_insurance_companies_by_agent( array $a = NULL )
	{
		$sql = '
			SELECT ia.agency_name, ia.insurance_agency_id
			FROM insurance_agency_agent_join AS iaaj
			INNER JOIN insurance_agency AS ia
				ON ia.insurance_agency_id = iaaj.insurance_agency_id
			WHERE 1 = 1
		';
		
		if( isset( $a[ 'mek' ] ) ) $sql .= ' AND iaaj.insurance_agent_id = ' . $this->db->escape( $a[ 'mek' ] );
		
		
		$q = $this->db->query( $sql );
		
		if( $q->num_rows() == 1 && isset( $a[ 'row' ] ) ) return $q->row();
		
		return $q->result_array();
		
	}



	public function create_sub_select_array(  array $a = NULL )
	{
		$t = ( array ) $this->get_insurance_companies_by_agent( $a );


		$z =  array('' => 'Please Select Insurance Company');		
		foreach( $t as $val ) $z[ $val[ 'insurance_agency_id' ] ] = $val[ 'agency_name' ];		
		return $z;
		
	}
	
	


	public function get_insurance_companies_by_bail_agent( array $a )
	{
		$sql = '
			SELECT ia.agency_name, ia.insurance_agency_id
			FROM bail_insurance_join AS iaaj
			INNER JOIN insurance_agency AS ia
				ON ia.insurance_agency_id = iaaj.insurance_agency_id
			WHERE 1 = 1
		';
		
		if( isset( $a[ 'mek' ] ) ) $sql .= ' AND iaaj.bail_agent_id = ' . $this->db->escape( $a[ 'mek' ] );
		
		return $this->db->query( $sql )->result_array();		
		
	}
	
	
	public function get_insurance_agent( array $args )
	{
		$sql = '
			SELECT m.full_name, ia.email, ia.agency_name, ia.insurance_agency_id, m.mek
			FROM member AS m
			INNER JOIN insurance_agency_agent_join AS iaaj
				ON iaaj.insurance_agent_id = m.mek
			INNER JOIN insurance_agency AS ia
				ON ia.insurance_agency_id = iaaj.insurance_agency_id	
			WHERE 1 = 1		
		';	
		
		if( isset( $args[ 'mek' ] ) ) $sql .= ' AND m.mek = ' . $this->db->escape( $args['mek'] );
		if( isset( $args[ 'ins_id' ] ) ) $sql .= ' AND ia.insurance_agency_id = ' . $this->db->escape( $args[ 'ins_id' ] );
		
		$sql .= ' ORDER BY ia.agency_name';
		
		if( isset( $args[ 'mek' ] ) || isset( $args[ 'ins_id' ] )  ) return $this->db->query( $sql )->row();
		
		return $this->db->query( $sql )->result_array();
		
		
	}

}