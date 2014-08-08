<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

use nesbot\Carbon\Carbon as Carbon;

class PayrollController extends BaseController 
{

	protected $payslipsRepository,$employeeRepository,$payrollGroupRepository;
	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();

		$this->payslipsRepository = new PayslipsRepository();
		$this->payrollGroupRepository= new PayrollGroupRepository();
		$this->employeeRepository = new EmployeeRepository();
	}
// GET
	public function index()
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = 'Payroll Generation';
		$data['payrollgroup'] = $this->payrollGroupRepository->all();
		$this->render('payroll/index.twig.html',$data);
	}
// GET
	public function payslip()
	{
	 	$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser()) ;
		
		$data['title'] = 'Payroll Generation';
		$this->render('payroll/payslip.twig.html',$data);

	}
// POST
	public function generatePayslip()
	{
		$input  = $this->input->post();
		$output = $this->payslipsRepository->generatePayslip($input);
		 $this->output
	    ->set_content_type('application/json')
	    ->set_output(json_encode($output));
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
