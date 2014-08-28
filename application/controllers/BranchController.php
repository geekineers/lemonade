<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class BranchController extends BaseController
{

    protected $branchRepository;
    protected $employeeRepository;
    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository   = new BranchRepository();
        $this->employeeRepository = new EmployeeRepository();
        $this->load->library('session');

    }

    public function index()
    {

        $data['alert_message'] = ($this->session->flashdata('message') == null)?null:$this->session->flashdata('message');
        $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['title']    = "Branches";
        $data['branches'] = $this->branchRepository->all();
        $this->render('branch/index.twig.html', $data);

    }

    public function add()
    {

        $data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['title'] = "Branches";
        $this->render('branch/add.twig.html', $data);

    }

    public function save()
    {
        $branch_name = $this->input->post('branch_name');

        $save = $this->branchRepository->create($this->input->post());
        // dd($save);
        $this->session->set_flashdata('message', $branch_name.' has been added.');

        redirect('/settings/branches', 'location');

    }

    public function edit()
    {
        $id = $this->input->get('id');

        $data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['title']  = "Branches";
        $data['branch'] = $this->branchRepository->find($id);

        $this->render('branch/edit.twig.html', $data);

    }

    public function update()
    {
        $branch_name = $this->input->post('branch_name');
        $id          = $this->input->post('id');
        $save        = $this->branchRepository->find($id)->update($this->input->post());
        $this->session->set_flashdata('message', $branch_name.' has been updated.');
        redirect('/settings/branches', 'location');

    }

    public function delete()
    {
        $id = $this->input->get('id');

        $branch_name = $this->branchRepository->find($id)->branch_name;

        $this->branchRepository->delete($id);
        $this->session->set_flashdata('message', $branch_name.' has been deleted.');
        redirect('/settings/branches', 'location');

    }

}
