<?php
require_once ('BaseController.php');

class SubDepartmentController extends BaseController {

    protected $SubDepartmentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->employeeRepository       = new EmployeeRepository();
        $this->subDepartmentRepository  = new SubDepartmentRepository();
        $this->departmentRepository     = new DepartmentRepository();
        $this->branchRepository         = new BranchRepository();
        $this->load->library('session');
    }

    public function index()
    {
        // $data['alert_message'] = ($this->session->flashdata('message') == null)
        // ? null : $this->session->flashdata('message');
        $data['company']     = $this->company;
        $data['title']       = "Sub-Department";
        $data['departments'] = $this->departmentRepository->all();
        $data['sub_depts']   = $this->subDepartmentRepository->all();
        $data['branches']    = $this->branchRepository->all();
        $data['user']        = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $this->render('sub-department/index.twig.html', $data);
    }

    public function add()
    {
        $data['title'] = "Sub Department";
        $data['user']  = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $this->render('/sub-department/add.twig.html', $data);
    }

    public function save()
    {
        $input['sub_department_name']        = (string) $this->input->post('sub_department_name');
        $input['sub_department_description'] = (string) $this->input->post('sub_department_description');
        $input['parent_department_id']     = (int) $this->input->post('parent_department_id');
        $sub = $this->subDepartmentRepository->createNotExist($input);
        // dd($input);
        if ($sub) {
            $this->session->set_flashdata('alert_message', ' added.');
            redirect('/settings/sub-department');
        } else {
            $this->session->set_flashdata('alert_message', ' is already in here.');
            // dd($message);
            redirect('/sub-department/add');
        }

        redirect('settings/sub-department', 'location');
    }

    public function update()
    {
        $id    = $this->input->post('id');
        $input = $this->input->post();

        $this->subDepartmentRepository->update($input, $id);
        redirect('/settings/sub-department');

    }
    
    public function delete()
    {
        $id  = $this->input->get('token');
        
        $this->subDepartmentRepository->delete($id);
        $this->session->set_flashdata('message', 'Successfully deleted!');
        redirect('/settings/sub-department');
       
    }

    public function trash()
    {
        $data['company']           =  $this->company;
        $data['alert_message']     =  ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
        $data['user']              =  $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']             =  "Deleted Sub-Departments";
        $data['sub_depts']         =  $this->subDepartmentRepository->all();
        $data['sub_dept_trashes']  =  $this->subDepartmentRepository->onlyTrashed()->get();
        $this->render('sub-department/trash.twig.html', $data);
    }

    public function restore($id)
    {
        if(is_null($id)) {
            $this->session->set_flashdata('message', 'Error!');
            redirect('settings/sub-department/trash','location');
        }

        $this->subDepartmentRepository->where('id', '=', $id)
            ->onlyTrashed()
            ->first()
            ->restore();

        $this->session->set_flashdata('alert_message', 'Succesfully Restored!');
        redirect('settings/sub-department/trash','location');
    }

}
