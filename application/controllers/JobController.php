<?php
require_once('BaseController.php');

class JobController extends BaseController {

	protected $jobPositionRepository;
	protected $employeeRepository;

	public function __construct()
	{
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->jobPositionRepository = new JobPositionRepository();
		$this->employeeRepository = new EmployeeRepository();
		$this->load->library('session');

	}
	public function index()
	{
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$data['title'] = "Job Positions";
		$data['groups'] = $this->jobPositionRepository->all();

		// dd($data);
		$this->render('job_position/index.twig.html', $data);

	}

	public function add()
	{

		// $data['permissions'] = $this->config->item('permissions');
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());

		$data['title'] = "Job Position";

		$this->render('/job_position/add.twig.html', $data);

	}

	public function save()
	{
		$input['job_position'] = (string) $this->input->post('job_position');
		$input['job_description'] = (string) $this->input->post('job_description');


		// dd($input);
		$job  =  $this->jobPositionRepository->createNotExist($input);
		if($job){
			$this->session->set_flashdata('message',$input['job_position']  .' has been added.');
			redirect('/settings/job');
		}
		else{
			$this->session->set_flashdata('message',$input['job_position']  .' is already in here.');

			redirect('/settings/job/add');
		}
	}
}
