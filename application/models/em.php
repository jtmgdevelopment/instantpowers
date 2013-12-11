<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class em extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->pdf 		= realpath( './uploads/pdf/' );
		$this->images	= realpath( './uploads/images/' );
	}


	public function send_power_copies( $data )
	{

		$str = $this->load->view( 'email/ins/send_powers', $data, true );
		$sub = 'Your Requested Powers As PDF';
		
		$d = array(
			'subject' 	=> $sub,
			'message'	=> $str,
			'email'		=> $data['email'],
			'attachments' => array($data[ 'zip' ])
		);	

		$this->send( $d );
		return true;
		
		
		
	}

	public function notify_master_agent_of_master_report( $data )
	{

		$str = $this->load->view( 'email/agent/notify_master_agent_of_master_report', $data, true );
		$sub = 'Sub Agent Report for ' . $data[ 'sub_name' ] . ' is available';
		
		$d = array(
			'subject' 	=> $sub,
			'message'	=> $str,
			'email'		=> $data['master_email'], 
			'cc'		=> $data[ 'sub_email' ]
		);	
		
		$this->send( $d );
		return true;
		
		
		
	}


	public function notify_ins_of_master_report( $data )
	{
		
		$str = $this->load->view( 'email/ins/notify_ins_of_master_report', $data, true );
		$sub = 'Master Report Available';
		
		$d = array(
			'subject' 	=> $sub,
			'message'	=> $str,
			'email'		=> $data['ins_email'],
			'cc'		=> $data[ 'master_email' ]
		);	
		
		$this->send( $d );
		return true;
		
	}
	
	
	public function send_password_info( $data )
	{
		$str = $this->load->view( 'email/password_info', $data, true );
		$sub = 'Reset Password';
		
		$d = array(
			'subject' 	=> $sub,
			'message'	=> $str,
			'email'		=> $data['email']
		);	
		
		$this->send( $d );
		return true;
	}


	public function notify_agent_voided_offline_power( $data )
	{
		$data = ( array ) $data;

		$str 	= $this->load->view( 'email/jail/notify_agent_void_offline_power', $data, true );
		$sub	= $data[ 'jail_name' ] . ' has VOIDED your offline power.';

		$d = array(
			'subject' 		=> $sub,
			'message' 		=> $str,
			'email'	  		=> $data['email']
		);	


		$this->send( $d );
		return true;		
	}


	public function notify_agent_accepted_offline_power( $data )
	{
		$data = ( array ) $data;

		$str 	= $this->load->view( 'email/jail/notify_agent_accepted_offline_power', $data, true );
		$sub	= $data[ 'jail_name' ] . ' has accepted your offline power.';

		$d = array(
			'subject' 		=> $sub,
			'message' 		=> $str,
			'email'	  		=> $data['email']
		);	


		$this->send( $d );
		return true;		
	}



	public function notify_low_credits( array $data )
	{

		$str 	= $this->load->view( 'email/agent/notify_low_credits', $data, true );
		$sub	= 'Low Credits Alert!';

		$d = array(
			'subject' 		=> $sub,
			'message' 		=> $str,
			'email'	  		=> $data['email']
		);	


		$this->send( $d );
		return true;		
		
		
	}


	
	
	public function notify_agent_of_jail_decline( array $data )
	{
		
		$str 	= $this->load->view( 'email/agent/notify_agent_of_jail_decline', $data, true );
		$sub	= $data['jail_name'] . ' has declined a power for ' . $data['defendant_name'];
		
		
		$d = array(
			'subject' 		=> $sub,
			'message' 		=> $str,
			'email'	  		=> $data['email']
		);	


		$this->send( $d );
		return true;		
		
		
	}





	public function notify_agent_of_jail_accept( array $data )
	{
		
		$str 	= $this->load->view( 'email/agent/notify_agent_of_jail_accept', $data, true );
		$sub	= $data['jail_name'] . ' has accepted a power for ' . $data['defendant_name'];

		$d = array(
			'subject' 		=> $sub,
			'message' 		=> $str,
			'email'	  		=> $data['email']
		);	


		$this->send( $d );
		return true;		
		
		
	}




	public function notify_sub_agent_transfers( array $data )
	{
		
		$str 	= $this->load->view( 'email/sub_agent/notify_sub_agent_power_transfers', $data, true );
		$sub	= 'Instant Powers Have Been Transferred To You';

		$d = array(
			'subject' 		=> $sub,
			'message' 		=> $str,
			'email'	  		=> $data['sub_agent_email'],
			'cc'	  		=> $data['master_agent_email']
		);	


		$this->send( $d );
		return true;		
		
		
	}

	
	
	public function notify_sub_agent_recoup( array $data )
	{
		
		$str 	= $this->load->view( 'email/sub_agent/notify_sub_agent_power_recoup', $data, true );
		$sub	= 'Some Of Your Intant Power Have Been Recouped';

		$d = array(
			'subject' 		=> $sub,
			'message' 		=> $str,
			'email'	  		=> $data['sub_agent_email'],
			'cc'	  		=> $data['master_agent_email']
		);	


		$this->send( $d );
		return true;		
		
		
	}
	

	public function notify_jail_offline_power( $data )
	{
	
	
	
		$str 	= $this->load->view( 'email/powers/notify_jail_offline_power', $data, true );
		$sub	= 'A New Offline Transmission From ' . $data['agent']->agency_name . ' Has Been Created For ' . $data[ 'defendant_name' ];

		$attachments = explode( ',' , $data['power'] );
		$attachments[] = $data['photo'];

		$d = array(
			'subject' 		=> $sub,
			'message' 		=> $str,
			'email'	  		=> $data['jail']->email,
			'cc'	  		=> $data['agent']->email,
			'attachments'	=> $attachments
		);	
		
		
		
		
		$this->send( $d );
		return true;		
		
		
	}


	public function notify_jail_executed_powers( $data )
	{
	
		$str 	= $this->load->view( 'email/powers/notify_jail_executed_powers', $data, true );
		$sub	= 'A New Transmission From ' . $data['agency_name'] . ' Has Been Created For ' . $data[ 'defendant_name' ];
		
		$d = array(
			'subject' 		=> $sub,
			'message' 		=> $str,
			'email'	  		=> $data['jail_email'],
			'cc'	  		=> $data['bail_email'],
			'attachments' 	=> array( $data['photo'] )
		
		);	

		
		
		$this->send( $d );
		return true;		
		
		
	}

	public function send_transmission_notification( $data )
	{
		$str 	= $this->load->view( 'email/transmission/send_new_notification', $data, true );
		$sub	= 'A New Transmission Has Been Created For You';
		
		$data	= ( object ) $data;
		
		$d = array(
			'subject' => $sub,
			'message' => $str,
			'email'	  => $data->email
		
		);	
		
		$this->send( $d );
		return true;		
	}


	public function send_mga_admin_info( $data )
	{
		$str 	= $this->load->view( 'email/admin/notify_mga_admin_creation', $data, true );
		$sub	= 'New MGA Account Created';
		
		$d = array(
			'subject' => $sub,
			'message' => $str,
			'email'	  => $data['email']
		
		);	
		
		$this->send( $d );
		return true;		
	}


	public function send_jail_admin_info( $data )
	{
		$str 	= $this->load->view( 'email/admin/notify_jail_admin_creation', $data, true );
		$sub	= 'New Jail Account Created';
		
		$d = array(
			'subject' => $sub,
			'message' => $str,
			'email'	  => $data['email']
		
		);	
		
		$this->send( $d );
		return true;		
	}

	
	public function send_insurance_agent_info( $data )
	{
		$str 	= $this->load->view( 'email/admin/notify_insurance_agent_creation', $data, true );
		$sub	= 'New Insurance Agent Account Created';
		
		$d = array(
			'subject' => $sub,
			'message' => $str,
			'email'	  => $data['email']
		
		);	
	
		$this->send( $d );
		return true;		
	}
	
	public function notify_sub_agent_creation( $data )
	{
		
		$str 	= $this->load->view( 'email/notify_sub_agent_creation', $data, true );
		$sub	= 'New Sub Agent Account Created';
		
		$d = array(
			'subject' => $sub,
			'message' => $str,
			'email'	  => $data['email']
		
		);	
		
		$this->send( $d );
		return true;
	}
	
	public function send_admin_agent_info( $data )
	{
		$str 	= $this->load->view( 'email/agent_info', $data, true );
		$sub	= 'New Bail Agent Registration';

		$d = array(
			'subject' => $sub,
			'message' => $str
		
		);	
		
		$this->send( $d );
		return true;
	}
	
	
	public function send_jail_information( $data )
	{
		$str 	= $this->load->view( 'email/jail_info', $data, true );
		$sub	= 'Jail Registration';
		
		$d = array(
			'subject' => $sub,
			'message' => $str
		
		);	
		
		$this->send( $d );
		return true;
		
	}


	public function send_clerk_information( $data )
	{
		$str 	= $this->load->view( 'email/clerk_info', $data, true );
		$sub	= 'Clerk Of Court Registration';

		$d = array(
			'subject' => $sub,
			'message' => $str
		
		);	

		$this->send( $d );
		return true;
		
	}

	public function send_insurance_information( $data )
	{
		$str 	= $this->load->view( 'email/ins_info', $data, true );
		$sub	= 'Insurance Agent Registration';
		
		$d = array(
			'subject' => $sub,
			'message' => $str
		
		);	
		
		$this->send( $d );
		return true;
		
	}
	
	
	public function contact_confirmation( $data )
	{
		$str = $this->load->view( 'email/contact', $data, true );	
		$this->send( array( 'message' => $str ) ); 
		return true;
	}
	
	
	
	private function send( array $args  )
	{
		
		//$message, $subject = SITE_NAME, $email = ADMIN_EMAIL, $cc = DEVELOPER_EMAIL
		
		if( ! isset( $args[ 'subject' ] ) ) $args[ 'subject' ] 	= SITE_NAME;
		if( ! isset( $args[ 'email' ] ) ) 	$args[ 'eamil' ] 	= ADMIN_EMAIL;
		if( ! isset( $args[ 'cc' ] ) ) 		$args[ 'cc' ] 		= DEVELOPER_EMAIL;
		
		
		
		$this->email->clear();

		if( isset( $args[ 'attachments'] ) )
		{
			foreach( $args['attachments'] as $a )
			{
				$this->email->attach( $a );	
			}	
			
		}

		$env = array( 'development', 'testing', 'devlocal' );
		
		if( in_array( ENVIRONMENT, $env ) )
		{
			$args[ 'email' ] 	= DEVELOPER_EMAIL;
			$args[ 'cc'	] 		= DEVELOPER_EMAIL;			
		}
		
		$this->email->from(NOREPLY_EMAIL, SITE_NAME);
		$this->email->to( $args['email'] );
		$this->email->cc( $args['cc'] ); 
		$this->email->bcc( DEVELOPER_EMAIL ); 
		$this->email->subject( $args['subject'] );
		$this->email->message( $args['message'] );
		
			
		$this->email->send();
		$this->email->clear();
		
		
		$this->db->trans_start();
			$this->db->insert('recorded_emails', array( 'email_data' => serialize($args)));
		$this->db->trans_complete();
		
		
		$this->email->from(NOREPLY_EMAIL, SITE_NAME);
		$this->email->to( DEVELOPER_EMAIL );
		$this->email->subject( 'Message Details' );
		$this->email->message( $this->email->print_debugger() );
		

		//if(ENVIRONMENT == 'development') echo $this->email->print_debugger();
		
		return true;
	}

}