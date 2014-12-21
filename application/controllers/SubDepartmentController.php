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
        $this->load->library('session');
    }

    public function index()
    {
        // $data['alert_message'] = ($this->session->flashdata('message') == null)
        // ? null : $this->session->flashdata('message');
        $data['company']    = $this->company;
        $data['title']      = "Sub-Department";
        $data['departments'] = $this->departmentRepository->all();
        $data['sub_depts'] = $this->subDepartmentRepository->all();
        $data['user']  = $this->employeeRepository->getLoginUser($this->sentry->getUser());
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
        $input['parent_department_name']     = (int) $this->input->post('parent_department_id');
        $sub = $this->subDepartmentRepository->createNotExist($input);
        
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

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function trash()
    {

    }

    public function restore()
    {

    }

}
