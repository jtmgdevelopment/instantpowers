<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class powers_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	/*
		ARGUMENTS
		@
	*/
	
	
	/*
		ARGUMENTS
		@jail_id required
		@type
	*/
	
	public function get_powers( array $args )
	{
		$sql = "
			SELECT p.transmission_id, p.pek, pp.prefix, pd.data, m.full_name, bay.agency_name
			FROM power AS p
			INNER JOIN power_details AS pd
				ON pd.pek = p.pek
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN bail_agent AS ba
				ON ba.mek = t.bail_agent_id					
			INNER JOIN bail_agency_agent_join AS baaj
				ON baaj.bail_agent_id = ba.mek
			INNER JOIN bail_agency AS bay
				ON bay.bail_agency_id = baaj.bail_agency_id
			INNER JOIN member AS m
				ON m.mek = ba.mek			
				
			WHERE jail_id = " . $this->db->escape( $args[ 'jail_id' ] );
			
				
		if( isset( $args[ 'type'] ) && $args[ 'type' ] == 'pending' ) $sql .= "AND accepted = 0 AND declined is NULL";
	
		$sql .= " ORDER BY agency_name";
		
		return $this->db->query( $sql )->result_array();
	}
	


}