<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class credits_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model('agent/crud_model', 'agent' );		
		$this->load->model( 'mga/mga_crud_model', 'mga' );
	}
	
	
	
	
	//mek, amount of credits, pek, prefix_id
	public function update_sub_agent_credit_use( array $args )
	{
	
		$this->db->trans_start();
			$this->db->insert( 'sub_agent_credit_use_history', $args );
		$this->db->trans_complete();
		
		return true;	
	}
	
	
	public function notify_low_credits( $mek, $is_mga = false )
	{
		$credits = $this->get_credits( $mek );

		if( $credits->credit_count < 5 )
		{
			$agent = $this->agent->get_agents( $mek );	
			
			if( $is_mga )
			{
				$agent = ( object ) $this->mga->get_mga_admins( array( 'mek' => $mek ) );	
			}
			$d = array(
				'email' 	=> $agent->email,
				'credit' 	=> $credits->credit_count 
			);	
 				
			$this->em->notify_low_credits( $d );
			
		}
		return true;
	}
	
	
	
	
	
	public function update_credits_amount( $mek, $price, $credits, $is_mga = false )
	{
		
		$credits = $credits - $price;
		
		$d = array(
			'credit_count' => $credits
		);
		
		$this->db->update( 'credits', $d, array( 'mek' => $mek ) );
		$this->notify_low_credits( $mek, $is_mga );
		
		
		return true;
		
	}
	
	
	public function get_credits( $mek )
	{
		
		$sql = '
			select credit_count, 	
			DATE_FORMAT(modified_date, "%m/%d/%Y") as modified_date
			from credits
			where mek = ?
		';
	
		$query = $this->db->query( $sql, array( $mek ) );
		
		return $query->row();
	}

	public function get_credit_history( $mek )
	{
		$sql = '
			select c.credits, 	t.amount,
			DATE_FORMAT(c.modified_date, "%m/%d/%Y %r") as modified_date
			from credits_history c
			inner join transactions t
				on t.transaction_id = c.transaction_id
			where c.mek = ?
			order by created_date desc
		';
	
		$query = $this->db->query( $sql, array( $mek ) );
		
		return $query->result_array();
	}

	public function validate_credits_frm()
	{
		$this->sfa();

		$this->form_validation->set_error_delimiters('<li>', '</li>');		

		$this->form_validation->set_rules('credits', 'Credits', 'required|number|greater_than[0]|trim');		

		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');		
		$this->form_validation->set_rules('last_name', 'last Name', 'required|trim');		
		$this->form_validation->set_rules('address', 'Billing Address', 'required|trim');		
		$this->form_validation->set_rules('city', 'Billing City', 'required|trim');		
		$this->form_validation->set_rules('state', 'Billing State', 'required|trim');		
		$this->form_validation->set_rules('zip', 'Billing Zip', 'required|trim');		

		$this->form_validation->set_rules('creditcard', 'Credit Card', 'required|card_number_valid|trim');		
		$this->form_validation->set_rules('securitycode', 'Security Code (CVV)', 'required|trim');		

		$this->form_validation->set_rules('exp_mth', 'Expiration Month', 'required|number|exact_length[2]|trim');		
		$this->form_validation->set_rules('exp_yr', 'Expiration Year', 'required|number|exact_length[4]|trim');		



		
		return $this->form_validation->run();
	}

	public function purchase_credits()
	{
	
		$this->load->library('Payment' );
		$amount	= $this->input->post('credits') * CREDIT_AMOUNT;
		$fee = $amount * .03;
		$amount = $fee + $amount;
		
		
 		
		
		$params = array();
		$params['x_card_num'] 		= $this->input->post('creditcard');
        $params['x_card_code'] 		= $this->input->post('securitycode');
        $params['x_exp_date'] 		= $this->input->post('exp_mth') . '/' . $this->input->post('exp_yr');
        $params['x_desc']			= CREDITS_DESC;
        $params['x_amount'] 		= $amount;
        $params['x_first_name'] 	= $this->input->post('first_name');
        $params['x_last_name'] 		= $this->input->post('last_name');
        $params['x_address'] 		= $this->input->post('address');
        $params['x_city'] 			= $this->input->post('city');
        $params['x_state'] 			= $this->input->post('state');
        $params['x_zip'] 			= $this->input->post('zip');
		$params['x_email']			= $this->input->post( $this->session->userdata('email') );
		$params['x_cust_id']		= $this->input->post( $this->session->userdata('mek') );
		$params['x_customer_ip']	= $this->input->post( $this->session->userdata('ip_address') );
	
	
		$this->payment->clear();
        $this->payment->setData($params);
	 	$aim = $this->payment->authorizeAndCapture();
		$ret = $this->payment->parseResponse($aim);
		
		$error = $this->payment->getError();
		
		/*
		var_dump($error);
		d($this->payment->debug());			
		dd($this->payment->getTransactionId());
		dd($this->payment->debug());
		*/


		if( ! $ret ) $error = $this->payment->getError();
		else $this->save_transaction( $this->payment->getTransactionId(), $amount );
		
		return array(
			'success' 	=> $ret,
			'error'		=> $error
		);
		
		
	}
	
	private function save_transaction( $trans_id, $amount )
	{
		$trans_type	= $this->db->get_where( 'transaction_type', array( 'type' => 'credit' ) );
		$trans_type = $trans_type->row();
		$mek 		= $this->session->userdata('mek');
		$insert		= false;
		
		
		//get total credits
		$this->db->select_sum('credit_count', 'credit_count')->from( 'credits' )->where('mek', $mek );
		$current_credits = $this->db->get();
		$current_credits = $current_credits->row();
		
		//get the total credits
		$credits = $current_credits->credit_count + $this->input->post( 'credits' );
		
		
		$update_credits = array(
			'credit_count' => $credits
		);
		
		
		$trans = array(
			'trans_id'		=> $trans_id,
			'mek'			=> $mek,
			'type'			=> $trans_type->transaction_type_id,
			'amount'		=> $amount,
			'created_date'	=> $this->now()
		);
		
		
		$this->db->trans_start();
			$this->db->insert( 'transactions', $trans );			
	
			$credits_history = array(
				'mek' 			=> $mek,
				'transaction_id'=> $this->db->insert_id(),
				'credits' 		=> $this->input->post( 'credits' ),
				'modified_date' => $this->now()
			);
			
			$this->db->insert( 'credits_history', $credits_history );
			$this->db->update( 'credits', $update_credits, array( 'mek' => $mek ) );
		$this->db->trans_complete();		
		
		
		return true;
		
		
		
	}

}