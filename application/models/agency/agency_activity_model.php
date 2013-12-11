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

class agency_activity_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	public function get_agency_activity( array $a = NULL )
	{
		
		$sql = '
			SELECT p.pek, pp.amount, pp.prefix, ps.status
			FROM bail_agency AS ba
			INNER JOIN bail_agency_agent_join AS baaj
			  ON baaj.bail_agency_id = ba.bail_agency_id
			INNER JOIN bail_agent AS agent
			  ON agent.mek = baaj.bail_agent_id
			INNER JOIN transmission AS t 
			  ON t.bail_agent_id = agent.mek
			INNER JOIN power AS p 
			  ON p.transmission_id = t.transmission_id
			INNER JOIN power_prefix as pp
				ON pp.prefix_id = p.prefix_id
			INNER JOIN power_status AS ps
				ON ps.power_status_id = p.status_id	
			WHERE agent.is_sub_agent = 0 		
		';
		
		if( isset( $a[ 'agency_id' ] ) ) $sql .= ' AND ba.bail_agency_id = ' . $this->db->escape( $a[ 'agency_id' ] );
		
		$sql .= ' ORDER BY pp.prefix, pp.amount, ps.status ASC, p.pek';
		
		return $this->db->query( $sql )->result_array();
		
	}
	
	public function validate_agency_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');			
		$this->form_validation->set_rules('bail_agency', 'Bail Agency', 'required|trim');		
		return $this->form_validation->run();
		
	}
	

}