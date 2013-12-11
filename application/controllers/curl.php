<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class curl extends MY_Controller {

	private $view;
	private $mek;


	public function __construct()
	{
		parent::__construct();
		if( $this->session->userdata( 'is_valid' ) ) $this->validate_login();	
	
	}


	public function curl_login()
	{
		$d = $this->sfa();
		$this->load->library('encryption');
		
		if( $d[ 'username' ] == 'curllogin' && $this->encryption->decode( $d[ 'password' ] ) == 'password' )
		{
			$d[ 'is_valid' ] = true;
			$this->output->set_status_header('200');
			$this->session->set_userdata( $d );
		}
		else
		{
			$this->output->set_status_header('401');
		}
	}
	
	public function print_accepted_jail_powers()
	{
		$this->output->set_status_header('200');
		set_time_limit(0);
		$this->load->model( 'agent/crud_model', 'agent' );
		$this->load->model( 'jail/jail_print_model', 'print' );
		$this->load->library( 'zip' );
		$this->load->helper( 'file' );

		$d = $this->sfa();
		$html = '';
		
		
		$folder_name = uniqid();
		$folder_path = realpath('./uploads/downloads/') . '/' . $folder_name . '/';
		mkdir( $folder_path );
		chmod( $folder_path , 0777 );
		
		//get the power info from the report_id
		$this->load->model( 'jail/jail_print_model', 'print' );		
		$powers = $this->print->get_power_info( $d[ 'report_id' ] );
		$files	= array();
		$powersTxt	= '';
		
		
		foreach( $powers as $key => $val )
		{
			$data = array(
				'power' => $val
			);
		
			$data[ 'agent' ] = ( $val[ 'transferred' ] == 'Transferred' ?  $this->agent->get_sub_agent_by_power( array( $val[ 'power_id' ] ) ) : $this->agent->get_agent_by_power( array( $val[ 'power_id' ] ) ) );

			$powersTxt .=  $val[ 'prefix'] . '-' .$val[ 'pek' ] . "\n";
			
			$filename = strtolower( str_replace(' ','_', $val[ 'agency_name' ] ));
			
			$html .= $this->load->view('print/powers/' . $filename . '_power', $data, true);		

			$p = 'power_' . $val[ 'prefix' ] . '-' . $val[ 'pek' ] . '.pdf';	
			$files[] = $p;
			$file = pdf_create($html, 'filename', false );
			$html = '';
			write_file( $folder_path . $p, $file );
			$this->zip->add_data( $p, $file );


		}

		$this->zip->add_data( 'POWER_LIST.txt', $powersTxt );		
		write_file( $folder_path . 'powers.zip' , $this->zip->get_zip() ); 
		
		$email = array(
			'zip'	=> $folder_path . 'powers.zip',
			'email'	=> $d[ 'email' ]
		);
		
		$this->db->update( 'jail_accepted_powers_report', array( 'zip_path'=> $folder_name . '/powers.zip' ), array( 'batch_report_id' => $d[ 'report_id' ] ) );
		
		$this->em->send_power_copies( $email );
		return true;
		
	}
	
	
	public function print_powers()
	{		
		$this->output->set_status_header('200');
		set_time_limit(0);
		$this->load->model( 'agent/crud_model', 'agent' );
		$this->load->model( 'insurance/ins_print_model', 'print' );
		$this->load->library( 'zip' );
		$this->load->helper( 'file' );

		$d = $this->sfa();
		$html = '';
		
		
		$folder_name = uniqid();
		$folder_path = realpath('./uploads/downloads/') . '/' . $folder_name . '/';
		mkdir( $folder_path );
		chmod( $folder_path , 0777 );

		$powers = $this->print->get_power_info( $d[ 'report_id' ]);
		$agent	= $this->agent->get_master_agent( array( 'mek' => $d[ 'mek' ] ) );
		$files	= array();
		$powersTxt	= '';
		
		foreach( $powers as $key => $val )
		{
			$data = array(
				'power' => $val,
				'agent'	=> $agent
			);
			
			$powersTxt .=  $val[ 'prefix'] . '-' .$val[ 'pek' ] . "\n";
			
			$filename = strtolower( str_replace(' ','_', $val[ 'agency_name' ] ));
			
			$html .= $this->load->view('print/powers/' . $filename . '_power', $data, true);		

			$p = 'power_' . $val[ 'prefix' ] . '-' . $val[ 'pek' ] . '.pdf';	
			$files[] = $p;
			$file = pdf_create($html, 'filename', false );
			$html = '';
			write_file( $folder_path . $p, $file );
			$this->zip->add_data( $p, $file );
		}	
		

		$this->zip->add_data( 'POWER_LIST.txt', $powersTxt );		
		write_file( $folder_path . 'powers.zip' , $this->zip->get_zip() ); 
		
		$email = array(
			'zip'	=> $folder_path . 'powers.zip',
			'email'	=> $d[ 'email' ]
		);
		
		$this->em->send_power_copies( $email );
		delete_files( $folder_path );
		return true;
	}
	
	public function end_session()
	{
		$this->output->set_status_header('200');
		$this->session->sess_destroy();
	}
		
	private function validate_login()
	{
		if( $this->session->userdata( 'is_valid' ) && 
			$this->session->userdata( 'username' ) == 'curllogin' && 
			$this->encryption->decode( $this->session->userdata( 'password' ) ) == 'password' )
		{
			return true;	
		}
		else
		{
			$this->output->set_status_header('401');
			$this->session->sess_destroy();
			die('RESTRICTED!');
		}
	}
}
