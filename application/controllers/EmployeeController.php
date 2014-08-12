<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

use Upload\Storage\FileSystem as FileSystem;


class EmployeeController extends BaseController {

	protected	$employeeRepository, 
				$branchesRepository,
				$jobPositionRepository, 
				$departmentRepository,
				$documentRepository,
				$deductionRepository,
				$basicPayAdjustmentRepository,
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
		$this->deductionRepository = new DeductionRepository();
		$this->documentRepository = new DocumentRepository();
		$this->basicPayAdjustmentRepository = new BasicPayAdjustmentRepository();
		$this->load->library('session'); 
	}


	public function index()
	{
		// // dd(FileSystem);
		// dd(realpath(APPPATH.'../uploads/'));

		$data['alert_message'] = ($this->session->flashdata('message') == null)
			? null
			: $this->session->flashdata('message');
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$data['title'] = "Employee";
		$data['employees'] = $this->employeeRepository->all();

		$data['job_positions'] = $this->jobPositionRepository->all();
		$data['departments'] = $this->departmentRepository->all();

		
		$this->render('/employee/index.twig.html', $data);
	}

	public function add()
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$data['title'] = "Employees";
		$data['branches'] = $this->branchesRepository->all();
		$data['groups'] = $this->sentry->findAllGroups();
		$data['job_positions'] = $this->jobPositionRepository->all();
		$data['departments'] = $this->departmentRepository->all();
		// dd($data['job_position'][0]['job_position']);		
		$this->render('employee/add.twig.html', $data);

	}

	public function update()
	{
		$employee_id = $this->input->post('id');
		$post = array(
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'middle_name' => $this->input->post('middle_name'),
		'full_address' => $this->input->post('full_address'),
		'birthdate' => $this->input->post('birthdate'),
		'gender' => $this->input->post('gender'),
		'marital_status' => $this->input->post('marital_status'),
		// 'spouse_name' => $this->input->post('spouse_name'),
		'dependents' => (int) $this->input->post('dependents'),

		// Employee Details
		'employee_type' => $this->input->post('employee_type'),
		'payroll_period' => $this->input->post('payroll_period'),
		'job_position' => (int) $this->input->post('job_position'),
		'department' => (int) $this->input->post('department'),
		'role_id' => (int) $this->input->post('role_id'),
		'branch_id'=> (int) $this->input->post('branch_id'),
		'date_hired' => $this->input->post('date_hired'),
		// 'basic_pay' => $this->input->post('basic_pay'),
		

		// Government Details
		'tin_number' => $this->input->post('tin_number'),
		'sss_number' => $this->input->post('sss_number'),
		'pagibig_number' => $this->input->post('pagibig_number'),
			);
		// dd($post);
		$this->employeeRepository->where('id', '=', $employee_id)->update($post);

		redirect('/employees/' . $employee_id . '/profile', 'location');
	}

	public function updateSalary($id)
	{
		$employee_id = $id;
		// $post = $this->input->post();
		$post = array(
				'withholding_tax_type' => $this->input->post('withholding_tax_type'),
				'expanded_withholding_tax' => floatval($this->input->post('expanded_withholding_tax')),
				'entitled_night_differential' => (int)$this->input->post('entitled_night_differential'),
				'night_differential_rate' => floatval($this->input->post('night_differential_rate')),
				'entitled_overtime_pay' => (int) $this->input->post('entitled_overtime_pay'),
				'overtime_pay_rate' => floatval($this->input->post('overtime_pay')),
			);
		// dd($post);
		$update = $this->employeeRepository->where('id', '=', $employee_id)->update($post);
		dd($update);
	}

	public function save()
	{


		// Basic Info
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$middle_name = $this->input->post('middle_name');
		$full_address = $this->input->post('full_address');
		$birthdate = $this->input->post('birthdate');
		$gender = $this->input->post('gender');
		$marital_status = $this->input->post('marital_status');
		$spouse_name = $this->input->post('spouse_name');
		$dependents = (int) $this->input->post('dependents');

		// Employee Details
		$employee_type = $this->input->post('employee_type');
		$payroll_period = $this->input->post('payroll_period');
		$job_position = $this->input->post('job_position');
		$department = $this->input->post('department');
		$role_id = $this->input->post('role_id');
		$branch_id = $this->input->post('branch_id');
		$date_hired = $this->input->post('date_hire');
		$basic_pay = $this->input->post('basic_pay');
		

		// Government Details
		$tin_number = $this->input->post('tin_number');
		$sss_number = $this->input->post('sss_number');
		$pagibig_number = $this->input->post('pagibig_number');

		//Contact Information

		$email_address = $this->input->post('email_address');
		$contact_number = $this->input->post('contact_number');
		$fb = $this->input->post('fb');

		//User Accounts
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$cofirm_password = $this->input->post('confirm_password');




		// Creation of New Account 

		if($email != "") 
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
	
		$save =$this->employeeRepository->create(
				array(

					'user_id'	=> (string) $user_id,
					'first_name' => (string) $first_name,
					'last_name' => (string) $last_name,
					'middle_name' => (string) $middle_name,
					'full_address' => (string) $full_address,
					'birthdate' => (string) $birthdate,
					'gender' => (string)$gender,
					'marital_status' => (string)$marital_status,
					'spouse_name' => (string)$spouse_name,
					'employee_type' => (string)$employee_type,
					'payroll_period' => (string)$payroll_period,
					'job_position' => (string)$job_position,
					'department' => (int) $department,
					'role_id' => (int) $role_id,
					'branch_id' => (int) $branch_id,
					'date_hired' =>  (string) $date_hired,
					'date_ended' =>  (string) "none",
					'basic_pay' => (string) $basic_pay,
					'tin_number' => (string)$tin_number,
					'sss_number' => (string)$sss_number,
					'pagibig_number' => (string)$pagibig_number,
					'dependents' => (int)$dependents,
					'contact_number' => (string)$contact_number,
					'profile_picture' => $filename,
					'email'	=> (string) $email_address,
					'fb'	=> (string)$fb,
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
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['job_positions'] = $this->jobPositionRepository->all();
		$data['branches'] = $this->branchesRepository->all();
		$data['departments'] = $this->departmentRepository->all();
		$data['employee'] = $this->employeeRepository->find($id);
		$data['deduction_types'] = $this->deductionRepository->all();
		// $data['documents'] = $this->employeeRepository->find($id);
		$this->render('/employee/profile.twig.html', $data);
	}

	public function upload()
	{	
		$new_filename = uniqid();
		$file = new \Upload\File('file', $this->fileSystem);
		$file->setName($new_filename);
		$data = array(
			'employee_id'    => (int)$this->input->post('employee_id'),
			'name'			  => (string)$this->input->post('name'),
			'file_description' => (string)$this->input->post('description'),
		    'file_name'       => (string)$file->getNameWithExtension(),
		    'file_extension'  => (string)$file->getExtension(),
		    'file_type'       => (string)$file->getMimetype(),
		    'file_size'       => (string)$file->getSize()
		);

		try {
		    // Success!
		    $file->upload();
		} catch (\Exception $e) {
		    // Fail!
		    $errors = $file->getErrors();
		}

		// dd($data);
		$this->documentRepository->create($data);


		redirect('/employees/' . $this->input->post('employee_id') . '/profile', 'location');

	}

	public function adjustBasicPay()
	{


		$employee_id = $this->input->post('employee_id');
		$current_basic_pay = str_replace(',', '', $this->input->post('current_basic_pay'));
		$new_basic_pay = str_replace(',', '', $this->input->post('new_basic_pay'));
		$effective_date = $this->input->post('effective_date');
		$adjustment_date = $this->input->post('adjustment_date');
		$adjustment_reason = $this->input->post('adjustment_reason');
		$created_by = $this->sentry->getUser()->id;

		$post = array(
				'employee_id' => (int)$employee_id,
				'current_basic_pay' => floatval($current_basic_pay),
				'new_basic_pay' => floatval($new_basic_pay),
				'effective_date' => $effective_date,
				'adjustment_date' => $adjustment_date,
				'adjustment_reason' => $adjustment_reason,
				'created_by' => $created_by,
				
			);
		// $post = $this->input->post();

		// dd($post);

		$this->basicPayAdjustmentRepository->create($post);
		redirect('/employees/' . $this->input->post('employee_id') . '/profile', 'location');



	}


}
