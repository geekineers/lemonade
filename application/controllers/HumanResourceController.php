<?php
require_once('BaseController.php');

class HumanResourceController extends BaseController {

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
	
		$data['forms'] = $this->formApplicationRepository->all();
		$this->render('human_resource/index.twig.html',$data);
	}
	public function application()
	{

		$data = $this->formApplicationRepository->getFormAppId($this->input->get('id'));
	
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function approve()
	{
		$id = $this->input->post('id');
		echo $this->formApplicationRepository->approved($id);
		
	}
}
