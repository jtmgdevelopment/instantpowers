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

class jail_report_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	public function get_voided_powers( $mek )
	{
		
		$sql = "
			SELECT DISTINCT
			p.power_id, p.pek, p.prefix_id, ps.status, ps.key,
			def.first_name, def.last_name, pp.prefix, pp.amount, pd.bond_amount, pd.county, p.exp_date, bay.agency_name,
			pd.court, pd.case_number, pd.charge, pd.executing_agent, DATE_FORMAT(pd.court_date, '%m/%d/%Y') as court_date,
			CASE p.transferred_sub
				WHEN 1 THEN 'Transferred' 
				WHEN 0 THEN 'Not Transferred'
				ELSE 'Not Transferred'
			END AS transferred
			
			FROM power AS p
			
			inner join voided_powers as vp
				ON vp.power_id = p.power_id
			
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
			WHERE 1 = 1 
		";
		
		$sql .= " AND vp.mek = " . $this->db->escape( $mek );	
			
		$sql .= "	ORDER BY vp.timestamp DESC";

		return $this->db->query( $sql )->result_array();		
		
		
	}
	
	
	
	public function get_accepted_powers( $batch_id )
	{
		$sql = "
			SELECT DISTINCT
			p.power_id, p.pek, p.prefix_id, ps.status, ps.key,
			def.first_name, def.last_name, pp.prefix, pp.amount, pd.bond_amount, pd.county, p.exp_date, bay.agency_name,
			pd.court, pd.case_number, pd.charge, pd.executing_agent, DATE_FORMAT(pd.court_date, '%m/%d/%Y') as court_date,
			CASE p.transferred_sub
				WHEN 1 THEN 'Transferred' 
				WHEN 0 THEN 'Not Transferred'
				ELSE 'Not Transferred'
			END AS transferred
			
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
			
			WHERE p.power_id in (
	        	SELECT power_id 
	            FROM jail_accepted_powers_data 
	            WHERE batch_report_id = ?            
	          )
			ORDER BY p.pek
		";

		return $this->db->query( $sql , array( $batch_id ) )->result_array();		
		
		
	}
	
	public function generate_daily_accepted_report( $jail_id )
	{
		$d = $this->sfa();
		//select all powers that have not been reported by the jail
		$sql = "
			SELECT DISTINCT power_id
			FROM power
			WHERE 1 = 1
			AND accepted = 1
			AND sent_electronically = 1
			AND is_jail_reported = 0
		";
	
		$sql .= ' AND jail_id = ' . $this->db->escape( $jail_id );
		
		$ret = $this->db->query( $sql )->result_array();
		
		
		//if there are powrs then create batch_id report and get id
		if( count( $ret ) > 0 )
		{			
			$this->db->trans_start();
				
				$data = array(
					'jail_id' 			=> $jail_id,
					'createddatetime' 	=> $this->now()
				);				
				$this->db->insert( 'jail_accepted_powers_report', $data );							
				
				$insert_id = $this->db->insert_id();
			
			$this->db->trans_complete();			
		
			//insert powers into the jail_accepted_powers_data		
			foreach( $ret as $r )
			{
				$this->db->trans_start();
					$data = array(
						'power_id' 			=> $r[ 'power_id' ],
						'batch_report_id' 	=> $insert_id
					);
					$this->db->insert( 'jail_accepted_powers_data', $data );
					//reset the power table and mark is reported
					$this->db->update( 'power', array( 'is_jail_reported' => 1 ), array( 'power_id' => $r[ 'power_id' ] ) );
				$this->db->trans_complete();	
			}
		
			//email out the powers to the jail admin
	
	
			$this->load->library('encryption');
			
			$data = array(
				'username' 	=> 'curllogin',
				'password'	=> $this->encryption->encode( 'password' ) 
			);	
			
			$this->load->library( 'curl' );
			$this->curl->create('/curl/curl_login');	
			$this->curl->post( $data );
			$this->curl->execute();
	
			$data[ 'report_id' ] 	= $insert_id;
			$data[ 'mek' ] 			= $this->session->userdata( 'mek' );
			$data[ 'email' ]		= $this->session->userdata( 'email' );
			
			
			$this->curl->create('/curl/print_accepted_jail_powers');	
			$this->curl->post( $data );
			$this->curl->execute();
	
			$this->curl->create('/curl/end_session');	
			$this->curl->execute();
			
		
		}
				
		return true;		
		
	}
	
	
	public function get_accepted_power_reports( array $args )
	{
		
		$sql = '
			SELECT batch_report_id, createddatetime, zip_path
			FROM jail_accepted_powers_report
			WHERE 1 = 1';
		
		$sql .= ' AND jail_id = ' . $this->db->escape( $args[ 'jail_id' ] );
		
		$sql .= ' ORDER BY createddatetime DESC';
		return $this->db->query( $sql )->result_array();
	}
	

}