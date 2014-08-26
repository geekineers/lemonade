<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class EvaluationController extends BaseController
{

    protected $evaluationRepository, $employeeRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->evaluationRepository = new EvaluationRepository();
        $this->employeeRepository   = new EmployeeRepository();
        $this->load->library('session');

    }

    public function index()
    {

        $data['alert_message'] = ($this->session->flashdata('message') == null)?null:$this->session->flashdata('message');
        $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['title']    = "Branches";
        $data['branches'] = $this->branchRepository->all();
        $this->render('branch/index.twig.html', $data);

    }

    public function store()
    {
    	$data = $this->input->post();
    	$employee_id = $this->input->post('employee_id');
    	$creator = $this->employeeRepository->getLoginUser($this->sentry->getUser());
    	return $this->evaluationRepository->scheduleForEvaluation($employee_id, $data, $creator->id);
    	
    }

}
