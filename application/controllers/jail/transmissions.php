<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transmissions extends Jail_Controller {

	private $view;
	private $mek;
	private $jail;
	
	public function __construct()
	{
		parent::__construct();
		$this->view = 'jail/powers/';
		$this->mek	= $this->session->userdata( 'mek' );
		$this->load->helper('state');
		$this->load->helper('html');		
		$this->load->helper('power');		
		
		$this->load->model( 'powers/power_jail_model', 'p' );
		$this->load->model( 'powers/power_model', 'power' );
		
		$this->load->model( 'powers/offline_power_model', 'o' );
		$this->load->model( 'jail/jail_crud_model', 'j' );
		$this->load->model( 'agent/crud_model', 'b' );
		$this->jail_id = $this->j->get_jail( array( 'mek' => $this->mek ) )->jail_id;
		$this->session->set_userdata( 'jail_id', $this->jail_id );
		$this->template->add_js( '_assets/js/libs/tablesorter/jquery.tablesorter.min.js' );	
		$this->template->add_js( '_assets/js/libs/tablesorter/jquery.tablesorter.pager.js' );	
		$this->template->add_js( '_assets/fancybox/jquery.fancybox.pack.js' );	
		$this->template->add_css( '_assets/fancybox/jquery.fancybox.css' );	
		
		$script = "
			$(document).ready(function() { 
				$('.fancybox').fancybox({
		openEffect		: 'elastic',
		closeEffect		: 'fade',
		closeBtn		: true,
		helpers		: {
			title	: { type : 'inside' }
		}
	});
		    	$('table.tablesorter, table#table2') 
			    	.tablesorter({widthFixed: false}) 
				    .tablesorterPager({container: $('#pager')}); 
			}); 			
		"; 
		$this->template->add_js( $script, 'embed' );

	}

	public function print_offline_power( $off_pek )
	{

		$view = 'print_offline_power';

		$d = array(
			'power' => $this->o->get_offline_power( array( 'offline_power_id' => $off_pek ) )
		);

		$this->template->write('title', 'Accept Offline Power');
		$this->template->write('sub_title', '');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();
		
	
	}


	public function process_void_offline( $off_pek )
	{
		
		$d = array(
			'offline_pek' 	=> $off_pek,
			'status'		=> 'decline'
		);
		$this->o->update_offline_power_status( $d );
		
		
		$msg = 'You have successfully VOIDED this offline power';
		$url = safe_url( '/jail/transmissions' , 'pending_offline' );	
		$this->set_message( $msg, 'done' ,$url );
		
	}



	public function process_accept_offline( $off_pek )
	{
		
		$d = array(
			'offline_pek' 	=> $off_pek,
			'status'		=> 'accept'
		);
		$this->o->update_offline_power_status( $d );
		
		
		$msg = 'You have successfully accepted this offline power';
		$url = safe_url( '/jail/transmissions' , 'print_offline_power', array( $off_pek ) );	
		$this->set_message( $msg, 'done' ,$url );
		
	}
	
	
	public function accept_offline_power( $off_pek )
	{
		$view = 'accept_offline_power';

		$d = array(
			'off_pek' => $off_pek
		);

		$this->template->write('title', 'Accept Offline Power');
		$this->template->write('sub_title', '');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();
		
		
	}

	public function void_offline_power( $off_pek )
	{
		$view = 'void_offline_power';

		$d = array(
			'off_pek' => $off_pek
		);
		
		$this->template->write('title', 'Void Offline Power');
		$this->template->write('sub_title', '');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();
		
	}




	public function pending()
	{
		$view = 'pending';
		
		$data = array(
			'powers' 	=> $this->p->get_powers( array( 'jail_id' => $this->jail_id, 'accepted' => 0 ) )
		);
		
		$this->template->write('title', 'Manage Transmissions');
		$this->template->write('sub_title', '');
		$this->template->write_view('content', $this->view . $view, $data);
		$this->template->render();


		
	}


	public function pending_offline()
	{
		
		$view = 'pending_offline';
		$data = array(
			'offline'	=> $this->o->list_offline_powers( array( 'jail_id' => $this->jail_id, 'accepted' => 0 ) )
		);



		$this->template->write('title', 'Manage Transmissions');
		$this->template->write('sub_title', '');
		$this->template->write_view('content', $this->view . $view, $data);
		$this->template->render();


		
	}


	public function offline_powers()
	{
		$data = array(
			'offline'	=> $this->o->list_offline_powers( array( 'jail_id' => $this->jail_id, 'accepted' => 1 ) )
		);
		
		
		$this->template->write('title', 'Manage Transmissions');
		$this->template->write('sub_title', 'Use this admin to manage your transmissions');
		$this->template->write_view('content', $this->view . 'offline_powers', $data);
		$this->template->render();
		


		
	}
	
	
	public function accepted_powers()
	{
		
		$d = array(
			'powers' => $this->p->get_powers( array( 'jail_id' => $this->jail_id, 'accepted' => 1 ) )
		);
		
		$view = 'accepted_powers';


		$this->template->write('title', 'Accepted Transmissions');
		$this->template->write('sub_title', 'Use this admin to view your accepted transmissions');
		$this->template->write_view('content', $this->view . $view, $d);
		$this->template->render();
	
	}


	public function index()
	{
		$data = array(
			'powers' 	=> $this->p->get_powers( array( 'jail_id' => $this->jail_id, 'accepted' => 0 ) ),
			'offline'	=> $this->o->list_offline_powers( array( 'jail_id' => $this->jail_id ) )
		);
		
		$this->template->write('title', 'Manage Transmissions');
		$this->template->write('sub_title', '');
		$this->template->write_view('content', $this->view . 'index', $data);
		$this->template->render();

	}

	
	
	public function view_power( $power_id, $view = '' )
	{
		$this->load->model( 'agent/crud_model', 'agent' );
		
		$d = array(
			'power' 		=> $this->power->get_power( array( 'power_id' => $power_id ) ),
			'view'			=> $view 
			);
		
		if( $d[ 'power' ][ 'transferred_sub' ] == 'yes' )
			$d[ 'agent' ] = (array) $this->agent->get_sub_agent_by_power( array( $power_id ) );
		else 
			$d[ 'agent' ] = (array)  $this->agent->get_agent_by_power( array( $power_id ) );	
		
		$filename = strtolower( str_replace( ' ', '_', $d[ 'power' ][ 'ins_name' ] ) );
		
		$file_path = 'power_template/' . $filename;		
		
		//dd( $d );
		$this->load->view( $this->view . $file_path, $d );		
	
	}

	
	public function print_online( $power_id )
	{
		
		$d = array( 
			'p' => $this->power->get_power( array( 'power_id' => $power_id ) )
		);

		$this->template->write('title', 'Print Power');
		$this->template->write('sub_title', '');
		$this->template->write_view('content', $this->view . 'print_power', $d);
		$this->template->render();
		
		
	}


	public function process_accept( $power_id )
	{
	
		$args = array( 'power_id' => $power_id );
		$this->p->accept_power( $args );
		$msg = 'You have accepted this power. An email has been sent to the bail agent notifying them';
		$url = safe_url( '/jail/transmissions', 'print_online', array( $power_id ) );
		
		$this->set_message( $msg, 'done', $url  );			
		
		
	}
	
	public function print_powers( $power_id )
	{	

		$power = $this->power->get_power( array( 'power_id' => $power_id ) );

		$agent = $this->b->get_agent_by_power( array( 'power_id' => $power_id ) );

		if( $power[ 'transferred_sub' ] == 'yes' )
		{
			$agent = $this->b->get_sub_agent_by_power( array( $power_id ) );			
		}
		
		$filename = strtolower( str_replace( ' ', '_', $power[ 'ins_name' ] ) );
		
		$url = '/_tasks/' . $filename . '_print_power.cfm';		
		
		$url .= '?powers=' . $power_id . '&mek=' . $agent->mek;
		
		redirect( $url );
		
	}
	



	public function accept_power( $power_id)
	{
		$d = array(
				'power'	=> $this->power->get_power( array( 'power_id' => $power_id ) ),
				'now'	=> $this->now()
		
			);
			
		$this->template->write('title', 'Accept Power');
		$this->template->write('sub_title', 'Accept Power?');
		$this->template->write_view('content', $this->view . 'accept_power', $d);
		$this->template->render();

	}



	public function process_void()
	{
		
		$d = $this->sfa();
		$d[ 'mek' ] = $this->mek;
		
		$this->p->void_power( $d );
		$msg = 'You have voided this power. An email has been sent to the bail agent notifying them';
		$this->set_message( $msg, 'done', '/jail/transmissions/' );			
		
		
	}


	public function void_power( $power_id )
	{
		$d = array(
				'power' => $this->power->get_power( array( 'power_id' => $power_id ) ),
				'now'	=> $this->now()
		
			);

		$this->template->write('title', 'Void Power');
		$this->template->write('sub_title', 'Void Power?');
		$this->template->write_view('content', $this->view . 'void_power', $d);
		$this->template->render();

	}

	
}

