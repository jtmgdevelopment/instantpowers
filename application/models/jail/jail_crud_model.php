<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jail_crud_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	
	
	public function get_jails( $jail_id = NULL )
	{
		$sql = "
			SELECT j.jail_id, j.mek, j.email, j.jail_name, j.address, j.city, j.state, j.zip, j.phone, m.full_name
			FROM jails j
			INNER JOIN member m
				ON m.mek = j.mek
			WHERE j.active = 1
			
		";
		
		if( isset( $jail_id ) ) $sql .= ' AND jail_id = ' . $this->db->escape( $jail_id );
		
		$sql .= ' ORDER BY jail_name';
		$q = $this->db->query( $sql );
		
		if( isset( $jail_id ) ) return $q->row();
		
		return $q->result_array();
	}
	
	/*
		ARGUMENTS
		@mek required
	*/
	
	public function get_jail( array $args )
	{
		
		$sql = "
			SELECT j.jail_id, j.email as jail_email, j.jail_name, j.address, j.city, j.state, j.zip, j.phone,
			m.first_name, m.last_name, m.email, m.address, m.city, m.state, m.zip, m.mek
			FROM jails j
			INNER JOIN member AS m
				ON m.mek = j.mek
			WHERE j.mek = ?
		";
			
		return $this->db->query( $sql, array( 'mek' => $args[ 'mek' ] ) )->row();
	}
	
	
	public function create_select_array()
	{
		$t = $this->get_jails();
		$z =  array('' => 'Please Select Jail');
		foreach( $t as $val ) $z[ $val[ 'jail_id' ] ] = $val[ 'jail_name' ];
		
		return $z;
		
	}

}