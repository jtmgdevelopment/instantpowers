<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class crud_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	
	
	public function get_jails( $mek = NULL )
	{
		$sal = "
			SELECT jail_id, mek, email, jail_name, address, city, state, zip, phone
			FROM jails
			WHERE active = 1
			ORDER BY jail_name
		";
		
		$q = $this->db->query( $sql );
		
		return $q->result_array();
	}
	
	
	public function create_select_array()
	{
		$t = $this->get_jails();
		$z =  array();
		foreach( $t as $val ) $z[ $val[ 'jail_id' ] ] = $val[ 'jail_name' ];
		
		return $z;
		
	}

}