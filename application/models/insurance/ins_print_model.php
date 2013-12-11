<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ins_print_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	public function get_power_info( $report_id )
	{
		$sql = '
			SELECT DISTINCT
			p.power_id, p.pek, p.prefix_id, ps.status, ps.key, ia.agency_name,
			def.first_name, def.last_name, pp.prefix, pp.amount, pd.bond_amount, pd.county, p.exp_date,
			pd.court, pd.case_number, pd.charge, pd.executing_agent, DATE_FORMAT(pd.court_date, "%m/%d/%Y") as court_date
			
			
			FROM power AS p
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN bail_agent AS ba 			
				ON	ba.mek = t.bail_agent_id
			INNER JOIN bail_agency_agent_join AS baaj
				ON	baaj.bail_agent_id = ba.mek
			INNER JOIN bail_agency AS bay
				ON bay.bail_agency_id = baaj.bail_agency_id	
			INNER JOIN member AS m
				ON m.mek = ba.mek
				
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id	
			
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			
			INNER JOIN power_details as pd
				ON pd.pek = p.pek AND pd.prefix_id = p.prefix_id	
			INNER JOIN power_details_defendant as def
				ON def.pek = p.pek AND def.prefix_id = p.prefix_id	

			INNER JOIN insurance_agency as ia 
				ON ia.insurance_agency_id = t.insurance_company_id
			
			WHERE p.power_id in (
	        	SELECT power_id 
	            FROM master_agent_report_data 
	            WHERE report_id = ?            
	          )
			ORDER BY p.pek
		';

		return $this->db->query( $sql , array( $report_id ) )->result_array();		
	}		
}