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

class power_inventory_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model( 'agent/crud_model', 'a' );
		
	}
	
	
	public function list_powers_by_agency( array $a )
	{
		$ins_company_id = $this->get_ins_company_id( array( 'mek' => $a[ 'mek' ] ) );	
		
		if( isset( $a[ 'search' ] ) )
		{
			$power = explode( ' ', $a[ 'search' ] );

		}
		
		
		$sql = '
			SELECT p.power_id, pp.prefix, pp.amount, p.pek, DATE_FORMAT( p.exp_date, "%c/%m/%Y" ) as exp_date, ps.status, ps.key
			FROM transmission AS t
			INNER JOIN power AS p
				ON p.transmission_id = t.transmission_id
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id
			INNER JOIN power_prefix AS pp
				ON pp.prefix_id = p.prefix_id	
			WHERE 1 = 1
			AND p.is_reported = 0
		';		
		
		$sql .= ' AND t.insurance_company_id = ' . $ins_company_id;
		
		if( is_numeric( $a['bail_agency'] ) ) $sql .= ' AND t.bail_agency_id = ' . $a['bail_agency'];
		else $sql .= ' AND t.mga_id = ' . $this->db->escape( $a['bail_agency'] );

		if( isset( $a[ 'status' ] ) ) $sql .= ' AND ps.key = ' . $this->db->escape( $a[ 'status' ] );
		if( isset( $a[ 'search' ] ) ) $sql .= ' AND p.pek = ' . $this->db->escape( $a[ 'search' ] );
		if( isset( $a[ 'prefix' ] ) ) $sql .= ' AND pp.prefix_id = ' . $this->db->escape( $a[ 'prefix' ] );
		if( isset( $a[ 'defendant_first' ] ) && strlen( $a[ 'defendant_first' ] ) > 0 ) $sql .= " AND  pdd.first_name like '%" .  $a[ 'defendant_first' ]  . "%'";
		if( isset( $a[ 'defendant_last' ] )  && strlen( $a[ 'defendant_last' ] ) > 0 ) $sql .= " AND  pdd.last_name like '%" .  $a[ 'defendant_last' ]  . "%'";
		if( isset( $a[ 'start_date' ] ) && isset( $a[ 'end_date' ] ) ) $sql .= ' AND t.created_date between ' . $this->db->escape( $this->mysql_date_format( $a[ 'start_date' ] ) ) . ' AND ' . $this->db->escape( $this->mysql_date_format( $a[ 'end_date' ] ) );
		if( isset( $a[ 'exp_start_date' ] ) && isset( $a[ 'exp_end_date' ] ) ) $sql .= ' AND p.exp_date between ' . $this->db->escape( $this->mysql_date_format( $a[ 'exp_start_date' ] ) ) . ' AND ' . $this->db->escape( $this->mysql_date_format( $a[ 'exp_end_date' ] ) );


		$sql .= ' ORDER BY pp.prefix, pp.amount, p.exp_date';	
		
		$q = $this->db->query( $sql )->result_array();
			
		return $q;		
			
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
	
	
	/*
		ins mek
	*/
	public function get_bail_agencies( array $a )
	{	
		
		$ins_company_id = $this->get_ins_company_id( array( 'mek' => $a[ 'mek' ] ) );
		
		$sql = '
			SELECT DISTINCT b.bail_agency_id ,b.agency_name
			FROM bail_insurance_join AS bij
			INNER JOIN bail_agent AS ba
				ON ba.mek = bij.bail_agent_id
			INNER JOIN bail_agency_agent_join AS baaj
				ON baaj.bail_agent_id = ba.mek
			INNER JOIN bail_agency AS b
				ON	b.bail_agency_id = baaj.bail_agency_id	
			WHERE 1 = 1
			AND ba.is_sub_agent = 0
		';
		
		
		$sql .= ' AND bij.insurance_agency_id = ' . $this->db->escape( $ins_company_id );
		 
		$q = $this->db->query( $sql )->result_array();
		
		return $q;		
	}

}