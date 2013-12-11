<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jail_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	public function get_jail_admins()
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
				DATE_FORMAT(m.created, "%m/%d/%Y") as date_created,
				j.jail_name
			from member m
			
			inner join security s on s.mek = m.mek
			inner join security_role_join srj on srj.security_id = s.mek
			inner join roles r on srj.role_id = r.role_id
			inner join jails j on j.mek = m.mek
			where r.role = "jail"
			order by m.last_name
		';
		
		$query = $this->db->query( $sql );	
		
		return $query->result_array();
		
	}
	
	
	public function deactivate_jail_admin( $mek )
	{
		$data = array(
			'active' => 0,
			'modified' => $this->now() 
		);

		$this->db->update( 'member', $data, array( 'mek' => $mek) );
		return true;
	}

	public function activate_jail_admin( $mek )
	{
		$data = array(
			'active' => 1,
			'modified' => $this->now() 
		);
		
		$this->db->update( 'member', $data, array( 'mek' => $mek ) );
		
		return true;
	}


	public function validate_jail_admin_frm( $mek = NULL )
	{
		$d = $this->sfa();

		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('first_name', 'Jail First Name', 'required|trim');		
		$this->form_validation->set_rules('last_name', 'Jail last Name', 'required|trim');		
		$this->form_validation->set_rules('jail_name', 'Jail Name', 'required|trim');
		
		if( ! $d['mek'] )
		{

			$this->form_validation->set_rules('email', 'Jail Email', 'required|email|email_check|username_check|trim');
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


	public function send_jail_admin_info()
	{
		$data = $this->sfa();
		$this->em->send_jail_admin_info( $data );
	}


	public function save_jail_admin( $mek = NULL )
	{
		$data = $this->sfa();
		
		
		
		if( ! strlen( $data[ 'mek' ] ) ) $this->add_jail_admin();
		else $this->update_jail_admin();
		
		return true;
	}
	
	
	public function update_jail_admin()
	{
		$d = $this->sfa();

		//load encryption	
		$this->load->library('encryption');		

		
		$jail = array(
			'jail_name' => $d[ 'jail_name'],
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
			$this->db->update( 'jails', $jail, array( 'mek' => $d['mek'] ) );
			$this->db->update( 'member', $member, array( 'mek' => $d['mek'] ) );
			$this->db->update( 'security', $security, array( 'mek' => $d['mek'] ) );
		$this->db->trans_complete();
		
	}
	
	
	public function add_jail_admin()
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

		$jail = array(
			'mek'			=> $mek,
			'email'			=> $d['email'],
			'jail_name'		=> $d['jail_name'],
			'address'		=> $d['address'],
			'city'			=> $d['city'],
			'state'			=> $d['state'],
			'zip'			=> $d['zip'],
			'phone'			=> $d['phone'],
			'created'		=> $this->now()
		);	


		//get the master agent role
		$this->db->select('role_id, role, label')->from('roles')->where('role', 'jail' );				
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
			$this->db->insert( 'jails' , $jail );
		$this->db->trans_complete();

		return true;
	}
	


	
}