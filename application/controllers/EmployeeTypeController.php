<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class EmployeeTypeController extends BaseController
{

    protected $branchRepository;
    protected $employeeRepository;
    protected $employeeTypeRepository;
    
    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository   = new BranchRepository();
        $this->employeeRepository = new EmployeeRepository();
        $this->employeeTypeRepository = new EmployeeTypeRepository();
        $this->load->library('session');

    }

    public function index()
    {
        $data['company'] = $this->company;
        $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
        $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']    = "Employee Type";
        $data['employee_types'] = $this->employeeTypeRepository->all();

        $this->render('employee_type/index.twig.html', $data);

    }

    public function add()
    {

        $data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title'] = "Branches";

        $this->render('employee-types/add.twig.html', $data);

    }

    public function save()
    {
        $employee_type_name = $this->input->post('employee_type_name');
        $save = $this->employeeTypeRepository->saveEmployeeType($employee_type_name);
        $this->session->set_flashdata('message', $employee_type_name . ' has been added.');

        redirect('/settings/employee-types', 'location');

    }

    public function edit()
    {
        $id = $this->input->get('id');
        $data['company'] = $this->company;
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']  = "Branches";
        $data['employee-types'] = $this->branchRepository->find($id);

  
        $this->render('employee-types/edit.twig.html', $data);

    }

    public function update()
    {
        $name = $this->input->post('employee_type_name');
        $id = $this->input->post('id');
      
        $save        = $this->employeeTypeRepository->updateEmployeeType($id, $name);
        $this->session->set_flashdata('message', $name . ' has been updated.');
        
        redirect('/settings/employee-types', 'location');

    }

    public function delete()
    {
        $id = $this->input->get('id');
        $employee_type_name = $this->employeeTypeRepository->find($id)->employee_type_name;
        $this->employeeTypeRepository->delete($id);
        $this->session->set_flashdata('message', $employee_type_name . ' has been deleted.');
       
        redirect('/settings/employee-types', 'location');

    }

    public function trash()
    {
        $data['company'] = $this->company;
        $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
        $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title']    = "Deleted employee-types";
        $data['employee_types'] = $this->employeeTypeRepository->onlyTrashed()->get();

        $this->render('employee_type/trash.twig.html', $data);
    }

    public function restore($id)
    {
        if(is_null($id)){
            $this->session->set_flashdata('message', 'Error!');
            redirect('settings/employee-types/trash','location');
        }

        $this->employeeTypeRepository->where('id', '=', $id)
                               ->onlyTrashed()
                               ->first()
                               ->restore();

        $this->session->set_flashdata('message', 'Succesfully Restored!');
            redirect('settings/employee-types/trash','location');
    }
}
