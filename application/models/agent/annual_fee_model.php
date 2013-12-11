<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class annual_fee_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
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

		$this->form_validation->set_rules('creditcard', 'Credit Card', 'required|card_number_valid|trim');		
		$this->form_validation->set_rules('securitycode', 'Security Code (CVV)', 'required|trim');		
		$this->form_validation->set_rules('exp_mth', 'Expiration Month', 'required|number|exact_length[2]|trim');		
		$this->form_validation->set_rules('exp_yr', 'Expiration Year', 'required|number|exact_length[4]|trim');		
		
		return $this->form_validation->run();
	}
	
	
	public function check_fee_assessment( array $args )
	{
		
		//check to see if the fee has been initailly charged
		$sql = "
			SELECT DATEDIFF( CURDATE(), date_paid ) as date_paid_span
			FROM agent_annual_fee AS a
			WHERE a.mek = ?
			ORDER BY date_paid DESC
			LIMIT 1
		";	
		
		$fee = $this->db->query( $sql, array( $args['mek'] ) )->result_array();	

		if( count( $fee ) )
		{
			return $fee[0][ 'date_paid_span' ];		
		}
		else
		{
			return false;
		
		}
	}
	
	
	public function purchase_annual_fee()
	{
	
		$this->load->library('Payment' );
 		
		
		$params = array();
		$params['x_card_num'] 		= $this->input->post('creditcard');
        $params['x_card_code'] 		= $this->input->post('securitycode');
        $params['x_exp_date'] 		= $this->input->post('exp_mth') . '/' . $this->input->post('exp_yr');
        $params['x_desc']			= ANNUAL_FEE_DESC;
        $params['x_amount'] 		= ANNUAL_FEE;
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
		else $this->save_transaction( $this->payment->getTransactionId(), ANNUAL_FEE );
		
		return array(
			'success' 	=> $ret,
			'error'		=> $error
		);
		
		
	}
	
	private function save_transaction( $trans_id, $amount )
	{
		$trans_type	= $this->db->get_where( 'transaction_type', array( 'type' => 'annual_fee' ) );
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

			$fee = array(
				'mek'				=> $mek,
				'transaction_id'	=> $this->db->insert_id(),
				'date_paid'			=> $this->now()
			);		
			$this->db->insert( 'agent_annual_fee', $fee );
		$this->db->trans_complete();		
		
		
		return true;
		
		
		
	}
	
}