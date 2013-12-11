<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class status_crud_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	


	public function get_power_status_id( $key )
	{
		return $this->db->select( 'power_status_id' )->from( 'power_status' )
						->where( array( 'key' => $key ) )->get()->row();
		
	}
		




}