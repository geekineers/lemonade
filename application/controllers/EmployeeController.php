<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

use Upload\Storage\FileSystem as FileSystem;


class EmployeeController extends BaseController {

	protected	$employeeRepository, 
				$branchesRepository,
				$jobPositionRepository, 
				$departmentRepository,
				$fileSystem;

	public function __construct()
	{
		parent::__construct();

		$this->mustBeLoggedIn();

		$path = realpath(APPPATH.'../uploads/');
		$this->fileSystem = new FileSystem($path);

		$this->employeeRepository = new EmployeeRepository();
		
		$this->branchesRepository = new BranchRepository();
		$this->jobPositionRepository = new JobPositionRepository();

		$this->departmentRepository = new DepartmentRepository();
		$this->load->library('session'); 
	}


	public function index()
	{
		// // dd(FileSystem);
		// dd(realpath(APPPATH.'../uploads/'));

		$data['alert_message'] = ($this->session->flashdata('message') == null)
			? null
			: $this->session->flashdata('message');
		$data['user'] = $this->sentry->getUser();
		$data['title'] = "Employee";
		$data['employees'] = $this->employeeRepository->all();

		$data['job_positions'] = $this->jobPositionRepository->all();
		$data['departments'] = $this->departmentRepository->all();

		
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


		//EMPLOYEE INFORMATION
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$middle_name = $this->input->post('middle_name');
		$full_address = $this->input->post('full_address');
		$job_position = $this->input->post('job_position');
		$department = $this->input->post('department');
		$role_id = $this->input->post('role_id');
		$branch_id = $this->input->post('branch_id');
		

		//Salary Information
		$basic_pay = $this->input->post('basic_pay');
		$payroll_period = $this->input->post('employee_type');
		$tin_number = $this->input->post('tin_number');
		$sss_number = $this->input->post('sss_number');
		$pagibig_number = $this->input->post('pagibig_number');
		$dependents = (int) $this->input->post('dependents');

		//Contact Information

		$email_address = $this->input->post('email_address');
		$contact_number = $this->input->post('contact_number');

		//User Accounts
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$cofirm_password = $this->input->post('confirm_password');




		// Creation of New Account 

		if($email == "" || $email == null) 
		{	
			
		   $user = $this->sentry->createUser(array(
      			 'email'     => $email,
       			 'password'  => $password,
       			 'activated' => true,
  		  ));

		 	$group = $this->sentry->findGroupById($role_id);
		 	$user->addGroup($group);
			$user_id =  $user->id;
		}
		else 
		{
			$user_id = null;
		}

		// Upload Picture 

		$file = new \Upload\File('display_picture', $this->fileSystem);
			// openssl_csr_export_to_file(csr, outfilename)ionally you can rename the file on upload
		$new_filename = uniqid();
		$file->setName($new_filename);

	  // Access data about the file that has been uploaded
		$data = array(
		    'name'       => $file->getNameWithExtension(),
		    'extension'  => $file->getExtension(),
		    'mime'       => $file->getMimetype(),
		    'size'       => $file->getSize(),
		    'md5'        => $file->getMd5(),
		    'dimensions' => $file->getDimensions()
		);

		// Try to upload file
	

		$filename = $file->getNameWithExtension();
	
		$save = $this->employeeRepository->create(
				array(

					'user_id'	=> (string) $user_id,
					'first_name' => (string) $first_name,
					'last_name' => (string) $last_name,
					'middle_name' => (string) $middle_name,
					'full_address' => (string) $full_address,
					'job_position' => (string)$job_position,
					'department' => (int) $department,
					'role_id' => (int) $role_id,
					'branch_id' => (int) $branch_id,
					'basic_pay' => (string) $basic_pay,
					'tin_number' => (string)$tin_number,
					'sss_number' => (string)$sss_number,
					'pagibig_number' => (string)$pagibig_number,
					'dependents' => (int)$dependents,
					'contact_number' => (string)$contact_number,
					'employee_type' => (string)$employee_type,
					'profile_picture' => $filename,
					'email'	=> (string) $email_address,
					'fb'	=> 'mark.a.penaranda',
				)
		);



		try {
		    // Success!
		    $file->upload();
		} catch (\Exception $e) {
		    // Fail!
		    $errors = $file->getErrors();
		}



		$this->session->set_flashdata('message', $first_name . ' ' . $last_name . ' has been added.');

		redirect('/employees', 'location');
	}

	public function profile($id)
	{
		$data['employee'] = $this->employeeRepository->find($id);
		$this->render('/employee/profile.twig.html', $data);
	}
}
