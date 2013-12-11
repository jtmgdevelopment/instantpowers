<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class insurance_model extends MY_Model {



    public function __construct()

    {

        // Call the Model constructor

        parent::__construct();

		

	}

	
	public function get_agent( array $args = array())

	{

		$sql = '

			select 

				m.first_name, m.last_name, m.email, m.address, m.city, m.state, m.zip, m.phone,m.mek,

				case m.active

					when 1 then "Active"

					when 0 then "Not Active"

					else "Not Active"

				end as active,				

				s.username, r.label,

				ia.agency_name,

				DATE_FORMAT(m.created, "%m/%d/%Y") as date_created

			from member m

			

			inner join security s on s.mek = m.mek

			inner join security_role_join srj on srj.security_id = s.mek

			inner join roles r on srj.role_id = r.role_id

			inner join insurance_agency_agent_join iaaj on iaaj.insurance_agent_id = m.mek

			inner join insurance_agency ia on ia.insurance_agency_id = iaaj.insurance_agency_id
			
			where m.mek = ?
			
			order by m.last_name

		';

		
		return $this->db->query( $sql, array( $args['mek'] ) )->row();	

	}



	public function get_agents( array $args = array())

	{

		$sql = '

			select 

				m.first_name, m.last_name, m.email, m.address, m.city, m.state, m.zip, m.phone,m.mek,

				case m.active

					when 1 then "Active"

					when 0 then "Not Active"

					else "Not Active"

				end as active,				

				s.username, r.label,

				ia.agency_name,

				DATE_FORMAT(m.created, "%m/%d/%Y") as date_created

			from member m

			

			inner join security s on s.mek = m.mek

			inner join security_role_join srj on srj.security_id = s.mek

			inner join roles r on srj.role_id = r.role_id

			inner join insurance_agency_agent_join iaaj on iaaj.insurance_agent_id = m.mek

			inner join insurance_agency ia on ia.insurance_agency_id = iaaj.insurance_agency_id

			order by m.last_name

		';

		
		$query = $this->db->query( $sql );	

		return $query->result_array();

	}

	

	

	public function deactivate_agent( $mek )

	{

		$data = array(

			'active' => 0,

			'modified' => $this->now() 

		);



		$this->db->update( 'member', $data, array( 'mek' => $mek) );

		return true;

	}



	public function activate_agent( $mek )

	{

		$data = array(

			'active' => 1,

			'modified' => $this->now() 

		);

		

		$this->db->update( 'member', $data, array( 'mek' => $mek ) );

		

		return true;

	}





	public function validate_agent_frm( $mek = NULL )
	{

		$d = $this->sfa();

		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('first_name', 'Jail First Name', 'required|trim');		
		$this->form_validation->set_rules('last_name', 'Jail last Name', 'required|trim');		
		$this->form_validation->set_rules('agency_name', 'Agency Name', 'required|trim');
		
		if( ! $d['mek'] )
		{

			$this->form_validation->set_rules('email', 'Agency/Agent Email', 'required|email|email_check|username_check|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]|trim');		
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim');				
		}
		else if( strlen( $d['password'] ) )
		{
			$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]|trim');		
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim');				
		}
		
		if( $d[ 'mek' ] && $d['email'] != $d['existing_email'] )	
		{
			$this->form_validation->set_rules('email', 'Jail Email', 'required|email|email_check|username_check|trim');
		}
		
		return $this->form_validation->run();

	}





	public function send_agent_info()

	{

		$data = $this->sfa();

		$this->em->send_insurance_agent_info( $data );

	}




	public function save_agent( $mek = NULL )

	{

		$data = $this->sfa();

		if( ! strlen( $data[ 'mek' ] ) ) $this->add_agent();

		else $this->update_agent();

		return true;
	}

	
	
	public function update_agent()
	{
		$d = $this->sfa();

		//load encryption	
		$this->load->library('encryption');		
		
		$agency = array(
			'agency_name' 	=> $d[ 'agency_name'],
			'email'			=> $d['agency_email'],
			'address'		=> $d['agency_address'],
			'city'			=> $d['agency_city'],
			'state'			=> $d['agency_state'],
			'zip'			=> $d['agency_zip'],
			'phone'			=> $d['agency_phone'],
			'modified'		=> $this->now()
		);
		
		$member = array(
			'first_name' 	=> $d['first_name'],
			'last_name'		=> $d['last_name'],
			'email'			=> $d['email'],
			'address'		=> $d['address'],
			'city'			=> $d['city'],
			'state'			=> $d['state'],
			'zip'			=> $d['zip'],
			'phone'			=> $d['phone'],
			'modified'		=> $this->now()
		);			
					
		$security = array(
			'username' => $d['email']
		);
		
		
		if( strlen( $d['password'] ) ) $security['password'] = $this->encryption->encode( $d['password']);
		
		
		
		$agency_id = $this->db->select( 'insurance_agency_id' )
						->get_where( 'insurance_agency_agent_join', array( 'insurance_agent_id' => $d[ 'mek' ] ) )
						->row();
		
		
		$this->db->trans_start();
			$this->db->update( 
				'insurance_agency', 
				$agency, 
				array( 
					'insurance_agency_id' => $agency_id->insurance_agency_id 
				) 
			);
			$this->db->update( 'member', $member, array( 'mek' => $d['mek'] ) );
			$this->db->update( 'security', $security, array( 'mek' => $d['mek'] ) );
		$this->db->trans_complete();

		return true;
	}
	

	

	public function add_agent()

	{

		//load encryption	

		$this->load->library('encryption');		

		

		$mek 	= uniqid();

		$d 		= $this->sfa();

		

		//member array

		$member = array(

			'mek'			=> $mek,

			'first_name'	=> $d['first_name'],

			'last_name'		=> $d['last_name'],

			'email'			=> $d['email'],

			'full_name'		=> $d['first_name'] . ' ' . $d['last_name'],

			'address'		=> $d['address'],

			'city'			=> $d['city'],

			'state'			=> $d['state'],

			'zip'			=> $d['zip'],

			'phone'			=> $d['phone'],

			'created'		=> $this->now(),

			'ip'			=> $d['ip']

		);	

		

		//security array		

		$security = array(

			'username'	=> $d['email'],

			'password'	=> $this->encryption->encode( $d['password']),

			'mek'		=> $mek

		);



		//get the master agent role

		$this->db->select('role_id, role, label')->from('roles')->where('role', 'insurance' );				

		$role = $this->db->get();

		$ins_role = $role->row_array();



		//set the security link array

		$main_security_link = array(

			'security_id'	=> $mek,

			'role_id'		=> $ins_role['role_id']		

		);		



		

		//agency array

		$agency = array(

			'agency_name'	=> $d['agency_name'],

			'email'			=> $d['email'],

			'address'		=> $d['address'],

			'city'			=> $d['city'],

			'state'			=> $d['state'],

			'zip'			=> $d['zip'],

			'phone'			=> $d['phone'],

			'created'		=> $this->now()

		);	



		//save the main agent

		$this->db->trans_start();

			$this->db->insert( 'member', $member );

			$this->db->insert( 'security', $security );

			$this->db->insert( 'security_role_join', $main_security_link );	

			$this->db->insert( 'insurance_agency', $agency );	



			$agency_id =  $this->db->insert_id();

			

			//join the bail agency and agent

			$ins_agency_join = array(

				'insurance_agency_id' 	=> $agency_id,

				'insurance_agent_id'	=> $mek

			);

			

			$this->db->insert( 'insurance_agency_agent_join', $ins_agency_join );

			

		$this->db->trans_complete();



		return true;

	}

	

	

}