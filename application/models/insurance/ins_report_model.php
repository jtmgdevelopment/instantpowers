<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ins_report_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	public function list_liability( $d )
	{
		
		//convert the bail agency id 
		
		$name = explode( '-', $d[ 'agency' ] ); 
		
		$sql = '
			select pd.bond_amount, pp.prefix, p.pek, pd.execution_date, pd.case_number, ps.status
			from power as p
			inner join transmission as t on t.transmission_id = p.transmission_id
			inner join power_status as ps on ps.power_status_id = p.status_id
			inner join power_details as pd on pd.power_id = p.power_id
			inner join power_prefix as pp on pp.prefix_id = p.prefix_id
			where 1 = 1 and ps.key in ( "transfer", "rewrite", "executed" ) AND 
	
		';
		
		if( count( $name ) > 1 ) $sql .= 't.mga_id = ' . $this->db->escape( $d[ 'agency' ] );
		else $sql .= 't.bail_agency_id = ' .  $this->db->escape( $d[ 'agency' ] );
			
		$sql .= 'order by prefix, execution_date DESC, pek ASC LIMIT 100';		
		
		return $this->db->query( $sql )->result_array();
	}

	public function list_liability_total( $d )
	{
		$name = explode( '-', $d[ 'agency' ] ); 
		$sql = '
			select sum( pd.bond_amount ) as total_bond, pp.prefix, count( p.pek ) as power_count
			from power as p
			inner join transmission as t on t.transmission_id = p.transmission_id
			inner join power_status as ps on ps.power_status_id = p.status_id
			inner join power_details as pd on pd.power_id = p.power_id
			inner join power_prefix as pp on pp.prefix_id = p.prefix_id
			where 1 = 1 and ps.key in ( "transfer", "rewrite", "executed" ) AND 
		';
		
		if( count( $name ) > 1 ) $sql .= 't.mga_id = ' . $this->db->escape( $d[ 'agency' ] );
		else $sql .= 't.bail_agency_id = ' .  $this->db->escape( $d[ 'agency' ] );
		
		$sql .= ' group by pp.prefix ';			
		$sql .= ' order by prefix, execution_date DESC, p.pek ASC';		

		return $this->db->query( $sql )->result_array();
		
	}
}