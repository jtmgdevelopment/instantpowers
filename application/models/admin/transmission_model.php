<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transmission_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	public function validate_prefix_frm()
	{
		
		$this->sfa();

		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('prefix', 'Power Prefix', 'required|trim');		
		$this->form_validation->set_rules('amount', 'Power Amount', 'required|trim');		
		return $this->form_validation->run();
	}
	
	
	public function save_prefix( $mek )
	{
		$data = $this->sfa();
		
		$data['mek'] = $mek;
		
		$this->db->trans_start();
			$this->db->insert( 'power_prefix', $data );
		$this->db->trans_complete();	
		
		return true;
	}
	
	public function get_prefixes()
	{
		$sql = '
			select prefix, amount,
			case active
				when 1 then "Active"
				when 0 then "Not Active"
				else "Not Active"
			end as active
			from power_prefix
			order by amount, prefix, active 
		';
		
		$q = $this->db->query( $sql );
		
		return $q->result_array();
		
	}
	

}