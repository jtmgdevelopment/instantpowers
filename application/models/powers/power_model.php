<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class power_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->helper('file');
		$this->load->model( 'power_status/status_crud_model', 'ps' );

	}


/*

	CREATE POWERS
	powers_batch = array(
		'powers' => array(
			'TRANSID_PEK_PREFIX_ID' => 'serialized_data of the power info',
			'TRANSID_PEK_PREFIX_ID' => 'serialized_data of the power info',
			'TRANSID_PEK_PREFIX_ID' => 'serialized_data of the power info'	 	
		),
		'defendant' => array(
			'defendant_name' 	=> 'Full Name',
			'data'				=> 'serialized data
		),
		'executing_agent' => 'Agent Name' 
	)

*/

	//need to change this to the power id

	public function save_general_power_info()
	{
		$batch_id 		= ( ! $this->session->userdata( 'batch_id' ) ? 0 : $this->session->userdata( 'batch_id' ) );
		$d 				= $this->sfa();
		
		$powers_batch = array(
			'powers' => array(
					$d[ 'power_id' ]  => json_encode( $d )		
			)
		);		
		
		//add the defendant and executing agent info
		if( $batch_id == 0 )
		{
			$powers_batch[ 'defendant' ] = array(
				'first_name' 	=> $d[ 'defendant_fname' ],
				'last_name'		=> $d[ 'defendant_lname' ]
			);			
			$powers_batch[ 'executing_agent' ] = $d[ 'executing_agent' ];
		}
		
		//save to the database
		$batch_id = $this->temp_save_power( $batch_id, $powers_batch );

	}

	private function temp_save_power($batch_id, $powers_batch )
	{
		
		//the need to make sure there is no duplicate powers
		//need to check the power_id for this
		
		//get the saved power
		$data = $this->db->select( 'saved_power_id, data' )->get_where( 'saved_powers', array( 'saved_power_id' => $batch_id ) );		
		
		if( ! $data->num_rows() )
		{
			//insert the power info	
			$d = array(
				'data' => json_encode( $powers_batch )
			);
			
			$this->db->trans_start();
				$this->db->insert( 'saved_powers', $d );	
				$this->session->set_userdata( 'batch_id' , $this->db->insert_id() );
			$this->db->trans_complete();			
			
		}
		else
		{
			//existing data
			$temp 	= $data->row_array();
			$temp 	= ( array ) json_decode( $temp[ 'data' ] );		
			$powers	= ( array ) $temp[ 'powers' ];
			
			
			$powers[ key( $powers_batch[ 'powers' ] ) ] = reset( $powers_batch[ 'powers' ] );
			
			unset( $temp[ 'powers' ] );
			$temp[ 'powers' ] = $powers;

			$d = array(
				'data' => json_encode( $temp )
			);
			
			$this->db->trans_start();
				$this->db->update( 'saved_powers', $d, array( 'saved_power_id' => $batch_id ) );	
			$this->db->trans_complete();
			
		}
		
		return true;		
		
	}


	public function get_saved_power()
	{
		$batch_id = $this->session->userdata( 'batch_id' );

		if( ! $batch_id ) return array();
		$q = $this->db->select( 'data' )->get_where( 'saved_powers', array( 'saved_power_id' => $batch_id ) )->row_array();
		
		
		return ( array ) json_decode( $q[ 'data' ] );		
		
	}
	
	public function parse_saved_powers( $powers )
	{
		$a = ( array ) $powers;
		$r = array();
		
		foreach( $a as $k => $v ) $r[ $k ] = ( array ) json_decode( $v );
		
		return $r;	
		
	}
	
	public function parse_saved_defendant( $defendant )
	{
		$a = ( array ) $defendant;
		if( isset( $a[ 'data' ] ) ) $a[ 'data' ] = (array) json_decode( $a['data'] );
		else $a[ 'data' ] = array();
		return $a;	
		
	}
	
	
	public function strip_used_powers( $inventory, $used )
	{
		$p 		= array_keys( $used );
		$pek 	= array();
		$prefix = array();
		
		
		foreach( $inventory as $k => $v )	if( in_array( $v[ 'power_id'], $p ) ) unset( $inventory[ $k ] );
		
		
		return $inventory;
	}
	
	
	public function save_defendant_info()
	{
		$d = $this->get_saved_power();	
		$d[ 'defendant' ]->data = json_encode( $this->sfa() );
		
		$d = array(
			'data' => json_encode( $d )
		);
		
		$this->db->trans_start();
			$this->db->update( 'saved_powers', $d, array( 'saved_power_id' => $this->session->userdata( 'batch_id' ) ) );	
		$this->db->trans_complete();
		
		
		return true;	
		
	}


	public function save_offline_power()
	{
		
		$batch 		= $this->get_saved_power();		
		$powers 	= $this->parse_saved_powers( $batch[ 'powers' ] );
		$defendant 	= $this->parse_saved_defendant( $batch[ 'defendant' ] );
		$power_ids	= array();
		
		foreach( $powers as $p )
		{
			if( $p[ 'power_status' ] == 'executed' ) $p[ 'execution_date' ] = $this->now();
			if( $p[ 'power_status' ] == 'rewrite' ) $p[ 'rewrite_date' ] 	= $this->now();
			if( $p[ 'power_status' ] == 'transfer' ) $p[ 'transfer_date' ] 	= $this->now();
			
			$power_details = array(
				'trans_id' 			=> $this->get_value( $p, 'trans_id' ),
				'pek'				=> $this->get_value( $p, 'pek' ),
				'prefix_id'			=> $this->get_value( $p, 'prefix_id' ),
				'power_amount'		=> $this->get_value( $p, 'power_amount' ),
				'bond_amount'		=> $this->get_value( $p, 'bond_amount' ),
				'execution_date'	=> ( $this->get_value( $p, 'execution_date' ) != NULL ?  $this->mysql_date_format( $this->get_value( $p, 'execution_date' ) ) : $this->get_value( $p, 'execution_date' ) ),
				'discharge_date'	=> ( $this->get_value( $p, 'discharge_date' ) != NULL ?  $this->mysql_date_format( $this->get_value( $p, 'discharge_date' ) ) : $this->get_value( $p, 'discharge_date' ) ),
				'voided_date'		=> ( $this->get_value( $p, 'voided_date' ) != NULL ?  $this->mysql_date_format( $this->get_value( $p, 'voided_date' ) ) : $this->get_value( $p, 'voided_date' ) ),
				'rewrite_date'		=> ( $this->get_value( $p, 'rewrite_date' ) != NULL ?  $this->mysql_date_format( $this->get_value( $p, 'rewrite_date' ) ) : $this->get_value( $p, 'rewrite_date' ) ),
				'requesting_agency'	=> $this->get_value( $p, 'requesting_agency' ),
				'transfer_date'		=> $this->get_value( $p, 'transfer_date' ),
				'court_date'		=> ( $this->get_value( $p, 'court_date' ) != NULL ?  $this->mysql_date_format( $this->get_value( $p, 'court_date' ) ) : $this->get_value( $p, 'court_date' ) ),
				'court_time'		=> $this->get_value( $p, 'court_time' ),
				'court'				=> $this->get_value( $p, 'court' ),
				'county'			=> $this->get_value( $p, 'county' ),
				'case_number'		=> $this->get_value( $p, 'case_number' ),
				'charge'			=> $this->get_value( $p, 'charge' ),
				'city'				=> $this->get_value( $p, 'city' ),
				'state'				=> $this->get_value( $p, 'state' ),
				'executing_agent'	=> $batch[ 'executing_agent' ],
				'power_id'			=> $this->get_value( $p, 'power_id' )	,
				'rewrite_original_prefix_power' => $this->get_value( $p, 'rewrite_original_prefix_power' ),
				'rewrite_original_bond_amount'	=> $this->get_value( $p, 'rewrite_original_bond_amount' )		
			);
			
			$defendant_info = array(
				'trans_id' 			=> $this->get_value( $p, 'trans_id' ),
				'pek'				=> $this->get_value( $p, 'pek' ),
				'prefix_id'			=> $this->get_value( $p, 'prefix_id' ),
				'first_name'		=> $defendant[ 'first_name' ],
				'last_name'			=> $defendant[ 'last_name' ],
				'email'				=> $this->get_value( $defendant[ 'data' ], 'defendant_email' ),
				'ssn'				=> $this->get_value( $defendant[ 'data' ], 'defendant_social_security_number' ),
				'dob'				=> $this->get_value( $defendant[ 'data' ], 'defendant_dob' ),
				'address'			=> $this->get_value( $defendant[ 'data' ], 'defendant_address' ),
				'city'				=> $this->get_value( $defendant[ 'data' ], 'defendant_city' ),
				'state'				=> $this->get_value( $defendant[ 'data' ], 'defendant_state' ),
				'zip'				=> $this->get_value( $defendant[ 'data' ], 'defendant_zip' ),
				'phone'				=> $this->get_value( $defendant[ 'data' ], 'defendant_phone' ),
				'dl'				=> $this->get_value( $defendant[ 'data' ], 'defendant_dl' ),
				'power_id'			=> $this->get_value( $p, 'power_id' )
			);
			
			$indemnitor = array(
				'trans_id' 			=> $this->get_value( $p, 'trans_id' ),
				'pek'				=> $this->get_value( $p, 'pek' ),
				'prefix_id'			=> $this->get_value( $p, 'prefix_id' ),
				'first_name'		=> $this->get_value( $defendant[ 'data' ], 'indemnitor_first_name' ),
				'last_name'			=> $this->get_value( $defendant[ 'data' ], 'indemnitor_last_name' ),
				'email'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_email' ),
				'ssn'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_social_security_number' ),
				'dob'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_dob' ),
				'address'			=> $this->get_value( $defendant[ 'data' ], 'indemnitor_address' ),
				'city'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_city' ),
				'state'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_state' ),
				'zip'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_zip' ),
				'phone'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_phone' ),
				'dl'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_dl' ),
				'power_id'			=> $this->get_value( $p, 'power_id' )
			);
			
			$collateral = array(
				'trans_id' 			=> $this->get_value( $p, 'trans_id' ),
				'pek'				=> $this->get_value( $p, 'pek' ),
				'prefix_id'			=> $this->get_value( $p, 'prefix_id' ),
				'type'				=> $this->get_value( $defendant[ 'data' ], 'collateral_type' ),
				'owner'				=> $this->get_value( $defendant[ 'data' ], 'collateral_owner' ),
				'amount'			=> $this->get_value( $defendant[ 'data' ], 'collateral_amount' ),
				'desc'				=> $this->get_value( $defendant[ 'data' ], 'collateral_description' ),
				'power_id'			=> $this->get_value( $p, 'power_id' )
			);


			//update the sent electronically
			$d = array(
				'sent_electronically' 	=> 0,
				'status_id'				=> $this->ps->get_power_status_id( $p[ 'power_status' ] )->power_status_id
				
			);
			$where = array(
				'power_id'			=> $this->get_value( $p, 'power_id' )
			);				
			
			$power_ids[] = $this->get_power_id( $where );
			$log = 'Power executed as a offline printed power';		
			
			$this->db->trans_start();
				//insert the info
				$this->db->insert( 'power_details' , $power_details );			
				$this->db->insert( 'power_details_defendant' , $defendant_info );			
				$this->db->insert( 'power_details_indemnitor' , $indemnitor );			
				$this->db->insert( 'power_details_collateral' , $collateral );			
				$this->db->update( 'power', $d, $where );			
				$this->add_power_history( $log, $this->get_value( $p, 'power_id' ) );
				
			$this->db->trans_complete();
			
		}

		$this->session->unset_userdata( 'batch_id' );

		return $power_ids;
	}


	public function save_power()
	{
		
		$batch 		= $this->get_saved_power();	
		$powers 	= $this->parse_saved_powers( $batch[ 'powers' ] );
		$defendant 	= $this->parse_saved_defendant( $batch[ 'defendant' ] );
		$power_ids	= array();

		
		foreach( $powers as $p )
		{
			
			if( $p[ 'power_status' ] == 'executed' ) 	$p[ 'execution_date' ] 	= $this->now();
			if( $p[ 'power_status' ] == 'rewrite' ) 	$p[ 'rewrite_date' ] 	= $this->now();
			if( $p[ 'power_status' ] == 'transfer' ) 	$p[ 'transfer_date' ] 	= $this->now();
			
			$power_details = array(
				'trans_id' 			=> $this->get_value( $p, 'trans_id' ),
				'pek'				=> $this->get_value( $p, 'pek' ),
				'prefix_id'			=> $this->get_value( $p, 'prefix_id' ),
				'power_amount'		=> $this->get_value( $p, 'power_amount' ),
				'bond_amount'		=> $this->get_value( $p, 'bond_amount' ),
				'execution_date'	=> ( $this->get_value( $p, 'execution_date' ) != NULL ?  $this->mysql_date_format( $this->get_value( $p, 'execution_date' ) ) : $this->get_value( $p, 'execution_date' ) ),
				'discharge_date'	=> ( $this->get_value( $p, 'discharge_date' ) != NULL ?  $this->mysql_date_format( $this->get_value( $p, 'discharge_date' ) ) : $this->get_value( $p, 'discharge_date' ) ),
				'voided_date'		=> ( $this->get_value( $p, 'voided_date' ) != NULL ?  $this->mysql_date_format( $this->get_value( $p, 'voided_date' ) ) : $this->get_value( $p, 'voided_date' ) ),
				'rewrite_date'		=> ( $this->get_value( $p, 'rewrite_date' ) != NULL ?  $this->mysql_date_format( $this->get_value( $p, 'rewrite_date' ) ) : $this->get_value( $p, 'rewrite_date' ) ),
				'requesting_agency'	=> $this->get_value( $p, 'requesting_agency' ),
				'transfer_date'		=> $this->get_value( $p, 'transfer_date' ),
				'court_date'		=> ( $this->get_value( $p, 'court_date' ) != NULL ?  $this->mysql_date_format( $this->get_value( $p, 'court_date' ) ) : $this->get_value( $p, 'court_date' ) ),
				'court_time'		=> $this->get_value( $p, 'court_time' ),
				'court'				=> $this->get_value( $p, 'court' ),
				'county'			=> $this->get_value( $p, 'county' ),
				'case_number'		=> $this->get_value( $p, 'case_number' ),
				'charge'			=> $this->get_value( $p, 'charge' ),
				'city'				=> $this->get_value( $p, 'city' ),
				'state'				=> $this->get_value( $p, 'state' ),
				'executing_agent'	=> $batch[ 'executing_agent' ],
				'power_id'			=> $this->get_value( $p, 'power_id' ),
			
				'rewrite_original_prefix_power' => $this->get_value( $p, 'rewrite_original_prefix_power' ),
				'rewrite_original_bond_amount'	=> $this->get_value( $p, 'rewrite_original_bond_amount' )		
						
			);

			$defendant_info = array(
				'trans_id' 			=> $this->get_value( $p, 'trans_id' ),
				'pek'				=> $this->get_value( $p, 'pek' ),
				'prefix_id'			=> $this->get_value( $p, 'prefix_id' ),
				'first_name'		=> $defendant[ 'first_name' ],
				'last_name'			=> $defendant[ 'last_name' ],
				'email'				=> $this->get_value( $defendant[ 'data' ], 'defendant_email' ),
				'ssn'				=> $this->get_value( $defendant[ 'data' ], 'defendant_social_security_number' ),
				'dob'				=> $this->get_value( $defendant[ 'data' ], 'defendant_dob' ),
				'address'			=> $this->get_value( $defendant[ 'data' ], 'defendant_address' ),
				'city'				=> $this->get_value( $defendant[ 'data' ], 'defendant_city' ),
				'state'				=> $this->get_value( $defendant[ 'data' ], 'defendant_state' ),
				'zip'				=> $this->get_value( $defendant[ 'data' ], 'defendant_zip' ),
				'phone'				=> $this->get_value( $defendant[ 'data' ], 'defendant_phone' ),
				'dl'				=> $this->get_value( $defendant[ 'data' ], 'defendant_dl' ),
				'power_id'			=> $this->get_value( $p, 'power_id' )
			);
			
			$indemnitor = array(
				'trans_id' 			=> $this->get_value( $p, 'trans_id' ),
				'pek'				=> $this->get_value( $p, 'pek' ),
				'prefix_id'			=> $this->get_value( $p, 'prefix_id' ),
				'first_name'		=> $this->get_value( $defendant[ 'data' ], 'indemnitor_first_name' ),
				'last_name'			=> $this->get_value( $defendant[ 'data' ], 'indemnitor_last_name' ),
				'email'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_email' ),
				'ssn'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_social_security_number' ),
				'dob'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_dob' ),
				'address'			=> $this->get_value( $defendant[ 'data' ], 'indemnitor_address' ),
				'city'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_city' ),
				'state'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_state' ),
				'zip'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_zip' ),
				'phone'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_phone' ),
				'dl'				=> $this->get_value( $defendant[ 'data' ], 'indemnitor_dl' ),
				'power_id'			=> $this->get_value( $p, 'power_id' )
			);
			
			$collateral = array(
				'trans_id' 			=> $this->get_value( $p, 'trans_id' ),
				'pek'				=> $this->get_value( $p, 'pek' ),
				'prefix_id'			=> $this->get_value( $p, 'prefix_id' ),
				'type'				=> $this->get_value( $defendant[ 'data' ], 'collateral_type' ),
				'owner'				=> $this->get_value( $defendant[ 'data' ], 'collateral_owner' ),
				'amount'			=> $this->get_value( $defendant[ 'data' ], 'collateral_amount' ),
				'desc'				=> $this->get_value( $defendant[ 'data' ], 'collateral_description' ),
				'power_id'			=> $this->get_value( $p, 'power_id' )
			);
			
			$this->move_image();

			//update the sent electronically
			$d = array(
				'sent_electronically' 	=> 1,
				'status_id'				=> $this->ps->get_power_status_id( $p[ 'power_status' ] )->power_status_id,
				'jail_id'				=> $this->session->userdata( 'jail_id' ),
				'photo'					=> $this->session->userdata( 'security_image' )
			);
			
			$where = array(
				'power_id'			=> $this->get_value( $p, 'power_id' )
			);				
			
			
			$power_ids[] = $this->get_power_id( $where );
			$log = 'Power executed as a online transmitted power';		
			
						
			$this->db->trans_start();
				//insert the info
				$this->db->insert( 'power_details' , $power_details );			
				$this->db->insert( 'power_details_defendant' , $defendant_info );			
				$this->db->insert( 'power_details_indemnitor' , $indemnitor );			
				$this->db->insert( 'power_details_collateral' , $collateral );			
				$this->db->update( 'power', $d, $where );			
				$this->add_power_history( $log, $this->get_value( $p, 'power_id' ) );
			$this->db->trans_complete();
			
		}


		return $power_ids;
	}






	public function get_power_id( array $a )
	{
		return $this->db->select( 'power_id' )->get_where( 'power', $a )->row()->power_id;	
	}


/*START SEND NOTIFICATIONS*/

	public function send_notifications( $mek, $photo )
	{
		$d 			= $this->sfa();
		$jail 		= $this->j->get_jails( $this->session->userdata( 'jail_id' ) );
		$bail		= $this->b->get_agents( $mek );
		$batch 		= $this->get_saved_power();		
		$powers 	= $this->parse_saved_powers( $batch[ 'powers' ] );
		$defendant 	= $this->parse_saved_defendant( $batch[ 'defendant' ] );


		$data = array(
			'jail_name' 		=> $jail->jail_name,	
			'jail_full_name'	=> $jail->full_name,		
			'jail_email'		=> $jail->email,
			'bail_name'			=> $bail->full_name,
			'bail_email'		=> $bail->email,
			'agency_name'		=> $bail->agency_name,
			'defendant_name'	=> $defendant[ 'first_name' ] . ' ' . $defendant[ 'last_name' ],
			'photo'				=> $photo
		);


		$this->em->notify_jail_executed_powers( $data );	
		$this->session->unset_userdata( 'batch_id' );
		$this->session->unset_userdata( 'security_image' );
		$this->session->unset_userdata( 'jail_id' );
		return true;
	}


/*END SEND NOTIFICATIONS*/



	public function void_power( array $args = NULL )
	{
		$d 			= $this->sfa();
		$power_id 	= $d[ 'power_id' ];
		$log 		= 'Power status set to void';
		
		if( isset( $args[ 'power_id' ] ) ) $power_id = $args[ 'power_id' ];
		
		$this->add_power_history( $log, $power_id );
		$this->set_power_status( 'voided', $power_id );


		$this->db->trans_start();			
			$this->db->update( 'power_details', array( 'voided_date' => $this->now() ), array( 'power_id' => $power_id ) );
		$this->db->trans_complete();
		
		return true;
		
	}
	
	
	public function discharge_power()
	{
		$d 			= $this->sfa();
		$power_id 	= $d[ 'power_id' ];
		$log = 'Power status set to discharged';
		
		$this->add_power_history( $log, $power_id );
		$this->set_power_status( 'discharged', $power_id );

		$this->db->trans_start();			
			$this->db->update( 'power_details', array( 'discharge_date' => $this->now() ), array( 'power_id' => $power_id ) );
		$this->db->trans_complete();
		
		return true;
		
	}
	
	public function get_power_history( $power_id )
	{
		$sql = "
			SELECT log, DATE_FORMAT( date, '%c/%d/%Y' ) as date
			FROM power_history
			WHERE power_id =	" . $this->db->escape( $power_id );
		
		
		$q = $this->db->query( $sql );
		
		return $q->result_array();
		
	}
	
	
	public function add_power_history( $log, $power_id )
	{
		$this->db->insert( 'power_history', array( 'mek' => $this->session->userdata( 'mek' ), 'power_id' => $power_id, 'log' => $log, 'date' => $this->now() ) );
		return true;
	}

	public function set_power_status( $key, $power_id )
	{
		$status_id = $this->db->select( 'power_status_id' )->from( 'power_status' )->where( array( 'key' => $key ) )->get()->row()->power_status_id;	
		$this->db->trans_start();			
			$this->db->update( 'power' , array( 'status_id' => $status_id ), array( 'power_id' => $power_id ) );					
		$this->db->trans_complete();
		
		return true;	
		
	}


//OLD INFO



/*START BATCHING METHODS*/

	public function update_batch( $trans_id, $pek )
	{
		$batch = $this->session->userdata( 'batch' );
		
		if( ! $batch  ) $batch = array();
		
		$batch[] = $pek;
		
		$this->session->set_userdata( 'batch' , array_unique( $batch ) );	
		
		
		return true;			
	}
	
	
	
	
	public function add_to_batch( $trans_id, $pek )
	{
		$batch =  $this->session->userdata( 'batch' );
		
		//if( ! $batch ) return false;
	
		$this->update_batch( $trans_id, $pek );
		
		return true;		
	}



/*END BATCHING METHODS*/


/*START PROCESS SECURITY IMAGES*/

	public function move_image()
	{
		$photo = $this->session->userdata( 'security_image' );
		$path = './photo/';
		$write_path	= './uploads/images/';
		//get file


		$f = read_file( $path . $photo );

		//if file found
		if( $f )
		{
			$fp = fopen( $write_path . $photo, 'w');
			fwrite($fp, $f);
			fclose($fp);
			unlink( $path . $photo );
		}
		return true;		
	}

	
	//ARGS photo, pek
	public function add_identity_photo( array $args )
	{
		
		$data = array(
			'photo' => $args['photo']['file_name']
		);	
		
		$this->db->trans_start();
			$this->db->update( 'power', $data, array( 'pek' => $args[ 'pek' ] ) );	
		$this->db->trans_complete();
		
		return true;
	}

/*END PROCESS SECURITY IMAGES*/



	
	
/*START CRUD METHODS*/	


	
	public function save_powers( $photo = NULL )
	{
		$d 				= $this->sfa();
		$batch 			= $this->session->userdata( 'batch' );
		$jail 			= $this->j->get_jails( $d[ 'jail_name' ] );
		$log 			= 'Power executed, sent to ' . $jail->jail_name;		
		$saved_powers 	= $this->get_saved_power();
		
		
		//get the power status id
		$ps 	= $this->db->select( 'power_status_id' )->from( 'power_status' )->where( array( 'key' => 'executed' ) )->get()->row();
		
		
		
		foreach( $batch as $b )
		{
			$data = array(
				'jail_id' 	=> $d[ 'jail_name' ],
				'status_id' => $ps->power_status_id,
				'photo' 	=> $photo
			);
			
			$this->db->trans_start();
			
				$this->add_power_history( $log, $b, $saved_powers[0]['prefix_id'] );
				$this->db->update( 'power' , $data, array( 'pek' => $b, 'prefix_id' => $saved_powers[0]['prefix_id'] ) );	
				
			$this->db->trans_complete();
		} 
		
		$this->move_image();	

		foreach( $saved_powers as $sp )
		{
			$this->db->trans_start();
				$this->db->insert( 'power_details', array( 'pek' => $sp[ 'pek' ], 'prefix_id' => $sp['prefix_id'], 'data' => $sp[ 'data' ] ) );		
			$this->db->trans_complete();
		}

		return true;	
	}

	
	public function save_step_one()
	{
		$d = $this->sfa();
			
		$power 		= $d;
		
		unset( $power['defendant_fname' ], $power['defendant_lname' ], $power['ip'] );
		
		$defendant 	= array(
			'first_name' 	=> $d[ 'defendant_fname'],
			'last_name' 	=> $d[ 'defendant_lname']
		);
		
		
		
		
		$POWER = array(
			'power'		 	=> $power,
			'defendant' 	=> $defendant
		);
		
		if( ! $this->session->userdata( 'defendant' )  ) $this->session->set_userdata( 'defendant' , $d[ 'defendant_fname' ] . ' ' . $d[ 'defendant_lname' ] ); 
		if( ! $this->session->userdata( 'executing_agent' ) ) $this->session->set_userdata( 'executing_agent', $d[ 'executing_agent'] );
		
		$serialize = json_encode( $POWER );
		
		$this->db->select( 'pek' )->from('saved_powers')->where( array( 'pek' => $d['pek'], 'prefix_id' => $d['prefix_id'] ) );
		
		$q = $this->db->get();
		
		$data = array(
			'pek' 		=> $d['pek'],
			'prefix_id'	=> $d['prefix_id'],
			'data'		=> $serialize
		);
		
		if( $q->num_rows() == 0 ) $this->db->insert( 'saved_powers', $data );
		else $this->db->update( 'saved_powers', $data, array( 'pek' => $d[ 'pek'], 'prefix_id' => $d[ 'prefix_id' ] ) ); 		
		
		return true;
	}
	
	
	public function save_step_two()
	{
		$d = $this->sfa();
		$defendant 	= $this->strip_form( $d, 'defendant' );
		$indemnitor = $this->strip_form( $d, 'indemnitor' );
		$collateral = $this->strip_form( $d, 'collateral' );
		
		
		
		$temp = $this->convert_json( $this->get_saved_power( $d[ 'pek' ] ) );
		 		 
		$POWER = $temp[0];		
		
		$POWER->defendant 	= ( object ) $defendant;
		$POWER->indemnitor 	= ( object ) $indemnitor;
		$POWER->collateral 	= ( object ) $collateral;
		
 		$data = array(
			'data' => json_encode( $POWER )		
		);
		
		
		$this->db->update( 'saved_powers', $data, array( 'pek' => $d[ 'pek' ], 'prefix_id' => $d[ 'prefix_id'] ) );
		$this->session->set_userdata( 'defendant', $d[ 'defendant_first_name' ] . ' ' . $d[ 'defendant_last_name' ] );
		
		return true;
	}
	
	/*

	
	public function get_saved_power( $pek = NULL, $one = false )
	{
		$batch = $this->session->userdata( 'batch' );
		

		//if( $batch ) $where = $batch;
	
		$this->db->select( 'data, pek, prefix_id' )->from( 'saved_powers' );
		
		if( ! $one && $batch ) $this->db->where_in( 'pek', $batch );
		
		else $this->db->where( array( 'pek' => $pek ) ); 
		
		$q = $this->db->get();
		
		$q = $q->result_array();
		return $q;	
		
		
	}
	*/
	
	
	public function get_power_detail( $pek )
	{
		return $this->db->select( 'data' )->from( 'power_details' )->where( array( 'pek' => $pek ) )->get()->row();	
	}
	


	public function get_power_status_query( $key )
	{
		return $this->db->select( 'power_status_id' )->from( 'power_status' )
						->where( array( 'key' => $key ) )->get()->row();
		
	}
	
	
	public function get_power_status()
	{
		$ret = array('' => 'Select Power Status' );
		$sql = '
			SELECT * FROM power_status
		';	
		$q = $this->db->query( $sql );
		$q = $q->result_array();
		
		$hide = array( 'inventory', 'voided' );
		
		foreach( $q as $val ) if( ! in_array( $val['key'], $hide ) ) $ret[ $val[ 'key' ] ] = $val[ 'status' ];
		
		return $ret;
		
	}


	public function delete_saved_power( $trans_id, $power_id )
	{
		$this->session->unset_userdata( 'batch_id' );
		$this->session->unset_userdata( 'security_image' );
		$this->session->unset_userdata( 'jail_id' );
		
		return true;
			
	}
	

	public function get_sub_powers( array $args )
	{
		
		$sql = "
			SELECT ps.status, p.pek, DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp_date,
			t.transmission_id, concat( pp.prefix, ' ', pp.amount ) as prefix, pp.amount,
			ps.status, ps.key, p.prefix_id

			FROM power AS p
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN power_sub_agent_join AS psaj
				ON psaj.power_id = p.power_id	
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id	
							
			WHERE 1 = 1
			AND psaj.active = 1
		";

		$sql .= ' AND psaj.mek = ' . $this->db->escape( $args[ 'mek' ] );
		
		if( isset( $args['type'] ) ) $sql .= ' AND ps.key = ' . $this->db->escape( $args['type'] );
		
		
		if( isset( $args[ 'pek' ] ) )
		{
			 $sql .= ' AND psaj.pek = ' . $this->db->escape( $args[ 'pek' ] );
			return $this->db->query( $sql )->row();					
		}
		else
		{
			return $this->db->query( $sql )->result_array();	
		}
		
	}
	
	
	/*
	
	
	*/
	
	public function get_power_before_execute( $power_id )
	{

		$sql = '
			SELECT DISTINCT
				p.power_id, p.pek, DATE_FORMAT( p.exp_date, "%c/%m/%Y" ) as exp_date, 
				case p.transferred_sub
					when 1 then "yes"
					when 0 then "no"
					else "no"
				end  as transferred_sub,	
				pp.prefix, pp.amount, concat( pp.prefix , " " , pp.amount ) as full_prefix,
				ps.status, ps.key, p.prefix_id, t.transmission_id, ba.license_number
			
			FROM power AS p
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id	
			INNER JOIN bail_agent AS ba
				ON	ba.mek = t.bail_agent_id
			INNER JOIN member AS m
				ON m.mek = t.bail_agent_id
			WHERE 1 = 1 and p.power_id = ?
		';	
		
		return $this->db->query( $sql, array( $power_id ) )->row_array();
		
	}
	
	public function get_power( array $a )
	{
		$sql = '
			SELECT DISTINCT
				psaj.mek as sub_mek, p.power_id, p.pek, DATE_FORMAT( p.exp_date, "%c/%m/%Y" ) as exp_date, 
				case p.transferred_sub
					when 1 then "yes"
					when 0 then "no"
					else "no"
				end  as transferred_sub,	
				p.photo,				
				pp.prefix, pp.amount, concat( pp.prefix , " " , pp.amount ) as full_prefix,
				ps.status, ps.key, p.prefix_id, t.transmission_id,  ps.key as power_status,
				pd.power_amount, pd.bond_amount, pd.court_date, pd.court_time, pd.court, pd.county, pd.case_number, pd.city as power_city, pd.execution_date,
				pd.charge, pd.city, pd.state, pd.executing_agent, pd.state as power_state,
				pdd.first_name AS defendant_first_name, pdd.last_name AS defendant_last_name,
				ba.license_number, m.first_name as agent_first_name, m.last_name as agent_last_name, m.company as agency_name,
				 baa.address, baa.city, baa.state, baa.zip, ia.agency_name as ins_name, ps.key
			
			FROM power AS p
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id	
			LEFT JOIN power_details_defendant AS pdd
				ON pdd.power_id = p.power_id
			INNER JOIN bail_agent AS ba
				ON	ba.mek = t.bail_agent_id
			INNER JOIN member AS m
				ON m.mek = t.bail_agent_id
			LEFT JOIN power_details AS pd
				ON pd.power_id = p.power_id	
			INNER JOIN bail_agency_agent_join AS baaj
				ON 	baaj.bail_agent_id = m.mek
			INNER JOIN bail_agency AS baa
				ON baa.bail_agency_id = baaj.bail_agency_id	
			INNER JOIN insurance_agency as ia
				ON ia.insurance_agency_id = t.insurance_company_id			
			
			LEFT JOIN power_sub_agent_join as psaj
				ON psaj.power_id = p.power_id 
				
			WHERE 1 = 1  
		';	
		
		if( isset( $a[ 'role' ] ) && $a[ 'role' ] == 'sub_agent' ) $sql .= ' and psaj.recouped_date is NULL';
		
		if( isset( $a[ 'power_id' ] ) ) $sql .= ' AND p.power_id = ' . $this->db->escape( $a[ 'power_id' ] );
		
		if( isset( $a[ 'power_id' ] ) ) $sql .= ' LIMIT 1 ';
		
		if( isset( $a[ 'power_id' ] ) ) return $this->db->query( $sql )->row_array();
			 
		return $this->db->query( $sql )->result_array(); 	
		
		
	}


	
	public function get_all_powers( array $a = NULL )
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
				
		";
		
		
		$sql .= ' WHERE 1 = 1';
		
		if( isset( $a[ 'key' ] ) ) $sql .= ' AND ps.key = ' . $this->db->escape( $a[ 'key' ] );
		if( isset( $a[ 'mek' ] ) ) $sql .= ' AND t.bail_agent_id = ' . $this->db->escape( $a[ 'mek' ] );
		if( isset( $a[ 'paid' ] ) && $a[ 'paid' ] == 'paid' ) $sql .= ' AND t.paid = 1';

		if( $a[ 'role' ] == 'sub_agent' )
		{
			$sql = "
				SELECT
					p.power_id, p.pek, DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp_date,
					DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp, p.photo,				
					pp.prefix, pp.amount, concat( pp.prefix , ' ' , pp.amount ) as full_prefix,
					ps.status, ps.key, p.prefix_id, t.transmission_id
				FROM power_sub_agent_join AS psj
				INNER JOIN power AS p
					ON p.power_id = psj.power_id
				INNER JOIN transmission AS t
					ON t.transmission_id = p.transmission_id
				INNER JOIN power_status AS ps
					ON ps.power_status_id = p.status_id
				INNER JOIN power_prefix AS pp
					ON pp.prefix_id = p.prefix_id	
				
				WHERE 1 = 1 AND paid = 1 			
			
			
			";	

			if( isset( $a[ 'key' ] ) ) $sql .= ' AND ps.key = ' . $this->db->escape( $a[ 'key' ] );
			if( isset( $a[ 'mek' ] ) ) $sql .= ' AND psj.mek = ' . $this->db->escape( $a[ 'mek' ] );
			if( isset( $a[ 'paid' ] ) && $a[ 'paid' ] == 'paid' ) $sql .= ' AND t.paid = 1';
			

		}
		else
		{
			$sql .= ' AND p.transferred_sub = 0';
		}

		
		
		return $this->db->query( $sql )->result_array();
		
	}
	
	
	
	public function get_powers( $trans_id = NULL, $power_id = NULL, $type = NULL )
	{
		$sql = "
			SELECT
				p.power_id, p.pek, DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp_date,
				DATE_FORMAT( p.exp_date, '%c/%m/%Y' ) as exp, p.photo,
				
				pp.prefix, pp.amount, concat( pp.prefix , ' ' , pp.amount ) as full_prefix,
				
				ps.status, ps.key, p.prefix_id
				
			FROM power AS p
			
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id
		";
		
		$sql .= 'WHERE 1 = 1 ';
		
		
		if( isset( $trans_id ) ) $sql .= ' AND p.transmission_id = ' . $this->db->escape( $trans_id );
		
		if( isset( $power_id ) ) $sql .= ' AND power_id = ' . $this->db->escape( $power_id );
		
		if( isset( $type ) ) $sql .= ' AND ps.key = ' . $this->db->escape( $type );
		
		$sql .= ' ORDER BY p.prefix_id, p.pek,  p.status_id';
		
		
		$q = $this->db->query( $sql );
		
		if( $q->num_rows() == 1 && $type == NULL) return $q->row();
		
		return $q->result_array();
	}

	
	public function get_transmission_by_power_id( $power_id )
	{
		$sql = "
			SELECT
				t.*
				FROM power AS p			
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id	
			WHERE 1 = 1
		";	
		
		$sql .= ' AND p.power_id = ' . $this->db->escape( $power_id );	
	
	
		return $this->db->query( $sql )->row();
		
		
	}
/*END CRUD METHODS*/
	
	
	
	
	
/*sTART UTILITY METHODS*/
	
	public function convert_json( $array )
	{
		$a = array();
		

		foreach( $array as $val ) $a[] = json_decode( $val[ 'data' ] );
		
		return $a;
 		
	}	
	
	private function strip_form( $array, $prepend_name )
	{
		$t = array();	
		
		foreach( $array as $key => $val )
		{
			
			$x = explode( '_', $key, 2  );	
			if( $x[0] == $prepend_name ) $t[ $x[1] ] = $val;		
		}
		
		return $t;
	}

/*END UTILITY METHODS*/



/*START VALIDATION METHODS*/
	
	public function validate_void_frm()
	{

		$this->sfa();
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('void_date', 'Void Date', 'required|trim');		
		return $this->form_validation->run();
		
		
	}
	
	
	public function validate_discharge_frm()
	{

		$this->sfa();
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('discharge_date', 'Discharge Date', 'required|trim');		
		return $this->form_validation->run();
		
		
	}
	
	
	public function validate_execution_power()
	{

		$this->sfa();
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('jail_name', 'Jail', 'required|trim');		
		$this->load->model( 'jail/jail_crud_model' , 'j' );
		$this->load->model( 'agent/crud_model' , 'b' );
		return $this->form_validation->run();
		
		
	}
	
	public function validate_step_two()
	{
		$d = $this->sfa();
		
		return true;		
	}
	
	public function validate_step_one()
	{
		$d = $this->sfa();
		
		$num = $d['power_amount'];
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('power_status', 'Power Status', 'required|trim');		
		$this->form_validation->set_rules('bond_amount', 'Bond Amount', 'required|less_than[' . ( $num + 1 ) . ']|number|trim');		
		$this->form_validation->set_rules('court', 'Court', 'required|trim');
		$this->form_validation->set_rules('county', 'County', 'required|trim');
		$this->form_validation->set_rules('case_number', 'Case Number', 'required|trim');
		
		if( ! isset( $d[ 'has_defendant' ] ) )
		{
			$this->form_validation->set_rules('defendant_fname', 'Defendant First Name', 'required|trim');
			$this->form_validation->set_rules('defendant_lname', 'Defendant Last Name', 'required|trim');
			$this->form_validation->set_rules('executing_agent', 'Executing Agent', 'required|trim');				
		}
	
	
		$this->form_validation->set_message('less_than', 'The bond amount must be less than the power amount: $' . $d['power_amount']);
		return $this->form_validation->run();
		
	}
	
	
/*END VALIDATION METHODS */



/*START NEED TO BE MOVED METHODS*/
	
	
	
	
	





/*END NEED TO BE MOVED METHODS*/


}