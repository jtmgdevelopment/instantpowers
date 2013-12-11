<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class mga_crud_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}

	public function get_insurance_companies( $mek )
	{
		
		$sql = '
			SELECT ia.agency_name, ia.insurance_agency_id, iaaj.insurance_agent_id as mek, ia.agency_name as company
			FROM mga_insurance_join AS mij
			INNER JOIN insurance_agency AS ia ON mij.insurance_agency_id = ia.insurance_agency_id
			INNER JOIN insurance_agency_agent_join AS iaaj on iaaj.insurance_agency_id = mij.insurance_agency_id
			
			WHERE 1 = 1
		';
		
		$sql .= ' AND mij.mga_id = ' . $this->db->escape( $mek );
		
		return $this->db->query( $sql )->result_array();
	}


	public function deactivate_mga_admin( $mek )
	{
		$data = array(
			'active' => 0,
			'modified' => $this->now() 
		);

		$this->db->update( 'member', $data, array( 'mek' => $mek) );
		return true;
	}

	public function activate_mga_admin( $mek )
	{
		$data = array(
			'active' => 1,
			'modified' => $this->now() 
		);
		
		$this->db->update( 'member', $data, array( 'mek' => $mek ) );
		
		return true;
	}
	
	

	public function validate_mga_admin_frm( $mek = NULL )
	{
		$d = $this->sfa();

		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('first_name', 'MGA First Name', 'required|trim');		
		$this->form_validation->set_rules('last_name', 'MGA last Name', 'required|trim');		
		$this->form_validation->set_rules('company_name', 'MGA Company Name', 'required|trim');
		
		if( ! $d['mek'] )
		{

			$this->form_validation->set_rules('email', 'MGA Email', 'required|email|email_check|username_check|trim');
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
			$this->form_validation->set_rules('email', 'MGA Email', 'required|email|email_check|username_check|trim');
		}
		
		return $this->form_validation->run();
	}


	public function send_mga_admin_info()
	{
		$data = $this->sfa();
		$this->em->send_mga_admin_info( $data );
	}


	public function save_mga_admin( $mek = NULL )
	{
		$data = $this->sfa();
		
		
		
		if( ! strlen( $data[ 'mek' ] ) ) $this->add_mga_admin();
		else $this->update_mga_admin();
		
		return true;
	}
	
	
	public function update_mga_admin()
	{
		$d = $this->sfa();

		//load encryption	
		$this->load->library('encryption');		

		
		$mga = array(
			'company_name' => $d[ 'company_name'],
			'email'		=> $d['email'],
			'address'	=> $d['address'],
			'city'		=> $d['city'],
			'state'		=> $d['state'],
			'zip'		=> $d['zip'],
			'phone'		=> $d['phone']
		);
		
		$member = array(
			'first_name' 	=> $d['first_name'],
			'last_name'		=> $d['last_name'],
			'email'			=> $d['email']
		);			
					
		$security = array(
			'username' => $d['email']
		);

		if( strlen( $d['password'] ) ) $security['password'] = $this->encryption->encode( $d['password']);
		
		$this->db->trans_start();
			$this->db->update( 'mgas', $mga, array( 'mek' => $d['mek'] ) );
			$this->db->update( 'member', $member, array( 'mek' => $d['mek'] ) );
			$this->db->update( 'security', $security, array( 'mek' => $d['mek'] ) );
		$this->db->trans_complete();
		
	}
	
	
	public function add_mga_admin()
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

		$mga = array(
			'mek'			=> $mek,
			'email'			=> $d['email'],
			'company_name'	=> $d['company_name'],
			'address'		=> $d['address'],
			'city'			=> $d['city'],
			'state'			=> $d['state'],
			'zip'			=> $d['zip'],
			'phone'			=> $d['phone'],
			'created'		=> $this->now()
		);	

		//create the credits table
		$credits = array(
			'mek'			=> $mek,
			'credit_count' 	=> 0
		);
		


		//get the master agent role
		$this->db->select('role_id, role, label')->from('roles')->where('role', 'mga' );				
		$role = $this->db->get();
		$ins_role = $role->row_array();

		//set the security link array
		$main_security_link = array(
			'security_id'	=> $mek,
			'role_id'		=> $ins_role['role_id']		
		);		

		
		
		//save the main agent
		$this->db->trans_start();
			$this->db->insert( 'member', $member );
			$this->db->insert( 'security', $security );
			$this->db->insert( 'security_role_join', $main_security_link );	
			$this->db->insert( 'mgas' , $mga );
			$this->db->insert( 'credits', $credits );										
		$this->db->trans_complete();

		return true;
	}


	
	public function get_mga_admins( array $a = NULL )
	{

		$sql = '
			select 
				m.first_name, m.last_name, m.full_name, m.email, m.address, m.city, m.state, m.zip, m.phone,m.mek,
				case m.active
					when 1 then "Active"
					when 0 then "Not Active"
					else "Not Active"
				end as active,				
				s.username, r.label,
				DATE_FORMAT(m.created, "%m/%d/%Y") as date_created,
				j.company_name,
				concat( m.full_name, " - ", j.company_name ) as name_company
			from member m
			
			inner join security s on s.mek = m.mek
			inner join security_role_join srj on srj.security_id = s.mek
			inner join roles r on srj.role_id = r.role_id
			inner join mgas j on j.mek = m.mek
			left join mga_insurance_join as mij on mij.mga_id = m.mek
			where r.role = "mga"
			
		';
		
		if( isset( $a[ 'mek' ] ) ) $sql .= ' AND m.mek = ' . $this->db->escape( $a[ 'mek' ] );
		if( isset( $a[ 'active' ] ) && $a[ 'active' ] ) $sql .= ' and m.active = 1';
		if( isset( $a[ 'insurance_agency_id' ]) ) $sql .= ' AND mij.insurance_agency_id = ' . $this->db->escape( $a[ 'insurance_agency_id' ] );
		
		$sql .= ' order by m.last_name';

		$query = $this->db->query( $sql );	
		
		if( isset( $a[ 'obj' ] ) ) return $query->row();
		
		if( isset( $a[ 'mek' ] ) ) return $query->row_array();
		
		return $query->result_array();
	}
}