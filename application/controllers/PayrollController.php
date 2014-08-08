<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class PayrollController extends BaseController 
{

	protected $employeeRepository;
	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->employeeRepository = new EmployeeRepository();
	}
// GET
	public function index()
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = 'Payroll Generation';
	
		$this->render('payroll/index.twig.html',$data);
	}
// GET
	public function payslip()
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = 'Payroll Generation';
		$this->render('payroll/payslip.twig.html',$data);
	}
// POST
	public function generateSlip()
	{

	}
// GET
	public function govForm()
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = 'Payroll Generation';
		$this->render('payroll/govform.twig.html',$data);
	}
// GET
	public function bank()
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = 'Payroll Generation';
		$this->render('payroll/govform.twig.html',$data);
	}
}
