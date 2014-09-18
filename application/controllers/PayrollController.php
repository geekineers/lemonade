    <?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

// use Maatwebsite\Excel\Excel as Excel;
class PayrollController extends BaseController {

	protected $branchesRepository, $payslipsGroupRepository, $payslipsRepository, $employeeRepository, $payrollGroupRepository;
	public function __construct() {
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->branchesRepository      = new BranchRepository();
		$this->payslipsRepository      = new PayslipsRepository();
		$this->payrollGroupRepository  = new PayrollGroupRepository();
		$this->employeeRepository      = new EmployeeRepository();
		$this->payslipsGroupRepository = new PayslipsGroupRepository();
	}
// GET

	public function test()
	{
		$this->payslipsRepository->sendEmail();
		$employee = Employee::where('id','=',3)->first();
		dd($employee->getSSSValue());
	}
	public function index() {

		$data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$data['company']       = $this->company;
		$data['title']         = 'Payroll Generation';
		$data['payslipGroups'] = $this->payslipsGroupRepository->all();
		$data['payrollgroups'] = $this->payrollGroupRepository->all();
		$data['branches']      = $this->branchesRepository->all();

		$this->render('payroll/index.twig.html', $data);
	}

	public function restGetPayrollGroup() {
		$id   = $this->input->get('id');
		$data = $this->payrollGroupRepository->getPayrollGroupByBranch($id);
		return $this->sendJSON($data);
	}
	public function masterList($id) {
		$from = $this->input->get('from');
		$to   = $this->input->get('to');
		$slip = $this->payslipsGroupRepository->getPayslipById($id, $from, $to)->getAllPayslips();
		// dd($slip);
		$company = $this->company;
		$data    = [
			'payslips'     => $slip,
			'from'         => $from,
			'to'           => $to,
			'period'       => $this->payslipsGroupRepository->getPayslipById($id, $from, $to),
			'company_logo' => $company->company_logo,
			'date'		   => date('Y-m-d',strtotime($this->payslipsGroupRepository->getPayslipById($id,$from,$to)->created_at))
		];
		$html = $this->load->view('payroll/masterlist', $data, true);
		// dd($html);
		// $html = "dsadas";
		// dd($html);
		// echo $html;
		$pdf = pdf_create($html, '', false, true);
		echo $pdf;
	}

	public function groupList($id) {

		$from         = $this->input->get('from');
		$to           = $this->input->get('to');
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		// dd($this->payrollGroupRepository->getDate($id));

		$data['id']       = $id;
		$data['from']     = $from;
		$data['to']       = $to;
		$data['payslips'] = $this->payslipsGroupRepository->getPayslipById($id, $from, $to)->getAllPayslips();
		$data['company']  = $this->company;
		$this->render('payroll/group-slip.twig.html', $data);

	}
// GET
	public function payslip() {
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());

		$data['title'] = 'Payroll Generation';

		$data['payslips'] = $this->payslipsRepository->getAllPayslip();
		$data['company']  = $this->company;
		$this->render('payroll/payslip.twig.html', $data);

	}

	public function slipXls($id)
	{
		$slip    = $this->payslipsRepository->getSlipById($id);
		$company = $this->company;

		$data = [
			'employee' => $slip->getEmployee(),
			'payslip'  => $slip,
			'company'  => $company,
		];


	}

	public function slip($id) 
	{

		$slip    = $this->payslipsRepository->getSlipById($id);
		$company = $this->company;

		$data = [
			'employee' => $slip->getEmployee(),
			'payslip'  => $slip,
			'company'  => $company,
		];

		// dd($data);
		$html = $this->load->view('payroll/payslip_template', $data, true);
		// echo $html;
		$pdf = pdf_create($html, '', false, true);
		echo $pdf;

	}

// POST
	public function generatePayslip() {

		$this->load->helper(array('dompdf', 'file'));
		$data        = $this->input->post();
		$prepared_by = $this->employeeRepository->getLoginUser($this->sentry->getUser())->id;
		echo $this->payslipsRepository->generatePayslip($data, $prepared_by);

	}
	public function deletePayslips() {
		$id = $this->input->post('id');
		$this->payslipsGroupRepository->deletePayslips($id);
	}
// GET
	public function bank() {
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());

		$data['title'] = 'Payroll Generation';
		$this->render('payroll/govform.twig.html', $data);
	}
//
	public function myPaySlips() {
		$data['company']  = $this->company;
		$data['user']     = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$data['payslips'] = $this->payslipsRepository->where('employee_id', '=', $data['user']->id)->get();
		$data['title']    = 'My Payslips';
		$this->render('payroll/mypayslip.twig.html', $data);

	}

// GET
    public function govform($id)
    {
        $form = $this->input->get('form');
        $from = $this->input->get('from');
        $to   = $this->input->get('to');
        $this->payslipsRepository->generateGovermentForms($id, $form, $from, $to);
    }

    public function masterListInXls($id)
    {
        $from = $this->input->get('from');
		$to   = $this->input->get('to');
		recursiveRemoveDirectory('excel_files');
		$slip = $this->payslipsGroupRepository->getPayslipById($id, $from, $to)->getAllPayslips();
		
		$company = $this->company;
		$data    = [
			'payslips'     => $slip,
			'from'         => $from,
			'to'           => $to,
			'period'       => $this->payslipsGroupRepository->getPayslipById($id, $from, $to),
			'company_logo' => $company->company_logo,
			'date'		   => date('Y-m-d',strtotime($this->payslipsGroupRepository->getPayslipById($id,$from,$to)->created_at))
		];

        $check = $this->payslipsRepository->generateMasterXLS($data);
		if($check)
		{
			redirect('excel_files/masterlist-'.$data['date'].'.xlsx');
		}
    }

}
