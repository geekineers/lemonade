<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');


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

		$data['payroll'] = $this->payslipsRepository->getAllPayrollGroupBySlips();
		
		$this->render('payroll/index.twig.html',$data);
	}
	public function groupList($id)
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser()) ;
		// dd($this->payrollGroupRepository->getDate($id));
		$data['title'] = $this->payrollGroupRepository->where('id','=',$id)->first()->period;
		
		$data['payslips'] = $this->payslipsRepository->getPayslipById($id);

		$this->render('payroll/group-slip.twig.html',$data);

	}
// GET
	public function payslip()
	{
	 	$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser()) ;
		
		$data['title'] = 'Payroll Generation';
		
		$data['payslips'] = $this->payslipsRepository->getAllPayslip();

		$this->render('payroll/payslip.twig.html',$data);

	}
	public function slip($id)
	{
		
		$slip =  $this->payslipsRepository->getSlipById($id);
		// dd($slip);
		$data = [
			'employee' => $slip->getEmployee(),
			'payslip' => $slip
		];
		$html = $this->load->view('payroll/payslip_template',$data, true);
		// dd($html);
		// $html = "dsadas";
		// dd($html);
		$pdf = pdf_create($html, '', false);
	    echo $pdf;
		
	}
	public function test()
	{

			// $html = $this->load->view('payroll/payslip_template',$data, true);
		// dd($html);
		$html = "dsadas";
		// dd($html);
		$pdf = pdf_create($html, '', false);
	    echo $pdf->render();
	}
// POST
	public function generatePayslip()
	{

		$this->load->helper(array('dompdf', 'file'));
		
		$this->payslipsRepository->generatePayslip($this->input->post());
		
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
