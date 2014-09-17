<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class PHConfigController extends BaseController
{

    protected $employeeRepository,
              $branchRepository, 
              $payrollGroupRepository,
    	      $phConfigRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository       = new BranchRepository();
        $this->payrollGroupRepository = new PayrollGroupRepository();
        $this->phConfigRepository = new PHConfigsRepository();
    }

    public function index()
    {   
        $data['sets'] = $this->phConfigRepository->all();
        $this->render('settings/ph-config.twig.html',$data);
    }

    public function store()
    {
        $data['from_range'] = $this->input->post('from_range');
        $data['to_range'] = $this->input->post('to_range');
        $data['salary_base'] = $this->input->post('salary_base');
        $data['total_monthly_premium'] = $this->input->post('total_monthly_premium');
        $data['employee_share'] = $this->input->post('employee_share');
        $data['employer_share'] = $this->input->post('employer_share');

       
        $check = $this->phConfigRepository->createPH($data);
       
        if($check)
        {
           
            redirect('/settings/philhealth-config');
        }else{
            dd($check);
        }
    }

    public function update()
    {
        $id = $this->input->post('id');
        $data['from_range'] = $this->input->post('from_range');
        $data['to_range'] = $this->input->post('to_range');
        $data['salary_base'] = $this->input->post('salary_base');
        $data['total_monthly_premium'] = $this->input->post('total_monthly_premium');
        $data['employee_share'] = $this->input->post('employee_share');
        $data['employer_share'] = $this->input->post('employer_share');

        $check = $this->phConfigRepository->updatePH($data,$id);
        
        if($check)
        {
            $this->sendJSON(['status'=>'ok']);
        }
        else
        {
            $this->sendJSON(['status'=>'error']);
        }
    }

}