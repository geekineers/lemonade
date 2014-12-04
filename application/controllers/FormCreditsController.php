<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class FormCreditsController extends BaseController
{

    protected $evaluationRepository, $employeeRepository,$employeeFormCreditsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->evaluationRepository = new EvaluationRepository();
        $this->employeeRepository   = new EmployeeRepository();
        $this->$employeeFormCreditsRepository new EmployeeFormCreditsRepository()
        $this->load->library('session'); 

    }

    public function index()
    {

 
    }

    public function store()
    {
    	$data = $this->input->post();
    	$employee_id = $this->input->post('employee_id');
        return $this->employeeFormCreditsRepository->createNewCreditsForEmployee($employee_id, $data);
    }

    public function update()
    {
        $data = $this->input->post();
        $employee_id =  $this->inpupt->post('employee_id');
        return $this->employeeFormCreditsRepository->updateCreditsForEmployee($employee_id,$data);
    }
}
