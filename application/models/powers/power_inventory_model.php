<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class power_inventory_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model( 'powers/power_model', 'power' );
		$this->load->model( 'agent/crud_model', 'agent' );
		$this->load->model( 'powers/power_history_model', 'history' );
	}

	public function complate_transfer()
	{
		
		$data = $this->session->userdata( 'transfer' );
		foreach( $data[ 'powers' ] as $powers )
		{
			foreach( $powers as $p )
			{

				$this->save_transfer( array( 'mek' => $data[ 'agent' ]->mek, 'power_id' => $p['power_id' ] ) );
				$h = array(
					'power_id'		=> $p['power_id' ],
					'log'			=> 'Initial Transfer To Sub Agent: ' . $data[ 'agent' ]->full_name
				);
			
				$this->history->set_power_history( $h );
			}
			
		}
		
				
		
		return true;
		
		
		
	}


	public function list_powers_to_transfer( $d, $mek )
	{
	
		$keys = array_keys( $d );
		$temp = array();
		
		foreach( $keys as $key )
		{
			$prefix = explode( '_', $key );
			if( count( $prefix ) > 1 ) $temp[ ] = $this->get_powers_list( $prefix[0], $d[ $key ], $mek );
		
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
			where ps.key = 'inventory' and p.transferred_sub = 0
		
		";
		$sql .= ' AND pp.prefix = ' . $this->db->escape( $prefix );
		$sql .= ' AND t.bail_agent_id = ' . $this->db->escape( $mek );
		$sql .= ' ORDER BY pek asc';
		$sql .= ' LIMIT ' . $val;
		
		return $this->db->query( $sql )->result_array();
	}

	public function validate_transfer( $mek )
	{
	
		$breakdown = $this->get_power_breakdown( array( 'mek' => $mek ) );
		
		$d = $this->sfa();
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
			
		foreach( $breakdown as $v  )
		{
			$this->form_validation->set_rules( $v['prefix'] . '_' . 'amount', $v[ 'prefix' ], 'required|integer|check_power_transfer_amount[' . ( intval( $v[ 'power_count' ] ) ) .' ]|greater_than[ -1 ]');		
		}
		
		$this->form_validation->set_rules('subagent', 'Sub Agent', 'required');		
		
		return $this->form_validation->run();
		
	}




	public function get_power_breakdown( array $a )
	{
		$sql = "
			select prefix, count( power_id ) as power_count 
			from power as p			
			inner join power_prefix as pp 
			on pp.prefix_id = p.prefix_id
			inner join power_status as ps
			on ps.power_status_id = status_id
			inner join transmission as t on t.transmission_id = p.transmission_id			
			where ps.key = 'inventory' and p.transferred_sub = 0
		";

		$sql .= ' AND t.bail_agent_id = ' . $this->db->escape( $a['mek'] );
		$sql .= ' group by prefix ORDER BY prefix';
		//$sql .= " AND p.transferred_master = 1";	
		
		$q = $this->db->query( $sql )->result_array();
			
		return $q;		

		
	}


	public function get_sub_agent_power_breakdown( array $a )
	{
		$sql = "
			select prefix, count( p.power_id ) as power_count 
			from power as p			
			inner join power_prefix as pp 
			on pp.prefix_id = p.prefix_id
			inner join power_status as ps
			on ps.power_status_id = status_id
			inner join transmission as t on t.transmission_id = p.transmission_id			
            inner join power_sub_agent_join as psaj on psaj.power_id = p.power_id
			where ps.key = 'inventory' and p.transferred_sub = 1 and psaj.recouped_date is NULL
		";

		$sql .= ' AND psaj.mek = ' . $this->db->escape( $a['mek'] );
		$sql .= ' group by prefix ORDER BY prefix';
		
		$q = $this->db->query( $sql )->result_array();
			
		return $q;		

		
	}



	public function sub_agent_search_powers( array $a )
	{
		
		if( isset( $a[ 'search' ] ) )
		{
			$power = explode( ' ', $a[ 'search' ] );

		}
				
		$sql = '
			SELECT 
				p.power_id, 
				pp.prefix, 
				pp.amount, 
				p.pek, 
				DATE_FORMAT( p.exp_date, "%c/%m/%Y" ) as exp_date, ps.status, ps.key, m.full_name, ia.agency_name, t.transmission_id
			FROM power_sub_agent_join AS psj
			INNER JOIN power AS p
				ON p.power_id = psj.power_id
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN insurance_agency_agent_join AS iaaj
				ON iaaj.insurance_agent_id = t.insurance_agent_id
			INNER JOIN insurance_agency AS ia
				ON ia.insurance_agency_id = iaaj.insurance_agency_id
			INNER JOIN member AS m
				ON m.mek = t.insurance_agent_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id	
			LEFT JOIN power_details_defendant AS pdd
				ON pdd.power_id = p.power_id				
			
			WHERE 1 = 1 AND paid = 1 			
			
			and psj.recouped_date is NULL
		';
		
		$sql .= ' AND psj.mek = ' . $this->db->escape( $a[ 'mek' ] );
		
	
		if( isset( $a[ 'status' ] ) ) $sql .= ' AND ps.key = ' . $this->db->escape( $a[ 'status' ] );
		if( isset( $a[ 'search' ] ) ) $sql .= ' AND p.pek = ' . $this->db->escape( $a[ 'search' ] );
		if( isset( $a[ 'prefix' ] ) ) $sql .= ' AND pp.prefix_id = ' . $this->db->escape( $a[ 'prefix' ] );
		if( isset( $a[ 'defendant_first' ] ) && strlen( $a[ 'defendant_first' ] ) > 0 ) $sql .= " AND  pdd.first_name like '%" .  $a[ 'defendant_first' ]  . "%'";
		if( isset( $a[ 'defendant_last' ] )  && strlen( $a[ 'defendant_last' ] ) > 0 ) $sql .= " AND  pdd.last_name like '%" .  $a[ 'defendant_last' ]  . "%'";
	
		
		if( isset( $a[ 'start_date' ] ) && isset( $a[ 'end_date' ] ) ) $sql .= ' AND t.created_date between ' . $this->db->escape( $this->mysql_date_format( $a[ 'start_date' ] ) ) . ' AND ' . $this->db->escape( $this->mysql_date_format( $a[ 'end_date' ] ) );
		$sql .= ' ORDER BY pp.prefix, pp.amount, p.exp_date';	
		
	
		
			
		$q = $this->db->query( $sql )->result_array();
			
		return $q;		
		
	}



	public function search_powers( array $a )
	{

		
		if( isset( $a[ 'search' ] ) )
		{

			$power = explode( ' ', $a[ 'search' ] );


		}
		
		$sql = '
			SELECT 
				p.power_id, 
				pp.prefix, 
				pp.amount, 
				p.pek, 
				DATE_FORMAT( p.exp_date, "%c/%m/%Y" ) as exp_date, ps.status, ps.key, m.full_name, ia.agency_name, t.transmission_id
			FROM transmission AS t
			INNER JOIN power AS p
				ON p.transmission_id = t.transmission_id
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id	
			INNER JOIN insurance_agency_agent_join AS iaaj
				ON iaaj.insurance_agent_id = t.insurance_agent_id
			INNER JOIN insurance_agency AS ia
				ON ia.insurance_agency_id = iaaj.insurance_agency_id
			INNER JOIN member AS m
				ON m.mek = t.insurance_agent_id				
			LEFT JOIN power_details_defendant AS pdd
				ON pdd.power_id = p.power_id				
			WHERE 1 = 1
			AND t.paid = 1
			-- AND p.is_reported = 0
		';		
 		
		$sql .= ' AND t.bail_agent_id = ' . $this->db->escape( $a['mek'] );
		if( isset( $a[ 'status' ] ) ) $sql .= ' AND ps.key = ' . $this->db->escape( $a[ 'status' ] );
		if( isset( $a[ 'search' ] ) ) $sql .= ' AND p.pek = ' . $this->db->escape( $a[ 'search' ] );
		if( isset( $a[ 'prefix' ] ) ) $sql .= ' AND pp.prefix_id = ' . $this->db->escape( $a[ 'prefix' ] );
		if( isset( $a[ 'defendant_first' ] ) && strlen( $a[ 'defendant_first' ] ) > 0 ) $sql .= " AND  pdd.first_name like '%" .  $a[ 'defendant_first' ]  . "%'";
		if( isset( $a[ 'defendant_last' ] )  && strlen( $a[ 'defendant_last' ] ) > 0 ) $sql .= " AND  pdd.last_name like '%" .  $a[ 'defendant_last' ]  . "%'";
	

		if( isset( $a[ 'start_date' ] ) && isset( $a[ 'end_date' ] ) ) $sql .= ' AND t.created_date between ' . $this->db->escape( $this->mysql_date_format( $a[ 'start_date' ] ) ) . ' AND ' . $this->db->escape( $this->mysql_date_format( $a[ 'end_date' ] ) );
		$sql .= ' ORDER BY pp.prefix, pp.amount, p.exp_date';	
		
	
			
		$q = $this->db->query( $sql )->result_array();
			
		return $q;		
			
	}




	
	public function validate_recoup_powers_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('recoup[]', 'Recoup Powers', 'required');		
		
		return $this->form_validation->run();
		
		
	}

	public function save_recoup_powers( array $powers )
	{
	
	
		$this->db->trans_start();
			foreach( $powers as $r )
			{
				
				$power = explode( '-', $r );
				$this->db->update( 'power', array( 'transferred_sub' => 0 ), array( 'power_id' => $power[0] ) );
				
				$this->db->update( 'power_sub_agent_join', array( 'active' => 0, 'recouped_date' => $this->now() ), array( 'power_id' => $power[0]  ) );

				$agent = $this->agent->get_agents( $power[ 1 ] );

			
				$h = array(
					'mek' 			=> $power[ 1 ],
					'power_id'		=> $power[ 0 ],
					'log'			=> 'Recouped Power From Sub Agent: ' . $agent->full_name
				);
				
				$this->history->set_power_history( $h );
			
			}
		$this->db->trans_complete();

		return true;
	}

	
	public function notify_sub_agent_recoup( array $powers )
	{
		$duplicates = array();

		foreach( $powers as $r )
		{
			if( ! in_array( $r[ 1 ], $duplicates ) )
			{
				$power = explode( '-', $r );
				$data = array();
				
				$data[ 'sub_agent_email' ] 		= $this->agent->get_sub_agents( array( 'sub_mek' => $power[ 1 ] ) )->email;
				$data[ 'master_agent_email' ] 	= $this->session->userdata( 'email' );
				
				$this->em->notify_sub_agent_recoup( $data );
				$duplicates[] = $power[1 ];			
			}
		}
		
		return true;
	}





	public function notify_sub_agent_transfers($d)
	{

		$data = array();
			
		$data[ 'sub_agent_email' ] 		= $d[ 'agent' ]->email;
		$data[ 'master_agent_email' ] 	= $this->session->userdata( 'email' );

		$this->em->notify_sub_agent_transfers( $data );		
		
		return true;
	}







	
	public function get_sub_agent_powers( array $args )
	{
		$sql = "
			SELECT
				m.full_name, p.power_id, p.pek, DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp_date,
				DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp, 
				pp.prefix, pp.amount, concat( pp.prefix , ' ' , pp.amount ) as full_prefix,
				ps.status, ps.key, p.prefix_id, m.mek
			FROM power AS p
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id
      		INNER JOIN power_sub_agent_join AS psaj
      			ON psaj.power_id = p.power_id
      		INNER JOIN member AS m 
		      	ON m.mek = psaj.mek
			INNER JOIN master_sub_join AS msj
			    on msj.sub_id = m.mek				
			WHERE 1 = 1	
			AND ps.key = 'inventory'	
	  ";

		if( isset( $args['mek'] ) ) $sql .= 'AND msj.master_id = ' . $this->db->escape( $args[ 'mek' ] );
		
		$sql .= ' AND psaj.active = 1';
		$sql .= ' ORDER BY m.full_name';
		
		return $this->db->query( $sql )->result_array();

	}







	
	
	
	public function save_transfer_powers()
	{
		$d = $this->sfa();
		$power_status = $this->power->get_power_status_query('sub_agent')->power_status_id;
		$peks = $this->session->userdata( 'transfer_powers' );
		
		
		foreach( $peks as $p )
		{
			$agent = $this->agent->get_agents( $d[ 'sub_agent' ] );
			$this->save_transfer( array( 'mek' => $d[ 'sub_agent' ], 'power_id' => $p ) );
			
			$h = array(
				'power_id'		=> $p,
				'log'			=> 'Initial Transfer To Sub Agent: ' . $agent->full_name
			);
			
			$this->history->set_power_history( $h );
		}
		
		
		$this->session->unset_userdata( 'transfer_powers' );
		
		return true;
	}







	
	
	
	//mek, pek
	public function save_transfer( array $args )
	{
		$this->db->trans_start();
			$this->db->update( 'power', array( 'transferred_sub' => 1 ), array( 'power_id' => $args['power_id' ] ) );
			$this->db->insert( 'power_sub_agent_join', array( 'power_id' => $args['power_id'], 'mek' => $args[ 'mek'] ) );
		$this->db->trans_complete();	

		return true;
		
	}
	
	






	

	public function validate_sub_agent_transfer_powers_frm()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('sub_agent', 'Sub Agent', 'required');		
		
		return $this->form_validation->run();
		
	}
	
	






	

	public function validate_transfer_powers_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('transfer[]', 'Transfer Powers', 'required');		
		
		return $this->form_validation->run();
		
		
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
	





	

	






	

	//mek, status key
	public function get_inventory( array $args )
	{
		$sql = "
			SELECT p.power_id, ps.status, p.pek, DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp_date, ps.key,
			m.full_name, ia.agency_name, t.transmission_id, concat( pp.prefix, ' ', pp.amount ) as prefix, pp.prefix_id,
			p.pek
			FROM power AS p
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN insurance_agency_agent_join AS iaaj
				ON iaaj.insurance_agent_id = t.insurance_agent_id
			INNER JOIN insurance_agency AS ia
				ON ia.insurance_agency_id = iaaj.insurance_agency_id
			INNER JOIN member AS m
				ON m.mek = t.insurance_agent_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id	
							
			WHERE 1 = 1 AND paid = 1
		";
		
		if( ! isset( $args[ 'sub_agent' ] ) ) $args['sub_agent'] = 0;
		
		
		if( isset( $args[ 'mek' ] ) ) $sql .= "AND t.bail_agent_id = " . $this->db->escape( $args[ 'mek' ] );			
		if( isset( $args[ 'key' ] ) ) $sql .= "AND ps.key = " . $this->db->escape( $args[ 'key' ] ); 
		if( isset( $args[ 'sub_agent' ] ) ) $sql .= "AND p.transferred_sub = " . $this->db->escape( $args[ 'sub_agent' ] ); 
		//$sql .= " AND p.transferred_master = 1";	
		return $this->db->query( $sql )->result_array();
	}


	public function get_sub_agent_inventory( array $a )
	{
		$sql = "
			SELECT p.power_id, ps.status, p.pek, DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp_date, ps.key,
			m.full_name, ia.agency_name, t.transmission_id, concat( pp.prefix, ' ', pp.amount ) as prefix, pp.prefix_id,
			p.pek
			FROM power_sub_agent_join AS psj
			INNER JOIN power AS p
				ON p.power_id = psj.power_id
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN insurance_agency_agent_join AS iaaj
				ON iaaj.insurance_agent_id = t.insurance_agent_id
			INNER JOIN insurance_agency AS ia
				ON ia.insurance_agency_id = iaaj.insurance_agency_id
			INNER JOIN member AS m
				ON m.mek = t.insurance_agent_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id	
			
			WHERE 1 = 1 AND paid = 1 	
			AND psj.recouped_date is NULL		
		";
		
		$sql .= ' AND psj.mek = ' . $this->db->escape( $a[ 'mek' ] );
		if( isset( $a[ 'key' ] ) ) $sql .= " AND ps.key = " . $this->db->escape( $a[ 'key' ] ); 
		
		return $this->db->query( $sql )->result_array();
	}





	

}