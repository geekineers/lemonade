<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class ImageController extends BaseController {

	public function index()
	{

		$this->load->helper('file');
		$image = $this->input->get('image');
		$file_path = realpath(APPPATH.'../uploads/' . $image);
	
		 header('Content-Type: ' . get_mime_by_extension($file_path));
		  readfile($file_path);

	}
}