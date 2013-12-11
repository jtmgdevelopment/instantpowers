<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class agents_report_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model( 'insurance/insurance_crud_model', 'i' );
		$this->load->model( 'premium/premium_crud_model', 'premium' );
		$this->load->model( 'agent/crud_model', 'a' );
	}





	public function transmitting_type( array $a )
	{
		$sql = '
			SELECT COUNT( insurance_agent_id ) as count
			FROM insurance_agent as i
			WHERE 1 = 1
			AND i.mek = ' . $this->db->escape( $a[ 'ins_id' ] );
		
		$q = $this->db->query( $sql )->row_array();
		if( $q[ 'count' ] > 0 ) return 'ins';
		
		$sql = '
			SELECT COUNT( mga_id ) as count
			FROM mgas as m
			WHERE 1 = 1
			AND m.mek = ' . $this->db->escape( $a[ 'ins_id' ] );
		
		$q = $this->db->query( $sql )->row_array();
		
		if( $q[ 'count' ]  > 0 ) return 'mga';
		
		
		return 'ins';
	}


	public function view_report_totals_by_date( array $a )
	{
		$sql = '
			SELECT SUM( pd.power_amount ) as premium_total
			FROM power AS p
			INNER JOIN power_details AS pd
			ON pd.power_id = p.power_id
			INNER JOIN master_agent_report_data AS mard
			ON mard.power_id = p.power_id
			WHERE mard.mek = ? and mard.ins_id = ?	and mard.timestamp between ? and ?	
		';	
			
		
		$premium_total 	= $this->db->query( $sql, array( $a[ 'mek' ], $a[ 'ins_id' ], $this->mysql_date_format( $a[ 'start_date' ] ), $this->mysql_date_format( $a[ 'end_date' ] ) ) )->row();		
		$premium_total	= $premium_total->premium_total;
		$premium 		= $this->premium->get_premiums( array( 'mek' => $a['mek' ] , 'insurance_agency_id' => $a[ 'ins_id' ] ) );
		
		$company 		= $premium_total * ( $premium[ 0 ][ 'premium' ]/100 );
		$buf			= $company * ( $premium[ 0 ][ 'buf' ]/100 );
		
		return array(
			'premium_total' => number_format( $premium_total, 2, '.', ',' ),
			'company'		=> number_format( $company, 2, '.', ',' ),
			'buf'			=> number_format( $buf, 2, '.', ',' )
		);
						
	}







	public function list_archived_mar_reports( array $a = NULL )
	{
		$sql = "
			SELECT mar.transaction_id, t.amount,
			
			case 
			when mar.online_payment IS TRUE then 'Online Payment'
			else 'Offline Payment' end as payment_type,
			
			DATE_FORMAT( mar.date_created, '%c/%e/%Y %r' ) AS date_created, bac.bail_agency_id, bac.agency_name, m.full_name, 
			
			case 
			when mar.ins_id IS NULL then mar.mga_id
			ELSE mar.ins_id 
			end as ins_id,
			
			 mar.mek, mar.report_id
			FROM master_agent_report AS mar
			INNER JOIN member as m
				ON m.mek = mar.mek
			INNER JOIN bail_agent AS ba 
				ON ba.mek = m.mek
			INNER JOIN bail_agency_agent_join baaj 
				ON baaj.bail_agent_id = m.mek
			INNER JOIN bail_agency bac 
				ON bac.bail_agency_id = baaj.bail_agency_id		
				
			left join transactions as t on t.trans_id = mar.transaction_id	
			
			WHERE 1 = 1
		";
		
		
		if( ! isset( $a[ 'show_all' ] ) ) $sql .= ' AND date_created > DATE(CURDATE()- INTERVAL DAYOFYEAR(CURDATE()) DAY)';

				
				
		if( isset( $a[ 'ins_id' ] ) && $a[ 'transmitting_type' ] == 'ins' && ! isset( $a[ 'company_id' ] ) )
		{
			if( is_numeric( $a[ 'ins_id' ] ) ){
				$sql .= ' AND  mar.ins_id = ' . $this->db->escape( $a[ 'ins_id' ] );	
				
			}
			else{
				$sql .=  ' AND  Mar.Ins_id = ( select insurance_agency_id from insurance_agency_agent_join where insurance_agent_id = ' .  $this->db->escape( $a[ 'ins_id' ] ) .  ')';
				
			}

		} 
		else if( isset( $a[ 'ins_id' ] ) && $a[ 'transmitting_type' ] == 'ins' && ! isset( $a[ 'company_id' ] ) )
		{
			$sql .= ' AND  ( mar.ins_id = ' . $this->db->escape( $a[ 'ins_id' ] ) . ' OR mar.ins_id = ' . $this->db->escape( $a[ 'company_id' ] );	
			
		}
		
		if( isset( $a[ 'ins_id' ] ) && $a[ 'transmitting_type' ] == 'mga' ) $sql .= ' AND mar.mga_id = ' . $this->db->escape( $a[ 'ins_id' ] );
		if( isset( $a[ 'mek' ] ) ) $sql .= ' AND mar.mek = ' . $this->db->escape( $a[ 'mek' ] );
				
		$sql .= ' ORDER BY mar.date_created';
		
		return $this->db->query( $sql )->result_array();	
	}



	public function validate_ins_choose_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');			
		$this->form_validation->set_rules('ins_company', 'Insurance Company', 'required|trim');		
		return $this->form_validation->run();
			
	}

	public function create_report_record( array $a = NULL )
	{
		
		
		if( ! isset( $a[ 'trans_id' ] ) ) 			$a[ 'trans_id' ] 		= NULL;
		if( ! isset( $a[ 'offline_payment' ] ) ) 	$a[ 'offline_payment' ] = true;
		if( ! isset( $a[ 'online_payment' ] ) ) 	$a[ 'online_payment' ] 	= false;
		
		$this->db->trans_start();
			
			$d = array( 'transaction_id' => $a[ 'trans_id' ], 'mek' => $a[ 'mek' ], 'ins_id' => $a[ 'ins_id' ], 'date_created' => $this->now() );
			
			if( $a[ 'is_mga' ] == 'MGA' ) 
			{
				$d[ 'mga_id' ] = $d[ 'ins_id' ];
				unset( $d[ 'ins_id' ] );
			}
			
			if( $a[ 'online_payment' ] ) $d[ 'online_payment' ] = true;
			else if( $a[ 'offline_payment' ] ) $d[ 'offline_payment' ] = false;
			
			$this->db->insert( 'master_agent_report', $d );
			$report_id = $this->db->insert_id();

		$this->db->trans_complete();			
		
		$params = array( 
			'ins_company_id' 	=> $a[ 'ins_id' ], 
			'mek' 				=> $a[ 'mek' ],
			'premium' 			=> $a[ 'premium' ],
			'buf'				=> $a[ 'buf' ]
		);

		if( $a[ 'is_mga' ] == 'MGA' ) 
		{
			$params[ 'mga_id' ] = $params[ 'ins_company_id' ];
			unset( $params[ 'ins_company_id' ] );
		}

		
		if( $a[ 'role' ] == 'sub_agent' )
		{
			$params[ 'sub_agent' ] = true;	
		}

		
		$report = $this->get_powers_for_master_report( $params );
		
		
		foreach( $report as $r )
		{
			$temp = array(
				'report_id' => $report_id,
				'power_id'	=> $r[ 'power_id' ],
				'ins_id'	=> $a[ 'ins_id' ],
				'mek'		=> $a[ 'mek' ]
			);	
			

			if( $a[ 'is_mga' ] == 'MGA' ) 
			{
				$temp[ 'mga_id' ] = $temp[ 'ins_id' ];
				unset( $temp[ 'ins_id' ] );
			}
			
			
			$this->db->trans_start();
				$this->db->insert( 'master_agent_report_data', $temp );
			$this->db->trans_complete();			
			
			$where = array(
				'power_id'	=> $r[ 'power_id' ]
			);
			$update = array(
				'is_reported' => 1
			);
			
			

			if( $a[ 'role' ] == 'sub_agent' )
			{
				$this->db->trans_start();
					$this->db->update( 'power_sub_agent_join', $update, $where );		
				$this->db->trans_complete();			
			}
			else
			{
				$this->db->trans_start();
					$this->db->update( 'power', $update, $where );		
				$this->db->trans_complete();			
				
			}
						

		}
		
		if( $a[ 'is_mga' ] == 'MGA' )
		{
			
			$this->load->model( 'mga/mga_crud_model', 'mga' );
			$ins = ( object ) $this->mga->get_mga_admins( array( 'mek' => $a[ 'ins_id' ] ) );
		}
		else
		{
			$ins = $this->i->get_insurance_agent( array( 'ins_id' => $a[ 'ins_id' ] ) );
		}
		
		if( $a[ 'role' ] == 'sub_agent' )
		{
			$master_id 		= $this->a->get_sub_agent_master( array( 'sub_mek' => $a[ 'mek' ] ) );
			$master_agent 	= $this->a->get_master_agent( array( 'mek' => $master_id->master_id ) );
			$sub_agent		= $this->a->get_sub_agents( array( 'sub_mek' => $a[ 'mek' ] ) );
			
			$d = array(
				'master_email' 	=> $master_agent->email,
				'master_name'	=> $master_agent->full_name,
				'sub_email'		=> $sub_agent->email,
				'sub_name'		=> $sub_agent->full_name 
			
			);
			
			$this->em->notify_master_agent_of_master_report( $d );
		
		}
		else
		{
			$master_agent 	= $this->a->get_master_agent( array( 'mek' => $a[ 'mek' ] ) );

			$d = array(
				'master_email' 	=> $master_agent->email,
				'master_name'	=> $master_agent->full_name,
				'ins_email'		=> $ins->email,
				'ins_name'		=> $ins->full_name 
			
			);
			
			$this->em->notify_ins_of_master_report( $d );
		}
		
		
		return true;
	}
	
	
	public function get_master_report_total( array $a = NULL )
	{
		$totals = array(
			'bond_amount'	=> 0,
			'premium'		=> 0,
			'company'		=> 0,
			'buf'			=> 0
		);
		
		$amount = 0;
		$dont_calculate = array( 'voided', 'transfer', 'rewrite' );
		
		foreach( $a as $r )
		{
			
			if( ! in_array( $r[ 'status' ], $dont_calculate ) )
			{
				$totals[ 'bond_amount' ] 	+=  (float) str_replace( ',', '', $r[ 'amount' ] );
				$totals[ 'premium' ] 		+=  (float) str_replace( ',', '', $r[ 'premium' ] );
				$totals[ 'buf' ] 			+=  (float) str_replace( ',', '', $r[ 'buf' ] );
				$totals[ 'company' ] 		+=  (float) str_replace( ',', '', $r[ 'company' ] );
				
			}
			else
			{
				$totals[ 'bond_amount' ] 	+=  (float) str_replace( ',', '', $r[ 'amount' ] );
				$totals[ 'premium' ] 		+=  0.00;
				$totals[ 'buf' ] 			+=  0.00;
				$totals[ 'company' ] 		+=  0.00;
			}	
			
		}
		
			$totals[ 'bond_amount' ] 	=  number_format( $totals[ 'bond_amount' ], 2, '.', ',' );
			$totals[ 'premium' ] 		=  number_format( $totals[ 'premium' ], 2, '.', ',' );
			$totals[ 'buf' ] 			=  number_format( $totals[ 'buf' ], 2, '.', ',' );
			$totals[ 'company' ] 		=  number_format( $totals[ 'company' ], 2, '.', ',' );
			$totals[ 'total_powers'] 	= count( $a );
			
		return  $totals;
	}
	
	public function get_grouped_powers_for_master_report( array $a = NULL, $mek = NULL, $agent_type = NULL )
	{
	
		$sql = '		
			SELECT distinct pp.prefix_id, pp.prefix, pp.amount, count( * ) as grouping
			FROM power AS p
			LEFT JOIN power_details AS pd
			ON pd.power_id = p.power_id			
			INNER JOIN power_prefix AS pp
			ON pp.prefix_id = p.prefix_id	
			INNER JOIN power_status AS ps
			ON ps.power_status_id = p.status_id				
			INNER JOIN transmissiON AS t
			ON t.transmission_id = p.transmission_id
			LEFT JOIN insurance_agency_agent_join AS iaaj
			ON t.insurance_agent_id = iaaj.insurance_agent_id
			LEFT JOIN mgas as mga ON mga.mek = t.mga_id
			INNER JOIN bail_agency_agent_join AS baaj
			ON baaj.bail_agent_id = t.bail_agent_id
			INNER JOIN bail_agency AS ba
			ON ba.bail_agency_id = baaj.bail_agency_id
		';	
	
		if( $agent_type == 'sub_agent' )
		{
			$sql .= '
				INNER JOIN power_sub_agent_join AS psaj
				ON psaj.power_id = p.power_id
			';	
			
		}
	
		$sql .= ' WHERE 1=1 AND ps.key != "inventory"';
		
		if( ! isset( $a[ 'report' ] ) && $agent_type != 'sub_agent' ) $sql .= ' AND p.is_reported = 0';
		
		if( isset( $a[ 'ins_company_id' ] ) ) $sql .= ' AND ( iaaj.insurance_agency_id = ' . $this->db->escape( $a[ 'ins_company_id'] ) . ' OR iaaj.insurance_agent_id = ' . $this->db->escape( $a[ 'ins_company_id'] ) . ')';
		if( isset( $a[ 'mga_id' ] ) ) $sql .= ' AND t.mga_id = ' . $this->db->escape( $a[ 'mga_id'] );
		if( isset( $a[ 'mek' ] ) && $agent_type != 'sub_agent' ) $sql .= ' AND t.bail_agent_id = ' . $this->db->escape( $mek );
		if( isset( $a[ 'agency_id' ] ) ) $sql .= ' AND ba.bail_agency_id = ' . $this->db->escape( $a[ 'agency_id' ] );	


		if( $agent_type == 'sub_agent' ) $sql .= ' AND psaj.mek = ' . $this->db->escape( $mek );
		if( $agent_type == 'sub_agent' ) $sql .= ' AND psaj.is_reported = 0';
		if( $agent_type == 'sub_agent' ) $sql .= ' AND p.transferred_sub = 1';
		if( $agent_type == 'sub_agent' ) $sql .= ' and psaj.recouped_date is NULL';
		
		
		if( isset( $a[ 'archived' ] ) )
		{
			$sql = '
				SELECT distinct mard.power_id, pp.prefix_id, pp.prefix, pp.amount, count( * ) as grouping
				FROM power AS p
				INNER JOIN master_agent_report_data as mard
				on mard.power_id = p.power_id
				LEFT JOIN power_details AS pd
					ON pd.power_id = p.power_id			
				INNER JOIN power_prefix AS pp
					ON pp.prefix_id = p.prefix_id	
				INNER JOIN transmissiON AS t
					ON t.transmission_id = p.transmission_id
				INNER JOIN insurance_agency_agent_join AS iaaj
					ON t.insurance_agent_id = iaaj.insurance_agent_id
				WHERE 1 = 1	
			';	
			$sql .= ' AND mard.report_id = ' . $this->db->escape( $a[ 'report_id' ] );		
			
		}
					
		$sql .= ' GROUP BY pp.prefix_id, pp.prefix, pp.amount ORDER BY grouping desc';


		return $this->db->query( $sql )->result_array();		
		
	}
	
	
	public function get_powers_for_master_report( array $a = NULL )
	{
		
		$sql = '		
			SELECT distinct p.power_id, p.pek, pp.prefix, pp.amount, pd.data, p.power_id, p.prefix_id, ps.key, pd.county
			FROM power AS p
			LEFT JOIN power_details AS pd
				ON pd.power_id = p.power_id			
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id	
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id				
			INNER JOIN transmissiON AS t
				ON t.transmission_id = p.transmission_id
			LEFT JOIN insurance_agency_agent_join AS iaaj
				ON t.insurance_agent_id = iaaj.insurance_agent_id
			LEFT JOIN mgas as mga ON mga.mek = t.mga_id
			INNER JOIN bail_agency_agent_join AS baaj
				ON baaj.bail_agent_id = t.bail_agent_id
			INNER JOIN bail_agency AS ba
				ON ba.bail_agency_id = baaj.bail_agency_id
		';
		
		if( isset( $a[ 'sub_agent' ] ) )
		{
			
			$sql .= '
				INNER JOIN power_sub_agent_join AS psaj
				ON psaj.power_id = p.power_id
			';	
		}
		
		$sql .= '		
			WHERE 1 = 1	
			AND ps.key != "inventory"
		';	
		
		if( ! isset( $a[ 'report' ] ) && ! isset( $a[ 'sub_agent' ] ) ) $sql .= ' AND p.is_reported = 0';		
		if( isset( $a[ 'ins_company_id' ] ) ) $sql .= ' AND ( iaaj.insurance_agency_id = ' . $this->db->escape( $a[ 'ins_company_id'] ) . ' OR iaaj.insurance_agent_id = ' . $this->db->escape( $a[ 'ins_company_id'] ) . ')';
		if( isset( $a[ 'mek' ] )  && ! isset( $a[ 'sub_agent' ] ) ) $sql .= ' AND t.bail_agent_id = ' . $this->db->escape( $a[ 'mek' ] );
		if( isset( $a[ 'agency_id' ] ) ) $sql .= ' AND ba.bail_agency_id = ' . $this->db->escape( $a[ 'agency_id' ] );	
		if( isset( $a[ 'mga_id' ] ) ) $sql .= ' AND mga.mek = ' . $this->db->escape( $a[ 'mga_id'] );
		
		
		if( isset( $a[ 'sub_agent' ] ) ) $sql .= ' AND psaj.mek = ' . $this->db->escape( $a[ 'mek' ] );
		if( isset( $a[ 'sub_agent' ] ) ) $sql .= ' AND psaj.is_reported = 0';
		if( isset( $a[ 'sub_agent' ] ) ) $sql .= ' AND p.transferred_sub = 1';
		if( isset( $a[ 'sub_agent' ] ) ) $sql .= ' and psaj.recouped_date is NULL';
		
		

		if( isset( $a[ 'archived' ] ) )
		{
			$sql = '
				SELECT distinct p.power_id, p.pek, pp.prefix, pp.amount, pd.data, p.power_id, p.prefix_id, ps.key, pd.county
				FROM power AS p
				INNER JOIN master_agent_report_data as mard
					on mard.power_id = p.power_id 
				LEFT JOIN power_details AS pd
					ON pd.power_id = p.power_id			
				INNER JOIN power_prefix AS pp
					ON pp.prefix_id = p.prefix_id	
				INNER JOIN power_status AS ps
					ON ps.power_status_id = p.status_id				
				INNER JOIN transmission AS t
					ON t.transmission_id = p.transmission_id
				INNER JOIN insurance_agency_agent_join AS iaaj
					ON t.insurance_agent_id = iaaj.insurance_agent_id
				WHERE 1 = 1	
			';	
			$sql .= ' AND mard.report_id = ' . $this->db->escape( $a[ 'report_id' ] );		
			
		}
			
		$sql .= ' Order by pp.prefix, pp.amount, p.pek';
		
		
		
		$q = $this->db->query( $sql )->result_array();

		$report = array();
		
		$premiums = $a[ 'premium' ];
		
		foreach( $q as $p )
		{
			
			$power	 	= $this->db->select( 'bond_amount, execution_date' )->get_where( 'power_details', array( 'power_id' => $p[ 'power_id' ] ) )->row_array();
			$defendant 	= $this->db->select( 'first_name, last_name' )->get_where( 'power_details_defendant', array( 'power_id' => $p[ 'power_id' ] ) )->row_array();
			
			
			//temp
			if( ! isset( $power[ 'bond_amount' ] ) ) $power[ 'bond_amount' ] = 0.00;
			if( ! isset( $defendant[ 'first_name' ] ) ) $defendant[ 'first_name' ] = '';
			if( ! isset( $defendant[ 'last_name' ] ) ) $defendant[ 'last_name' ] = '';
			if( ! isset( $power[ 'execution_date' ] ) ) $power[ 'execution_date' ] = '';
			
			
			if( $power[ 'bond_amount' ] <= 1000 ) $premium = 100.00;
			else $premium = $power[ 'bond_amount' ] * 0.10;
			
			
			$company 	= $premium * ( ( int ) $a[ 'premium' ]/100 );
			$buf		= $premium * ( ( int ) $a[ 'buf' ]/100 ); 

			
			$sub 			= $premium - $company;
			$master 		= $premium - $sub;
			
			
			$report[] = array(
				'power' 	=> $p[ 'prefix' ] . '-' . $p[ 'pek' ],
				'amount' 	=> number_format( $power[ 'bond_amount' ], 2, '.', ',' ),
				'premium' 	=> number_format( $premium, 2, '.', ',' ),
				'company'	=> number_format( $company, 2, '.', ',' ),
				'buf'		=> number_format(  $buf, 2, '.', ',' ),
				'defendant'	=> $defendant[ 'first_name' ] . ' ' . $defendant[ 'last_name' ],
				'exec_date'	=> $power[ 'execution_date' ],
				'power_id'	=> $p[ 'power_id' ],
				'status'	=> $p[ 'key' ],
				'county'	=> $p[ 'county' ],
				'master'	=> number_format( $master, 2, '.', ',' ),
				'sub'		=> number_format( $sub, 2, '.', ',' )
			);

		}
		
		return $report;	

	}
	

	public function generate_sub_agent_totals( array $a )
	{
		$itemized = array();
		$total_master 	= 0;
		$total_sub		= 0;
		
		
		foreach( $a[ 'report' ] as $r )
		{
			if( $r[ 'status' ] != 'executed' )
			{
				$master = 0.00;
				$sub	= 0.00;
			}
			else
			{
				$premium = str_replace( ',', '', $r[ 'premium' ] );
				$company = str_replace( ',', '', $r[ 'company' ] );


				$sub 			= $premium - $company;
				$master 		= $premium - $sub;
			
			}
			
			$itemized[] = array(
				'power'		=> $r[ 'power' ],
				'amount'	=> $r[ 'amount' ],
				'premium'	=> $r[ 'premium' ],
				'defendant'	=> $r[ 'defendant' ],
				'exec_date'	=> $r[ 'exec_date' ],
				'power_id'	=> $r[ 'power_id' ],
				'status'	=> $r[ 'status' ],
				'master'	=> number_format( $master, 2, '.', ',' ),
				'sub'		=> number_format( $sub, 2, '.', ',' ),
				'buf'		=> $r[ 'buf' ]
			);
			
			$total_master 	+= $master;
			$total_sub 		+= $sub;
		} 
		
		$a[ 'report' ] = $itemized;
		
		$a[ 'totals' ] = array(
			'total_powers'	=> $a['totals']['total_powers'],
			'bond_amount' 	=> $a['totals']['bond_amount'],
			'premium'		=> $a[ 'totals']['premium'],
			'master'		=> number_format( $total_master, 2, '.', ',' ),
			'sub'			=> number_format( $total_sub, 2, '.', ',' ),
			'buf'			=> $a[ 'totals']['buf']
		);
		
		return $a;
	}
	

	
	/*
		METHOD GET_POWER_HISTORY
		ARGS
		* 	
	*/
	
	public function get_power_history( array $args )
	{
		$sql = "
			SELECT DISTINCT 
				p.power_id, p.pek, pp.prefix, pp.amount,pp.prefix_id,
				ps.status, ps.key, pdd.first_name, pdd.last_name
			FROM power AS p 
			INNER JOIN power_prefix AS pp
			  ON pp.prefix_id = p.prefix_id
			INNER JOIN power_status AS ps
			  ON ps.power_status_id = p.status_id
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id			  			  
			LEFT JOIN power_details_defendant AS pdd
				ON pdd.power_id = p.power_id				
			WHERE t.bail_agent_id = ?			  
		";	
		
		if( $args[ 'role' ] == 'sub_agent' )
		{
			
			$sql = "
				SELECT DISTINCT 
					p.power_id, p.pek, pp.prefix, pp.amount,pp.prefix_id,
					ps.status, ps.key, pdd.first_name, pdd.last_name
				FROM power_sub_agent_join AS psj
				INNER JOIN power AS p
					ON p.power_id = psj.power_id
				INNER JOIN power_prefix AS pp
				  ON pp.prefix_id = p.prefix_id
				INNER JOIN power_status AS ps
				  ON ps.power_status_id = p.status_id
				INNER JOIN transmission AS t
					ON t.transmission_id = p.transmission_id		
				LEFT JOIN power_details_defendant AS pdd
					ON pdd.power_id = p.power_id				
						  			  
				WHERE psj.mek = ?			  
			";	
			
		}
		
		if( isset( $args[ 'filter' ] ) ) $sql .= ' AND ps.key = ' . $this->db->escape( $args[ 'filter' ] );
		
		$sql .= ' ORDER BY t.created_date, t.exp_date, pp.prefix, pp.amount, p.pek';		
		
		return $this->db->query( $sql, array( $args['mek'] ) )->result_array();
		
	}
	
	
	public function validate_sub_agent_credit_usage()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('start_date', 'Start Date', 'required|trim');		
		$this->form_validation->set_rules('end_date', 'End Date', 'required|trim');		
		return $this->form_validation->run();
	}
	
	
	
	
	public function clear_sub_agent_credits( array $meks )
	{
		
		$this->db->where_in( 'mek' , $meks );
		$this->db->update( 'sub_agent_credit_use_history', array( 'active' => 0 ) );	
		
		return true;
	}
	
	
	
	//master_id, date span, start date/end date
	public function get_sub_agent_credit_usage( array $args )
	{
		$d = $this->sfa();
		
		$sql = "
			SELECT m.full_name, count( credits ) AS credit_count, ( count( credits ) * 5 ) as cost, m.mek
			FROM sub_agent_credit_use_history AS sac
			
			INNER JOIN member AS m 
			  ON m.mek = sac.mek
			
			LEFT JOIN power_prefix AS pp
			  ON pp.prefix_id = sac.prefix_id
			
			INNER JOIN master_sub_join AS msj
			  ON msj.sub_id = m.mek
			
			WHERE msj.master_id = ? AND used_date BETWEEN ? AND ? AND  sac.active = 1
			
			GROUP BY m.full_name
		";	
		
		$p = array( $args['mek'], $this->mysql_date_format( $args['startdate'] ), $this->mysql_date_format( $args['enddate'] ) );
		return $this->db->query( $sql, $p )->result_array();	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	//pek, prefix_id
	public function get_agent_detailed_power( array $args )
	{
		


		$sql = "
			SELECT 
			  p.pek, pp.prefix, pp.amount, pp.prefix_id, p.transmission_id, 
			  ps.status, ps.key, psaj.log, DATE_FORMAT( psaj.date,'%m/%d/%Y' ) as created_date
			
			FROM power_history AS psaj
			
			INNER JOIN power AS p 
			  ON p.power_id = psaj.power_id
			
			INNER JOIN power_prefix AS pp
			  ON pp.prefix_id = p.prefix_id
			
			INNER JOIN power_status AS ps
			  ON ps.power_status_id = p.status_id
	
			WHERE p.power_id = ? 
			
			ORDER BY psaj.date desc, pp.prefix, pp.amount, p.pek 
		";	
			
			
		
		
		return $this->db->query( $sql, array( $args['power_id'] ) )->result_array();
		
	}
	
	
	
	
	
	
	//mek
	public function get_sub_agent_powers( array $args )
	{
		$sql = "
			SELECT 
			  
			  DISTINCT p.pek, p.power_id, pp.prefix, pp.amount,pp.prefix_id,
			  CASE psaj.active
				WHEN 1 THEN 'Agent Has Control'
				WHEN 0 THEN 'Power Recouped'
				ELSE 'Power Recouped'
			  END AS recouped,
			  ps.status
	
			FROM power_sub_agent_join AS psaj
			
			INNER JOIN power AS p 
			  ON p.power_id = psaj.power_id
			
			INNER JOIN power_prefix AS pp
			  ON pp.prefix_id = p.prefix_id
			
			INNER JOIN power_status AS ps
			  ON ps.power_status_id = p.status_id
			  
			WHERE psaj.mek = ?			  
		";	
		
		if( isset( $args[ 'status'] ) && $args[ 'status' ] != NULL )
			$sql .= ' AND ps.key = ' . $this->db->escape( $args[ 'status' ] );
		
		$sql .= ' ORDER BY pp.prefix, pp.amount, p.pek';		
		
		
		return $this->db->query( $sql, array( $args['mek'] ) )->result_array();
	}
	
	
	public function validate_sub_agent_history_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
	
		$this->form_validation->set_rules('sub_agent', 'Sub Agent', 'required|trim');		

		return $this->form_validation->run();
		
		
	}



	public function validate_sub_agent_mar_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
	
		$this->form_validation->set_rules('sub_agent', 'Sub Agent', 'required|trim');		
		$this->form_validation->set_rules('ins_company', 'Insurance Company', 'required|trim');		

		return $this->form_validation->run();
		
		
	}


}