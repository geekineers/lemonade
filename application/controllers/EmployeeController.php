<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

// use Illuminate\Validation\Validator;
// use Illuminate\Validation\Factory as Validator;
use Cartalyst\Sentry\Groups\Eloquent\Group;
use Upload\Storage\FileSystem as FileSystem;

class EmployeeController extends BaseController
{

    protected $employeeRepository,
    $branchesRepository,
    $jobPositionRepository,
    $departmentRepository,
    $documentRepository,
    $deductionRepository,
    $allowanceRepository,
    $basicPayAdjustmentRepository,
    $fileSystem,
    $payrollGroupRepository;

    public function __construct()
    {

        parent::__construct();

        $this->mustBeLoggedIn();

        $path             = realpath(APPPATH . '../uploads/');
        $this->fileSystem = new FileSystem($path);

        $this->employeeRepository = new EmployeeRepository();

        $this->branchesRepository    = new BranchRepository();
        $this->jobPositionRepository = new JobPositionRepository();

        $this->payrollGroupRepository       = new PayrollGroupRepository();
        $this->departmentRepository         = new DepartmentRepository();
        $this->deductionRepository          = new DeductionRepository();
        $this->allowanceRepository          = new AllowanceRepository();
        $this->documentRepository           = new DocumentRepository();
        $this->basicPayAdjustmentRepository = new BasicPayAdjustmentRepository();
        $this->load->library('session');
    }

    public function index()
    {
        // $employee = Employee::find(2);
        // $absent = $employee->getAbsent('2014-08-25','2014-08-29');
        // dd($absent);
        $data['company']       = $this->company;
        $data['alert_message'] = ($this->session->flashdata('message') == null)
        ? null
        : $this->session->flashdata('message');
        $data['user']      = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']     = "Employee";
        $data['employees'] = $this->employeeRepository->where('id', '!=', 1)->get();

        $data['job_positions']  = $this->jobPositionRepository->all();
        $data['departments']    = $this->departmentRepository->all();
        $data['payroll_groups'] = $this->payrollGroupRepository->all();

        $this->render('/employee/index.twig.html', $data);
    }

    public function add()
    {
        $data['company'] = $this->company;
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']   = "Employees";

        $data['groups']         = Group::where('company_id', '=', COMPANY_ID)->get();
        $data['job_positions']  = $this->jobPositionRepository->all();
        $data['departments']    = $this->departmentRepository->all();
        $data['payroll_groups'] = $this->payrollGroupRepository->all();
        $this->render('employee/add.twig.html', $data);

    }

    public function save()
    {
        $data = $this->input->post();
        $this->employeeRepository->createEmployee($data, $this->sentry);
        redirect('/employees', 'location');
    }

    /*
     * Update Methods
     * - 201 file
     * - Contributions
     * - Salary
     *
     */

    public function update()
    {

        $employee_id = $this->input->post('id');
        $data        = $this->input->post();

        $this->employeeRepository->updateEmployee201($employee_id, $data, $this->sentry);
        redirect('/employees/' . $employee_id . '/profile', 'location');
    }

    public function updateSalary($id)
    {
        $employee_id = $id;
        $post        = array(
            'withholding_tax_type'        => $this->input->post('withholding_tax_type'),
            'expanded_withholding_tax'    => floatval($this->input->post('expanded_withholding_tax')),
            'entitled_night_differential' => (int) $this->input->post('entitled_night_differential'),
            'night_differential_rate'     => floatval($this->input->post('night_differential_rate')),
            'entitled_overtime_pay'       => (int) $this->input->post('entitled_overtime_pay'),
            'overtime_pay_rate'           => floatval($this->input->post('overtime_pay')),
            'timesheet_required'          => (int) $this->input->post('timesheet_required'),

        );
        $update = $this->employeeRepository->where('id', '=', $employee_id)->update($post);
        redirect('/employees/' . $employee_id . '/profile', 'location');
    }

    public function updateContributions($id)
    {
        $employee_id = $id;

        $post = array(
            'deduct_sss'              => (boolean) $this->input->post('deduct_sss'),
            'deduct_hdmf'             => (boolean) $this->input->post('deduct_hdmf'),
            'deduct_philhealth'       => (boolean) $this->input->post('deduct_philhealth'),
            'fixed_sss_amount'        => floatval($this->input->post('fixed_sss_amount')),
            'fixed_hdmf_amount'       => floatval($this->input->post('fixed_hdmf_amount')),
            'fixed_philhealth_amount' => floatval($this->input->post('fixed_philhealth_amount')),
        );

        $update = $this->employeeRepository->where('id', '=', $employee_id)->update($post);
        redirect('/employees/' . $employee_id . '/profile', 'location');

    }
    public function updateContacts($id)
    {
        $data = $this->input->post();
        $this->employeeRepository->where('id', '=', $id)->update($data);
        redirect('/employees/' . $id . '/profile', 'location');

    }

    public function profile($id)
    {
        $data['company'] = $this->company;
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['job_positions'] = $this->jobPositionRepository->all();
        $data['branches']      = $this->branchesRepository->all();

        $data['payroll_groups']  = $this->payrollGroupRepository->getPayrollGroupbyEmployeeBranch($id);
        $data['departments']     = $this->departmentRepository->all();
        $data['employee']        = $this->employeeRepository->find($id);
        $data['deduction_types'] = $this->deductionRepository->all();
        $data['allowance_types'] = $this->allowanceRepository->all();
        // $data['documents'] = $this->employeeRepository->find($id);

        $data['employee']->getRole();

        $this->render('/employee/profile.twig.html', $data);
    }

    public function uploadFile()
    {
        $this->documentRepository->saveDocument($this->input->post());
        redirect('/employees/' . $this->input->post('employee_id') . '/profile', 'location');

    }

    public function deleteFile()
    {

        $this->documentRepository->delete($this->input->get());
        redirect('/employees/' . $this->input->get('eid') . '/profile', 'location');

    }

    public function uploadCertificate()
    {
        $this->documentRepository->saveCertificate($this->input->post());
        redirect('/employees/' . $this->input->post('employee_id') . '/profile', 'location');
    }

    public function adjustBasicPay()
    {

        $employee_id       = $this->input->post('employee_id');
        $current_basic_pay = str_replace(',', '', $this->input->post('current_basic_pay'));
        $new_basic_pay     = str_replace(',', '', $this->input->post('new_basic_pay'));
        $effective_date    = $this->input->post('effective_date');
        $adjustment_date   = $this->input->post('adjustment_date');
        $adjustment_reason = $this->input->post('adjustment_reason');
        $created_by        = $this->sentry->getUser()->id;

        $post = array(
            'employee_id'       => (int) $employee_id,
            'current_basic_pay' => floatval($current_basic_pay),
            'new_basic_pay'     => floatval($new_basic_pay),
            'effective_date'    => $effective_date,
            'adjustment_date'   => $adjustment_date,
            'adjustment_reason' => $adjustment_reason,
            'created_by'        => $created_by,

        );
        // $post = $this->input->post();

        // dd($post);

        $this->basicPayAdjustmentRepository->create($post);
        redirect('/employees/' . $this->input->post('employee_id') . '/profile', 'location');

    }

    public function search()
    {
        $search_query      = $this->input->get('search');
        $items             = $this->employeeRepository->search($search_query);
        $data['employees'] = $items;

        return $this->render('/employee/search.twig.html', $data);

    }

    public function delete()
    {
        $id = $this->input->get('token');
        $this->employeeRepository->deleteEmployee($id);

        redirect('/employees');
    }

    public function apiAll()
    {
        // dd('mark');
        $employees = $this->employeeRepository->getAllEmployeesJSON();

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($employees));
    }

}
