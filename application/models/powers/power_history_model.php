<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class power_history_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	/*
		SET_POWER_HISTORY
		*ARGUMENTS
		- PEK
		- PREFIX_ID
	*/
	
	public function set_power_history( array $args )
	{
				
		$d = array(
			'mek'		=> ( ! isset( $args[ 'mek' ] ) ? $this->session->userdata( 'mek' ) : $args[ 'mek' ] ),
			'power_id'	=> $args['power_id'],
			'log'		=> $args[ 'log' ],
			'date'		=> $this->now()
		);
		
	
		$this->db->trans_start();
			$this->db->insert( 'power_history', $d );
		$this->db->trans_complete();
		
		return true;	
	}
	
	
	public function get_power_history( $power_id )
	{
		return $this->db->select( 'log, date' )->get_where( 'power_history', array( 'power_id' => $power_id ) )->result_array();
		
	}

}