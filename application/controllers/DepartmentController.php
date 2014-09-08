<?php
require_once ('BaseController.php');

class DepartmentController extends BaseController
{

    protected $departmentRepository;
    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->departmentRepository = new DepartmentRepository();
        $this->employeeRepository   = new EmployeeRepository();
        $this->load->library('session');

    }
    public function index()
    {
        $data['company'] = $this->company;
        $data['groups']  = $this->departmentRepository->all();
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']   = "Department";
        // dd($data);
        $this->render('department/index.twig.html', $data);

    }

    public function add()
    {

        // $data['permissions'] = $this->config->item('permissions');
        // $data['user'] = $this->sentry->getUser();
        $data['title'] = "Deparment";
        $data['user']  = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $this->render('/department/add.twig.html', $data);

    }

    public function save()
    {
        $input['department_name']        = (string) $this->input->post('department_name');
        $input['department_description'] = (string) $this->input->post('department_description');

        // dd($input);
        $job = $this->departmentRepository->createNotExist($input);
        if ($job) {
            $this->session->set_flashdata('message', $input['department_name'] . ' has been added.');
            redirect('/settings/department');
        } else {
            $this->session->set_flashdata('message', $input['department_name'] . ' is already in here.');
            dd($message);
            redirect('/department/add');
        }
    }

    public function delete()
    {
        $id = $this->input->get('token');
        $this->departmentRepository->delete($id);
        redirect('/settings/department');
    }

    public function update()
    {
        $id    = $this->input->post('id');
        $input = $this->input->post();

        $this->departmentRepository->update($input, $id);
        redirect('/settings/department');

    }
}
