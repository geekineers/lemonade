<?php
require_once('BaseController.php');

class FormSettingsController extends BaseController {

	protected $formRepository;
	protected $employeeRepository;

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
		$title = 'Forms';

		$user = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$forms = $this->formRepository->all();

		$this->render('form_settings/index.twig.html', compact('user', 'title', 'forms'));
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

	public function delete()
	{
		$id   = $this->input->get('token');
		$form = $this->formApplicationRepository->find($id);
		$form->delete();
		
		$this->session->set_flashdata('alert_message', 'Form has been deleted.');
		redirect('forms', 'location');
	}

}
