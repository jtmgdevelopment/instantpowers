<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mga_power_inventory_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model( 'powers/power_model', 'p' );
		$this->load->model( 'agent/crud_model', 'agent' );
		$this->load->model( 'power_status/status_crud_model', 'status' );
		$this->load->model( 'powers/power_history_model', 'history' );
	}





	public function transfer_powers( $mek )
	{		
		$d = $this->sfa();
		
		$data = $this->session->userdata( 'transfer' );		
		
		
		
		//create a new transmission using the current transmission as a copy
		
		$powers = $data[ 'powers' ][ 0 ];
		
		
		$trans = $this->p->get_transmission_by_power_id( $powers[0][ 'power_id' ] );
		
		
		$agent = $this->agent->get_master_agent( array( 'agency_id' => $data[ 'agent' ]->bail_agency_id ) );
		


		
		unset( $trans->transmission_id );
		
		$trans->bail_agent_id 	= $agent->mek;
		$trans->bail_agency_id 	= $agent->bail_agency_id;		
		$trans->mga_accepted	= true;
		$trans->paid			= false;
		$trans->active			= true;
		$trans->is_recouped		= false;
		$trans->mga_paid		= true;
		
		
		
		$this->db->trans_start();
			$this->db->insert( 'transmission', $trans );
			$trans_id = $this->db->insert_id();	
		$this->db->trans_complete();	
		


		$powers = $data[ 'powers' ];

		foreach( $powers as $power )
		{
			foreach( $power as $p )
			{
				
			
		
				$this->db->trans_start();
					$this->db->update( 'power', array( 'transferred_master' => 1, 'transmission_id' => $trans_id ), array( 'power_id' => $p[ 'power_id' ] ) );	
				$this->db->trans_complete();	
	
	
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
		}

		$a = $this->agent->get_agents( $agent->mek );		
		$this->em->send_transmission_notification( $a );
		$this->session->unset_userdata( 'transfer_powers' );

		return true;		
	}






	public function list_powers_to_transfer( $d, $mek )
	{
	
		$keys = array_keys( $d );
		$temp = array();
		
		
		foreach( $keys as $key )
		{
			$prefix = explode( '_', $key );			
			if( count( $prefix ) > 1  && $d[ $key ] > 0 ) $temp[ ] = $this->get_powers_list( $prefix[0], $d[ $key ], $mek );
		
		}
		
		return $temp;
	}


	public function get_powers_list( $prefix, $val, $mek )
	{
		$sql = "
			select p.power_id, p.pek, pp.prefix
			from power as p
			inner join power_prefix as pp 
			on pp.prefix_id = p.prefix_id
			inner join power_status as ps
			on ps.power_status_id = status_id
			inner join transmission as t on t.transmission_id = p.transmission_id			
			where ps.key = 'inventory' and p.transferred_sub = 0 and p.transferred_master = 0
		
		";
		$sql .= ' AND pp.prefix = ' . $this->db->escape( $prefix );
		$sql .= ' AND t.mga_id = ' . $this->db->escape( $mek );
		$sql .= ' ORDER BY pek asc';
		$sql .= ' LIMIT ' . $val;
		
		return $this->db->query( $sql )->result_array();
	}


	public function validate_transfer( $mek )
	{
	
		$breakdown = $this->get_mga_power_breakdown( array( 'mek' => $mek ) );
		
		$d = $this->sfa();
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
			
		foreach( $breakdown as $v  )
		{
			$this->form_validation->set_rules( $v['prefix'] . '_' . 'amount', $v[ 'prefix' ], 'required|integer|check_power_transfer_amount[' . ( intval( $v[ 'power_count' ] ) ) .' ]|greater_than[ -1 ]');		
		}
		
		$this->form_validation->set_rules('agencies', 'Agency', 'required');		
		
		return $this->form_validation->run();
		
	}


	public function get_mga_power_breakdown( array $a )
	{
		$sql = "
			select prefix, count( power_id ) as power_count 
			from power as p			
			inner join power_prefix as pp 
			on pp.prefix_id = p.prefix_id
			inner join power_status as ps
			on ps.power_status_id = status_id
			inner join transmission as t on t.transmission_id = p.transmission_id			
			where 1 = 1 
			AND			
			p.transferred_sub = 0 and p.transferred_master = 0
		";

		$sql .= ' AND t.mga_id = ' . $this->db->escape( $a['mek'] );
		$sql .= ' group by prefix ORDER BY prefix';
		
		$q = $this->db->query( $sql )->result_array();
			
		return $q;		

		
	}



	public function process_recoup( $f )
	{
		$powers = explode( ',', $f[ 'recoup' ] );
		$key	= $this->status->get_power_status_id( 'inventory' );
		
		
		foreach( $powers as $p )
		{
			
			$this->db->trans_start();
				$this->db->update( 'power', array( 'transferred_master' => 0, 'status_id' => $key->power_status_id ), array( 'power_id' => $p ) );
			$this->db->trans_complete();	
		}
		
		return true;
		
	}

	public function validate_recoup_frm()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
	
		$this->form_validation->set_rules('bail_agency', 'Bail Agency', 'required|trim');


		return $this->form_validation->run();
		
		
	}


	public function get_inventory_powers_recoup( array $a = NULL )
	{
		$sql = '
			select p.power_id,  IFNULL( bail_agent.full_name, "Not Transferred Yet" ) as full_name, p.pek,
			IFNULL( ba.agency_name, "Not Transferred Yet" ) as agency_name, pp.prefix, DATE_FORMAT( t.exp_date, "%c/%m/%Y" ) as exp_date, ps.key, ps.status			
			from power as p
			inner join transmission as t on t.transmission_id = p.transmission_id
			inner join power_prefix as pp on pp.prefix_id = p.prefix_id
			inner join power_status as ps on ps.power_status_id = p.status_id
			left join member as bail_agent on t.bail_agent_id = bail_agent.mek
			left join bail_agency_agent_join as baaj on baaj.bail_agent_id = bail_agent.mek
			left join bail_agency as ba on ba.bail_agency_id = baaj.bail_agency_id
			where 1 = 1			
		';
		
		$sql .= ' and t.mga_id 			= ' . $this->db->escape( $a[ 'mek' ] );
		$sql .= ' and t.bail_agent_id = ' . $this->db->escape( $a[ 'agent_id' ] );
		$sql .= ' and t.mga_accepted 	= 1';
		$sql .= ' and p.transferred_master = 1';
		$sql .= ' and ps.key = "inventory"';
		
		$sql .= ' order by pp.prefix, ps.key, p.pek, full_name';
		
		return $this->db->query( $sql )->result_array();
		
		
		
	}


	public function get_temp_transfer_powers()
	{
		return $this->session->userdata( 'transfer_powers' );		
	}
	
	
	public function save_temp_transfer_powers()
	{
		$d = $this->sfa();
		
		
		$this->session->unset_userdata( 'transfer_powers' );
		$this->session->set_userdata( 'transfer_powers', explode( ',', $d['transfer'] ) );
		
		return true;

	}
		
 	
	public function get_inventory( array $a = NULL )
	{
		$sql = '
			select p.power_id,  IFNULL( bail_agent.full_name, "Not Transferred Yet" ) as full_name, p.pek,
			IFNULL( ba.agency_name, "Not Transferred Yet" ) as agency_name, pp.prefix, DATE_FORMAT( t.exp_date, "%c/%m/%Y" ) as exp_date, ps.key, ps.status			
			from power as p
			inner join transmission as t on t.transmission_id = p.transmission_id
			inner join power_prefix as pp on pp.prefix_id = p.prefix_id
			inner join power_status as ps on ps.power_status_id = p.status_id
			left join member as bail_agent on t.bail_agent_id = bail_agent.mek
			left join bail_agency_agent_join as baaj on baaj.bail_agent_id = bail_agent.mek
			left join bail_agency as ba on ba.bail_agency_id = baaj.bail_agency_id
			where 1 = 1			
		';
		
		$sql .= ' and t.mga_id 			= ' . $this->db->escape( $a[ 'mek' ] );
		$sql .= ' and t.mga_accepted 	= 1';
		
		#$sql .= ' and ps.key = "inventory" and bail_agent.full_name is NULL';
		
		
		
		$sql .= ' order by pp.prefix, ps.key, p.pek, full_name';
		
		return $this->db->query( $sql )->result_array();
	}
	

}