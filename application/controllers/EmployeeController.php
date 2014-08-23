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
				$allowanceRepository,
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
		$this->allowanceRepository = new AllowanceRepository();
		$this->documentRepository = new DocumentRepository();
		$this->basicPayAdjustmentRepository = new BasicPayAdjustmentRepository();
		$this->load->library('session'); 
	}


	public function index()
	{


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
		$data = $this->input->post();
		$this->employeeRepository->updateEmployee201($employee_id, $data);
		redirect('/employees/' . $employee_id . '/profile', 'location');
	}

	public function updateSalary($id)
	{
		$employee_id = $id;
		$post = array(
				'withholding_tax_type' => $this->input->post('withholding_tax_type'),
				'expanded_withholding_tax' => floatval($this->input->post('expanded_withholding_tax')),
				'entitled_night_differential' => (int)$this->input->post('entitled_night_differential'),
				'night_differential_rate' => floatval($this->input->post('night_differential_rate')),
				'entitled_overtime_pay' => (int) $this->input->post('entitled_overtime_pay'),
				'overtime_pay_rate' => floatval($this->input->post('overtime_pay')),
			);
		$update = $this->employeeRepository->where('id', '=', $employee_id)->update($post);

	}

	public function updateContributions($id)
	{
		$employee_id = $id;

		$post = array(
				'deduct_sss' => (boolean) $this->input->post('deduct_sss'),
				'deduct_hdmf' => (boolean) $this->input->post('deduct_hdmf'),
				'deduct_philhealth' => (boolean) $this->input->post('deduct_philhealth'),
				'fixed_sss_amount' => floatval($this->input->post('fixed_sss_amount')),
				'fixed_hdmf_amount' => floatval($this->input->post('fixed_hdmf_amount')),
				'fixed_philhealth_amount' => floatval($this->input->post('fixed_philhealth_amount')),
			);

		$update = $this->employeeRepository->where('id', '=', $employee_id)->update($post);
		redirect('/employees/' . $employee_id . '/profile', 'location');

	}



	public function profile($id)
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['job_positions'] = $this->jobPositionRepository->all();
		$data['branches'] = $this->branchesRepository->all();
		$data['departments'] = $this->departmentRepository->all();
		$data['employee'] = $this->employeeRepository->find($id);
		$data['deduction_types'] = $this->deductionRepository->all();
		$data['allowance_types'] = $this->allowanceRepository->all();
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

	public function search()
	{
		$search_query = $this->input->get('search');
		$items = $this->employeeRepository->search($search_query);
		$data['employees'] = $items;
		
		return $this->render('/employee/search.twig.html', $data);
	


	}


}
