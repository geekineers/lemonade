<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

// use Illuminate\Validation\Validator;
// use Illuminate\Validation\Factory as Validator;
use Cartalyst\Sentry\Groups\Eloquent\Group;
use Upload\Storage\FileSystem as FileSystem;
// use EmployeeTransform;

    class EmployeeController extends BaseController
    {

    protected $employeeRepository,
    $branchesRepository,
    $jobPositionRepository,
    $departmentRepository,
    $subDepartmentRepository,
    $documentRepository,
    $deductionRepository,
    $allowanceRepository,
    $employeeTypeRepository,
    $historyRepository,
    $basicPayAdjustmentRepository,
    $fileSystem,
    $payrollGroupRepository;

    public function __construct()
    {
        parent::__construct();

        $this->mustBeLoggedIn();

        $path                               = realpath(APPPATH . '../uploads/');
        $this->fileSystem                   = new FileSystem($path);
        $this->employeeRepository           = new EmployeeRepository();
        $this->branchesRepository           = new BranchRepository();
        $this->jobPositionRepository        = new JobPositionRepository();
        $this->payrollGroupRepository       = new PayrollGroupRepository();
        $this->departmentRepository         = new DepartmentRepository();
        $this->subDepartmentRepository         = new SubDepartmentRepository();
        $this->deductionRepository          = new DeductionRepository();
        $this->allowanceRepository          = new AllowanceRepository();
        $this->employeeTypeRepository       = new EmployeeTypeRepository();
        $this->documentRepository           = new DocumentRepository();
        $this->historyRepository            = new HistoryRepository();
        $this->basicPayAdjustmentRepository = new BasicPayAdjustmentRepository();
        $this->load->library('session');
    }

    public function index()
    {
        // dd(createEmployeeID('1'));
        $data['company']              = $this->company;
        $data['alert_message']        = ($this->session->flashdata('message') == null)
        ? null
        : $this->session->flashdata('message');
        $data['alert_message_error']  = ($this->session->flashdata('message_error') == null)
        ? null
        : $this->session->flashdata('message_error');
        $data['user']                 = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']                = "Employee";
        $data['employees']            = $this->employeeRepository->where('first_name', '!=', 'Super Admin')->get();
        $data['job_positions']        = $this->jobPositionRepository->all();
        $data['departments']          = $this->departmentRepository->all();
        $data['payroll_groups']       = $this->payrollGroupRepository->all();

        $this->render('/employee/index.twig.html', $data);
    }

    public function terminated()
    {
        $data['company']       = $this->company;
        $data['alert_message'] = ($this->session->flashdata('message') == null)
        ? null
        : $this->session->flashdata('message');
        $data['user']      = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']     = "Employee";
        $data['employees'] = $this->employeeRepository->onlyTrashed()->get();

        $data['job_positions']  = $this->jobPositionRepository->all();
        $data['departments']    = $this->departmentRepository->all();
        $data['payroll_groups'] = $this->payrollGroupRepository->all();

        $this->render('/employee/trashed.twig.html', $data);
    }

    public function add()
    {
        $data['company'] = $this->company;
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']   = "Employees";
        $data['alert_message'] = ($this->session->flashdata('message') == null)
        ? null
        : $this->session->flashdata('message');
        $data['groups']         = Group::where('company_id', '=', COMPANY_ID)->get();
        $data['job_positions']  = $this->jobPositionRepository->all();
        $data['departments']    = $this->departmentRepository->all();
        $data['employee_types'] = $this->employeeTypeRepository->all();
        $data['payroll_groups'] = $this->payrollGroupRepository->all();
        $data['branches']       = $this->branchesRepository->all();
        $this->render('employee/add.twig.html', $data);

    }

    public function save()
    {
        $data = $this->input->post();
        $saving = $this->employeeRepository->createEmployee($data, $this->sentry);

        
        if($saving == "confirm_password_error")
        {
            
            $this->session->set_flashdata('message', 'Kindly confirm the user password.');
            redirect('/employees/add', 'location');
        
        }

        else if($saving == "duplicate_error")
        {
            $this->session->set_flashdata('alert_message', 'Employee Record is currently existing.');
            redirect('/employees/add', 'location');    
        }

        else
        {

            $this->session->set_flashdata('message', 'Successfully added!');    
        }
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
        $this->session->set_flashdata('alert', true);
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
        
        $this->session->set_flashdata('alert', true);
        redirect('/employees/' . $employee_id . '/profile', 'location');
    }

    public function updateContributions($id)
    {
        $employee_id = $id;

        $post = array(
            'deduct_sss'              => (boolean) $this->input->post('deduct_sss'),
            'deduct_hdmf'             => (boolean) $this->input->post('deduct_hdmf'),
            'deduct_philhealth'       => (boolean) $this->input->post('deduct_philhealth'),
            'fixed_sss_amount'        => $this->input->post('fixed_sss_amount'),
            'fixed_hdmf_amount'       => $this->input->post('fixed_hdmf_amount'),
            'fixed_philhealth_amount' => $this->input->post('fixed_philhealth_amount'),
        );

        $update = $this->employeeRepository->where('id', '=', $employee_id)->update($post);
        
        $this->session->set_flashdata('alert', true);
        redirect('/employees/' . $employee_id . '/profile', 'location');

    }
    
    public function updateContacts($id)
    {
        $data = $this->input->post();
        $this->employeeRepository->where('id', '=', $id)->update($data);
        
        $this->session->set_flashdata('alert', true);
        redirect('/employees/' . $id . '/profile', 'location');

    }

    public function profile($id)
    {
        $data['alert'] = $this->session->flashdata('alert');
        $data['company'] = $this->company;
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['job_positions'] = $this->jobPositionRepository->all();
        $data['branches']      = $this->branchesRepository->all();

        $data['payroll_groups']  = $this->payrollGroupRepository->getPayrollGroupbyEmployeeBranch($id);
        // dd($data['payroll_groups']);
        $data['leave_types']     = LeaveType::all();
        $data['employee']        = $this->employeeRepository->where('id', '=', $id)->withTrashed()->first();
        $data['histories']        = $this->historyRepository->getByEmployee($id)->groupBy(function($value) { return date('Y-m-d', strtotime($value->created_at)); })->reverse();
      
        $data['departments']     = $this->departmentRepository->all();
        $data['sub_departments']     = $this->subDepartmentRepository->where('parent_department_id', $data['employee']->department)->get();
        $data['deduction_types'] = $this->deductionRepository->all();
        $data['allowance_types'] = $this->allowanceRepository->all();
        $data['employee_types'] = $this->employeeTypeRepository->all();
        // $data['documents'] = $this->employeeRepository->find($id);

        $data['employee']->getRole();
        $data['employee']->getInAttendance('2014-01-01', '2014-02-01');

        $this->render('/employee/profile.twig.html', $data);
    }

    public function uploadFile()
    {
        $this->documentRepository->saveDocument($this->input->post());

        
        $this->session->set_flashdata('alert', true);
        redirect('/employees/' . $this->input->post('employee_id') . '/profile', 'location');

    }

    public function deleteAllowance()
    {

        
        $id = $this->input->get('token');
        $deleteAllowance = EmployeeAllowance::where('id', '=', $id)->first();
        $deleteAllowance->delete();
        
        $this->session->set_flashdata('alert', true);
        redirect('/employees/' . $this->input->get('eid') . '/profile', 'location');
    }

    public function deleteFile()
    {

        
        $this->documentRepository->deleteFile($this->input->get('token'));
        
        $this->session->set_flashdata('alert', true);
        redirect('/employees/' . $this->input->get('eid') . '/profile', 'location');
    }

    public function uploadCertificate()
    {
        $this->documentRepository->saveCertificate($this->input->post());
        
        $this->session->set_flashdata('alert', true);
        redirect('/employees/' . $this->input->post('employee_id') . '/profile', 'location');
    }

    public function updateProfilePicture($id)
    {
        $input = $this->input->post();
        $this->employeeRepository->updateProfilePicture($input, $id);
        
        $this->session->set_flashdata('alert', true);
        redirect('/employees/' . $id . '/profile', 'location');
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

        $this->basicPayAdjustmentRepository->create($post);
        
        $this->session->set_flashdata('alert', true);
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

        $this->session->set_flashdata('message', 'Successfully deleted!');
        redirect('/employees');
    }

    public function reactivate()
    {
        $id = $this->input->get('token');
        $this->employeeRepository->reactivateEmployee($id);

        redirect('/employees');
    }

    public function apiAll()
    {
        $branch = $this->input->get('branch');
        // dd($_GET);
        if($branch)
        {
            $collection = $this->employeeRepository->where('branch_id', $branch)->get();
        }
        else
        {
            $collection = $this->employeeRepository->all();
        }
        
        $employees = EmployeeTransformer::transform($collection);

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($employees));
    }

    public function api()
    {

    }

    public function addEmployeeByBatch()
    {

        $input = $this->input->post();
        $output = $this->employeeRepository->uploadBybatch($input);
        if($output['status'])
        {
            $this->session->set_flashdata('message', $output['message']);
        }
        else
        {
            $this->session->set_flashdata('message_error', $output['message']);
        }
        redirect('/employees');
    }
}
