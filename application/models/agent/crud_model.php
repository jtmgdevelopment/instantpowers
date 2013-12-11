<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class crud_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	public function is_danzy_member( $session )
	{
		//find out if the agent is a sub agent
		if( $session[ 'role' ] == 'sub_agent' )
		{
			//get the master agent
			$master = $this->get_sub_agent_master( array( 'sub_mek' => $session[ 'mek' ] ) );
			
			$master = $this->get_master_agent( array( 'mek' => $master->master_id ) );
			
			if( strtolower( $master->full_name ) == 'derrick danzy' ) return true;
			
		}		
		//if not then see if the agent has an mga
		if( $session[ 'role' ] == 'master_agent' )
		{
			$mga = $this->get_master_mga( array( 'mek' => $session[ 'mek' ] ) );
			
			if( count( $mga ) > 0 )
			{
				$this->load->model( 'mga/mga_crud_model', 'mga' );
				
				$mga = $this->mga->get_mga_admins( array( 'mek' => $mga->mga_id ) );	

				if( strtolower( $mga[ 'full_name' ] ) == 'derrick danzy' ) return true;
			}
			
			
		}		

		return false;
	}
	
	
	public function get_transmiting_agencies( $mek )
	{

		$sql = '
			SELECT DISTINCT t.insurance_agent_id as mek, ia.agency_name as company
			FROM  insurance_agency_agent_join AS iaaj ON iaaj.insurance_agent_id = t.insurance_agent_id
			INNER JOIN insurance_agency AS ia ON ia.insurance_agency_id = iaaj.insurance_agency_id
			WHERE t.bail_agent_id = ' . $this->db->escape( $mek ) . '  
				
			UNION 
			
			SELECT DISTINCT t.mga_id as mek, mga.company_name as company
			FROM transmission AS t
			INNER JOIN mgas AS mga ON mga.mek = t.mga_id
			WHERE t.bail_agent_id = ' . $this->db->escape( $mek )
			;
		
		
	}
	
	public function get_transmission_agencies( $mek )
	{
		/*
		$sql = '
			SELECT DISTINCT t.insurance_agent_id as mek, ia.agency_name as company
			FROM transmission as t
			INNER JOIN insurance_agency_agent_join AS iaaj ON iaaj.insurance_agent_id = t.insurance_agent_id
			INNER JOIN insurance_agency AS ia ON ia.insurance_agency_id = iaaj.insurance_agency_id
			WHERE t.bail_agent_id = ' . $this->db->escape( $mek ) . '  
				
			UNION 
			
			SELECT DISTINCT t.mga_id as mek, mga.company_name as company
			FROM transmission AS t
			INNER JOIN mgas AS mga ON mga.mek = t.mga_id
			WHERE t.bail_agent_id = ' . $this->db->escape( $mek )
			;
		*/
		

		$sql = '
			SELECT DISTINCT mga.mek as mek, mga.company_name as company
			FROM mgas as mga
			INNER JOIN bail_mga_join as bmj
				ON bmj.mga_id = mga.mek
			WHERE
				bmj.bail_agent_id = ' . $this->db->escape( $mek ) . '
					
			UNION 

			SELECT DISTINCT ia.mek as mek, iaa.agency_name
			FROM bail_insurance_join as bij
			INNER JOIN insurance_agency_agent_join as iaaj
				ON iaaj.insurance_agency_id = bij.insurance_agency_id
			INNER JOIN member AS ia
				ON ia.mek = iaaj.insurance_agent_id
			INNER JOIN insurance_agency AS iaa
				ON iaa.insurance_agency_id = bij.insurance_agency_id	
			WHERE
				bij.bail_agent_id = ' . $this->db->escape( $mek ) . '
			';
		
		
		return $this->db->query( $sql )->result_array();
	}
	
	
	public function validate_ins_contract_frm()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('ins_agency', 'Insurance Company', 'required|trim');		
		
		return $this->form_validation->run();
	}
	
	public function get_master_mga( array $a = NULL )
	{
		$sql = '
			SELECT mga_id 
			FROM bail_mga_join msj
			WHERE 1 = 1
		';	
		
		if( isset( $a[ 'mek' ] ) ) $sql .= ' AND bail_agent_id = ' . $this->db->escape( $a[ 'mek' ] );
		
		
		return $this->db->query( $sql )->row();
	}
	

	
	public function get_sub_agent_master( array $a = NULL )
	{
		$sql = '
			SELECT master_id 
			FROM master_sub_join msj
			WHERE 1 = 1
		';	
		
		if( isset( $a[ 'sub_mek' ] ) ) $sql .= ' AND sub_id = ' . $this->db->escape( $a[ 'sub_mek' ] );
		
		
		return $this->db->query( $sql )->row();
	}
	
	
	public function get_master_agent( array $a = NULL )
	{
		$sql = "
			SELECT 
			m.full_name, m.first_name, m.last_name, m.email, m.mek,
			ba.license_number,
			case ba.is_sub_agent
				when 1 then 'Sub Agent'  
				when 0 then 'Master Agent'
				else 'Sub Agent'
			end as agent_type,
			
			bac.agency_name,
			bac.address,
			bac.city,
			bac.state,
			bac.zip,
			bac.phone,
			bac.bail_agency_id,
			ba.is_sub_agent,
			concat( bac.agency_name, ' ~ ', m.full_name ) as name_company
			FROM member as m
			INNER JOIN bail_agent AS ba 
				ON ba.mek = m.mek
			INNER JOIN bail_agency_agent_join baaj 
				ON baaj.bail_agent_id = m.mek
			INNER JOIN bail_agency bac 
				ON bac.bail_agency_id = baaj.bail_agency_id		
			WHERE 1 = 1	
			AND ba.is_sub_agent = 0
		";	
		
		if( isset( $a[ 'mek' ] ) ) $sql .= " AND m.mek = " . $this->db->escape( $a[ 'mek' ] );		
		
		if( isset( $a[ 'agency_id' ] ) ) $sql .=  ' AND bac.bail_agency_id = ' . $this->db->escape( $a[ 'agency_id' ] );
		
		if( isset( $a[ 'agency_id' ] ) || isset( $a[ 'mek' ] ) ) $sql .= ' LIMIT 1';
		
		$q = $this->db->query( $sql );

		if( $q->num_rows() == 1 ) return $q->row();
		
		return $q->result_array();
		
	}
	
	
	public function add_sub_agent( $master_mek )
	{

		//create the member external key
		$mek = uniqid();

		$master_agent 	= $this->get_agents( $master_mek );
		$ins_ids		= $this->get_agent_insurance_companies( $master_mek );

		//bail ins join
		$sub_ins_agencies = array();

		foreach( $ins_ids as $i )
		{
			$sub_ins_agencies[] = array(
				'bail_agent_id' => $mek,
				'insurance_agency_id' => $i['insurance_agency_id']
			);
		}

		//load encryption	
		$this->load->library('encryption');		


		//get the main data
		$d = $this->sfa();

		$member = array(
			'mek'			=> $mek,
			'first_name' 	=> $d['first_name'],
			'last_name'		=> $d['last_name'],
			'full_name'		=> $d['full_name'],
			'email'			=> $d['email'],
			'address'		=> $d['address'],
			'city'			=> $d['city'],
			'state'			=> $d['state'],
			'zip'			=> $d['zip'],
			'phone'			=> $d['phone'],
			'company'		=> $d[ 'company' ],
			'created'		=> $this->now()
		);
		
		$agent = array(
			'mek'				=> $mek,
			'license_number' 	=> $d['license_number'],
			'created_date'		=> $this->now(),
			'is_sub_agent'		=> 1
		);

		$security = array(
			'mek'				=> $mek,
			'username' 			=> $d['email'],
			'password'			=> $this->encryption->encode( $d['password'] )
		);

		$role = $this->db->select('role_id, role, label')->from('roles')->where('role', 'sub_agent' )->get()->row()->role_id;
		

		//set the security link array
		$security_link = array(
			'security_id'	=> $mek,
			'role_id'		=> $role		
		);

		//create the credits table
		$sub_credits = array(
			'mek'			=> $mek,
			'credit_count' 	=> 0
		);

		//set the master/sub array
		$master_sub = array(
			'master_id'	=> $master_mek,
			'sub_id'	=> $mek
		);



		//join the bail agency and agent
		$bail_agency_join = array(
			'bail_agency_id' 	=> $master_agent->bail_agency_id,
			'bail_agent_id'		=> $mek
		);


		//email array
		$email_data = array(
			'username'		=> $d['email'],
			'email'			=> $d['email'],
			'password'		=> $d['password'],
			'bail_agency'	=> $master_agent->agency_name
		);


		//save the sub agent
		$this->db->trans_start();

			$this->db->insert( 'member', $member );
			$this->db->insert( 'security', $security );
			$this->db->insert( 'security_role_join', $security_link );
			$this->db->insert( 'bail_agent', $agent );	
			$this->db->insert( 'master_sub_join', $master_sub );		
			$this->db->insert( 'credits', $sub_credits );										
			$this->db->insert( 'bail_agency_agent_join', $bail_agency_join );
//			$this->db->insert_batch('bail_insurance_join', $sub_ins_agencies); 
			
		$this->db->trans_complete();


		//need to create the sub agent notify email
		$this->em->notify_sub_agent_creation( $email_data );

		return true;
	}

	public function get_agent_insurance_companies( $mek )
	{
		$sql = "
			SELECT DISTINCT insurance_agency_id
			FROM bail_insurance_join
			WHERE 1 = 1 AND bail_agent_id = ?	
		";	
		
		return $this->db->query( $sql, array( $mek ) )->result_array();
	}
	
	
	public function update_sub_agent( array $form )
	{
		$member = array(
			'first_name' 	=> $form['first_name'],
			'last_name'		=> $form['last_name'],
			'full_name'		=> $form['full_name'],
			'email'			=> $form['email'],
			'address'		=> $form['address'],
			'city'			=> $form['city'],
			'state'			=> $form['state'],
			'zip'			=> $form['zip'],
			'phone'			=> $form['phone'],
			'company'		=> $form[ 'company' ],
			'modified'		=> $this->now()
		);
		
		$agent = array(
			'license_number' 	=> $form['license_number'],
			'modified_date'		=> $this->now()
		);
		
		$this->db->trans_start();
			$this->db->update( 'member', $member, array( 'mek' => $form[ 'mek' ] ) );
			$this->db->update( 'bail_agent', $agent, array( 'mek' => $form[ 'mek' ] ) );
		$this->db->trans_complete();	
				
		return true;		
	}
	
	public function validate_sub_agent_add()
	{
		$d = $this->sfa();
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');		
		$this->form_validation->set_rules('license_number', 'License Number', 'required|trim');		
		$this->form_validation->set_rules('email', 'Agent Email', 'required|email|email_check|username_check|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]|trim');		
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim');		
		
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');		
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');		
		$this->form_validation->set_rules('email', 'Email', 'required|email|trim');		
		$this->form_validation->set_rules('company', 'Company', 'required|trim');		
		
		return $this->form_validation->run();
	}



	public function validate_sub_agent_edit()
	{
		$d = $this->sfa();
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');		
		$this->form_validation->set_rules('license_number', 'License Number', 'required|trim');		
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');		
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');		
		$this->form_validation->set_rules('email', 'Email', 'required|email|trim');		
		$this->form_validation->set_rules('company', 'Company', 'required|trim');		
		
		if( $d['orig_email'] != $d['email'] ) $this->form_validation->set_rules('email', 'Agent Email', 'required|email|email_check|username_check|trim');
		
		return $this->form_validation->run();
	}
	
	public function activate_agent( array $args )
	{
		return $this->db->update( 'member', array( 'active' => 1 ), array( 'mek' => $args['mek'] ) );	
	}


	public function deactivate_agent( array $args )
	{
		return $this->db->update( 'member', array( 'active' => 0 ), array( 'mek' => $args['mek'] ) );	
	}
	
	
	public function create_sub_select_array( $mek )
	{
		$t = $this->get_sub_agents( array( 'mek' => $mek ) );
		$z =  array('' => 'Please Select Sub Agent');
		foreach( $t as $val ) $z[ $val[ 'mek' ] ] = $val[ 'full_name' ];
		
		return $z;
		
	}

	
	public function get_agent_by_transmission( array $args )
	{
		$sql = "
			SELECT m.full_name, m.email, m.mek
			
			FROM power AS p
			
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id
			INNER JOIN member AS m
				ON m.mek = t.bail_agent_id
			WHERE p.pek = ? AND p.prefix_id = ?
		";
		
		return $this->db->query( $sql, $args )->row();
				
	}


	
	public function get_sub_agent_by_power( array $args )
	{
		$sql = "
			SELECT m.full_name, m.email, m.mek, m.address, m.city, m.state, m.zip, m.phone, m.company
	
			FROM power_sub_agent_join AS psaj
			
			INNER JOIN member AS m
				ON m.mek = psaj.mek
			
			WHERE psaj.power_id = ? 
		
		";
		
		return $this->db->query( $sql, $args )->row();	
		
		
	}


	public function get_agent_by_power( array $args )
	{
		$sql = "
			SELECT m.full_name, m.email, m.mek, m.address, m.city, m.state, m.zip, m.phone, m.company
	
			FROM power AS p
			
			INNER JOIN transmission AS t
				ON t.transmission_id = p.transmission_id				
			
			INNER JOIN member AS m
				ON m.mek = t.bail_agent_id
			
			WHERE p.power_id = ? 
		
		";
		
		return $this->db->query( $sql, $args )->row();	
		
		
	}

	
	
	public function get_sub_agents( array $args = NULL )
	{
		$sql = "
			SELECT m.mek, m.full_name, m.email, ms.master_id, ba.license_number, m.company,
				m.first_name, m.last_name, m.phone, m.city, m.address, m.state, m.zip,
			CASE m.active
				WHEN 1 THEN 'Active' 
				WHEN 0 THEN 'Not Active'
				ELSE 'Not Active'
			END AS active,
			DATE_FORMAT( '%m/%d/%Y', m.created ) AS created
			FROM master_sub_join AS ms
			INNER JOIN member AS m
				ON m.mek = ms.sub_id
			INNER JOIN bail_agent AS ba 
				ON ba.mek = m.mek
			INNER JOIN bail_agency_agent_join baaj 
				ON baaj.bail_agent_id = m.mek
			INNER JOIN bail_agency bac 
				ON bac.bail_agency_id = baaj.bail_agency_id		

			WHERE 1 = 1 
		";
		
		if( isset( $args[ 'mek' ] ) ) $sql .= 'AND ms.master_id = ' . $this->db->escape( $args['mek'] );
		if( isset( $args[ 'sub_mek' ] ) ) $sql .= 'AND ms.sub_id = ' . $this->db->escape( $args['sub_mek'] );
		
		if( isset( $args[ 'sub_mek' ] ) ) return $this->db->query( $sql )->row();
		return $this->db->query( $sql )->result_array();
				
	}
	
	public function get_agency_by_agent( array $a )
	{
		$sql = '
			SELECT bail_agency_id 
			FROM bail_agency_agent_join
			WHERE 1 = 1
		';	
		
		$sql .= ' AND bail_agent_id = ' . $this->db->escape( $a[ 'mek' ] );
		
		return $this->db->query( $sql )->row_array();
		
	}
	
	
	public function get_agents( $mek = NULL )
	{
		$sql = "
			SELECT 
			m.full_name, m.first_name, m.last_name, m.email, m.company,
			ba.license_number,
			case ba.is_sub_agent
				when 1 then 'Sub Agent'  
				when 0 then 'Master Agent'
				else 'Sub Agent'
			end as agent_type,
			bac.agency_name,
			m.address,
			m.city,
			m.state,
			m.zip,
			m.phone,
			bac.bail_agency_id,
			m.mek
			FROM member as m
			INNER JOIN bail_agent AS ba 
				ON ba.mek = m.mek
			INNER JOIN bail_agency_agent_join baaj 
				ON baaj.bail_agent_id = m.mek
			INNER JOIN bail_agency bac 
				ON bac.bail_agency_id = baaj.bail_agency_id		
		";	
		
		if( $mek ) $sql .= "WHERE m.mek = " . $this->db->escape( $mek );		
		
		$q = $this->db->query( $sql );
		
		if( $q->num_rows() == 1 ) return $q->row();
		
		return $q->row_array();
		
	}
}