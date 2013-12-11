<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class offline_power_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model( 'jail/jail_crud_model', 'j' );
		$this->load->model( 'agent/crud_model', 'b' );
		$this->load->helper('file');
		
		
	}
	
	public function move_image()
	{
		$photo = $this->session->userdata( 'security_image' );
		$path = './photo/';
		$write_path	= './uploads/images/';
		//get file
		$f = read_file( $path . $photo );
		
		//if file found
		if( $f )
		{
			$fp = fopen( $write_path . $photo, 'w');
			fwrite($fp, $f);
			fclose($fp);
			unlink( $path . $photo );
		}
		return true;		
	}
	
	
	public function update_offline_power_status( array $args )
	{
			
		if( $args[ 'status' ] == 'accept' )
		{
			$this->db->update( 
				'offline_powers', 
				array( 'accepted' => 1 ), 
				array( 'offline_power_id' => $args['offline_pek'] ) 
			);	
			
			#notify the agent of acceptance
			$offline_power = $this->get_offline_power( array( 'offline_power_id' => $args['offline_pek' ] ) );
			$this->em->notify_agent_accepted_offline_power( $offline_power );

		}
		else if( $args[ 'status' ] == 'decline' )	
		{

			$this->db->update( 
				'offline_powers', 
				array( 'accepted' => 0, 'declined' => 1 ), 
				array( 'offline_power_id' => $args['offline_pek'] ) 
			);	
			
			#notify the agent of acceptance
			$offline_power = $this->get_offline_power( array( 'offline_power_id' => $args['offline_pek' ] ) );
			
			
			$this->em->notify_agent_voided_offline_power( $offline_power );
			
		}

		return true;

	}
	
	public function get_offline_power( array $args )
	{

		$sql = "
			SELECT 
				op.offline_power_id, op.power, DATE_FORMAT( op.created, '%c/%m/%Y' ) as created , op.defendant_name, op.pek, op.amount, op.prefix,
				m.full_name, m.email, j.jail_name,
				agency.agency_name
			FROM offline_powers AS op
			INNER JOIN member AS m
				ON m.mek = op.mek
			INNER JOIN bail_agent AS ba
				ON ba.mek = m.mek
			INNER JOIN bail_agency_agent_join AS baaj
				ON baaj.bail_agent_id = ba.mek
			INNER JOIN bail_agency AS agency
				ON agency.bail_agency_id = baaj.bail_agency_id		
			
			INNER JOIN jails AS j
				ON j.jail_id = op.jail_id	
				
			WHERE op.offline_power_id = ?
		";

		return $this->db->query( $sql , array( $args['offline_power_id'] ) )->row();
		
	}
	
	public function list_offline_powers( array $args )
	{
		
		if( ! isset( $args[ 'accepted' ] ) ) $args[ 'accepted' ] = 0;
		
		$sql = "
			SELECT 
				op.offline_power_id, op.power, DATE_FORMAT( op.created, '%c/%m/%Y' ) as created , op.defendant_name, op.pek, op.amount, op.prefix, op.photo,
				m.full_name,
				agency.agency_name
			FROM offline_powers AS op
			INNER JOIN member AS m
				ON m.mek = op.mek
			INNER JOIN bail_agent AS ba
				ON ba.mek = m.mek
			INNER JOIN bail_agency_agent_join AS baaj
				ON baaj.bail_agent_id = ba.mek
			INNER JOIN bail_agency AS agency
				ON agency.bail_agency_id = baaj.bail_agency_id			
			WHERE op.jail_id = ?
			AND op.accepted = ?
			AND op.declined IS NULL
			ORDER BY op.created DESC
		";
		
		
		
		
		
		return $this->db->query( $sql, $args )->result_array();
	}
	
	
	public function validate_power_prefix()
	{
		$d = $this->sfa();	
		
		$sql = "
			SELECT offline_power_id
			FROM offline_powers AS pp
			WHERE 1 = 1
			AND prefix = ? AND amount = ? AND pek = ?
		";
		
		$num_rows = $this->db->query( $sql, array( $d['prefix'], $d['amount'], $d['pek']) )->num_rows();		
		
		if( $num_rows > 0 ) return false;
		
		return true;
	}
	
	
	public function validate_offline_frm()
	{

		$this->sfa();
		
		$this->form_validation->set_error_delimiters('<li>', '</li>');		
		$this->form_validation->set_rules('jail_name', 'Jail', 'required|trim');		
		$this->form_validation->set_rules('defendant_name', 'Defendant Name', 'required|trim');		
		return $this->form_validation->run();
		
		
	}
	
	public function save_offline_power( array $args )
	{
		$this->db->trans_start();
			$this->db->insert( 'offline_powers' , $args );
		$this->db->trans_complete();	
		return true;	
		
		
	}
	
	
	
	
	public function notify_jail_offline_power( array $args )
	{
		$args['jail'] 	= $this->j->get_jails( $args[ 'jail_id' ] );	
		$args['agent']	= $this->b->get_agents( $args[ 'mek' ] );	
		
		$this->em->notify_jail_offline_power( $args );
		
		return true;
		
	}


}