<?php
require_once ('BaseController.php');

class SubDepartmentController extends BaseController {

    protected $SubDepartmentRepository;

    public function __construct()
    {

        // $this->load->library('session');
    }

    public function index()
    {
        // $data['alert_message'] = ($this->session->flashdata('message') == null)
        // ? null : $this->session->flashdata('message');
        $data['company'] = $this->company;
        $data['title'] = "Sub-Department";   
        $this->render('sub-department/index.twig.html', $data);
    }

    public function add()
    {

    }

    public function save()
    {

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
