<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class powers extends Sub_Agent_Controller {

	private $view;
	private $mek;
	private $images;
	private $master_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'sub_agent/powers/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->images	= realpath( './uploads/images/' );		
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->load->model( 'transmissions/transmissions_model' , 't' );
		$this->load->model( 'credits/credits_model', 'c' );
		$this->load->model( 'powers/power_model', 'p' );
		$this->load->model( 'agent/crud_model', 'b' );
		$this->load->model( 'jail/jail_crud_model', 'j' );
		$this->load->model( 'powers/power_sub_agent_history_model', 'history' );
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');		
		$this->template->add_js( '_assets/js/powers/powers.js' );

		$this->master_id = $this->b->get_sub_agents( array( 'sub_mek' => $this->mek ) )->master_id;


	}
	
	
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
			$this->set_message( $msg, 'done' , '/sub_agent/powers/execute_power/'  . $this->input->post( 'trans_id' ) . '/' . $this->input->post( 'pek' ) );
			
		}				
		
	}
	
	
	public function set_identification( $trans_id, $pek )
	{
		


		$view = 'set_indentification';
		$d = array(
			'transmission'	=> $this->t->get_transmissions( $this->mek, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id, $pek ),
			'power_status'	=> $this->p->get_power_status()	,
			'power'			=> array()	
		);


		$this->check_transmission( $d['transmission']->paid );
		

		$this->template->write('title', 'Set Indentification');
		$this->template->write('sub_title', 'Please Upload Indentification');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
		
	}
	
	
	public function process_void_frm()
	{
		if( $this->p->validate_void_frm() )
		{
			
			$d = $this->sfa();
			
			
			$this->p->void_power();	
			$h = array(
				'mek' 			=> $this->mek,
				'pek'			=> $d['pek'],
				'prefix_id'		=> $d['prefix_id'],
				'log'			=> 'Sub Agent Voided Power',
				'created_date'	=> $this->now()
			);
			$this->history->log_history( $h );
			
			$msg = 'You successfully voided the power';
			$this->set_message( $msg, 'done', '/sub_agent/power_inventory' );
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
			'powers'		=> $this->p->get_sub_powers( array('mek' => $this->mek, 'pek' => $pek ) ),
			'power_status'	=> $this->p->get_power_status()	,
			'power'			=> array(),	
			'trans_id'		=> $trans_id,
			'pek'			=> $pek	
		);


		$this->template->write('title', 'Void Power');
		$this->template->write('sub_title', 'The following form will void this power');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

		
	}


	
	
	
	
	public function process_discharge_frm()
	{
		$d = $this->sfa();
		 
		if( $this->p->validate_discharge_frm() )
		{
			$h = array(
				'mek' 			=> $this->mek,
				'pek'			=> $d['pek'],
				'prefix_id'		=> $d['prefix_id'],
				'log'			=> 'Sub Agent Discharged Power',
				'created_date'	=> $this->now()
			);
			$this->history->log_history( $h );
			
			$this->p->discharge_power();	
			$msg = 'You successfully discharged the power';
			$this->set_message( $msg, 'done', '/sub_agent/power_inventory' );
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
			'powers'		=> $this->p->get_powers( $trans_id, $pek, 1 ),
			'power_status'	=> $this->p->get_power_status()	,
			'power'			=> array()	,
			'trans_id'		=> $trans_id,
			'pek'			=> $pek	
		);


		$this->template->write('title', 'Discharge Power');
		$this->template->write('sub_title', 'The following form will discharge this power');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

		
	}


	
	
	

	public function view( $trans_id, $pek )
	{

//		if( $this->session->userdata( 'security_image' ) ) redirect( '/sub_agent/powers/execute/' . $trans_id . '/' . $pek );

		//$url = '/photo/epower_photo.html?role=' . $this->session->userdata( 'role' ) . '&trans_id=' . $trans_id . '&pek=' . $pek;
		$url = '/sub_agent/powers/execute/' . $trans_id . '/' . $pek;

		redirect( $url );
	}
	
	
	

	public function execute( $trans_id, $pek )
	{
		$view = 'index';
		
		$master_id = $this->b->get_sub_agent_master( array( 'sub_mek' => $this->mek ) );
		
		
		$d = array(
			'transmission'	=> $this->t->get_transmissions( $master_id->master_id, $trans_id ),
			'powers'		=> $this->p->get_powers( $trans_id, $pek, 1 ),
			'power_status'	=> $this->p->get_power_status()	,
			'power'			=> array(),
			'trans_id'		=> $trans_id,
			'pek'			=> $pek
			
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
		
		
		if( $this->p->validate_step_one() )
		{
			$this->p->save_step_one();	
						
			if( isset( $_POST[ 'add_defendant'] ) )
				redirect( '/sub_agent/powers/step_two/' . $this->input->post( 'trans_id' ) . '/' . $this->input->post( 'pek' ) );
			else
				redirect( '/sub_agent/powers/step_three/' . $this->input->post( 'trans_id' ) . '/' . $this->input->post( 'pek' ) );
				
		}
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->view( $this->input->post( 'trans_id' ), $this->input->post( 'pek' ) );				
		}
	}



	
	
	
	
	
	public function step_two( $trans_id, $pek )
	{
		$d = array(
			'powers'		=> $this->p->get_powers( $trans_id, $pek, 1 ),
			'power_status'	=> $this->p->get_power_status(),
			'sp'			=> $this->p->convert_json( $this->p->get_saved_power( $pek ) ), //saved power
			'trans_id'		=> $trans_id,
			'pek'			=> $pek	
			
		);



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
			redirect( '/sub_agent/powers/step_three/' . $this->input->post( 'trans_id' ) . '/' . $this->input->post( 'pek' ) );
		}
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->step_two( $this->input->post( 'trans_id' ), $this->input->post( 'pek' ) );				
		}
	}
	












	public function print_power( $trans_id, $is_batch, $prefix_id )
	{	
		$batch = $this->session->userdata( 'batch' );

		$msg = 'You have already printed this power.';
		if( ! $batch ) $this->set_message( $msg, 'info', '/sub_agent/power_inventory' );

		
		$this->session->set_userdata( 'print', true );
		$this->p->save_offline_power();
		$url = '/generate_power_pdf.cfm?power=' .  implode( $batch, ',' ) . '&trans_id=' . $trans_id . '&batch=' . $is_batch. '&prefix_id=' . $prefix_id . '&mek=' . $this->mek;

		$h = array(
			'mek' 			=> $this->mek,
			'pek'			=> $batch[0],
			'prefix_id'		=> $prefix_id,
			'log'			=> 'Sub Agent Printed Powered',
			'created_date'	=> $this->now()
		);

		$this->history->log_history( $h );
		
		redirect( $url );
		
	}





	public function step_three( $trans_id, $pek )
	{
	
		if( $this->session->userdata( 'print' ) ) redirect( '/sub_agent/power_inventory' );
		
		$this->p->add_to_batch( $trans_id, $pek );
	
		$d = array(
			'powers'		=> $this->p->get_powers( $trans_id, $pek ),
			'power_status'	=> $this->p->get_power_status(),
			'sp'			=> $this->p->get_saved_power( $pek ), //saved power
			'batch'			=> $this->session->userdata( 'batch' ),
			'trans_id'		=> $trans_id,
			'pek'			=> $pek	

		);
		


		$this->template->write('title', 'View Power');
		$this->template->write('sub_title', 'Please choose how to complete your power');
		$this->template->write_view('content', $this->view . 'summary', $d);
		$this->template->render();		
	
	}
	










	public function batch_powers( $trans_id, $pek )
	{
		$this->p->update_batch( $trans_id, $pek );
		
		$d = array(
			'powers'		=> $this->p->get_sub_powers( array( 'mek' => $this->mek, 'type' => 'inventory' ) ),
			'power_status'	=> $this->p->get_power_status(),
			'sp'			=> $this->p->get_saved_power( $pek ), //saved power,
			'batch'			=> $this->session->userdata( 'batch' ),
			'trans_id'		=> $trans_id,
			'pek'			=> $pek	
		);
		
		



		$this->template->write('title', 'Choose A Power To Batch');
		$this->template->write('sub_title', 'Please choose another power to batch');
		$this->template->write_view('content', $this->view . 'add_power_batch', $d);
		$this->template->render();		
			
		
		
	}
	










	public function cancel_power( $trans_id, $pek )
	{
		$this->p->delete_saved_power( $trans_id, $pek );
		redirect( '/sub_agent/powers/view/' . $trans_id. '/' . $pek );		
	}
	










	
	public function view_power( $trans_id, $pek )
	{
		$batch = $this->session->userdata( 'batch' );
		
		$d = array(
			'sp'			=> $this->p->convert_json( $this->p->get_saved_power() ),
			'powers'		=> $this->p->get_sub_powers( array( 'mek' => $this->mek, 'pek' =>$pek ) ),
			'agent'			=> $this->b->get_agents( $this->mek ),
			'batch'			=> implode( $batch, ',' ),
			'is_batch'		=> true,
			'trans_id'		=> $trans_id,
			'pek'			=> $pek	
			
		);
		
		$this->load->view( $this->view . 'power_template/power_created', $d );		
	}
	










	public function process_execute_power_frm()
	{
		if( $this->p->validate_execution_power() )
		{
			$d = $this->sfa();
			$prefix_id = $this->p->get_powers( $d['trans_id'], $d['pek'], 1 )->prefix_id;
	
			$h = array(
				'mek' 			=> $this->mek,
				'pek'			=> $d['pek'],
				'prefix_id'		=> $prefix_id,
				'log'			=> 'Sub Agent Executed Power',
				'created_date'	=> $this->now()
			);
			
			
			$this->history->log_history( $h );
			
			$this->p->save_powers();
			$this->p->send_notifications( $this->mek, $this->input->post( 'trans_id' ), $this->input->post( 'pek' ) );	
			
			
			
			$credits = $this->c->get_credits( $this->master_id );
			
			$this->c->update_credits_amount( $this->master_id, 1, $credits->credit_count );
			
			
			$this->c->update_sub_agent_credit_use(
				array( 
					'mek' 		=> $this->mek, 
					'credits' 	=> 1, 
					'pek' 		=> implode( $this->session->userdata( 'batch' ), ', ' ) ,
					'prefix_id'	=> $prefix_id,
					'used_date'	=> $this->now()
				)
			);
			
			
			
			$this->session->unset_userdata( 'batch' );
			
			
			$msg = 'Your transmission was successfully sent!';
			$this->set_message( $msg, 'done', '/sub_agent/power_inventory' );
			
		}	
		else
		{
			$trans_id 	= $this->input->post( 'trans_id' );
			$pek		= $this->input->post( 'pek' );
			
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->execute_power( $trans_id, $pek );		
		}
	}
	











	public function execute_power( $trans_id, $pek )			
	{
		
		$d = array(
			'powers'		=> $this->p->get_sub_powers( array( 'mek' => $this->mek, 'pek' => $pek ) ),
			'power_status'	=> $this->p->get_power_status(),
			'sp'			=> $this->p->convert_json( $this->p->get_saved_power( $pek ) ), //saved power
			'agent'			=> $this->b->get_agents( $this->mek ),
			'batch'			=> implode( $this->session->userdata( 'batch' ), ', ' ),
			'credits'		=> $this->c->get_credits( $this->master_id ),		
			'jails'			=> $this->j->create_select_array(),
			'trans_id'		=> $trans_id,
			'pek'			=> $pek	
			
		);

		if( $d[ 'credits']->credit_count == 0 )  $this->set_message( 'You have 0 credits, please purchase more credits', 'error', '/sub_agent/manage_credits' );

		
		$this->template->write('title', 'Send Power Electronically');
		$this->template->write('sub_title', 'Please fill out the form below to send this power electronically to the prison of your choice.');
		$this->template->write_view('content', $this->view . 'execute_power', $d);
		$this->template->render();		
			
		
	}
	









	
	
	
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
	









	
	private function check_transmission( $trans )
	{
		if( $trans == 'Not Paid' ) show_error( 'You do not have access to this power.', 403 );				
	}
}

