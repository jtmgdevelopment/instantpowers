<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authenticate_model extends MY_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	
	public function get_members()
	{
		
		$sql = '
			select 
			m.full_name, s.username, r.role, ba.agency_name
			from member as m
			inner join security as s on m.mek = s.mek
			inner join security_role_join as srl on srl.security_id = s.mek
			inner join roles as r on r.role_id = srl.role_id
			left join bail_agency_agent_join as baaj on baaj.bail_agent_id = m.mek
			left join bail_agency as ba on ba.bail_agency_id = baaj.bail_agency_id
			
			where m.active = 1
			order by r.role, ba.agency_name, m.full_name
		';
		
		return $this->db->query( $sql )->result_array(); 	
	}
	
	
	public function private_login()
	{
		
			$sql = '
				select 
					s.username, 
					m.full_name, m.email, m.mek,
					r.role	
				
				from member as m
				inner join security as s on m.mek = s.mek
				inner join security_role_join as srl on srl.security_id = s.mek
				inner join roles as r on r.role_id = srl.role_id
				where
					s.username = ?
			';
			
			$username = $this->input->post('username');

			$query = $this->db->query($sql, array($username)); 
			$row = $query->row_array(); 

			
			$this->session->set_userdata('logged_in', TRUE);	
			$this->session->set_userdata('username', $row['email']);
			$this->session->set_userdata('mek', $row['mek']);
			$this->session->set_userdata('email', $row['email']);
			$this->session->set_userdata('full_name', $row['full_name']);
			$this->session->set_userdata('role', $row['role']);
			
			
			return TRUE;
		
	}
	
	
	public function validate_login(){
			
		//validate the login form
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if( ! $this->form_validation->run()) return FALSE;
		
		$this->load->library('encryption');
		$password = $this->encryption->encode($password);

		$query = $this->db->get_where('security', array('username' => $username,'password' => $password, 'active' => 1)); 		



		if($query->num_rows() == 1)
		{
					
			$sql = '
				select 
					s.username, 
					m.full_name, m.email, m.mek,
					r.role	
				
				from member as m
				inner join security as s on m.mek = s.mek
				inner join security_role_join as srl on srl.security_id = s.mek
				inner join roles as r on r.role_id = srl.role_id
				where
					s.username = ? 
				and
					s.password = ?
				and 
					s.active = ?
			';

			$query = $this->db->query($sql, array($username, $password, 1)); 
			$row = $query->row_array(); 

			
			$this->session->set_userdata('logged_in', TRUE);	
			$this->session->set_userdata('username', $row['email']);
			$this->session->set_userdata('mek', $row['mek']);
			$this->session->set_userdata('email', $row['email']);
			$this->session->set_userdata('full_name', $row['full_name']);
			$this->session->set_userdata('role', $row['role']);
			
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	private function validate_email()
	{
		//validate the login form
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		$response = array('success' => TRUE);
		if( ! $this->form_validation->run()) $response['success'] = FALSE;
		
		return $response;
		
	}
	
	public function retrieve_password()
	{
		$response = $this->validate_email();
		
		if( ! $response['success']) return $response;
		
		$email = $this->input->post('email');
		
		$query = $this->db->get_where('member', array('email' => $email));
		
		if($query->num_rows() == 0)
		{
			$this->session->set_flashdata('message', 'We could not find your email address, please try again.');
			$this->session->set_flashdata('message_type', 'alert');
			$response['redirect'] = TRUE;
			return $response;
		}
		
		$row = $query->row_array(); 
		$query = $this->db->get_where('security', array('member_external_key' => $row['member_external_key']));
		
		if($query->num_rows() > 0)
		{	
			$this->load->library('encryption');
			$row = $query->row_array(); 
			$username = $row['username'];
			$password = $this->encryption->decode($row['password']);
		}
		
		$this->load->library('email');

		$email_message = 
			'
				<h2>Forget Credentials</h2>
				<p>Your credentials are below:</p>
				<ul>
					<li>Username: ' . $username . '</li>
					<li>Password: ' . $password . '</li>
				</ul>	
				<p>Click <a href="' . site_url("login") .'">here</a> to login</p>
			';
		
		$data = array('message' => $email_message);
		$string = $this->load->view('email/index', $data, true);
		
		$this->email->clear();
		$this->email->to($email);
		$this->email->from(NOREPLY_EMAIL);
		$this->email->subject('Hung Like A Mule -> Forget Credentials');
		$this->email->message($string);
		$this->email->send();

		$response['succcess'] = TRUE;
		return $response;
	}
}
