<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class WithholdingtaxController extends BaseController
{

    protected   $employeeRepository,
            $branchRepository, 
            $payrollGroupRepository,
    	    $wtConfigRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository       = new BranchRepository();
        $this->payrollGroupRepository = new PayrollGroupRepository();
        $this->wtConfigRepository = new WTConfigsRepository();
    }

    public function index()
    {   
        $data['sets'] = $this->wtConfigRepository->all();
        $this->render('settings/wt-config.twig.html',$data);
    }

    public function store()
    {
        $data['from_range'] = $this->input->post('from_range');
        $data['to_range'] = $this->input->post('to_range');
        $data['monthly_salary_credit'] = $this->input->post('monthly_salary_credit');
        $data['ER'] = $this->input->post('er');
        $data['EE'] = $this->input->post('ee');
        $data['EC'] = $this->input->post('ec');
        $data['TTC'] = $this->input->post('ttc');


        $check = $this->wtConfigRepository->createWt($data);
       
        if($check)
        {
           
            redirect('/settings/wt-config');
        }else{
            dd($check);
        }
    }

    public function update()
    {
        $id = $this->input->post('id');
        $data['from_range'] = $this->input->post('from_range');
        $data['to_range'] = $this->input->post('to_range');
        $data['monthly_salary_credit'] = $this->input->post('monthly_salary_credit');
        $data['ER'] = $this->input->post('er');
        $data['EE'] = $this->input->post('ee');
        $data['EC'] = $this->input->post('ec');
        $data['TTC'] = $this->input->post('ttc');

        $check = $this->wtConfigRepository->updateWt($data,$id);
        
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