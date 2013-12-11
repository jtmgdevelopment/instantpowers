<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class powers extends Agent_Controller {

	private $view;
	private $mek;

	public function __construct()
	{
		parent::__construct();
		
		$this->role 	= $this->session->userdata( 'role' );
		$this->view 	= $this->role . '/powers/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->images	= realpath( './uploads/images/' );
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->load->model( 'transmissions/transmissions_model' , 't' );
		$this->load->model( 'credits/credits_model', 'c' );
		$this->load->model( 'powers/power_model', 'p' );
		$this->load->model( 'agent/crud_model', 'b' );
		$this->load->model( 'jail/jail_crud_model', 'j' );
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');		
		$this->template->add_js( '_assets/js/powers/powers.js' );

	}
	


	/*
		START EXECUTE A POWER
	*/

	public function execute( $trans_id, $pek, $prefix_id )
	{

		$view = 'index';
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->mek, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id, $pek, 0, NULL, $prefix_id ),
			'power_status'	=> $this->p->get_power_status()	,
			'power'			=> array(),
			'trans_id'		=> $trans_id,
			'pek'			=> $pek,
			'has_defendant'	=> $this->session->userdata( 'defendant' ),
			'has_agent'		=> $this->session->userdata( 'executing_agent' )
		);
		
		$this->check_transmission( $d['transmission']->paid );
		
		if( $d[ 'powers' ]->status == 'Inventory Bond' ) $view = 'create_power';

		$this->template->write('title', 'View Power');
		$this->template->write('sub_title', 'Please the following fill in the required information to complete this power');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
	
	
	}
	
	public function process_step_one()
	{
		$d = $this->sfa();
		
		if( $this->p->validate_step_one() )
		{
			$this->p->save_step_one();	
				
			//redirect the user to the the defendant page if the select to add a defendant
			if( isset( $_POST[ 'add_defendant'] ) ) redirect( '/master_agent/powers/step_two/' . $d[ 'trans_id' ] . '/' . $d[ 'pek' ] . '/' . $d[ 'prefix_id' ] );
			//redirect the user to the summary page
			else redirect( '/master_agent/powers/step_three/' . $d[ 'trans_id' ] . '/' . $d[ 'pek' ] . '/' . $d[ 'prefix_id' ] );
				
		}
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->execute( $d[ 'trans_id' ], $d[ 'pek' ], $d[ 'prefix_id' ] );				
		}
	}

	
	
	public function step_two( $trans_id, $pek, $prefix_id )
	{
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->mek, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id, $pek, 0, NULL, $prefix_id ),
			'power_status'	=> $this->p->get_power_status(),
			'sp'			=> $this->p->convert_json( $this->p->get_saved_power( $pek ) ) //saved power
		);

		$this->check_transmission( $d['transmission']->paid );

		$this->template->write('title', 'Defendant Information');
		$this->template->write('sub_title', 'Please add in the defendant information');
		$this->template->write_view('content', $this->view . 'create_defendant', $d);
		$this->template->render();		
	
	}
	





	public function process_step_two()
	{
		if( $this->p->validate_step_two() )
		{
			$this->p->save_step_two();	
			redirect( '/master_agent/powers/step_three/' . $this->input->post( 'trans_id' ) . '/' . $this->input->post( 'pek' ) . '/' . $this->input->post( 'prefix_id' ) );
		}
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->step_two( $this->input->post( 'trans_id' ), $this->input->post( 'pek' ), $this->input->post( 'prefix_id' ) );				
		}
	}
	




	public function step_three( $trans_id, $pek, $prefix_id )
	{	
		if( $this->session->userdata( 'print' ) ) redirect( '/master_agent/power_inventory' );
		
		$this->p->add_to_batch( $trans_id, $pek );
	
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->mek, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id, $pek, 0, NULL, $prefix_id ),
			'power_status'	=> $this->p->get_power_status(),
			'sp'			=> $this->p->get_saved_power( $pek ), //saved power
			'batch'			=> $this->session->userdata( 'batch' )
		);
		

		$this->check_transmission( $d['transmission']->paid );

		$this->template->write('title', 'View Power');
		$this->template->write('sub_title', 'Please choose how to complete your power');
		$this->template->write_view('content', $this->view . 'summary', $d);
		$this->template->render();		
	
	}
	




	public function batch_powers( $trans_id, $pek )
	{
		$this->p->update_batch( $trans_id, $pek );
		
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->mek, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id ),
			'power_status'	=> $this->p->get_power_status(),
			'sp'			=> $this->p->get_saved_power( $pek ), //saved power,
			'batch'			=> $this->session->userdata( 'batch' )
		);
		
	

		$this->check_transmission( $d['transmission']->paid );

		$this->template->write('title', 'Choose A Power To Batch');
		$this->template->write('sub_title', 'Please choose another power to batch');
		$this->template->write_view('content', $this->view . 'add_power_batch', $d);
		$this->template->render();		
			
		
		
	}
	




	public function cancel_power( $trans_id, $pek )
	{
		$this->p->delete_saved_power( $trans_id, $pek );
		redirect( '/master_agent/transmissions' );		
	}
	


	public function print_power( $trans_id, $is_batch, $prefix_id )
	{	
		$batch = $this->session->userdata( 'batch' );
		
		$msg = 'You have already printed this power.';
//		if( ! $batch ) $this->set_message( $msg, 'info', '/master_agent/power_inventory' );
		
//		$this->session->set_userdata( 'print', true );
		$this->p->save_offline_power();
		$url = '/generate_power_pdf.cfm?power=' .  implode( $batch, ',' ) . '&trans_id=' . $trans_id . '&batch=' . $is_batch. '&prefix_id=' . $prefix_id . '&mek=' . $this->mek;
		
		redirect( $url );
		
	}




	public function process_execute_power_frm()
	{
		
		if( $this->p->validate_execution_power() )
		{
			
			$d = $this->sfa();
			$batch = $this->session->userdata( 'batch' );	
				
				
			dd( $batch );	
						
			
//			$url = safe_url( '/master_agent/powers', 'set_identification', array( $d[ 'trans_id' ], $d[ 'pek' ], $d[ 'prefix_id' ], $d[ 'jail_name' ] ) );
			
			redirect( $url );


			
			$photo = $this->images . '\\' . $this->session->userdata( 'security_image' );
			$this->p->save_powers( $photo );


			$this->p->send_notifications( $this->mek, $this->input->post( 'trans_id' ), $this->input->post( 'pek' ) );	
			$this->session->unset_userdata( 'batch' );
			$this->session->unset_userdata( 'defendant' );
			$this->session->unset_userdata( 'executing_agent' );
			
			$credits = $this->c->get_credits( $this->mek );
			
			$this->c->update_credits_amount( $this->mek, 1, $credits->credit_count );
			
			$msg = 'Your transmission was successfully sent!';
			$this->set_message( $msg, 'done', '/master_agent/transmissions' );
			
		}	
		else
		{
			$trans_id 	= $this->input->post( 'trans_id' );
			$pek		= $this->input->post( 'pek' );
			
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->execute_power( $trans_id, $pek );		
		}
	}
	

	public function execute_power( $trans_id, $pek, $prefix_id)			
	{
		
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->mek, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id, $pek, 0, NULL, $prefix_id ),
			'power_status'	=> $this->p->get_power_status(),
			'sp'			=> $this->p->convert_json( $this->p->get_saved_power( $pek ) ), //saved power
			'agent'			=> $this->b->get_agents( $this->mek ),
			'batch'			=> implode( $this->session->userdata( 'batch' ), ', ' ),
			'credits'		=> $this->c->get_credits( $this->mek ),
			'jails'			=> $this->j->create_select_array()
		);


		if( $d[ 'credits']->credit_count == 0 )  $this->set_message( 'You have 0 credits, please purchase more credits', 'error', '/master_agent/manage_credits' );


		$this->check_transmission( $d['transmission']->paid );
		
		$this->template->write('title', 'Send Power Electronically');
		$this->template->write('sub_title', 'Please fill out the form below to send this power electronically to the prison of your choice.');
		$this->template->write_view('content', $this->view . 'execute_power', $d);
		$this->template->render();		
			
		
	}

	
	public function view_power( $trans_id, $pek, $prefix_id )
	{
		$batch = $this->session->userdata( 'batch' );
		
		$d = array(
			'sp'				=> $this->p->convert_json( $this->p->get_saved_power() ),
			'transmission'		=> $this->t->get_transmission( $this->mek, $trans_id),
			'powers'			=> $this->p->get_powers( $trans_id, $pek, 0, NULL, $prefix_id ),
			'agent'				=> $this->b->get_agents( $this->mek ),
			'batch'				=> implode( $batch, ',' ),
			'is_batch'			=> true,
			'defendant'			=> $this->session->userdata( 'defendant' ),
			'executing_agent'	=> $this->session->userdata( 'executing_agent' )
		);
	
		$this->load->view( $this->view . 'power_template/power_created', $d );		
	}
	


	public function set_identification( $trans_id, $pek, $prefix_id, $jail_id )
	{
		


		$view = 'set_indentification';
		$d = array(
			'transmission'	=> $this->t->get_transmission( $this->mek, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id, $pek, 0, NULL, $prefix_id ),
			'power_status'	=> $this->p->get_power_status()	,
			'power'			=> array()	
		);
		

		$this->check_transmission( $d['transmission']->paid );
		

		$this->template->write('title', 'Set Indentification');
		$this->template->write('sub_title', 'Please Upload Indentification');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
		
	}
	
	public function process_photo()
	{
		$photo = end( explode( '/', $this->input->post( 'photo' ) ) );
		
		$this->session->set_userdata( 'security_image', $photo  );		
		
		exit( json_encode( 'done' ) );
	}




	/*
		END EXECUTE A POWER
	*/


	
	





















	









	
	
	
	






	private function check_transmission( $trans )
	{
		if( $trans == 'Not Paid' ) show_error( 'You do not have access to this power.', 403 );				
	}



	
	
	/*START DISCHARGE A POWER*/

	
	public function process_discharge_frm()
	{
		if( $this->p->validate_discharge_frm() )
		{
			$this->p->discharge_power();	
			$msg = 'You successfully discharged the power';
			$this->set_message( $msg, 'done', '/master_agent/transmissions/view/' . $this->input->post( 'trans_id' ) );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->discharge( $this->input->post( 'trans_id' ), $this->input->post( 'pek' ) );
		}
	}
	
	
	
	
	public function discharge( $trans_id, $pek )
	{
		
		$view = 'discharge_power';
		$d = array(
			'transmission'	=> $this->t->get_transmissions( $this->mek, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id, $pek ),
			'power_status'	=> $this->p->get_power_status()	,
			'power'			=> array()	
		);


		$this->check_transmission( $d['transmission']->paid );
		

		$this->template->write('title', 'Discharge Power');
		$this->template->write('sub_title', 'The following form will discharge this power');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

		
	}


	/*END DISCHARGE A POWER*/



	/*
		SHOULD BE MOVED ELSE WHERE
	*/


	public function view_history( $pek, $prefix_id )
	{
		
		$d = array(
			'history' => $this->p->get_power_history( $pek, $prefix_id )
		);
		
		$this->template->write('title', 'View Power History');
		$this->template->write('sub_title', 'Your power history is below');
		$this->template->write_view('content', $this->view . 'history', $d);
		$this->template->render();		
		
	}



	
	


	/*START VOIDING A POWER*/
	
	public function process_void_frm()
	{
		if( $this->p->validate_void_frm() )
		{
			$this->p->void_power();	
			$msg = 'You successfully voided the power';
			$this->set_message( $msg, 'done', '/master_agent/transmissions/view/' . $this->input->post( 'trans_id' ) );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->discharge( $this->input->post( 'trans_id' ), $this->input->post( 'pek' ) );
		}
	}


	public function void( $trans_id, $pek )
	{
		
		$view = 'void_power';
		$d = array(
			'transmission'	=> $this->t->get_transmissions( $this->mek, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id, $pek ),
			'power_status'	=> $this->p->get_power_status()	,
			'power'			=> array()	
		);


		$this->check_transmission( $d['transmission']->paid );
		

		$this->template->write('title', 'Void Power');
		$this->template->write('sub_title', 'The following form will void this power');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

		
	}


	/*END VOIDING A POWER*/
	


	
	
	/*ARCHIVED METHODS*/
	
	public function process_indentity_frm()
	{

		$config['upload_path'] 		= $this->images;
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '1000';
		$config['max_width']  		= '1024';
		$config['max_height']  		= '768';
		$config['encrypt_name']		= true;
		
		$this->load->library('upload', $config);
		//remove validation for now. 
		if ( ! $this->upload->do_upload( 'identity_image' ))
		{
			$this->upload->display_errors('<li>', '</li>');
			$error = array('error' => $this->upload->display_errors());
			
			$this->template->write( 'errors', $this->set_errors($this->upload->display_errors()));
			$this->set_identification( $this->input->post( 'trans_id' ), $this->input->post( 'pek' ) );
		}
		else
		{
			$indentity_data = array('upload_data' => $this->upload->data());
			$allowed_exts = array( 'jpg', 'png', 'gif' );
			$ext = str_replace( '.', '', $indentity_data[ 'upload_data' ][ 'file_ext' ] );
			
			if( ! in_array( $ext, $allowed_exts ) )
			{
				$errors = '<li>Only JPG, PNG, GIF images are allowed</li>';
				$this->template->write( 'errors', $this->set_errors($errors));
				$this->index();
				return false;
			}
			
			$d = array(
				'photo'	=> $indentity_data[ 'upload_data' ],
				'pek'	=> $this->input->post( 'pek' )
			);
			
			$this->p->add_identity_photo( $d );
			
			$msg = 'Identity image successfully uploaded';					
			$this->set_message( $msg, 'done' , '/master_agent/powers/execute_power/'  . $this->input->post( 'trans_id' ) . '/' . $this->input->post( 'pek' ) );
			
		}				
		
	}
	
	
	
	
	public function view( $trans_id, $pek, $prefix_id )
	{
		//$url = '/photo/epower_photo.html?role=' . $this->session->userdata( 'role' ) . '&trans_id=' . $trans_id . '&pek=' . $pek;
		$url = '/master_agent/powers/execute/' . $trans_id . '/' . $pek . '/' . $prefix_id;
		redirect( $url );
	}


	
}

