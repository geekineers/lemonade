<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');




class DeductionController extends BaseController {
	
	protected $branchRepository;
	protected $deductionRepository;
	protected $employeeRepository;
	protected $employeeDeductionRepository;

	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->branchRepository = new BranchRepository();
		$this->employeeRepository = new EmployeeRepository();
		$this->deductionRepository = new DeductionRepository();
		$this->employeeDeductionRepository = new EmployeeDeductionRepository();
		$this->load->library('session'); 

	}

	public function index()
	{

		$data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = "Deductions";
		$data['deductions'] = $this->deductionRepository->all();
		$this->render('deductions/index.twig.html', $data);

	}



	public function save()
	{
		$deduction_name = $this->input->post('deduction_name');
		$post = $this->input->post();
		$post['created_by'] = $this->employeeRepository->getLoginUser($this->sentry->getUser())->id;
		// dd($post);
		$save = $this->deductionRepository->create($post);
		// dd($save);
		$this->session->set_flashdata('message', $deduction_name .' has been added.');

		redirect('/settings/deductions', 'location');

	}


	public function addEmployeeDeduction()
	{
		$employee_id = $this->input->post('employee_id');
		$deduction_id = $this->input->post('deduction_id');
		$amount = $this->input->post('amount');
		$deduction_type = $this->input->post('deduction_type');
		$recurring = $this->input->post('recurring');
		$percentage = $this->input->post('percentage');
		$basis = $this->input->post('basis');
		$valid_from = $this->input->post('valid_from');
		$valid_to = $this->input->post('valid_to');
		

		$post = array(
				'employee_id' => (int) $employee_id,
				'deduction_id' => (int) $deduction_id,
				'recurring' => $recurring,
				'deduction_type' => $deduction_type,
				'amount' => floatval($amount),
				'percentage' => floatval($percentage),
				'basis' => $basis,
				'valid_from' => $valid_from,
				'valid_to' => $valid_to

			);

		// dd($post);

		$this->employeeDeductionRepository->create($post);



	}

}
