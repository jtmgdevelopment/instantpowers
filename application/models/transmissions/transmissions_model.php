<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transmissions_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	public function mark_transmission_paid( $trans_id, $mek )
	{
		$this->db->select( 'transmission_status_id' )->from( 'transmission_status' )->where( array( 'key' => 'recieved' ) );
		$q = $this->db->get();
		
		$q = $q->row();
		
		$d = array(
			'paid' => 1,
			'transmission_status_id' => $q->transmission_status_id
		);	
		
		$this->db->update( 'transmission', $d, array( 'bail_agent_id' => $mek, 'transmission_id' => $trans_id ) );
		
	}
	
	
	public function get_transmission( $mek, $trans_id )
	{
		$sql = "
			SELECT t.transmission_id as trans_id, m.full_name as bail_agent, a.full_name as ins_agent, 
			m.email, m.phone,
			DATE_FORMAT( t.exp_date, '%c/%e/%Y' )  as exp_date,
			
			CASE t.active
			  WHEN 1 THEN 'Active'
			  WHEN 0 THEN 'Not Active'
			  ELSE 'Not Active'
			END AS active,
			
			CASE t.paid
				WHEN 1 THEN 'Paid'
				WHEN 0 THEN 'Not Paid'
				ELSE 'Not Paid'
			END AS paid,
			
			ia.agency_name, 
			DATE_FORMAT( t.created_date, '%c/%i/%Y' ) as created_date,
			
			( SELECT status FROM transmission_status WHERE transmission_status_id = t.transmission_status_id ) AS status,
			( SELECT full_name FROM member WHERE mek = t.insurance_agent_id ) AS ins_agent,
			( SELECT MIN( pek ) FROM power WHERE transmission_id = t.transmission_id and prefix_id = p.prefix_id  ) AS min_power,
			( SELECT MAX( pek ) FROM power WHERE transmission_id = t.transmission_id and prefix_id = p.prefix_id  ) AS max_power,
			(
			  SELECT CONCAT( pp.prefix, ' ', pp.amount )
			  from power p 
			  INNER JOIN power_prefix AS pp 
			  	ON pp.prefix_id = p.prefix_id 
    		  WHERE p.transmission_id = t.transmission_id
			  LIMIT 1
			) AS prefix,
			mga_agent.full_name as mga_agent
			
			FROM transmission t
			INNER JOIN member m 
				ON m.mek = t.bail_agent_id 
			INNER JOIN power p
				ON p.transmission_id = t.transmission_id
			INNER JOIN member a 
				ON a.mek = t.insurance_agent_id
			INNER JOIN insurance_agency_agent_join iaaj 
				ON iaaj.insurance_agent_id = t.insurance_agent_id
			INNER JOIN bail_agency_agent_join baaj 
				ON baaj.bail_agent_id = t.bail_agent_id
			INNER JOIN bail_agency b 
				ON b.bail_agency_id = baaj.bail_agency_id	
		    INNER JOIN insurance_agency ia 
				ON ia.insurance_agency_id = iaaj.insurance_agency_id
			LEFT JOIN mgas AS mga on mga.mek = t.mga_id
			LEFT JOIN member as mga_agent on mga.mek = mga_agent.mek
				
			WHERE 1 = 1	

		";	
		
		
		if( isset( $trans_id ) ) $sql .= ' AND t.transmission_id = ' . $this->db->escape( $trans_id );
		if( isset( $mek ) ) $sql .= ' AND t.bail_agent_id = ' . $this->db->escape( $mek );
		
		$sql .= 'ORDER BY active, t.paid, min_power desc, ia.agency_name';
		
		
		return $this->db->query( $sql )->row();
		
			
	}
	
	
	public function get_transmissions( $mek )
	{
		
		$trans_groups = array();
		
		
		$sql = 	"
			SELECT t.transmission_id as trans_id, m.full_name as bail_agent, a.full_name as ins_agent, 
			m.email, m.phone,
			DATE_FORMAT( t.exp_date, '%c/%e/%Y' )  as exp_date,
			DATE_FORMAT( t.created_date, '%c/%e/%Y' )  as created_date,
			
			CASE t.active
			  WHEN 1 THEN 'Active'
			  WHEN 0 THEN 'Not Active'
			  ELSE 'Not Active'
			END AS active,
			
			CASE t.paid
				WHEN 1 THEN 'Paid'
				WHEN 0 THEN 'Not Paid'
				ELSE 'Not Paid'
			END AS paid,
			
			ia.agency_name, 
			
			
			( SELECT status FROM transmission_status WHERE transmission_status_id = t.transmission_status_id ) AS status,
			( SELECT full_name FROM member WHERE mek = t.insurance_agent_id ) AS ins_agent,
			mga_agent.full_name as mga_agent
			
			
			FROM transmission t
			
			INNER JOIN member m 
				ON m.mek = t.bail_agent_id 
			INNER JOIN member a 
				ON a.mek = t.insurance_agent_id
			INNER JOIN insurance_agency_agent_join iaaj 
				ON iaaj.insurance_agent_id = t.insurance_agent_id
			INNER JOIN bail_agency_agent_join baaj 
				ON baaj.bail_agent_id = t.bail_agent_id
			INNER JOIN bail_agency b 
				ON b.bail_agency_id = baaj.bail_agency_id	
		    INNER JOIN insurance_agency ia 
				ON ia.insurance_agency_id = iaaj.insurance_agency_id
			LEFT JOIN mgas AS mga on mga.mek = t.mga_id
			LEFT JOIN member as mga_agent on mga.mek = mga_agent.mek

			WHERE t.bail_agent_id = ?			
			
			ORDER BY t.created_date DESC, t.paid, t.active DESC, t.exp_date DESC, t.paid DESC
			
			LIMIT 20
		";
			
			
		$q = $this->db->query( $sql, array( $mek ) )->result_array();
		
		
		
		foreach( $q as $trans )
		{
			$sql = "
				select distinct pp.prefix, pp.amount, 
				DATE_FORMAT( t.exp_date, '%c/%e/%Y' )  as exp_date,
				( select min( pek ) from power where transmission_id = t.transmission_id  and prefix_id = p.prefix_id  ) as min_power,
				( select max( pek ) from power where transmission_id = t.transmission_id and prefix_id = p.prefix_id  ) as max_power
				from power p
				inner join transmission as t on t.transmission_id = p.transmission_id
				inner join power_prefix as pp on pp.prefix_id = p.prefix_id
				inner join member m on m.mek = t.bail_agent_id 
				inner join member a on a.mek = insurance_agent_id
				inner join bail_agency_agent_join baaj on baaj.bail_agent_id = t.bail_agent_id
				inner join bail_agency b on b.bail_agency_id = baaj.bail_agency_id	
				where 	
				 p.transmission_id = " . $this->db->escape( $trans[ 'trans_id' ] );	
			
			$q = $this->db->query( $sql )->result_array();

			$trans[ 'power_group' ] = $q;
			
			$trans_groups[] = $trans;
			
					
		}
		
		return $trans_groups;
	}
	
	


}