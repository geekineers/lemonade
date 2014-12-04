<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class TrainingController extends BaseController
{

    protected $trainingRepository;
    protected $employeeRepository;
    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->trainingRepository = new TrainingRepository();
        $this->employeeRepository = new EmployeeRepository();
        $this->load->library('session');

    }

    public function index()
    {

    }

    public function save()
    {
        $this->trainingRepository->saveTraining($this->input->post());
        redirect('/employees/' . $this->input->post('employee_id') . '/profile', 'location');
    }

    public function delete()
    {
        $this->trainingRepository->deleteTraining($this->input->get());
        $this->session->set_flashdata('message', $training_name . ' has been deleted.');
        redirect('/employees/' . $this->input->get('eid') . '/profile', 'location');

    }

}
