<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
	}
	
	
	public function validate_contact_frm()
	{


		$this->form_validation->set_error_delimiters('<li>', '</li>');		
	
		$this->form_validation->set_rules('name', 'Full Name', 'required|trim');		
		$this->form_validation->set_rules('email', 'Email', 'required|email|trim');		
		$this->form_validation->set_rules('subject', 'Subject', 'required|trim');
		$this->form_validation->set_rules('message', 'Message', 'required|trim');


		return $this->form_validation->run();
		
		
	}


	public function save_contact_frm()
	{
		$data = $this->sfa();
		$this->db->trans_start();
			$this->db->insert('contact', $data );
		$this->db->trans_complete();			
		$this->em->contact_confirmation( $data );
		return true;
	}

}