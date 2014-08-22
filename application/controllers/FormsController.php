<?php
require_once('BaseController.php');

class FormsController extends BaseController {

	protected $formRepository;
	protected $employeeRepository;

	public function __construct()
	{
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->load->library('session');

		$this->formRepository = new FormRepository();
		$this->employeeRepository = new EmployeeRepository();

	}

	public function index()
	{
		$title = 'Forms';

		$user = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		// $forms = $this->formRepository->all();

		$data['employees'] = $this->employeeRepository->all();
		$this->render('forms/index.twig.html',$data);
	}

	public function create()
	{
		$user = $this->employeeRepository->getLoginUser($this->sentry->getUser());

		$this->render('form_settings/create.twig.html', compact('user'));
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
			'form_name' => $this->input->post('form-name'),
			'form_content' => $this->input->post('form-content'),
			'user_id' => $this->sentry->getUser()->id
		];

		$form  =  $this->formRepository->create($data);
		if($form){
			$this->session->set_flashdata('message',$data['form_name']  .' has been added.');
			redirect('/settings/forms');
		}
		else{
			$this->session->set_flashdata('message', 'There was an error.');
			redirect('/settings/forms/new');
		}
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

}
