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

class bail_agency_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}

	

	public function list_agencies( $mga_id )
	{
		
		$sql = "
				SELECT distinct  baa.bail_agency_id, m.mek, agency_name, m.full_name
				FROM bail_mga_join AS bij

				INNER JOIN bail_agent AS ba on ba.mek = bij.bail_agent_id
				INNER JOIN bail_agency_agent_join AS baaj ON baaj.bail_agent_id = ba.mek 						
				INNER JOIN bail_agency AS baa ON baa.bail_agency_id = baaj.bail_agency_id 			
				INNER JOIN member AS m ON m.mek = ba.mek
				WHERE is_sub_agent = 0
			";
		
		$sql .= ' AND bij.mga_id = ' . $this->db->escape( $mga_id );	
		
		return $this->db->query( $sql )->result_array();
	}


	public function verify_direct_relationship( $mga_id, $mek, $ins_id )
	{
	
		//get all insurance company ids
	
		$sql = '
			SELECT bail_agent_id
			FROM bail_insurance_join
			WHERE bail_agent_id = ' . $this->db->escape( $mek );
		
		$sql .= ' AND insurance_agency_id = ' . $this->db->escape( $ins_id );
		
		
		$q = $this->db->query( $sql );
		
		return $q->num_rows();
		
	}



	public function get_agency( $license, $mek )
	{
		$sql = "
			SELECT ba.mek, m.full_name, baa.agency_name, ba.license_number 
			FROM bail_agent as ba
			INNER JOIN bail_agency_agent_join as baaj ON baaj.bail_agent_id = ba.mek 			
			INNER JOIN bail_agency as baa ON baa.bail_agency_id = baaj.bail_agency_id 			
			INNER JOIN member as m ON m.mek = ba.mek
			 
			WHERE 1 = 1
			AND ba.is_sub_agent = 0
			
			
		";
		
		$sql .= ' AND ba.mek NOT IN ( 
					SELECT bail_agent_id 
					FROM bail_mga_join 
					WHERE bail_agent_id = 
					( 
						SELECT mek 
						FROM bail_agent 
						WHERE license_number = ' . $this->db->escape( $license ) . '   and mga_id = ' . $this->db->escape( $mek ) . ' LIMIT 1  
					) 
				)';
		
		$sql .= ' AND ba.license_number = ' . $this->db->escape( $license );
		
		$sql .= ' LIMIT 1';
		
		return $this->db->query( $sql )->row();
		
		
	}


	public function add_agency_to_mga( $mek, $mga_id )
	{
		$this->load->model( 'agent/crud_model', 'agent' );

		//get all sub agent meks
		$agents = $this->agent->get_sub_agents( array( 'mek' => $mek ) );

		//insert all meks into the dbo.insurance_agency_agent_join
		$this->db->trans_start();
			
			foreach( $agents as $agent )
			{
				$data = array(
					'bail_agent_id'        => $agent[ 'mek' ],
					'mga_id'  => $mga_id
				);				
				
				$this->db->insert( 'bail_mga_join', $data );				
			}
			
			$data = array(
				'bail_agent_id'         => $mek,
				'mga_id'   => $mga_id
			);
		
			$this->db->insert( 'bail_mga_join', $data );
		$this->db->trans_complete();		
		
		return TRUE;		
	}


	public function validate_add_agency_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('license_number', 'License Number', 'required|trim');		

		return $this->form_validation->run();

		
	}
	

}