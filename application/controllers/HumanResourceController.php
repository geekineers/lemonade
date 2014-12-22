<?php
require_once ('BaseController.php');

class HumanResourceController extends BaseController
{

    protected $formRepository;
    protected $employeeRepository;
    protected $formApplicationRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->load->library('session');

        $this->formRepository            = new FormRepository();
        $this->employeeRepository        = new EmployeeRepository();
        $this->formApplicationRepository = new FormApplicationRepository();
    }

    public function index()
    {
        $title           = 'Forms';
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['company'] = $this->company;
        $user            = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['forms'] = $this->formApplicationRepository->all();
        $this->render('human_resource/index.twig.html', $data);
    }
    public function delete()
    {
        $this->formApplicationRepository->delete($this->input->post('id'));
    }
    public function application()
    {

        $data = $this->formApplicationRepository->getFormAppId($this->input->get('id'));
        
        // $data->type_of_leave = LeaveType::find($data->type_of_leave)->leave_type_name;
        $form_data = json_decode($data['form_data']);
        // $form_data->type_of_leave  =  LeaveType::find($form_data->type_of_leave)->leave_type_name;
        $data['form_data'] = json_encode($form_data);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function approve()
    {
        $id = $this->input->post('id');
        $employee_id = $this->employeeRepository->getLoginUser($this->sentry->getUser())->id;
        echo $this->formApplicationRepository->approved($id, $employee_id);

    }

    public function disapproved()
    {
        $id = $this->input->post('id');

        echo $this->formApplicationRepository->disapproved($id);
    }
}
