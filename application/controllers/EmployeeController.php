<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');


class EmployeeController extends BaseController {

	protected $employeeRepository, $branchesRepository,$jobPositionRepository, $departmentRepository;

	public function __construct()
	{	
		parent::__construct();
	
		$this->mustBeLoggedIn();
		$this->employeeRepository = new EmployeeRepository();
		
		$this->branchesRepository = new BranchRepository();
		$this->jobPositionRepository = new JobPositionRepository();

		$this->departmentRepository = new DepartmentRepository();
		$this->load->library('session'); 

	}


	public function index()
	{	
		$data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
		$data['user'] = $this->sentry->getUser();
		$data['title'] = "Employee";
		$data['employees'] = $this->employeeRepository->all();
		$data['job_positions'] = $this->jobPositionRepository->all();
		$data['departments'] = $this->departmentRepository->all();
		// dd($this->employeeRepository->all());
		$this->render('/employee/index.twig.html', $data);
	}

	public function add()
	{
		$data['user'] = $this->sentry->getUser();
		$data['title'] = "Employees";
		$data['branches'] = $this->branchesRepository->all();
		$data['groups'] = $this->sentry->findAllGroups();
		$data['job_positions'] = $this->jobPositionRepository->all();
		
		$data['departments'] = $this->departmentRepository->all();
		// dd($data['job_position'][0]['job_position']);		
		$this->render('employee/add.twig.html', $data);

	}

	public function save()
	{

		$role_id = $this->input->post('role_id');
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		   $user = $this->sentry->createUser(array(
      			 'email'     => $email,
       			 'password'  => $password,
       			 'activated' => true,
  		  ));

		 $group = $this->sentry->findGroupById($role_id);

		 $user->addGroup($group);


		$user_id =  $user->id;

		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$middle_name = $this->input->post('middle_name');
	
		$full_address = $this->input->post('full_address');
		$job_position = $this->input->post('job_position');
		$branch_id = $this->input->post('branch_id');
		
		$tin_number = $this->input->post('tin_number');
		$sss_number = $this->input->post('sss_number');
		$pagibig_number = $this->input->post('pagibig_number');
		$employee_type = $this->input->post('employee_type');
		$contact_number = $this->input->post('contact_number');
		$job_position  =$this->input->post('job_position');
		$departments = $this->input->post('departments');
		$dependents = $this->input->post('dependents');


 		
		$save = $this->employeeRepository->create(
					array(
						'id' => 2,		
						'first_name' => (string)$first_name,
						'last_name' => (string)$last_name,
						'middle_name' => (string)$middle_name,
						'full_address' => (string)$full_address,
						'job_position' => (string)$job_position,
						'role_id' => intval($role_id),
						'tin_number' => (string)$tin_number,
						'sss_number' => (string)$sss_number,
						'pagibig_number' => (string)$pagibig_number,
						'contact_number' => (string)$contact_number,
						'employee_type' => (string)$employee_type,
						'dependents' => intval($dependents),
						'user_id' => intval($user_id),
						'branch_id' => intval($branch_id)
					)	
			);

		

	
		$this->session->set_flashdata('message', $first_name . ' ' . $last_name . ' has been added.');

		redirect('/employees', 'location');


	}
}