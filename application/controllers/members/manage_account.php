<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_account extends MY_Controller {

	private $view;
	private $mek;
	private $role;

	public function __construct()
	{
		parent::__construct();
		$this->view 	= 'members/';
		$this->mek		= $this->session->userdata( 'mek' );
		$this->role		= $this->session->userdata( 'role' );
		
		$this->load->model( 'premium/premium_crud_model', 'p' );
		$this->load->model( 'insurance/insurance_crud_model', 'i' );
		$this->load->model( 'member_model', 'm' );
		$this->load->model( 'agent/crud_model', 'a' );
		$this->load->model( 'mga/mga_crud_model', 'mga' );
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->template->add_js('_assets/js/libs/inputMask/jquery.maskedinput-1.3.min.js');	
		
		$script = '
			$(document).ready(function() { 
				$(".zip").mask("99999");
				$(".phone").mask("(999) 999-9999");
			    $(".ssn").mask("999-99-9999");
			}); 			
		'; 
		
		$this->template->add_js( $script, 'embed' );
	

		$this->master_id = $this->mek;
		
		if( $this->role == 'sub_agent' )
		{
			$m = $this->a->get_sub_agent_master( array( 'sub_mek' => $this->mek ) );
			$this->master_id = $m->master_id;	
		}

	}

	/*	
		PROCESS PREMIUM PTS FRM
	*/

	public function process_premium_pts_frm()
	{		
		if( $this->p->validate_premium_pts_frm() )
		{
			$a = array( 'mek' => $this->mek );
			
			
			$this->p->save_premium_pts( $a );
			$url = '/members/manage_account';
			$msg = 'You successfully saved your premium/BUF points';
			$this->set_message( $msg, 'done', $url );
		}
		else
		{
			$d = $this->sfa();
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->add_premium_points( $d[ 'ins' ] );			
		}	
		
	}
	
	
	/*	
		ADD PREMIUM POINTS
	*/

	
	public function add_premium_points( $ins )
	{
		
		$view = 'add_premium_points';
		
		$d = array(
			'ins' => ( strlen( $ins ) ? $ins : $this->input->post( 'ins' ) ),
			'premium' => array( 
				array(
					'premium' 	=> '0.00',
					'buf' 		=> '0.00'
				) 
			),
			'premium_id' => 0
			
		);
	
		$this->template->write('title', 'Add Premium Points');
		$this->template->write('sub_title', 'Add the Premium/BUF Points');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
		
		
	}
	
	
	/*	
		PROCESS INS CHOOSE FRM
	*/

	
	
	public function process_ins_choose_frm()
	{
		if( $this->p->validate_ins_choose_frm() )
		{
			$ins = $this->input->post( 'ins_company' );
			$url = safe_url( '/members/manage_account', 'add_premium_points', array( $ins ) );			
			
			redirect( $url );
		}
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->add_premium();			
		}	
	}
	
	
	/*	
		ADD PREMIUM
	*/

	
	public function add_premium()
	{
		$view = 'add_premium';
		
		$d = array(
			'ins' => $this->a->get_transmission_agencies( $this->master_id  )
		);
		
		if( $this->role == 'mga' )
		{
			$d = array(
				'ins' => $this->mga->get_insurance_companies( $this->mek  )
			);
		}
		
		
		
		$params = array(
			'default' 	=> 'Please select an transmitting company',
			'data'		=> $d[ 'ins' ],
			'id_opt'	=> 'mek',
			'val_opt'	=> 'company' 
		);
		$d[ 'ins' ] = $this->create_sub_select_array( $params );
		
		$this->template->write('title', 'Add Premium');
		$this->template->write('sub_title', 'Choose Transmitting Company');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
			
		
	}	
	
	
	/*	
		VIEW PREMIUMS
	*/

	
	public function view_premiums()
	{
		$view = 'view_premiums';
		
		$d = array(
			'premiums' => $this->p->get_premiums( array( 'mek' => $this->mek ) )
		);

		
		$this->template->write('title', 'View Premiums');
		$this->template->write('sub_title', 'View your premiums below');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
			
		
	}	
	
	
	/*	
		EDIT PREMIUMS
	*/

	
	public function edit_premium( $premium_id )
	{
		$view = 'add_premium_points';
		
		$p = array(
			'mek' 			=> $this->mek,
			'premium_id'	 => $premium_id
		);
		
		$d = array(
			'premium'	 => $this->p->get_premiums( $p ),
			'premium_id' => $premium_id
		);
		
		$d[ 'ins' ] = $d[ 'premium' ][ 0 ]['transmitter_id' ];


		$this->template->write('title', 'Edit Premiums');
		$this->template->write('sub_title', 'Edit your premiums below');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		
			
		
	}	

	
	
	/*	
		PROCESS UPDATE FRM
	*/

	


	public function process_update_frm()
	{
		if( $this->m->validate_update_frm() )
		{
			$this->m->update_member( array( 'mek' => $this->mek ) );
			$msg = 'You successfully updated your profile';
			$url = safe_url( '/members/manage_account', 'index' );
			$this->set_message( $msg, 'done', $url );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
			$this->edit_profile();
		}
	}

	
	public function edit_profile()
	{
		$view = 'edit_profile';
		$d = array(
			'member' => $this->m->get_member( array( 'mek' => $this->mek ) )
		);

		$this->template->write('title', 'Edit Profile');
		$this->template->write('sub_title', 'Edit your profile below');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}



	public function view_profile()
	{
		$view = 'view_profile';
		
		$d = array(
			'member' => $this->m->get_member( array( 'mek' => $this->mek ) )
		);

		$this->template->write('title', 'Your Profile');
		$this->template->write('sub_title', 'Find your profile details below');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}



	public function index()
	{
		$view = 'index';
		$d = array();

		$this->template->write('title', 'Manage Your Account');
		$this->template->write('sub_title', 'Use this area to manage your account');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();		

	}
}

/*

		if( $this->p->validate_void_frm() )
		{
			$msg = 'You successfully voided the power';
			$this->set_message( $msg, 'done', '/master_agent/transmissions/view/' . $this->input->post( 'trans_id' ) );
		}			
		else
		{
			$this->template->write( 'errors', $this->set_errors(validation_errors()));
		}

*/

