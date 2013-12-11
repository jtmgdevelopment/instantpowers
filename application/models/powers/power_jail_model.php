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

class power_jail_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model( 'agent/crud_model', 'a' );
		$this->load->model( 'powers/power_history_model', 'history' );
		$this->load->model( 'powers/power_model', 'power' );
		
	}
	
	
	
	public function void_power( array $args )
	{
		$power = array( 'power_id' => $args[ 'power_id' ] );
		$this->db->update( 'power', array( 'declined' => 1 ), $power );
		
		
		$this->db->insert( 'voided_powers', array( 'power_id' => $args[ 'power_id' ], 'mek' => $args[ 'mek' ] ) );
		
		
		$this->power->set_power_status( 'voided', $args[ 'power_id' ] );
		
		//get the power info
		$power = $this->power->get_power( array( 'power_id' => $args[ 'power_id' ] ) );
		
		
		$jail = $this->j->get_jails( $this->session->userdata( 'jail_id' ) );

		//check to see if the power is a sub agent
		if( $power[ 'transferred_sub' ] == 'yes' )
		{
			//get the sub agent mek	
			$agent = $this->a->get_sub_agent_by_power( array( $args[ 'power_id' ] ) );
		}
		//get the master agent info
		else 
		{
			$agent = $this->a->get_agent_by_power( array( $args[ 'power_id' ] ) );
		}
		
		
		$params = array(
			'log' => 'Power declined by Jail - <br />REASON ~ <strong>' . $args[ 'reason' ] . '</strong>',
			'mek' => $agent->mek,
			'power_id' => $args[ 'power_id' ]
		);
		
		//set the history
		$this->history->set_power_history( $params );
		
		$d = array(
			'jail_name' 		=> $jail->jail_name,
			'email'				=> $agent->email,
			'defendant_name'	=> $power[ 'defendant_first_name' ] . ' ' . $power[ 'defendant_last_name' ],
			'pek'				=> $power[ 'pek' ],
			'prefix'			=> $power[ 'prefix' ],
			'amount'			=> $power[ 'power_amount' ],
			'reason'			=> $args[ 'reason' ]
		);
		
		$this->em->notify_agent_of_jail_decline( $d );
		
		return true;
	}
	
	


	public function accept_power( array $args )
	{
		//update the power
		$this->db->update( 'power', array( 'accepted' => 1 ), $args );
		//get the power info
		$power = $this->power->get_power( array( 'power_id' => $args[ 'power_id' ] ) );
		//check to see if the power is a sub agent
		if( $power[ 'transferred_sub' ] == 'yes' )
		{
			//get the sub agent mek	
			$agent = $this->a->get_sub_agent_by_power( array( $args[ 'power_id' ] ) );
		}
		//get the master agent info
		else
		{
			$agent = $this->a->get_agent_by_power( array( $args[ 'power_id' ] ) );
		}
		
		
		$params = array(
			'log' => 'Power accepted by Jail',
			'mek' => $agent->mek,
			'power_id' => $args[ 'power_id' ]
		);
		
		//set the history
		$this->history->set_power_history( $params );
		//get the jail info		
		$jail = $this->j->get_jails( $this->session->userdata( 'jail_id' ) );
		
		$d = array(
			'jail_name' 		=> $jail->jail_name,
			'email'				=> $agent->email,
			'defendant_name'	=> $power[ 'defendant_first_name' ] . ' ' . $power[ 'defendant_last_name' ],
			'pek'				=> $power[ 'pek' ],
			'prefix'			=> $power[ 'prefix' ],
			'amount'			=> $power[ 'power_amount' ]
		);
		
		$this->em->notify_agent_of_jail_accept( $d );
		
		return true;
	}
	
	
	
	
	public function get_power( array $args )
	{
		$sql = "
			SELECT p.pek, pd.data, p.prefix_id, pp.prefix, pp.amount, 
			DATE_FORMAT( p.exp_date, '%c/%d/%Y' ) AS exp_date, p.transmission_id,
			
			CASE transferred_sub
				WHEN 1 THEN TRUE
				WHEN 0 THEN FALSE
				ELSE FALSE
			END AS transferred_sub,

			CASE accepted
				WHEN 1 THEN TRUE
				WHEN 0 THEN FALSE
				ELSE FALSE
			END AS accepted,
			ia.agency_name
				
			FROM power AS p
			
			INNER JOIN power_details AS pd
				ON pd.pek = p.pek AND pd.prefix_id = p.prefix_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id 
			INNER JOIN transmission as t
				ON t.transmission_id = p.transmission_id
			INNER JOIN insurance_agency as ia
				ON ia.insurance_agency_id = t.insurance_company_id			
			WHERE p.pek = ? AND p.prefix_id = ?
		";	
		
		$a = array( $args['pek'], $args['prefix_id'] );
		
		return 	$this->db->query( $sql, $a )->row();
	
	}
	




	//jail_id
	public function get_powers(array $args )
	{
		
		$sql = "
		
			SELECT 
			p.power_id, pp.prefix, pd.charge, pp.amount,
			pdd.first_name, pdd.last_name, 
			p.pek, m.full_name, 
			bay.agency_name, p.prefix_id, 
			p.timestamp, m.mek, t.transmission_id,
			DATE_FORMAT( pd.execution_date, '%c/%d/%Y' ) AS execution_date,
			pd.execution_date as exec_date
			FROM power AS p
			INNER JOIN power_details AS pd
				ON pd.power_id = p.power_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id 
			INNER JOIN power_details_defendant AS pdd 
				ON pdd.power_id = p.power_id
				
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN member AS m
				ON t.bail_agent_id = m.mek
				
			INNER JOIN bail_agent AS ba
                ON ba.mek = t.bail_agent_id                    
            INNER JOIN bail_agency_agent_join AS baaj
                ON baaj.bail_agent_id = ba.mek
            INNER JOIN bail_agency AS bay
                ON bay.bail_agency_id = baaj.bail_agency_id

				
			WHERE p.jail_id = ? AND p.transferred_sub = 0 AND p.declined is NULL 
			
			AND p.accepted = " . $this->db->escape( $args['accepted'] ) . "
			
			UNION
			
			SELECT p.power_id, pp.prefix, pd.charge, pp.amount, 
			pdd.first_name, pdd.last_name, 
			p.pek,  m.full_name, 
			bay.agency_name, p.prefix_id, 
			p.timestamp, m.mek, t.transmission_id,
			DATE_FORMAT( pd.execution_date, '%c/%d/%Y' ) AS execution_date,
			pd.execution_date as exec_date
			FROM power_sub_agent_join AS psaj
			INNER JOIN power AS p 
				ON psaj.power_id = p.power_id
			INNER JOIN power_details AS pd 
				ON pd.power_id = p.power_id
			INNER JOIN power_details_defendant AS pdd 
				ON pdd.power_id = p.power_id
			INNER JOIN power_prefix as pp 
				ON pp.prefix_id = p.prefix_id
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN member AS m 
				ON m.mek = psaj.mek
	
			INNER JOIN bail_agent AS ba
                ON ba.mek = t.bail_agent_id                    
            INNER JOIN bail_agency_agent_join AS baaj
                ON baaj.bail_agent_id = ba.mek
            INNER JOIN bail_agency AS bay
                ON bay.bail_agency_id = baaj.bail_agency_id
	
			WHERE jail_id = ? AND p.transferred_sub = 1 AND psaj.active = 1 AND p.declined is NULL 
			
			AND p.accepted = " . $this->db->escape( $args['accepted'] ) . "

			ORDER BY exec_date DESC, pek, full_name
			
			limit 50;
		";	
		
		return $this->db->query( $sql, array( $args['jail_id'], $args['jail_id'] ) )->result_array();	
		
	}


}


