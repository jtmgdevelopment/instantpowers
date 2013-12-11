<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class member_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}

	public function send_password_info()
	{
		
		$d = $this->sfa();
		
		$mek = $this->db->get_where( 'security', array( 'username' => $d['username'] ) )->row()->mek;		
		
		if( ! isset( $mek ) ) return false;
		
		$email = $this->db->get_where( 'member', array( 'mek' => $mek ) )->row()->email;
				
		//load encryption	
		$this->load->library('encryption');		

		//create the member external key
		$clear_password = uniqid();
		
		//enycrpted password
		$encrypt_pass = $this->encryption->encode( $clear_password );
		
		$this->db->update( 'security', array( 'password' => $encrypt_pass ), array( 'mek' => $mek ) );
		
		$data = array(
			'email' 	=> $email,
			'password'	=> $clear_password		
		);
		
		$this->em->send_password_info( $data );
		
		
		return true;		
	}

	public function validate_password_frm()
	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('username', 'username', 'required|trim');
		return $this->form_validation->run();
		
	}


	
	public function update_member( array $args )
	{
		
		//load encryption	
		$this->load->library('encryption');		
		
		$d  = $this->sfa();
		
		$member = array(
			'first_name' 	=> $d[ 'first_name' ],
			'last_name'		=> $d[ 'last_name' ],
			'address'		=> $d[ 'address' ],
			'city'			=> $d[ 'city' ],
			'state'			=> $d[ 'state' ],
			'zip'			=> $d[ 'zip' ],
			'phone'			=> $d[ 'phone' ],
			'company'		=> $d[ 'company' ],
			'modified'		=> $this->now()
		);	
		
		$security = array();
		
		if( $d[ 'current_email' ] != $d[ 'email' ] )
		{
			$member[ 'email' ] = $d[ 'email' ];	
		}
		
		if( $d['current_username' ] != $d[ 'username' ] )
		{
			$security[ 'username' ] = $d[ 'username' ];	
		}		
		
		if( strlen( $d['password' ] ) )
		{
			$security[ 'password' ] = $this->encryption->encode( $d['password'] );	
		}

		$this->db->trans_start();
			
			$this->db->update( 'member', $member, array( 'mek' => $args[ 'mek' ] ) );			
			if( $d['current_username' ] != $d[ 'username' ] || strlen( $d['password' ] ) )
			{
				$this->db->update( 'security', $security, array( 'mek' => $args[ 'mek' ] ) );
			}

		$this->db->trans_complete();
		
		
		return true;
	}
	
	
	public function validate_update_frm()
	{
		$d = $this->sfa();	
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');		
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');		
		$this->form_validation->set_rules('company', 'Company', 'required|trim');		

		if( $d[ 'current_email' ] != $d[ 'email' ] ) $this->form_validation->set_rules('email', 'Agent Email', 'required|email|email_check|username_check|trim');
		
		if( $d['current_username' ] != $d[ 'username' ] ) $this->form_validation->set_rules('username', 'Username', 'required|email|email_check|username_check|trim');
		
		if( strlen( $d[ 'password' ] ) )
		{
			$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]|trim');		
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim');		
		}
		
		return $this->form_validation->run(); 

	}
	
	
	public function get_member( array $args )
	{
		$sql = '
			SELECT
				m.full_name, m.first_name, m.last_name, m.email, m.address, m.company,
				m.city, m.state, m.zip, m.phone,
				s.password, s.username
			FROM member AS M
			INNER JOIN security AS s
				ON s.mek = m.mek
			WHERE m.mek = ?
		';		
		
		return $this->db->query( $sql, array(  $args[ 'mek' ] ) )->row();
		
	}
	
	
	
	/*validate agents*/
	
	public function validate_agent_frm()
	{

		$data = $this->sfa();
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('full_name', 'Agent Name', 'required|trim');		
		$this->form_validation->set_rules('email', 'Agent Email', 'required|email|email_check|username_check|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[co_password]|trim');		
		$this->form_validation->set_rules('co_password', 'Confirm Password', 'required|trim');		
		
		$this->form_validation->set_rules('agent_license_number', 'Agent License Number', 'required|trim');
		$this->form_validation->set_rules('address', 'Mailing Address', 'required|trim');
		$this->form_validation->set_rules('city', 'City', 'required|trim');
		$this->form_validation->set_rules('state', 'State', 'required|trim');
		$this->form_validation->set_rules('zip', 'Zip', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim');

		$this->form_validation->set_message('matches', 'Your passwords do not match');		
		
		
		for( $i = 0; $i <= 10; $i++ )		
		{
			if( array_key_exists( 'sub_agent_active_' . $i, $data ) )
			{
					
				$this->form_validation->set_rules('sub_agent_name_' . $i, 'Sub Agent Name ' . $i, 'required|trim');		
				$this->form_validation->set_rules('sub_agent_license_number_' . $i, 'Sub Agent License Number ' . $i, 'required|trim');
				$this->form_validation->set_rules('sub_agent_email_' . $i, 'Sub Agent Email ' . $i, 'required|email|email_check|username_check|trim');			
			}
			
		}
		
		return $this->form_validation->run();	
	}
	
	
	public function send_agent_info()
	{
		$data = $this->sfa();
		$this->em->send_admin_agent_info( $data );
	}
	
	
	public function save_agent()
	{
		//load encryption	
		$this->load->library('encryption');		

		//create the member external key
		$mek = uniqid();
		
		//get the main data
		$d = $this->sfa();
		
		//build the main member array
		$main_agent = array(
			'full_name'	=> $d['full_name'],
			'email'		=> $d['email'],
			'mek'		=> $mek,
			'address'	=> $d['address'],
			'city'		=> $d['city'],
			'state'		=> substr( $d['state'], 0, 2 ),
			'zip'		=> $d['zip'],
			'phone'		=> $d['phone'],
			'created'	=> date( 'Y-m-d H:i:s')
		);
		
		//create the bail agency
		$bail_agency = array(
			'agency_name'	=> $d['agency_name'],
			'email'			=> $d['email'],
			'address'		=> $d['address'],
			'city'			=> $d['city'],
			'state'			=> substr( $d['state'], 0, 2 ),
			'zip'			=> $d['zip'],
			'phone'			=> $d['phone'],
			'created_date'	=> date( 'Y-m-d H:i:s')
		
		);
		
		//create the main security array
		$main_security	= array(
			'mek'		=> $mek,
			'username'	=> $d['email'],
			'password'	=> $this->encryption->encode( $d['password'] )					
		);
		
		
		$bail_agent = array(
			'mek'				=> $mek,
			'license_number'	=> $d['agent_license_number'],
			'created_date'		=> date( 'Y-m-d H:i:s')
		);
		
		$main_ins_agencies = array();
		/*		
		for( $i = 0; $i < count( $d['insurance_agency'] ); $i++)
		{
			$main_ins_agencies[] = array(
				'bail_agent_id' => $mek,
				'insurance_agency_id' => $d['insurance_agency'][ $i ]
			);
		} 
		*/
		
		//get the master agent role
		$this->db->select('role_id, role, label')->from('roles')->where('role', 'master_agent' );				
		$role = $this->db->get();
		$master_agent_role = $role->row_array();

		//get the sub agent role
		$this->db->select('role_id, role, label')->from('roles')->where('role', 'sub_agent' );				
		$role = $this->db->get();
		$sub_agent_role = $role->row_array();

	
		//set the security link array
		$main_security_link = array(
			'security_id'	=> $mek,
			'role_id'		=> $master_agent_role['role_id']		
		);
				
		//create the credits table
		$credits = array(
			'mek'			=> $mek,
			'credit_count' 	=> 0
		);

		
		//save the main agent
		$this->db->trans_start();
			$this->db->insert( 'member', $main_agent );
			$this->db->insert( 'security', $main_security );
			$this->db->insert( 'security_role_join', $main_security_link );	
			//$this->db->insert_batch('bail_insurance_join', $main_ins_agencies); 

			$this->db->insert( 'bail_agency', $bail_agency );	
			$bail_agency_id =  $this->db->insert_id();

			
			//join the bail agency and agent
			$bail_agency_join = array(
				'bail_agency_id' 	=> $bail_agency_id,
				'bail_agent_id'		=> $mek
			);
			
			$this->db->insert( 'bail_agent', $bail_agent );	
			$this->db->insert( 'bail_agency_agent_join', $bail_agency_join );
			$this->db->insert( 'credits', $credits );		
		$this->db->trans_complete();
		
		
		//get the sub agents array
		for( $i = 0; $i <= 10; $i++ )		
		{			
			if( array_key_exists( 'sub_agent_active_' . $i, $d ) )
			{
				//create a password for the agent
				$clear_password 	= $this->generate_password();
				//create the encrypted password
				$encrypt_password 	= $this->encryption->encode( $clear_password );
				//create the sub agent mek
				$sub_mek			= uniqid();
								
				//fill the data array
				$sub_agent = array(
					'full_name'	=> $d['sub_agent_name_' . $i],
					'email'		=> $d['sub_agent_email_' . $i],
					'mek'		=> $sub_mek,
					'created'	=> date( 'Y-m-d H:i:s')			
				);
				
				//fill the security array
				$sub_security = array(				
					'username'	=> $d['sub_agent_email_' . $i],
					'password'	=> $encrypt_password,	
					'mek'		=> $sub_mek							
				);				

				//set the sub security role array
				$sub_security_link = array(
					'security_id'	=> $sub_mek,
					'role_id'		=> $sub_agent_role['role_id']
				);

				//set the master/sub array
				$master_sub = array(
					'master_id'	=> $mek,
					'sub_id'	=> $sub_mek
				);
				
				//create the sub agent
				$sub_bail_agent = array(
					'mek'				=> $sub_mek,
					'license_number'	=> $d['sub_agent_license_number_' . $i],
					'created_date'		=> date( 'Y-m-d H:i:s'),
					'is_sub_agent'		=> 1
				);
				
				//email array
				$email_data = array(
					'username'		=> $d['sub_agent_email_' . $i],
					'email'			=> $d['sub_agent_email_' . $i],
					'password'		=> $clear_password,
					'bail_agency'	=> $d['agency_name']
				);
				
				
				//create the credits table
				$sub_credits = array(
					'mek'			=> $sub_mek,
					'credit_count' 	=> 0
				);
				
				//bail ins join
				$sub_ins_agencies = array();
				
				for( $k = 0; $k < count( $d['insurance_agency'] ); $k++)
				{
					$sub_ins_agencies[] = array(
						'bail_agent_id' => $sub_mek,
						'insurance_agency_id' => $d['insurance_agency'][ $k ]
					);
				} 
			
				
				//save the sub agent
				$this->db->trans_start();
					$this->db->insert( 'member', $sub_agent );
					$this->db->insert( 'security', $sub_security );
					$this->db->insert( 'security_role_join', $sub_security_link );
					$this->db->insert( 'master_sub_join', $master_sub );		
					$this->db->insert( 'bail_agent', $sub_bail_agent );	
					$this->db->insert_batch('bail_insurance_join', $sub_ins_agencies); 
					
					//join the bail agency and agent
					$bail_agency_join = array(
						'bail_agency_id' 	=> $bail_agency_id,
						'bail_agent_id'		=> $sub_mek
					);
					
					$this->db->insert( 'bail_agency_agent_join', $bail_agency_join );
					$this->db->insert( 'credits', $sub_credits );										
				$this->db->trans_complete();


				//need to create the sub agent notify email
				$this->em->notify_sub_agent_creation( $email_data );
				
				
			}
		}
		


		return true;		
	}
	
	
	
	public function validate_clerks_frm()
	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('court_name', 'Clerks Of Courts Name', 'required|trim');		
		$this->form_validation->set_rules('county', 'County Name', 'required|trim');		
		$this->form_validation->set_rules('clerk_name', 'Clerk Administrator Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|email|email_check|username_check|trim');
		$this->form_validation->set_rules('physical_address', 'Physical Address', 'required|trim');
		$this->form_validation->set_rules('mailing_address', 'Mailing Address', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim');
		return $this->form_validation->run(); 
		
	}

	public function send_clerk_info()
	{
		$data = $this->sfa();
		$this->em->send_clerk_information( $data );
		return true;
	}




	public function validate_insurance_frm()
	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('company_name', 'Insurance Company Name', 'required|trim');		
		$this->form_validation->set_rules('agent_name', 'Agent Name', 'required|trim');		
		$this->form_validation->set_rules('email', 'Email', 'required|email|email_check|username_check|trim');
		$this->form_validation->set_rules('physical_address', 'Physical Address', 'required|trim');
		$this->form_validation->set_rules('mailing_address', 'Mailing Address', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim');
		return $this->form_validation->run();
		
	}

	public function send_insurance_info()
	{
		$data = $this->sfa();
		$this->em->send_insurance_information( $data );
		return true;
	}


	public function validate_jail_frm()
	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('jail_name', 'Jail Name', 'required|trim');		
		$this->form_validation->set_rules('county', 'County', 'required|trim');	
		$this->form_validation->set_rules('jail_admin', 'Jail Administrator', 'required|trim');			
		$this->form_validation->set_rules('email', 'Email', 'required|email|email_check|username_check|trim');
		$this->form_validation->set_rules('physical_address', 'Physical Address', 'required|trim');
		$this->form_validation->set_rules('mailing_address', 'Mailing Address', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim');
		return $this->form_validation->run();
		
	}

	public function send_jail_info()
	{
		$data = $this->sfa();
		$this->em->send_jail_information( $data );
		return true;
	}
	
	
	public function get_insurance_agencies()
	{
		$ins = array();
		$sql = '
			select agency_name, insurance_agency_id as ins_id
			from insurance_agency
			order by agency_name
		';
		$query = $this->db->query( $sql );
		
		$ret = $query->result_array();
			
		foreach( $ret as $key )
		{
			$ins[ $key[ 'ins_id' ] ] = $key[ 'agency_name' ];
			
		} 
		
		return $ins;
	}

}