<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photos {
	
	var $CI;

	public function __construct()
    {
		// Copy an instance of CI so we can use the entire framework.
		$this->CI =& get_instance();
		
		$this->CI->load->library('upload');
		$this->CI->load->database();
		$this->CI->config->load('upload');
		
	}
	
	
	public function check_directory($path)
	{
		$dir = $this->CI->config->item('upload_path') . '/' . $path;
		return is_dir($dir);
	}

	public function create_directory($path)
	{
		$dir = $this->CI->config->item('upload_path') . '/' . $path;
		mkdir($dir, 755);	
	}
	
	public function get_photo($image_id, $type)
	{
		$query = $this->CI->db->get_where( 'member_images', array( 'image_id' => $image_id, 'deleted' => 0, 'image_category' => 'public', 'active' => 1 ));
		$photo = $query->row_array();
		$this->render_photo($photo, $type);
	}
	
	public function get_internal_photo($mek, $image_id, $type)
	{
		$query = $this->CI->db->get_where( 'member_images', array( 'image_id' => $image_id, 'deleted' => 0, 'image_category' => 'public','member_external_key' => $mek ));
		$photo = $query->row_array();
		$this->render_photo($photo, $type);
		
	}
	
	public function get_internal_private_photo($mek, $image_id, $type)
	{
		$query = $this->CI->db->get_where( 'member_images', array( 'image_id' => $image_id, 'deleted' => 0, 'image_category' => 'private', 'member_external_key' => $mek));
		$photo = $query->row_array();
		$this->render_photo($photo, $type);
		
	}
	
	public function get_private_photo($image_id, $type)
	{
		$query = $this->CI->db->get_where( 'member_images', array( 'image_id' => $image_id, 'deleted' => 0, 'image_category' => 'private', 'active' => 1));
		$photo = $query->row_array();
		$this->render_photo($photo, $type);
	}
	
	private function render_photo($photo, $type)
	{
		if( ! is_array($photo) || count($photo) == 0) return FALSE;
		
		$path = $this->CI->config->item('upload_path');
		$path .= '/' . $photo['member_external_key'] . '/' . $photo['image_name'] . '_' . $type . $photo['image_ext'];
		
		header("Content-Type: image/" . $photo['image_type']);
		readfile($path);
		
	}

}
