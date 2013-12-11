<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class prefix_crud_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	public function update_prefix_status( $status, $prefix_id )
	{
		$this->db->trans_start();
			$this->db->update('power_prefix', array( 'active' => 0 ), array( 'prefix_id' => $prefix_id ) );
		$this->db->trans_complete();
		
		return true;
		
	}
	
	
	public function get_prefix_by_agent( array $a = array() )
	{
		$sql = '
			SELECT prefix_id, prefix, amount 
			FROM power_prefix AS pp
			INNER JOIN bail_insurance_join AS bij 
			ON bij.insurance_agency_id = pp.insurance_agency_id
			WHERE pp.active = 1
			AND bij.bail_agent_id = ?
			ORDER BY prefix, amount 
		';	
		
		return $this->db->query( $sql, array( $a[ 'mek' ] ) )->result_array();
		
	}
	
	
	
	
	public function validate_prefix_frm()
	{
		
		$this->sfa();

		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('prefix', 'Power Prefix', 'required|trim');		
		$this->form_validation->set_rules('amount', 'Power Amount', 'required|number|trim');		
		$this->form_validation->set_rules('prefix_start', 'Power Prefix Start', 'required|number|trim');		
		return $this->form_validation->run();
	}
	
	
	//mek, agency_id
	public function save_prefix( array $args )
	{
		
		
		$data = $this->sfa();
		
		$data['mek'] = $args['mek'];
		$data['insurance_agency_id' ] = $args[ 'agency_id' ];
	
		
	
		$this->db->trans_start();
			$this->db->insert( 'power_prefix', $data );
		$this->db->trans_complete();	
		
		return true;
	}
		
	/*
		get_prefix_name
		Args
			- prefix_id
	*/

	public function get_prefix_name( array $args )
	{
		$q = $this->db->get_where( 'power_prefix', array( 'prefix_id' => $args[ 'prefix_id' ] ) )->row();
		
		return $q->prefix . ' ' . $q->amount;
		
	}
	
	
	
	//company id
	public function get_prefixes( array $args = NULL )
	{
		
		$sql = '
			SELECT prefix_id, prefix, amount, 
			
			CASE active
				WHEN 1 THEN "Active"
				WHEN 0 THEN "Not Active"
				ELSE Not "Active"
			END AS active
			FROM power_prefix AS pp
			WHERE 1 = 1
		';

		if( isset( $args['agency_id'] ) ) $sql .= ' AND insurance_agency_id = ' . $this->db->escape( $args[ 'agency_id'] );
		
		if( isset( $args[ 'active' ]) ) $sql .= ' AND active = 1';
		
		$sql .= ' ORDER BY prefix, amount';
		
		
		return $this->db->query( $sql )->result_array();


	}
}