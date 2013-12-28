<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transmissions_model extends MY_Model {

    public function __construct()
	{
        // Call the Model constructor
        parent::__construct();
		$this->load->model( 'agent/crud_model' ,'a' );
		$this->load->model( 'agency/agency_crud_model' , 'agency' );
		$this->load->model( 'power_prefixes/prefix_crud_model', 'prefix' );
		$this->load->model( 'power_status/status_crud_model' , 'status' );
		$this->load->model( 'powers/power_history_model' , 'history' );
		$this->load->model( 'mga/mga_crud_model', 'mga' );
		
	}
	
	public function get_max_power( $prefix )
	{
		
		$sql = '
			select ( IFNULL( max( pek ), 0 ) + 1 ) as max_power from power where prefix_id = ?
		';	
		
		$q = $this->db->query( $sql, array( $prefix ) )->row();

		return $q->max_power;
		//return json_encode( array( 'power' => $q->max_power ) );
	}
	
	
	
	
	public function recoup_powers( $trans_id )
	{
		$status = $this->status->get_power_status_id( 'voided' );
		$powers = $this->get_inventory_powers_from_transmission( $trans_id );
		
		foreach( $powers as $p )
		{
			$this->db->trans_start();
				$this->db->update( 'power', array( 'status_id' => $status->power_status_id ), array( 'power_id' => $p[ 'power_id' ] ) );
				$this->db->update( 'transmission', array( 'is_recouped' => 1, 'recoup_date' => $this->now() ), array( 'transmission_id' => $trans_id ) );
				$this->history->set_power_history( array( 'power_id' => $p[ 'power_id' ], 'log' => 'Power recouped by insurance company' ) );
			$this->db->trans_complete();
			
		}	
		
		return true;
	}
	
	
	
	
	public function format_batch( array $batch )
	{
		$b 		= array_unique( $batch, SORT_REGULAR  );	
		$final 	= array();
		
		foreach( $b as $arr )
		{
			if( ! $arr[ 'is_mga' ] )
			{
				$temp = array(
					'bail_agency_name' 	=> $this->agency->get_agency( array( 'bail_agency_id' => $arr[ 'bail_agency' ] ) )->agency_name,
					'agent_name'		=> $this->a->get_agents( $arr['agent_id'] )->full_name,
					'prefix'			=> $this->prefix->get_prefix_name( array( 'prefix_id' => $arr[ 'power_prefix' ] ) )			
				);
				
			}
			else
			{
				$mga = $this->mga->get_mga_admins( array( 'mek' => $arr[ 'agent_id' ] ) );				
				$temp = array(
					'bail_agency_name' 	=> $mga[ 'company_name' ],
					'agent_name'		=> $mga[ 'full_name' ],
					'prefix'			=> $this->prefix->get_prefix_name( array( 'prefix_id' => $arr[ 'power_prefix' ] ) )			
				);
				
			}
						
			$final[] = array_merge( $temp, $arr );
		}
		
		return $final;	
	}
	
	public function get_inventory_powers_from_transmission( $trans_id )
	{
		$sql = "
			SELECT
				p.power_id, p.pek, DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp_date,
				DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp, p.photo,				
				pp.prefix, pp.amount, concat( pp.prefix , ' ' , pp.amount ) as full_prefix,
				ps.status, ps.key, p.prefix_id, t.transmission_id
			FROM power AS p			
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id	
			
			WHERE ps.key = 'inventory'	
		";
		
		$sql .= ' AND p.transmission_id = ' . $this->db->escape( $trans_id );
		
		
		
		
		return $this->db->query( $sql )->result_array();
		
		
		
	}
	
	public function check_initialized( $prefix )
	{
		
		//check if this is the first time the power has been used. 
		$sql2 = "
			select initialized, prefix_start
			from power_prefix
			where prefix_id = ?
		";			
		
		$initialized = $this->db->query( $sql2, array( $prefix ) )->row();

		if( $initialized->initialized == '0' )
		{
			$this->db->trans_start();
				$this->db->update( 'power_prefix', array( 'initialized' => 1 ), array( 'prefix_id' => $prefix ) );
			$this->db->trans_complete();
		}
			
		return $initialized;		
		
	}
	
	public function batch_transmission( array $a = NULL )
	{
		
		$batch 		= $this->session->userdata( 'batch_trans' );		
		$d 			= $this->sfa();		
		
		
		$initialized = $this->check_initialized( $d[ 'power_prefix' ] );
		
		if( $initialized->initialized == '0' )
		{
			$this->db->trans_start();
				$this->db->update( 'power_prefix', array( 'initialized' => 1 ), array( 'prefix_id' => $prefix ) );
			$this->db->trans_complete();

			$max_power = $initialized->prefix_start;
		}
		else
		{
			$max_power 	= $this->get_max_power( $d[ 'power_prefix' ] );
		}
		
		
		
		
		$batch[] = array(
			'agent_id'		=> ( isset( $a[ 'mga' ] )  ? $this->input->post( 'mga_agency' ) : $this->input->post( 'agent_id' ) ),
			'bail_agency'	=> ( isset( $a[ 'mga' ] )  ? NULL : $this->input->post( 'bail_agency' ) ),
			'power_prefix'	=> $this->input->post( 'power_prefix' ),
			'exp_date'		=> $this->input->post( 'exp_date' ),
			'power_start'	=> $max_power,
			'power_end'		=> $max_power + ( $d[ 'power_amount' ] - 1 ),
			'is_mga'		=> ( isset( $a[ 'mga' ] )  ? TRUE : FALSE )
		);
		
		$this->session->set_userdata( 'batch_trans', $batch );

		return true;
		
	}
	

	public function get_mga_transmissions( $mek )
	{
		$trans_groups = array();	
		$sql = "
			select transmission_id, m.full_name, mga.company_name, 
			DATE_FORMAT( t.exp_date, '%c/%e/%Y' )  as exp_date,			
			DATE_FORMAT( t.recoup_date, '%c/%e/%Y' )  as recoup_date,			
			DATE_FORMAT( t.created_date, '%c/%e/%Y' )  as created_date,			
			case t.active
			  when 1 then 'Active'
			  when 0 then 'Not Active'
			  else 'Not Active'
			end as active,
			case t.is_recouped
			  when 1 then 'RECOUPED TRANSMISSION'
			  when 0 then ''
			  else ''
			end as recouped
			
			from transmission as t
			inner join member m on m.mek = t.mga_id 
			inner join mgas as mga on mga.mek = m.mek
			
			where t.insurance_agent_id = ?	
			
			Order by created_date DESC			
		";
		$q = $this->db->query( $sql, array( $mek ) )->result_array();
		
		
		foreach( $q as $trans )
		{
  		$sql = "
			select distinct pp.prefix, pp.amount, 
			DATE_FORMAT( t.exp_date, '%c/%e/%Y' )  as exp_date,
			( select min( pek ) from power where transmission_id = t.transmission_id and prefix_id = pp.prefix_id ) as min_power,
			( select max( pek ) from power where transmission_id = t.transmission_id and prefix_id = pp.prefix_id ) as max_power
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

	
	
	public function get_transmissions( $mek )
	{
		$trans_groups = array();	
		$sql = "
			select transmission_id, m.full_name, b.agency_name, 
			DATE_FORMAT( t.exp_date, '%c/%e/%Y' )  as exp_date,			
			DATE_FORMAT( t.recoup_date, '%c/%e/%Y' )  as recoup_date,			
			DATE_FORMAT( t.created_date, '%c/%e/%Y' )  as created_date,			
			
			case t.active
			  when 1 then 'Active'
			  when 0 then 'Not Active'
			  else 'Not Active'
			end as active,
			case t.is_recouped
			  when 1 then 'RECOUPED TRANSMISSION'
			  when 0 then ''
			  else ''
			end as recouped
			
			from transmission as t
			inner join member m on m.mek = t.bail_agent_id 
			inner join member a on a.mek = insurance_agent_id
			inner join bail_agency_agent_join baaj on baaj.bail_agent_id = t.bail_agent_id
			inner join bail_agency b on b.bail_agency_id = baaj.bail_agency_id	
			
			where t.insurance_agent_id = ? AND t.mga_id is NULL				
		";
		$q = $this->db->query( $sql, array( $mek ) )->result_array();
		
		
		foreach( $q as $trans )
		{
  		$sql = "
			select distinct pp.prefix, pp.amount, 
			DATE_FORMAT( t.exp_date, '%c/%e/%Y' )  as exp_date,
			( select min( pek ) from power where transmission_id = t.transmission_id and prefix_id = pp.prefix_id ) as min_power,
			( select max( pek ) from power where transmission_id = t.transmission_id and prefix_id = pp.prefix_id ) as max_power
			from power p
			inner join transmission as t on t.transmission_id = p.transmission_id
			inner join power_prefix as pp on pp.prefix_id = p.prefix_id
			inner join member m on m.mek = t.bail_agent_id 
			inner join member a on a.mek = insurance_agent_id
			inner join bail_agency_agent_join baaj on baaj.bail_agent_id = t.bail_agent_id
			inner join bail_agency b on b.bail_agency_id = baaj.bail_agency_id	
			where 	
			 p.transmission_id = " . $this->db->escape( $trans[ 'transmission_id' ] );	
		
			$q = $this->db->query( $sql )->result_array();
			
			
			$trans[ 'power_group' ] = $q;
			
			$trans_groups[] = $trans;
		}	
		
		
		return $trans_groups;		
	}
	

	public function validate_mga_create_frm()
	{
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('mga_agency', 'MGA Agency', 'required');
		$this->form_validation->set_rules('power_prefix', 'Power Prefix', 'required');
		$this->form_validation->set_rules('exp_date', 'Expiration Date', 'required');
		$this->form_validation->set_rules('power_amount', 'Power Amount', 'required|integer');

		//$this->form_validation->set_rules('power_start', 'Power Start', 'required|integer|check_power_availability[power_start,power_end]');
		//$this->form_validation->set_rules('power_end', 'Power end', 'required|integer');
		
		return $this->form_validation->run();
	}


	
	public function validate_create_frm()
	{
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('bail_agency', 'Bail Agency', 'required');
		$this->form_validation->set_rules('agent_id', 'Bail Agent', 'required');
		$this->form_validation->set_rules('power_prefix', 'Power Prefix', 'required');
		$this->form_validation->set_rules('exp_date', 'Expiration Date', 'required');
		
		$this->form_validation->set_rules('power_amount', 'Power Amount', 'required|integer');

		//$this->form_validation->set_rules('power_start', 'Power Start', 'required|integer|check_power_availability[power_start,power_end]');
		//$this->form_validation->set_rules('power_end', 'Power end', 'required|integer');
		
		return $this->form_validation->run();
	}
	


	public function get_ins_company_id( array $a )
	{
		
		$sql = '
			SELECT insurance_agency_id
			FROM insurance_agency_agent_join AS iaaj
			WHERE 1 = 1
		';	
		
		$sql .= ' AND insurance_agent_id = ' . $this->db->escape( $a[ 'mek' ] );
		
		$q = $this->db->query( $sql )->row_array();
		
		return $q[ 'insurance_agency_id' ];
		
	}

	
	
	public function create_transmission( $mek , $d, $is_mga = NULL )
	{		

		//get the trans status
		$this->db->select( 'transmission_status_id' )->from( 'transmission_status' )->where( array( 'key' => 'new' ) );
		$q = $this->db->get();
		$trans_status = $q->row();
		$agency = $this->a->get_agency_by_agent( array( 'mek' => $d[0]['agent_id'] ) );
		

		if( isset( $is_mga ) )
		{
			$data = array(
				'insurance_company_id'		=> $this->get_ins_company_id( array( 'mek' => $mek ) ),
				'insurance_agent_id' 		=> $mek,
				'mga_id'					=> $d[0]['agent_id'],
				'transmission_status_id'	=> $trans_status->transmission_status_id,
				'exp_date'					=> $this->mysql_date_format( $d[0]['exp_date'] ),
				'created_date'				=> $this->now()
			);
		}
		else
		{

			$data = array(
				'insurance_company_id'		=> $this->get_ins_company_id( array( 'mek' => $mek ) ),
				'insurance_agent_id' 		=> $mek,
				'bail_agent_id'				=> $d[0]['agent_id'],
				'bail_agency_id'			=> $agency[ 'bail_agency_id' ],
				'transmission_status_id'	=> $trans_status->transmission_status_id,
				'exp_date'					=> $this->mysql_date_format( $d[0]['exp_date'] ),
				'created_date'				=> $this->now()
			);
			
		}

		$this->db->trans_start();		
			$this->db->insert( 'transmission', $data );
			$trans_id = $this->db->insert_id();				
		$this->db->trans_complete();
		
		return $trans_id;	
	}
	
	public function save_transmission( $mek , $d, $trans_id, $is_mga = NULL )
	{
		
		$powers = array();
		$history = array();
		
		
		
		//get the power status
		$this->db->select( 'power_status_id' )->from( 'power_status' )->where( array( 'key' => 'inventory' ) );
		$q = $this->db->get();
		$power_status = $q->row();

		
		
		$this->db->trans_start();
				
			for( $i = $d[ 'power_start']; $i <= $d[ 'power_end' ]; $i++ )
			{
				$power = array(
					'pek' 				=> $i,
					'prefix_id'			=> $d['power_prefix'],
					'transmission_id'	=> $trans_id,
					'status_id'			=> $power_status->power_status_id,
					'exp_date'			=> $this->mysql_date_format( $d[ 'exp_date' ] )
					
				);
	
				$this->db->insert( 'power', $power );

				$history = array(
					'power_id'	=> $this->db->insert_id(),
					'log'		=> 'Power created by insurance agency',
					'date'		=> $this->now(),
					'mek'		=> $mek
				);
				
				$this->db->insert( 'power_history', $history );
				
			}
			
			if( isset( $is_mga ) ) $this->send_mga_notification( $d['agent_id'], $mek );
			else $this->send_notification( $d['agent_id'], $mek );
			
		$this->db->trans_complete();		
	}
	
	
	private function send_notification( $agent_id, $ins_id )
	{
		$this->load->model( 'agent/crud_model', 'c' );
		$agent = $this->c->get_agents( $agent_id );
		
		$this->em->send_transmission_notification( $agent );
	}

	private function send_mga_notification( $agent_id, $ins_id )
	{
		$agent = $this->mga->get_mga_admins( array( 'mek' => $agent_id ) );
		
		$this->em->send_transmission_notification( $agent );
	}
	
	
	public function get_agencies()
	{
		$sql = '
			select bail_agency_id, agency_name
			from bail_agency
			order by agency_name
		';
		
		$q = $this->db->query( $sql );
		
		$q = $q->result_array();
		
		$ret = array('' => 'Select Agency' );
		
		foreach( $q as $value )	$ret[ $value[ 'bail_agency_id' ] ] = $value[ 'agency_name' ];
			
		return $ret;	
		
	}

	public function get_prefixes( $agency_id )
	{
		$sql = '
			select prefix_id, prefix, amount
			from power_prefix
			where active = 1
			and insurance_agency_id = ?
			order by amount, prefix
		';	
		$ret = array( '' => 'Select Prefix' );
		$q = $this->db->query( $sql, array( $agency_id ) );
		$q = $q->result_array();
		
		foreach( $q as $value ) $ret[ $value[ 'prefix_id' ] ] = $value['prefix'];
		
		return $ret;
		
	}
	
	public function get_agent_name( $agency_id )
	{
		$sql = '
			select m.full_name, m.mek
			from bail_agency_agent_join baaj
			inner join bail_agency bay on bay.bail_agency_id = baaj.bail_agency_id
			inner join bail_agent ba on ba.mek = baaj.bail_agent_id
			inner join member m on m.mek = ba.mek
			where ba.is_sub_agent = 0 and bay.bail_agency_id = ? 
		';
		
		$q = $this->db->query( $sql, array( $agency_id ) );
		$q = $q->row();
		
		return array( 'name' => 'Master Agent: ' .  $q->full_name, 'mek' => $q->mek );
	}


}