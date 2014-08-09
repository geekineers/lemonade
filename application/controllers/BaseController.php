<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class BaseController extends CI_Controller {

	protected $sentry;

	public function __construct()
	{
	
		parent::__construct();
		$this->sentry = Sentry::createSentry();
	}
	public function render($template, $data = [])
	{
		$loader = new Twig_Loader_Filesystem(APPPATH.'views');
		$twig = new Twig_Environment($loader, array(
		    // 'cache' => APPPATH.'/cache/views',
		    'cache' => false
		));

		echo $twig->render($template, $data);
	}



	public function mustBeLoggedIn()
	{
		if(!$this->sentry->check()){
			redirect('/auth', 'location');
		}

	}
	public function mustBeLoggedOut()
	{
		if($this->sentry->check()){
			redirect('/dashboard', 'location');
		}

	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/Welcome.php */
