<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transactions_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	public function get_trans( $mek, $type )
	{
		
		
		$sql = '
			select t.amount,  	
			DATE_FORMAT(t.created_date, "%m/%d/%Y") as created_date,
			trans_id
			from transactions t
			inner join transaction_type tt on t.type = tt.transaction_type_id
			where t.mek = ? and tt.type = ?
		';
		
		$query = $this->db->query( $sql, array( $mek, $type ) );
		
		return $query->result_array();
		
		
	}

}