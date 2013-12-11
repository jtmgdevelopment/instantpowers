<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class agency_crud_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	/*
		get_agency
		arguments
			- bail_agency_id
	
	*/
	
	public function get_agency( array $args )
	{
		
		return $this->db->get_where( 'bail_agency', array( 'bail_agency_id' => $args['bail_agency_id'] ) )->row();	
		
		
	}

	public function get_agency_by_ins( array $a = NULL )
	{
		
		$sql = '
			SELECT distinct ba.agency_name, ba.bail_agency_id
			FROM insurance_agency_agent_join AS iaaj
			INNER JOIN bail_insurance_join AS bij
				ON bij.insurance_agency_id = iaaj.insurance_agency_id
			INNER JOIN 	bail_agency_agent_join AS baaj
				ON baaj.bail_agent_id = bij.bail_agent_id			
			INNER JOIN bail_agency AS ba 
				ON ba.bail_agency_id = baaj.bail_agency_id					
			WHERE 1 = 1 	
		';
		
		if( isset( $a[ 'ins_agent_id' ] ) ) $sql .= ' AND iaaj.insurance_agent_id = ' . $this->db->escape( $a[ 'ins_agent_id' ] );
		
		return $this->db->query( $sql )->result_array();		
	}



}