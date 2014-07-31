<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class MainController extends BaseController 
{

	protected $employeeRepository;
	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->employeeRepository = new EmployeeRepository();

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
		$dependents = (int) $this->input->get('dependents');
		echo json_encode( getWTax($salary,$period,$dependents) );
	}

	public function slip()
	{
		$salary = (int) $this->input->get('salary');
		$period =  $this->input->get('period');
		$dependents = (int) $this->input->get('dependents');
		$pagibig = $this->input->get('pagibig');
		$sss = $this->input->get('sss');
		$ph = $this->input->get('ph');
		$data =  getWithholdingTax($salary,$period ,$dependents,$ph,$pagibig,$sss) ;
		$this->render('slip.twig.html',$data);

	}
}