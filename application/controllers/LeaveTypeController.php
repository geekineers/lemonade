<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');


class LeaveTypeController extends BaseController {

    protected $branchRepository,
			  $employeeRepository,
			  $leaveCreditsRepository;
    
    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository   = new BranchRepository();
        $this->employeeRepository = new EmployeeRepository();
        $this->leaveTypeRepository = new LeaveTypeRepository();
        $this->load->library('session');

    }

    public function index()
    {
    	 $data['company'] = $this->company;
        $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
        $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']    = "Leave Types";
        $data['types'] = $this->leaveTypeRepository->all();

        $this->render('leave-types/index.twig.html', $data);

      	
    }
      public function add()
    {
 		$data['company'] = $this->company;
       
        $data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title'] = "Leave Types";

        $this->render('leave-types/add.twig.html', $data);

    }

}