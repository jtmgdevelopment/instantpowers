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

class mga_transmission_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model( 'agent/crud_model', 'a' );
		$this->load->model( 'power_status/status_crud_model', 'status' );
	}

	public function mark_transmission_paid( $trans_id, $mek )
	{
		$this->db->select( 'transmission_status_id' )->from( 'transmission_status' )->where( array( 'key' => 'mga_accepted' ) );
		$q = $this->db->get();
		
		$q = $q->row();
		
		$d = array(
			'mga_paid' => 1,
			'transmission_status_id' => $q->transmission_status_id
		);	
		
		$this->db->update( 'transmission', $d, array( 'transmission_id' => $trans_id ) );
		
	}
	
		
	
	public function recoup_transmission( $trans_id )
	{
		
		$trans = array(
			'is_recouped' 	=> 1,		
			'recoup_date'	=> $this->now() 	
		);	

		$key = $this->status->get_power_status_id( 'voided' );

		$power = array(
			'status_id' => $key->power_status_id		
		);


		$this->db->trans_start();
			$this->db->update( 'transmission', $trans, array( 'transmission_id' => $trans_id ) );
			$this->db->update( 'power', $power, array( 'transmission_id' => $trans_id ) );
		$this->db->trans_complete();
		
		return true;
	}
	
	
	
	public function accept_transmission( $trans_id )
	{
		$data = array(
			'paid' 			=> 0,
			'mga_accepted' 	=> 1			
		);	
		$this->db->trans_start();
			$this->db->update( 'transmission', $data, array( 'transmission_id' => $trans_id ) );
		$this->db->trans_complete();	
		
		return true;
		
	}
	
	
	public function transfer_transmission_to_agent( $mek )
	{
		
		//update transmission with agent info
		$d 		= $this->sfa();
		$agent 	= $this->a->get_master_agent( array( 'agency_id' => $d[ 'bail_agency' ] ) );
		
		$trans = array(
			'bail_agent_id' 	=> $agent->mek,
			'bail_agency_id'	=> $agent->bail_agency_id
		);
			
		$this->db->trans_start();
			$this->db->update( 'transmission', $trans, array( 'transmission_id' => $d[ 'trans_id' ] ) );
		$this->db->trans_complete();
		
		
			
		
		//add the history to the powers
		//update power where transmission id = trans_id
		$sql = '
			SELECT power_id from power as p
			where p.transmission_id = 		
		';
		$sql .= $this->db->escape( $d[ 'trans_id' ] );
		
		$q = $this->db->query( $sql )->result_array();
		
		foreach( $q as $p )
		{
			$data = array(
				'power_id'	=> $p[ 'power_id' ],
				'log'		=> 'MGA Transferred Power To Master Agent',
				'date'		=> $this->now(),
				'mek'		=> $mek
			
			);
			
			$this->db->trans_start();
				$this->db->insert( 'power_history', $data );
			$this->db->trans_complete();
			
		}

		
		//send out a confirmation email
		
		$a = $this->a->get_agents( $agent->mek );
		
		$this->em->send_transmission_notification( $a );

		return true;		
		
	}
	

	public function validate_transfer_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('bail_agency', 'Bail Agency', 'required|trim');		
		return $this->form_validation->run();
	}



	
	public function get_mga_transmissions( $mek )
	{
		
		$trans_groups = array();	
		$sql = "
			select transmission_id, transmission_id as trans_id, m.full_name, mga.company_name, 
			DATE_FORMAT( t.exp_date, '%c/%e/%Y' )  as exp_date,			
			DATE_FORMAT( t.created_date, '%c/%e/%Y' )  as created_date,			
			DATE_FORMAT( t.recoup_date, '%c/%e/%Y' )  as recoup_date, t.bail_agent_id,			
			case t.active
			  when 1 then 'Active'
			  when 0 then 'Not Active'
			  else 'Not Active'
			end as active,
			case t.is_recouped
			  when 1 then 'RECOUPED TRANSMISSION'
			  when 0 then ''
			  else ''
			end as recouped,
			
			baa.agency_name,
			agent.full_name as agent_name,
			
			case t.mga_accepted
				when 1 then 'accepted'
				when 0 then 'not accepted'
				else 'not accepted'
			end as mga_accepted,
			ts.status,
			
			case t.mga_paid
				when 1 then 'Paid'
				when 0 then 'Not Paid'
				else 'Not Paid'
			end as paid	
			
			
			from transmission as t
			inner join transmission_status as ts on ts.transmission_status_id = t.transmission_status_id
			inner join member m on m.mek = t.mga_id 
			inner join mgas as mga on mga.mek = m.mek
			left join bail_agent as ba on ba.mek = t.bail_agent_id
			left join bail_agency_agent_join as baaj on baaj.bail_agent_id = t.bail_agent_id
			left join bail_agency as baa on baaj.bail_agency_id = baa.bail_agency_id
			left join member as agent on agent.mek = t.bail_agent_id
			
			where m.mek = ?	and t.exp_date >= curdate()		
			
			order by t.created_date DESC	
		";
		$q = $this->db->query( $sql, array( $mek ) )->result_array();
		
		
		foreach( $q as $trans )
		{
  		$sql = "
			select distinct pp.prefix, pp.amount, 
			DATE_FORMAT( t.exp_date, '%c/%e/%Y' )  as exp_date,
			( select min( pek ) from power where transmission_id = t.transmission_id and prefix_id = p.prefix_id  ) as min_power,
			( select max( pek ) from power where transmission_id = t.transmission_id and prefix_id = p.prefix_id ) as max_power
			from power p
			inner join transmission as t on t.transmission_id = p.transmission_id
			inner join power_prefix as pp on pp.prefix_id = p.prefix_id
			inner join member m on m.mek = t.mga_id 
			inner join member a on a.mek = insurance_agent_id
			inner join mgas as mga on mga.mek = m.mek
			where 	
			 p.transmission_id = " . $this->db->escape( $trans[ 'transmission_id' ] );	
		
			$q = $this->db->query( $sql )->result_array();
			
			
			$trans[ 'power_group' ] = $q;
			
			$trans_groups[] = $trans;
		}	
		
		
		return $trans_groups;		
		
		
	}

}