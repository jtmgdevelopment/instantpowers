<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class mga_report_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model( 'insurance/insurance_crud_model', 'i' );
		$this->load->model( 'premium/premium_crud_model', 'premium' );
		$this->load->model( 'mga/mga_crud_model', 'mga' );
		
	}

	public function list_powers_by_agency( $agency_id, $status = NULL, $mek )
	{
		
		$sql = '
			SELECT DISTINCT 
				p.power_id, p.pek, pp.prefix, pp.amount,pp.prefix_id,
				ps.status, ps.key, pdd.first_name, pdd.last_name, t.bail_agent_id  as mek
			FROM power AS p 
			INNER JOIN power_prefix AS pp
			  ON pp.prefix_id = p.prefix_id
			INNER JOIN power_status AS ps
			  ON ps.power_status_id = p.status_id
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id			  			  
			LEFT JOIN power_details_defendant AS pdd
				ON pdd.power_id = p.power_id	
			WHERE 1 = 1	
		';
		
		$sql .= ' AND t.bail_agency_id = ' . $this->db->escape( $agency_id );	
		$sql .= ' AND t.mga_id = ' . $this->db->escape( $mek );	
		if( isset( $status ) ) $sql .= ' AND ps.key = ' . $this->db->escape( $status );
		
		return $this->db->query( $sql )->result_array();
	}


	public function list_reports_by_agency( array $a )
	{

		$sql = "
			SELECT date_created, report_id, ins_id,mga_id, mar.transaction_id, t.amount,
			case 
			when mar.online_payment IS TRUE then 'Online Payment'
			else 'Offline Payment' end as payment_type
			
			FROM master_agent_report as mar
			left join transactions as t on t.trans_id = mar.transaction_id
			
			WHERE mga_id = " . $this->db->escape( $a[ 'mga_id' ] );
		
		$sql .= " AND mar.mek = " . $this->db->escape( $a[ 'mek' ] );
		$sql .= " ORDER BY date_created";
	
		
		return $this->db->query($sql)->result_array();
		
	}


	public function get_report_list( array $a )
	{
		$sql = "
			SELECT date_created, report_id, ins_id,mga_id
			FROM master_agent_report
			WHERE mek = " . $this->db->escape( $a[ 'mek' ] );
		
		$sql .= " AND ins_id = " . $this->db->escape( $a[ 'ins_id' ] );
		$sql .= " ORDER BY date_created";
	
		
		return $this->db->query($sql)->result_array();
	}


	public function validate_power_history_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
	
		$this->form_validation->set_rules('bail_agency', 'Bail Agency', 'required|trim');		
		return $this->form_validation->run();
		
	}


	public function validate_ins_mga_report_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
	
		$this->form_validation->set_rules('mga_agency', 'MGA', 'required|trim');		
		return $this->form_validation->run();
		
	}


	public function validate_new_mga_report_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
	
		$this->form_validation->set_rules('ins_company', 'Insurance', 'required|trim');		
		return $this->form_validation->run();
		
	}
	
	
	public function create_report_record( array $a )
	{
		$this->db->trans_start();
			$d = array( 'mek' => $a[ 'mek' ], 'ins_id' => $a[ 'ins_id' ], 'date_created' => $this->now() );
			
			$this->db->insert( 'master_agent_report', $d );
			$report_id = $this->db->insert_id();

		$this->db->trans_complete();			
		
		$params = array( 
			'ins_company_id' 	=> $a[ 'ins_id' ], 
			'mek' 				=> $a[ 'mek' ],
			'premium' 			=> $a[ 'premium' ]
		);

		
		$report = $this->get_powers_for_mga_report( $params );
		
		
		foreach( $report as $r )
		{
			$temp = array(
				'report_id'     => $report_id,
				'power_id'      => $r[ 'power_id' ],
				'ins_id'        => $a[ 'ins_id' ],
				'mek'           => $a[ 'mek' ],
				'mga_reported'  => 1
			);	
			

			$where = array(
				'power_id'	=> $r[ 'power_id' ]
			);

			$update = array(
				'mga_reported' => 1
			);
			
			$this->db->trans_start();
				$this->db->update( 'master_agent_report_data', $update, $where );		
			$this->db->trans_complete();			

			
			
			$this->db->trans_start();
				$this->db->insert( 'master_agent_report_data', $temp );
			$this->db->trans_complete();			
			
			
			$where = array(
				'power_id'	=> $r[ 'power_id' ]
			);

			$update = array(
				'is_mga_reported' => 1,
			);
			
			$this->db->trans_start();
				$this->db->update( 'power', $update, $where );		
			$this->db->trans_complete();			

		}
		
		$ins = $this->i->get_insurance_agent( array( 'ins_id' => $a[ 'ins_id' ] ) );
	

		$master_agent 	= $this->mga->get_mga_admins( array( 'mek' => $a[ 'mek' ] ) );

		
		$d = array(
			'master_email' 	=> $master_agent->email,
			'master_name'	=> $master_agent->full_name,
			'ins_email'		=> $ins->email,
			'ins_name'		=> $ins->full_name 
		
		);
		
		$this->em->notify_ins_of_master_report( $d );
		
		
		return true;		
		
		
	}
	
	
	public function get_powers_for_mga_report( array $a )
	{
		

		if(! isset( $a[ 'archived' ] ) )
		{
			$sql = '		
					SELECT Distinct p.power_id, p.pek, pp.prefix, pp.amount, pd.Data, p.prefix_id, ps.key, pd.county
					
					
					from power as p
					    
					INNER JOIN Transmission AS T ON T.Transmission_id = P.Transmission_id
					LEFT JOIN Power_details AS Pd ON Pd.Power_id = P.Power_id            
					INNER JOIN Power_prefix AS Pp ON Pp.Prefix_id = P.Prefix_id    
					INNER JOIN Power_status AS Ps ON Ps.Power_status_id = P.Status_id                
					                
					 WHERE 1 = 1    
					 AND Ps.Key != "Inventory"
					AND P.Is_mga_reported = 0  
			';
			
			 
			 $sql .= 'AND t.mga_id = ' . $this->db->escape( $a[ 'mek' ] );
			 $sql .= ' Order By Pp.Prefix, Pp.Amount, P.Pek';


		}
		else
		{

			$sql = '		
				SELECT distinct p.power_id, p.pek, pp.prefix, pp.amount, pd.data, p.power_id, p.prefix_id, ps.key, pd.county
	
				FROM master_agent_report_data as mard
				
				INNER JOIN power AS p ON p.power_id = mard.power_id
				INNER JOIN transmission AS t ON t.transmission_id = p.transmission_id
				LEFT JOIN power_details AS pd ON pd.power_id = p.power_id			
				INNER JOIN power_prefix AS pp ON pp.prefix_id = p.prefix_id	
				INNER JOIN power_status AS ps ON ps.power_status_id = p.status_id				
				
				WHERE 1 = 1 
			';
			
			 $sql .= " AND mard.report_id = " . $this->db->escape( $a[ 'report_id' ] );			
			 
			 if( ! isset( $a[ 'reported' ] ) ) $sql .= " AND mard.mga_reported = 1";
		}		
		
		
		
		
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
			
			$company 	= $premium * ( $premiums[ 'premium' ]/100 );
			$buf		= $premium * ( $premiums[ 'buf' ]/100 ); 
			
			
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
				'county'	=> $p[ 'county' ]
			);

		}
		
		return $report;	

	
	}

	public function get_grouped_powers_for_master_report( array $a )
	{

		if(! isset( $a[ 'archived' ] ) )
		{

			$sql = '		
					SELECT distinct pp.prefix_id, pp.prefix, pp.amount, count( distinct p.power_id ) as grouping
					
					
					from power as p
					    
					INNER JOIN Transmission AS T ON T.Transmission_id = P.Transmission_id
					LEFT JOIN Power_details AS Pd ON Pd.Power_id = P.Power_id            
					INNER JOIN Power_prefix AS Pp ON Pp.Prefix_id = P.Prefix_id    
					INNER JOIN Power_status AS Ps ON Ps.Power_status_id = P.Status_id                
					                
					 WHERE 1 = 1    
					 AND Ps.Key != "Inventory"
					AND P.Is_mga_reported = 0  
			';
			
			 
			 $sql .= 'AND t.mga_id = ' . $this->db->escape( $a[ 'mek' ] );
			 
			 $sql .= ' group by prefix_id';
	
		}
		else
		{

			$sql = '		
				SELECT distinct pp.prefix_id, pp.prefix, pp.amount, count( distinct p.power_id ) as grouping
				FROM master_agent_report_data as mard
				INNER JOIN power AS p ON p.power_id = mard.power_id
				INNER JOIN transmission AS t ON t.transmission_id = p.transmission_id
				LEFT JOIN power_details AS pd ON pd.power_id = p.power_id			
				INNER JOIN power_prefix AS pp ON pp.prefix_id = p.prefix_id	
				INNER JOIN power_status AS ps ON ps.power_status_id = p.status_id				
				
				WHERE 1 = 1 
			';
			
			 $sql .= " AND mard.report_id = " . $this->db->escape( $a[ 'report_id' ] );			
			 if( ! isset( $a[ 'reported' ] ) ) $sql .= " AND mard.mga_reported = 1";
			
			 $sql .= ' group by prefix_id';
			
		}	
		
		return $this->db->query( $sql )->result_array();
				
		
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


}