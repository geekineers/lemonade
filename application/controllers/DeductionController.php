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
		$recurring = $this->input->post('recurring');
		$valid_from = $this->input->post('valid_from');
		$valid_to = $this->input->post('valid_to');
		

		$post = array(
				'employee_id' => (int) $employee_id,
				'deduction_id' => (int) $deduction_id,
				'recurring' => $recurring,
				'amount' => floatval($amount),
				'valid_from' => $valid_from,
				'valid_to' => $valid_to

			);

		// dd($post);

		$this->employeeDeductionRepository->create($post);

		redirect('/employees/' . $employee_id  . '/profile', 'location');

	}


    public function delete()
    {
        $id = $this->input->get('id');

        $branch_name = $this->deductionRepository->find($id)->deduction_name;

        $this->deductionRepository->find($id)->delete();
        $this->session->set_flashdata('message', $branch_name.' has been deleted.');
        redirect('/settings/deductions', 'location');

    }

    public function update()
    {
    	$id = $this->input->post('id');
    	$input = $this->input->post();

    	$this->deductionRepository->update($input, $id);

    	redirect('/settings/deductions', 'location');
    }

}
