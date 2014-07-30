<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class MainController extends BaseController 
{

	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();


	}

	public function index()
	{

	}

	public function dashboard()
	{

		// dd($this->sentry->getUser());
		$data['user'] = $this->sentry->getUser();
		$data['title'] = "Dashboard";

		$this->render('index.twig.html', $data);
	}

	public function test()
	{
		$salary = (int) $this->input->get('salary');
		
		echo json_encode( getWithholdingTax($salary,true,true,true) );
	}
}