<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');


class PayrollPeriodController extends BaseController {

	protected $payrollPeriodRepository;

	public function __construct()
	{
		$this->payrollPeriodRepository = new PayrollPeriod();

	}

	public function index()
	{
		$data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = "Payroll Period";
		$data['branches'] = $this->payrollPeriodRepository->all();
	
		$this->render('/payroll_period/index.twig.html');
	}

	public function add()
	{
		$data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = "Payroll Period";
		$data['branches'] = $this->branchRepository->all();
	
		$this->render('/payroll_period/index.twig.html');
	}

}