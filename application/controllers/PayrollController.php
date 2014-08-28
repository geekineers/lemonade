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
	public function masterList($id)
	{
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$slip = $this->payslipsRepository->getPayslipById($id,$from,$to);
		// dd($slip);
		$data = [
			'payslips' => $slip,
			'from'    => $from,
			'to'	  => $to
		];
		$html = $this->load->view('payroll/masterlist',$data, true);
		// dd($html);
		// $html = "dsadas";
		// dd($html);
		// echo $html;
		$pdf = pdf_create($html, '', false ,true	);
	    echo $pdf;
	}
	public function groupList($id)
	{

		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser()) ;
		// dd($this->payrollGroupRepository->getDate($id));
		$group = $this->payrollGroupRepository->where('id','=',$id)->first();
		$data['title'] = $group->period;

		$data['id'] = $id;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['payslips'] = $this->payslipsRepository->getPayslipById($id,$from,$to);

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
	
		$data = [
			'employee' => $slip->getEmployee(),
			'payslip' => $slip
		];
		$html = $this->load->view('payroll/payslip_template',$data, true);
	
		$pdf = pdf_create($html, '', false,true);
	    echo $pdf;
		
	}
	public function test()
	{

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
	public function bank()
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = 'Payroll Generation';
		$this->render('payroll/govform.twig.html',$data);
	}
// 
	public function myPaySlips()
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$data['payslips'] = $this->payslipsRepository->where('employee_id', '=', $data['user']->id)->get();
		$data['title'] = 'My Payslips';
		$this->render('payroll/mypayslip.twig.html', $data);
	
	}

// GET
	public function govform($id)
	{

	
		$form = $this->input->get('form');
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$this->payslipsRepository->generateGovermentForms($id,$form,$from,$to);
	}
}
