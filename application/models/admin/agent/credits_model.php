<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class credits_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	public function validate_credits_frm()
	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('amount', 'Amount', 'required|trim|integer');		
		
		
		return $this->form_validation->run();		
		
	}
	
	public function save_credits( array $args )
	{
		//get current credits
		$sql = '
			SELECT credit_count
			FROM credits
			WHERE mek = ?
		';
		
		$q = $this->db->query( $sql, array( $args[ 'bail_agent' ] ) )->row();
		
		$credits = (int) $q->credit_count;
		
		$credits += $args[ 'amount' ];
		
		//update data
		return $this->db->update( 'credits', array( 'credit_count' => $credits ), array( 'mek' => $args['bail_agent'] ) );	
	}
	

}