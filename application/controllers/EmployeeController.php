<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');


class EmployeeController extends BaseController {

	protected $employeeRepository, $branchesRepository;

	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->employeeRepository = new EmployeeRepository();
		$this->branchesRepository = new BranchRepository();
		$this->load->library('session'); 

	}


	public function index()
	{	
		$data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
		$data['user'] = $this->sentry->getUser();
		$data['title'] = "Employee";
		$data['employees'] = $this->employeeRepository->all();		

		$this->render('/employee/index.twig.html', $data);
	}

	public function add()
	{
		$data['user'] = $this->sentry->getUser();
		$data['title'] = "Employees";
		$data['branches'] = $this->branchesRepository->all();
		$data['groups'] = $this->sentry->findAllGroups();
		$this->render('employee/add.twig.html', $data);

	}

	public function save()
	{
		$save = $this->employeeRepository->create($this->input->post());
		dd($save);
	}
}