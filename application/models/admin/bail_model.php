<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bail_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	public function get_agents()
	{
		$sql = '
			select 
				m.full_name, m.mek, b.license_number, DATE_FORMAT(b.created_date, "%m/%d/%Y") as date_created,
				ba.agency_name,
				case m.active
					when 1 then "Active"
					when 0 then "Not Active"
					else "Not Active"
				end as active,
				case b.is_sub_agent
					when 1 then "Yes"
					when 0 then "No"
					else "No"
				end as is_sub_agent	
							
			from member m
			inner join bail_agent b on b.mek = m.mek
			inner join bail_agency_agent_join baaj on b.mek = baaj.bail_agent_id
			inner join bail_agency ba on ba.bail_agency_id = baaj.bail_agency_id
			
			
			order by m.full_name
		';
		
		$query = $this->db->query( $sql );	
		
		return $query->result_array();
		
	}
	
	
	public function deactivate_agent( $mek )
	{
		$data = array(
			'active' => 0,
			'modified' => $this->now() 
		);

		$this->db->update( 'member', $data, array( 'mek' => $mek) );
		return true;
	}

	public function activate_agent( $mek )
	{
		$data = array(
			'active' => 1,
			'modified' => $this->now() 
		);
		
		$this->db->update( 'member', $data, array( 'mek' => $mek ) );
		
		return true;
	}

}