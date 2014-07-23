<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Base_Controller extends CI_Controller {

	public function render($template, $data = [])
	{
		$loader = new Twig_Loader_Filesystem(APPPATH.'views');
		$twig = new Twig_Environment($loader, array(
		    'cache' => APPPATH.'/cache/views',
		));

		echo $twig->render($template, $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/Welcome.php */
