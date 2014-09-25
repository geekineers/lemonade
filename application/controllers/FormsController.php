<?php
require_once ('BaseController.php');

class FormsController extends BaseController
{

    protected $formRepository;
    protected $employeeRepository;
    protected $formApplicationRepository;
    protected  $leaveCreditsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->load->library('session');

        $this->formRepository            = new FormRepository();
        $this->employeeRepository        = new EmployeeRepository();
        $this->leaveTypeRepository = new LeaveTypeRepository();
        $this->formApplicationRepository = new FormApplicationRepository();
    }

    public function index()
    {

        $title           = 'Forms';
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['company'] = $this->company;
        $user            = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['forms'] = $this->formApplicationRepository->all();
        $this->render('forms/index.twig.html', $data);
    }

    public function apply()
    {

        $title = 'Forms';

        $user = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        // $forms = $this->formRepository->all();
        $data['form_types'] = [
            ['name' => 'OB Form', 'string_key' => 'ob'],
            ['name' => 'OT Form', 'string_key' => 'ot'],
            ['name' => 'Undertime Form', 'string_key' => 'undertime'],
            ['name' => 'Leave Form', 'string_key' => 'leave']

        ];
        $data['company']   = $this->company;
        $data['title']     = $title;
        $data['employees'] = $this->employeeRepository->all();
        $this->render('forms/apply.twig.html', $data);

    }
    public function viewPrint($id)
    {
        $form = $this->input->get('type');
        $this->formRepository->viewForm($form, $id);
    }
    public function employeeApply()
    {

        $title = 'Forms';

        $user = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        // $forms = $this->formRepository->all();
        $data['form_types'] = [
            ['name' => 'OB Form', 'string_key' => 'ob'],
            ['name' => 'OT Form', 'string_key' => 'ot'],
            ['name' => 'Undertime Form', 'string_key' => 'undertime'],
            ['name' => 'Leave Form', 'string_key' => 'leave']

        ];
        $data['company'] = $this->company;
        $data['title']   = $title;
        $data['user']    = $user;
        $this->render('forms/employee_form.twig.html', $data);
    }
    public function edit()
    {
        $user = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $this->render('forms_settings/edit.twig.html', compact('user'));
    }

    public function show()
    {
        $user = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $this->render('forms_settings/show.twig.html', compact('user'));
    }

    public function store()
    {

        $data = [
            'employee_id'    => $this->input->post('employee_id'),
            'prepared_by'    => $this->employeeRepository->getLoginUser($this->sentry->getUser())->id,
            'from'           => date('Y-m-d H:i:s', strtotime($this->input->post('from'))),
            'to'             => date('Y-m-d H:i:s', strtotime($this->input->post('to'))),
            'effective_date' => $this->input->post('date'),
            'status'         => 'not-yet-approved',
            'form_data'      => (string) json_encode($this->input->post('form_data')),
            'form_type'      => $this->input->post('form_type')
        ];

        $form = $this->formApplicationRepository->createForm($data);
        if (!$form) {
            $this->sendJSON(['status' => 0]);
        } else {
            $this->sendJSON(['status' => 1]);
        }
    }

    public function delete($id)
    {
        if ($this->formRepository->delete($id)) {
            $this->session->set_flashdata('message', 'Form has been deleted.');
        } else {
            $this->session->set_flashdata('message', 'There was an error.');

        }

        redirect('/settings/forms');
    }

    public function restGetUser()
    {
        $user = $this->employeeRepository->getUserById($this->input->get('id'));

        $data = [
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'department' => $user->getDepartment(),
            'position'   => $user->getJobPosition()
        ];
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($data));
    }

    public function formTemplate()
    {
        $template    = $this->input->get('template_name');
        $employee_id = $this->input->get('employee_id');

        $employee          = $this->employeeRepository->getUserById($employee_id);
        $data['remaining'] = $employee->getRemainingCredits($template);
        $data['leaves'] = $this->leaveTypeRepository->all();
        if ($template == 'ob') {
            return $this->load->view('forms/ob_form', $data);
        } else if ($template == 'ot') {
            return $this->load->view('forms/ot_form', $data);
        } else if ($template == 'undertime') {
            return $this->load->view('forms/undertime_form', $data);
        } else if ($template == 'leave') {
            return $this->load->view('forms/leave_form', $data);
        }

    }

}
