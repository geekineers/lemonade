<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class PayrollSettingsController extends BaseController
{

    protected $employeeRepository, $branchRepository, $payrollGroupRepository;
    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository       = new BranchRepository();
        $this->payrollGroupRepository = new PayrollGroupRepository();
         $this->employeeRepository   = new EmployeeRepository();

    }

    public function index()
    {

        $data['user']  = $this->sentry->getUser();
        $data['title'] = 'Payroll Settings';
        $data['wtax']  = taxlist();
        redirect('/settings/payroll-group');
  
    }

    public function payrollGroup()
    {
        $data['company']  = $this->company;
        $data['user']     = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']    = 'Payroll Settings';
        $data['branches'] = $this->branchRepository->all();
        $data['groups']   = $this->payrollGroupRepository->all();
        $this->render('payroll_settings/payroll-group.twig.html', $data);
    }

    public function postPayrollGroup()
    {
        $this->payrollGroupRepository->create([
                'branch_id'   => $this->input->post('branch-id'),
                'group_name'  => $this->input->post('group-name'),
                'period'      => $this->input->post('period'),
                'prepared_by' => $this->sentry->getUser()->id
            ]);

        redirect('/settings/payroll-group');
    }
}
