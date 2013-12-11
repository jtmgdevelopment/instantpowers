<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class offline_powers extends Sub_Agent_Controller {

/*
	things that need to be done:
	* on upload hide the "X"
	* look for files fields with temp files
	* grab those files rename and upload to PDF folder
	* if 2 or more add to a zip file/ or attach all to email
	* clear the files from the temp folder
	* write scheduled task to delete the temp folder

*/

	private $view;
	private $mek;

	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'sub_agent/offline/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->pdf 		= realpath( './uploads/pdf/' );
		$this->images	= realpath( './uploads/images/' );
		
		
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->load->helper('file');		
		$this->load->model( 'powers/offline_power_model', 'p' );
		$this->load->model( 'credits/credits_model', 'c' );
		$this->load->model( 'agent/crud_model', 'b' );
		$this->load->model( 'jail/jail_crud_model', 'j' );
		$this->template->add_js( '_assets/js/utils/underscore/underscore-min.js' );
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');		
		$this->template->add_js( '_assets/js/powers/powers.js' );
		$this->template->add_js( '_assets/uploadify/jquery.uploadify-3.1.min.js' );
		$this->template->add_css( '_assets/uploadify/uploadify.css' );



	}

	
	public function process_photo()
	{
		$photo = end( explode( '/', $this->input->post( 'photo' ) ) );
		
		$this->session->set_userdata( 'security_image', $photo  );		
		
		exit( json_encode( 'done' ) );
	}
	
	public function process_offline_frm()
	{
		
		$files 	= explode( ',', $this->input->post( 'files' ) );
		$temp_path 	= './uploads/temp/';
		$write_path	= './uploads/pdf/';
		
		
		try{
			if( count( $files ) )
			{
				$filesArray = array();
				
				foreach( $files as $file )
				{
					
					if( strlen( $file ) )
					{
						//get file
						$f = read_file( $temp_path . $file );
						//if file found
						if( $f )
						{
							$new_file_name = uniqid() . '.pdf';
							$fp = fopen( $write_path . $new_file_name, 'w');
							fwrite($fp, $f);
							fclose($fp);
							unlink( $temp_path . $file );
							$filesArray[] = $this->pdf . '\\' . $new_file_name;	
						}
					}
				}
			}
		}
		catch( Exception $e ){}
		
		
		
		
		if( ! $this->p->validate_offline_frm() ) 
		{
			$this->template->write( 'errors', $this->set_errors( validation_errors() ));
			$this->index();
			return false;
		}
	
	
		if( ! $this->p->validate_power_prefix() )
		{
			$errors = '<li>This power already exists, please try another power</li>';
			$this->template->write( 'errors', $this->set_errors( $errors ));
			$this->index();
			return false;
			
		}	
		
		

		if ( ! count( $filesArray ) )
		{
			$errors = '<li>You have not added any offline powers. Please try again to upload the powers.</li>';
			$this->template->write( 'errors', $this->set_errors( $errors ));
			$this->index();
			return false;
		}
		else
		{

			$power_data = array(
				'photo' 			=> $this->images . '\\' . $this->session->userdata( 'security_image' ),
				'power'				=> implode( ',', $filesArray ),
				'mek'				=> $this->mek,
				'created' 			=> $this->now(),
				'jail_id'			=> $this->input->post( 'jail_name' ),
				'defendant_name'	=> $this->input->post( 'defendant_name' ),
				'pek'				=> $this->input->post( 'pek' ),
				'amount'			=> $this->input->post( 'amount' ),
				'prefix'			=> $this->input->post( 'prefix' )
			);
			

			$this->p->save_offline_power( $power_data );
			$this->p->notify_jail_offline_power( $power_data );		
			
			$credits = $this->c->get_credits( $this->mek );
			$this->c->update_credits_amount( $this->mek, 1, $credits->credit_count );
					
		
			$msg = 'Offline Power Uploaded Successfully & Sent to Jail';					
			$this->set_message( $msg, 'done' , '/sub_agent/cpanel' );

		}				
		
	}
	
	public function upload_powers()
	{
		
	}
	

	public function index()
	{
		$view = 'index';
		$this->template->add_js( '_assets/js/powers/upload_offline_powers.js' );

		$d = array(
			'credits'		=> $this->c->get_credits( $this->mek ),
			'jails'			=> $this->j->create_select_array()
		);
		

		
		if( $d[ 'credits']->credit_count == 0 )  $this->set_message( 'You have 0 credits, please purchase more credits', 'error', '/sub_agent/manage_credits' );
		
		$this->p->move_image();
		

		$this->template->write('title', 'Offline Power');
		$this->template->write('sub_title', 'Use the form to submit an offline power');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	
	
	}
}

