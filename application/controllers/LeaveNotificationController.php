<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');
use Cartalyst\Sentry\Groups\Eloquent\Group;

class LeaveNotificationController extends BaseController {

    protected $branchRepository,
			  $employeeRepository,
              $formApplicationRepository,
			  $leaveCreditsRepository;
    
    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository   = new BranchRepository();
        $this->employeeRepository = new EmployeeRepository();
        $this->leaveTypeRepository = new LeaveTypeRepository();
        $this->formApplicationRepository = new FormApplicationRepository();

        $this->load->library('session');

    }

    public function notify()
    {
        $data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        
        $formApplications = $this->formApplicationRepository->where('form_type','=','leave')
                                                           ->where('status','!=','approved')
                                                           ->where('employee_id','=',$data['user']->id)->get();

        $forms = [];
        foreach ($formApplications as $formApplication) {
            $form_data = json_decode($formApplication->form_data);
            $forms[] = [
                'id'=>$formApplication->id,
                'form_status' => $formApplication->status,
                'leaves' => $this->leaveTypeRepository->where('id','=',$form_data->type_of_leave)->get(),
            ];
        }
       // dd($form[0]['leaves']);
        $notification = [];
        foreach ($forms as $form ) {

            foreach ($form['leaves'] as $leave) {
                // foreach ($leave as $key => $value) {
                    $roleArrays = explode("|" , $leave->leave_type_required_approval);            
                
                    $employee = $this->employeeRepository->whereIn('role_id',$roleArrays)
                                                        ->where('id','=',$data['user']->id)->first(); 
                    
                    if( $employee != null )
                    {
                        $status = $form['form_status'];
                        if($status=='not-yet-approved'){
                            $notification[] = [
                                'id' => $form['id'],
                                 'status'=>$status,
                                'leave_id'=>$leave->id,
                                'employee_name' => $employee->first_name,
                                'leave_type_name' => $leave->leave_type_name,
                                'leave_type_approval_sequence' => $leave->leave_type_approval_sequence,
                                'leave_type_required_approval' => $leave->leave_type_required_approval,
                                'leave_type_base_points' => $leave->leave_type_base_points
                            ];
                        }else{
                            $status = explode("|",$form['form_status']  );
                            $notification[] = [
                                'id' => $form['id'],
                                'leave_id'=>$leave->id,
                                'status'=>$status,
                                'employee_name' => $employee->first_name,
                                'leave_type_name' => $leave->leave_type_name,
                                'leave_type_approval_sequence' => $leave->leave_type_approval_sequence,
                                'leave_type_required_approval' => $leave->leave_type_required_approval,
                                'leave_type_base_points' => $leave->leave_type_base_points
                            ];

                        }
                    }
                // }                      
            }         

        }

        return $this->sendJSON($notification);
        // $this->employeeRepository->
    }


    

    public function approved()
    {
        $user =  $this->employeeRepository->getLoginUser($this->sentry->getUser());

        // $employee  = $this->employeeRepository->whereIn('role_id',$roleArrays)
        //                                                 ->where('id','=',$user->id)->first();
        $role_id = $user->role_id;

        $id = $this->input->get('id');

        $sq = $this->input->get('sequence');

        $leave_id = $this->input->get('leave_id');

        $status = $this->input->get('status');
    
        $leave = $this->leaveTypeRepository->where('id','=',$leave_id)->first();
        
        $array = $status;

        if($sq=='or'){
            $this->formApplicationRepository->where('id','=',$id)->update(['status'=>'approved']);
            return $this->sendJSON(['status'=>'approved']);
        }else if($sq=='and') {
             $leave_type_required_approval = explode('|',$leave->leave_type_required_approval );

             if($status=='not-yet-approved'){
                $role_index_in_array = array_search(strval($role_id),$leave_type_required_approval);
                unset($leave_type_required_approval[0]);
                $status = implode('|',$leave_type_required_approval);
                
                $this->formApplicationRepository->where('id','=',$id)->update(['status'=>$status]);       
             }else{
                
                $currentStatus = $this->formApplicationRepository->where('id','=',$sq)->status;

                $arrayStatus = explode('|',$currentStatus );

                $role_index_in_array = array_search(strval($role_id),$currentStatus);

                unset($arrayStatus[$role_index_in_array]);

                $status = $arrayStatus;

                $this->formApplicationRepository->where('id','=',$id)->update(['status'=>$status]);
             }
        }
    }
}