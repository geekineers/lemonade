<?php
require_once('BaseController.php');

class FormsController extends BaseController {

	protected $formRepository;
	protected $employeeRepository;
	protected $formApplicationRepository;

	public function __construct()
	{
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->load->library('session');

		$this->formRepository = new FormRepository();
		$this->employeeRepository = new EmployeeRepository();
		$this->formApplicationRepository = new FormApplicationRepository();
	}	

	public function index()
	{
		$title = 'Forms';

		$user = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		// $forms = $this->formRepository->all();
		$data['form_types'] = [
			['name'=>'OB Form','string_key'=>'ob'],
			['name'=>'OT Form','string_key'=>'ot'],
			['name'=>'Undertime Form','string_key'=>'undertime']
		];
		$data['title'] = $title;
		$data['employees'] = $this->employeeRepository->all();
		$this->render('forms/index.twig.html',$data);
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
			'employee_id' => $this->input->post('employee_id'),
			'prepared_by' =>$this->employeeRepository->getLoginUser($this->sentry->getUser())->id,
			'from' => $this->input->post('from'),
			'to'	=> $this->input->post('to'),
			'effective_date' =>$this->input->post('data'),
			'status' => 'not-yet-approved',
			'form_data' => (string) json_encode($this->input->post('form_data')),
			'form_type' => $this->input->post('form_type')
		];

		$form  =  $this->formApplicationRepository->create($data);
		// if($form){
		// 	$this->session->set_flashdata('message',$data['form_name']  .' has been added.');
		// 	redirect('/settings/forms');
		// }
		// else{
		// 	$this->session->set_flashdata('message', 'There was an error.');
		// 	redirect('/settings/forms/new');
		// }
	}

	public function update()
	{
		$data = [
			'form_name' => $this->input->post('form-name'),
			'form_content' => $this->input->post('form-content'),
			'user_id' => $this->sentry->getUser()->id
		];

		//TODO UPDATE HERE
	}

	public function delete($id)
	{
		if($this->formRepository->delete($id)) {
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
			'last_name'	 => $user->last_name,
			'department' => $user->getDepartment(),
			'position' 	 => $user->getJobPosition()
		];
		$this->output
	    ->set_content_type('application/json')
	    ->set_output(json_encode($data));
	}

	public function formTemplate()
	{
		$template = $this->input->get('template_name');

		if( $template == 'ob' )
		{
			return $this->load->view('forms/ob_form');
		}
		else if ( $template == 'ot')
		{
			return $this->load->view('forms/ot_form');
		}
		else if ( $template == 'undertime')
		{
			return $this->load->view('forms/undertime_form');
		}

	}

}
