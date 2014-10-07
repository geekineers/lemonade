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
        $this->branchRepository   = new BranchRepository();
        $this->load->library('session');

    }
    public function index()
    {
        $data['company'] = $this->company;
        $data['groups']  = $this->departmentRepository->all();
        $data['branches']  = $this->branchRepository->all();
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
        $input['branch_id'] = (int) $this->input->post('branch_id');

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
        $this->session->set_flashdata('message', 'Successfully deleted!');
        redirect('/settings/department');
    }

    public function update()
    {
        $id    = $this->input->post('id');
        $input = $this->input->post();

        $this->departmentRepository->update($input, $id);
        redirect('/settings/department');

    }

    public function trash()
    {
        $data['company'] = $this->company;
        $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
        $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']    = "Deleted Departments";
         $data['branches']  = $this->branchRepository->all();
        $data['groups'] = $this->departmentRepository->onlyTrashed()->get();

        $this->render('department/trash.twig.html', $data);
    }

    public function restore($id)
    {
        if(is_null($id)){
            $this->session->set_flashdata('message', 'Error!');
            redirect('settings/department/trash','location');
        }

        $this->departmentRepository->where('id', '=', $id)
                               ->onlyTrashed()
                               ->first()
                               ->restore();

        $this->session->set_flashdata('message', 'Succesfully Restored!');
        redirect('settings/department/trash','location');
    }
}
