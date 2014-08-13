<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class TimesheetController extends BaseController 
{


	protected $employeeRepository;
	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->employeeRepository = new EmployeeRepository();
		$this->timesheetRepository = new TimesheetRepository();
	}

	public function index()
	{

		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$data['timesheets'] = $this->timesheetRepository->orderBy('id', 'desc')->get();
		$this->render('/timesheet/index.twig.html', $data);
	}



}