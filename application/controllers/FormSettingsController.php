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

		$this->employeeRepository = new EmployeeRepository();

	}

	public function index()
	{
		$title = 'Forms';

		$user = $this->employeeRepository->getLoginUser($this->sentry->getUser());

		$this->render('form_settings/index.twig.html', compact('user', 'title'));
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

	}

	public function update()
	{

	}

	public function delete()
	{

	}

}
