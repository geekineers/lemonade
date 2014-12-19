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

    public function delete()
    {
        $id = $this->input->get('id');
        $leave_type = LeaveType::where('id', '=', $id)->first();
        $leave_type->delete();

        $this->session->set_flashdata('alert_message', ' Successfully deleted.');
        redirect('settings/leave-types', 'location');        
    }

    public function edit()
    {
        $id = $this->input->get('id');
        $data['id'] = $id;
        $data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['roles'] = Group::where('company_id', '=', COMPANY_ID)->get();
        $data['title']  = "Edit Leave Type";
        $this->render('leave-types/edit.twig.html', $data);
    }

    public function update()
    {
        $data = [
            'leave_type_name' => $this->input->post('leave_type_name'),
            'leave_type_base_points' => $this->input->post('leave_type_base_points'),
            'leave_type_points_earning' => $this->input->post('leave_type_points_earning')
        ];
        $id = $this->input->post('id');
        // dd($this->leaveTypeRepository->find($id));
        $save = $this->leaveTypeRepository->find($id)->update($data);
        $this->session->set_flashdata('message', ' All settings has been updated.');
        
        redirect('/settings/leave-types', 'location');
    }

    public function store()
    {

        $requiredApproval = $this->input->post('leave_type_required_approval');
        $name             = $this->input->post('leave_type_name');
        $leavesq          = $this->input->post('leave_type_approval_sequence');
        $basePoints       = $this->input->post('leave_type_base_points');
        $pointsEarning    = $this->input->post('leave_type_points_earning');

        $check = $this->leaveTypeRepository->createType($name,$leavesq,$requiredApproval,$basePoints,$pointsEarning );
        if($check)
        {
            $this->sendJSON(['status'=>'success']);
        }
        else
        {
            $this->sendJSON(['status'=>'error']);
        }
        redirect('/settings/leave-types');
    }
}