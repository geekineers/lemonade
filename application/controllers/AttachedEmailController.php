<?php defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

// use Maatwebsite\Excel\Excel as Excel;
class AttachedEmailController extends BaseController {

	protected $branchesRepository, $payslipsGroupRepository, $payslipsRepository, $employeeRepository, $payrollGroupRepository;
	public function __construct() {
		parent::__construct();
		
		$this->branchesRepository      = new BranchRepository();
		$this->payslipsRepository      = new PayslipsRepository();
		$this->payrollGroupRepository  = new PayrollGroupRepository();
		$this->employeeRepository      = new EmployeeRepository();
		$this->payslipsGroupRepository = new PayslipsGroupRepository();
	}

	public function slip($id)
	{

		
		$slip    = $this->payslipsRepository->getSlipById($id);
	
		$company = Company::where('id','=', $slip->company_id)->first();
		dd($slip->getEmployee());
		$data = [
			'employee' => $slip->getEmployee(),
			'payslip'  => $slip,
			'company'  => $company,
		];

		// $html = $this->load->view('payroll/payslip_template', $data, true);
		// echo $html;
		// $pdf = pdf_create($html, '', false, true);
		// echo $pdf;
	}
}