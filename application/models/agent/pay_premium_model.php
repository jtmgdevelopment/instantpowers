<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pay_premium_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	public function validate_report_premium_frm()
	{

		$d = $this->sfa();

		$this->form_validation->set_error_delimiters('<li>', '</li>');		

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

	
	public function validate_fee_frm()
	{

		$this->sfa();

		$this->form_validation->set_error_delimiters('<li>', '</li>');		

		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');		
		$this->form_validation->set_rules('last_name', 'last Name', 'required|trim');		
		$this->form_validation->set_rules('address', 'Billing Address', 'required|trim');		
		$this->form_validation->set_rules('city', 'Billing City', 'required|trim');		
		$this->form_validation->set_rules('state', 'Billing State', 'required|trim');		
		$this->form_validation->set_rules('zip', 'Billing Zip', 'required|trim');		


		$this->form_validation->set_rules('amount', 'Premium Amount', 'required|number|trim');		
		$this->form_validation->set_rules('creditcard', 'Credit Card', 'required|card_number_valid|trim');		
		$this->form_validation->set_rules('securitycode', 'Security Code (CVV)', 'required|trim');		
		$this->form_validation->set_rules('exp_mth', 'Expiration Month', 'required|number|exact_length[2]|trim');		
		$this->form_validation->set_rules('exp_yr', 'Expiration Year', 'required|number|exact_length[4]|trim');		
		
		return $this->form_validation->run();
	}
	
	
	public function pay_premium( $arg )
	{
		
		$this->load->library('Payment' );
 		
		
		$params = array();
		$params['x_card_num'] 		= $arg['creditcard'];
        $params['x_card_code'] 		= $arg['securitycode'];
        $params['x_exp_date'] 		= $arg['exp_mth'] . '/' . $arg['exp_yr'];
        $params['x_desc']			= PAY_PREMIUM_DESC;
        $params['x_amount'] 		= $arg['amount'];
        $params['x_first_name'] 	= $arg['first_name'];
        $params['x_last_name'] 		= $arg['last_name'];
        $params['x_address'] 		= $arg['address'];
        $params['x_city'] 			= $arg['city'];
        $params['x_state'] 			= $arg['state'];
        $params['x_zip'] 			= $arg['zip'];
		$params['x_email']			= $this->session->userdata('email');
		$params['x_cust_id']		= $this->session->userdata('mek');
		$params['x_customer_ip']	= $this->session->userdata('ip_address');
	
		
		
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
		else $this->save_transaction( $this->payment->getTransactionId(), $arg['amount'] );
		
		return array(
			'success' 	=> $ret,
			'error'		=> $error,
			'trans_id'	=> $this->payment->getTransactionId()
		);
		
		
	}
	
	private function save_transaction( $trans_id, $amount )
	{
		$trans_type	= $this->db->get_where( 'transaction_type', array( 'type' => 'premium_payment' ) );
		$trans_type = $trans_type->row();
		$mek 		= $this->session->userdata('mek');
		$insert		= false;
		
		
		$trans = array(
			'trans_id'		=> $trans_id,
			'mek'			=> $mek,
			'type'			=> $trans_type->transaction_type_id,
			'amount'		=> $amount,
			'created_date'	=> $this->now()
		);
		
		
		$this->db->trans_start();
			$this->db->insert( 'transactions', $trans );			
		$this->db->trans_complete();		
		
		return true;
	}
	
}