<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');
use Cartalyst\Sentry\Groups\Eloquent\Group;

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
        $data['roles'] = Group::where('company_id', '=', COMPANY_ID)->get();
        $data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title'] = "Leave Types";
        $this->render('leave-types/add.twig.html', $data);

    }

    public function store()
    {
        // $save = $this->create(
        //         [
        //             'leave_type_name' => $name,
        //             'leave_type_approval_sequence' =>  $approval_seq,
        //             'leave_type_required_approval' =>  $required_approval,
        //             'leave_type_base_points' => $base_points,
        //             'leave_type_points_earning' => $type_of_point_earning,
        //         ]
        //      }
        $requiredApproval = $this->input->post('leave_type_required_approval');
        $name = $this->input->post('leave_type_name');
        $leavesq = $this->input->post('leave_type_approval_sequence');
        $basePoints = $this->input->post('leave_type_base_points');
        $pointsEarning = $this->input->post('leave_type_points_earning');

        $check = $this->leaveTypeRepository->createType($name,$leavesq,$requiredApproval,$basePoints,$pointsEarning );
        if($check){
            $this->sendJSON(['status'=>'success']);
        }else{
            $this->sendJSON(['status'=>'error']);
        }
    }
}