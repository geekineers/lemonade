<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class TimesheetController extends BaseController
{

    protected $employeeRepository;
    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->employeeRepository  = new EmployeeRepository();
        $this->timesheetRepository = new TimesheetRepository();
        $this->load->library('session');
    }

    public function index()
    {
        $data['company']    = $this->company;
        $data['user']       = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']      = "All Timesheets";
        $data['timesheets'] = $this->timesheetRepository->where('employee_id', '!=', 1)->orderBy('time_in', 'desc')->get();
        $data['employees']  = $this->employeeRepository->all();
        $this->render('/timesheet/index.twig.html', $data);
    }

    public function timein()
    {
        $this->timesheetRepository->timein($this->sentry->getUser());
        $this->session->set_userdata('time_in_status', 1);
        redirect('/dashboard', 'location');
    }

    public function timeout()
    {
        $this->timesheetRepository->timeout($this->sentry);
        $this->session->set_userdata('time_in_status', 0);
        redirect('/dashboard', 'location');
    }

    public function myTimesheet()
    {
        $data['company']    = $this->company;
        $data['user']       = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']      = "My Timesheets";
        $data['timesheets'] = $this->timesheetRepository->where('employee_id', '!=', 1)->where('employee_id', '=', $data['user']->id)->orderBy('id', 'desc')->get();
        $this->render('/timesheet/my_timesheet.twig.html', $data);
    }

    public function save()
    {
        $data = $this->input->post();
        $this->timesheetRepository->saveTime($data['employee'], $data['timestart'], $data['timeend'], $data['from'], $data['to']);
        redirect('/timesheet');

    }

    public function range()
    {
        $input              = $this->input->get();
        $data['timesheets'] = $this->timesheetRepository->getByRange($input['from'], $input['to']);

        $this->render('/timesheet/search.twig.html', $data);

    }

    public function update()
    {
        $data = $this->input->post();
        $this->timesheetRepository->updateTime($data['timesheet_id'], $data['employee'], $data['timestart'], $data['timeend'], $data['from'], $data['to']);

        redirect('/timesheet');

    }

    public function delete()
    {
        $id = $this->input->get('token');

        $this->timesheetRepository->delete($id);

        redirect('/timesheet');
    }

    public function testCase()
    {
        $employee = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        dd($employee->getAbsent('2014-09-01', '2014-09-30'));

    }
}
