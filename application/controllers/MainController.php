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
		$period =  $this->input->get('period');
		echo json_encode( getWTax($salary,$period) );
	}

	public function slip()
	{
		$salary = (int) $this->input->get('salary');
		$data =  getWithholdingTax($salary,true,true,true) ;
		$this->render('slip.twig.html',$data);
	}
}