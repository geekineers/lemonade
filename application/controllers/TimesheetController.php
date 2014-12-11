<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class TimesheetController extends BaseController {

	protected $employeeRepository,
		$timesheetRepository;
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
        $page  = (isset($_GET['page'])) ? $_GET['page'] : 0;
     	// dd($page);
        $take = 15;
        $skip = $page * 15;

        $data['current_page'] = $page;
        $data['next_page'] = $page + 1;
        $data['prev_page'] = $page - 1;
		$data['company']    = $this->company;
		$data['user']       = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$data['title']      = "All Timesheets";
		$data['timesheets'] = $this->timesheetRepository->where('employee_id', '!=', 1)->orderBy('time_in', 'desc')->take($take)->skip($skip)->get();

		$data['max_count'] = count($data['timesheets']);
		$data['max_page']  = ceil($data['max_count'] / $take);
		$data['employees']  = $this->employeeRepository->all();
		$this->render('/timesheet/index.twig.html', $data);
	}

	public function search()
	{
	   	$page  		 = (is_null($this->input->get('page'))) ? $this->input->get('page') : 0;
       	$name  		 = (is_null($this->input->get('name'))) ? '' : $this->input->get('name');
       	$employee_id = (is_null($this->input->get('employee_id'))) ? '' : $this->input->get('employee_id');
       	$timein      = (is_null($this->input->get('timein'))) ? '' : $this->input->get('timein');
       	$timeout     = (is_null($this->input->get('timeout'))) ? '' : $this->input->get('timeout');
       	$status  	 = (is_null($this->input->get('status'))) ? '' : $this->input->get('status');

       	// dd($empty(var)ployee_id);
       	$data  = $this->timesheetRepository->with('employee')
       		->whereHas('employee', function($q) use ($name, $employee_id)
			{
			    $q->where('full_name', 'like', '%'. $name .'%');								     
			})
       		->whereHas('employee', function($q) use ($name, $employee_id)
			{
       			$q->Where('employee_number', 'like', '%' . $employee_id . '%');										     
			})
       		->where('status', 'like',  '%'.$status.'%')
       		->where('time_in', 'like',  '%'.$timein.'%')
       		->where('time_out', 'like',  '%'.$timeout.'%')

       		->get();

      	$this->output->set_content_type('application/json')->set_output(json_encode($data));
  

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
		$data['timesheets'] = $this->timesheetRepository->search($input['query'], $input['from'], $input['to']);

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

		$this->session->set_flashdata('message', 'Successfully deleted!');
		redirect('/timesheet');
	}

	public function testCase() {
		$employee = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		dd($employee->getAbsent('2014-09-01', '2014-09-30'));

	}

	public function batchUpload() {
		$input = $this->input->post();
		$this->timesheetRepository->uploadByBatch($input);
		redirect('/timesheet');
	}

	
}
