<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class ImageController extends BaseController {

	public function index()
	{
		// dd('mark');
		$this->load->helper('file');
		$path = $this->input->get('image');
		$image_path = realpath(APPPATH.'../uploads/' . $path);

		$this->output->set_content_type(get_mime_by_extension($image_path));
		$this->output->set_output(file_get_contents($image_path));
	}
}