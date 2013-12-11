<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	public function validate_sub_agent_history_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
	
		$this->form_validation->set_rules('name', 'Full Name', 'required|trim');		
		$this->form_validation->set_rules('email', 'Email', 'required|email|trim');		
		$this->form_validation->set_rules('subject', 'Subject', 'required|trim');
		$this->form_validation->set_rules('message', 'Message', 'required|trim');


		return $this->form_validation->run();
		
		
	}



*/

class ins_agency_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
			
	}
	
	
	public function get_insurance_company_by_transmission( $trans_id )
	{
		$sql = '
			SELECT i.agency_name 
			FROM insurance_agency as i
			INNER JOIN transmission AS t ON t.insurance_company_id = i.insurance_agency_id 
			WHERE t.transmission_id = ' . $this->db->escape( $trans_id );
		
		
		return $this->db->query( $sql )->row();
		
		
	}
	
	
	
	public function list_agencies()
	{
		$this->load->model( 'insurance/insurance_crud_model', 'ins' );
		
		$ins_company = $this->ins->get_insurance_companies_by_agent( array( 'mek' => $this->session->userdata( 'mek' ), 'row' => true ) );
		
		$sql = "
				SELECT distinct m.mek, agency_name, m.full_name 
				FROM bail_insurance_join AS bij

				INNER JOIN bail_agent AS ba on ba.mek = bij.bail_agent_id
				INNER JOIN bail_agency_agent_join AS baaj ON baaj.bail_agent_id = ba.mek 						
				INNER JOIN bail_agency AS baa ON baa.bail_agency_id = baaj.bail_agency_id 			
				INNER JOIN member AS m ON m.mek = ba.mek
				WHERE is_sub_agent = 0
				AND m.active = 1
			";
		
		$sql .= ' AND bij.insurance_agency_id = ' . $this->db->escape( $ins_company->insurance_agency_id );	
		
		return $this->db->query( $sql )->result_array();
	}

	public function list_mgas()
	{
		$this->load->model( 'insurance/insurance_crud_model', 'ins' );
		
		$ins_company = $this->ins->get_insurance_companies_by_agent( array( 'mek' => $this->session->userdata( 'mek' ), 'row' => true ) );
		
		$sql = "
				SELECT distinct m.mek, mga.company_name, m.full_name 
				FROM mga_insurance_join AS mga_join

				INNER JOIN member AS m ON m.mek = mga_join.mga_id
				INNER JOIN mgas AS mga on mga.mek = m.mek
				WHERE 1 = 1 
			";
		
		$sql .= ' AND mga_join.insurance_agency_id = ' . $this->db->escape( $ins_company->insurance_agency_id );	
		
		return $this->db->query( $sql )->result_array();
	}

	public function add_mga_to_insurance( $mek )
	{
		$this->load->model( 'insurance/insurance_crud_model', 'ins' );

		//insurance company id
		$ins_company = $this->ins->get_insurance_companies_by_agent( array( 'mek' => $this->session->userdata( 'mek' ), 'row' => true ) );

		$this->db->trans_start();
						
			$data = array(
				'mga_id'         		=> $mek,
				'insurance_agency_id'   => $ins_company->insurance_agency_id
			);
			$this->db->insert( 'mga_insurance_join', $data );
		$this->db->trans_complete();		
		
		return TRUE;		
	}
	
	public function verify_direct_relationship( $mek, $ins_id )
	{
		
		$this->load->model( 'insurance/insurance_crud_model', 'ins' );

		$mgas = $this->ins->get_mgas_from_insurance_companies( $ins_id );
		
		$meks = array();
		
		foreach( $mgas as $mga )
		{
			$meks[] = $mga[ 'mek' ];
			
		}
		
	
		$sql = '
			SELECT bail_mga_id
			FROM bail_mga_join
			WHERE bail_agent_id = ' . $this->db->escape( $mek );
		
		$sql .=  " AND mga_id in ( '" . implode( ',', $meks ) . "')";
		
		
		$q = $this->db->query( $sql );
		
		return $q->num_rows();
		
	}
	
	public function add_agency_to_insurance( $mek )
	{
		
		$this->load->model( 'agent/crud_model', 'agent' );
		$this->load->model( 'insurance/insurance_crud_model', 'ins' );
		
		//get all sub agent meks
		$agents = $this->agent->get_sub_agents( array( 'mek' => $mek ) );

		//insurance company id
		$ins_company = $this->ins->get_insurance_companies_by_agent( array( 'mek' => $this->session->userdata( 'mek' ), 'row' => true ) );

		//insert all meks into the dbo.insurance_agency_agent_join
		$this->db->trans_start();
			
			foreach( $agents as $agent )
			{
				$data = array(
					'bail_agent_id'        => $agent[ 'mek' ],
					'insurance_agency_id'  => $ins_company->insurance_agency_id
				);				
				
				$this->db->insert( 'bail_insurance_join', $data );				
			}
			
			$data = array(
				'bail_agent_id'         => $mek,
				'insurance_agency_id'   => $ins_company->insurance_agency_id
			);
		
			$this->db->insert( 'bail_insurance_join', $data );
		$this->db->trans_complete();		
		
		return TRUE;		
	}
	
	public function get_agency( $license )
	{
		$this->load->model( 'insurance/insurance_crud_model', 'ins' );
		$ins_company = $this->ins->get_insurance_companies_by_agent( array( 'mek' => $this->session->userdata( 'mek' ), 'row' => true ) );

		$sql = "
			SELECT ba.mek, m.full_name, baa.agency_name, ba.license_number 
			FROM bail_agent as ba
			INNER JOIN bail_agency_agent_join as baaj ON baaj.bail_agent_id = ba.mek 			
			INNER JOIN bail_agency as baa ON baa.bail_agency_id = baaj.bail_agency_id 			
			INNER JOIN member as m ON m.mek = ba.mek
			 
			WHERE 1 = 1
			AND ba.is_sub_agent = 0
			
			
		";
		
		$sql .= ' AND ba.mek NOT IN ( SELECT bail_agent_id from bail_insurance_join WHERE bail_agent_id = ( select mek from bail_agent where license_number = ' . $this->db->escape( $license ) . '   and insurance_agency_id = ' . $this->db->escape( $ins_company->insurance_agency_id ) . ' limit 1  ) )';
		
		$sql .= ' AND ba.license_number = ' . $this->db->escape( $license );
		
		$sql .= ' LIMIT 1';
		
		return $this->db->query( $sql )->row();
		
		
	}
	

	public function get_mga( $email )
	{
		$this->load->model( 'insurance/insurance_crud_model', 'ins' );
		$ins_company = $this->ins->get_insurance_companies_by_agent( array( 'mek' => $this->session->userdata( 'mek' ), 'row' => true ) );

		$sql = "
			SELECT m.mek, m.full_name, mga.company_name 
			FROM mgas as mga
			INNER JOIN member as m ON m.mek = mga.mek
			 
			WHERE 1 = 1
			
		";
		
		$sql .= ' AND m.mek NOT IN ( SELECT mga_id from mga_insurance_join WHERE mga_id = ( select mek from mgas where email = ' . $this->db->escape( $email ) . '   and insurance_agency_id = ' . $this->db->escape( $ins_company->insurance_agency_id ) . ' limit 1 ) )';
		
		$sql .= ' AND mga.email = ' . $this->db->escape( $email );
		
		$sql .= ' LIMIT 1';
		
		return $this->db->query( $sql )->row();
		
	}


	
	public function validate_add_agency_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('license_number', 'License Number', 'required|trim');		

		return $this->form_validation->run();

		
	}


	public function validate_add_mga_frm()
	{
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('email', 'License Number', 'required|email|trim');		

		return $this->form_validation->run();

		
	}

}