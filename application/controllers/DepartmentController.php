<?php
require_once('BaseController.php');

class DepartmentController extends BaseController {

	protected $departmentRepository;
	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->departmentRepository = new DepartmentRepository();
		$this->load->library('session'); 

	}
	public function index() 
	{
		$data['groups'] = $this->departmentRepository->all();

		// dd($data);
		$this->render('department/index.twig.html', $data);

	}

	public function add()
	{
	
		// $data['permissions'] = $this->config->item('permissions');
		// $data['user'] = $this->sentry->getUser();
		$data['title'] = "Deparment";

		$this->render('/department/add.twig.html', $data);

	}

	public function save()
	{
		$input['department_name'] = (string) $this->input->post('department_name');
		$input['department_description'] = (string) $this->input->post('department_description');
		
		
		// dd($input);
		$job  =  $this->departmentRepository->createNotExist($input);
		if($job){
			$this->session->set_flashdata('message',$input['department_name']  .' has been added.');
			redirect('/department');
		}
		else{
			$this->session->set_flashdata('message',$input['department_name']  .' is already in here.');
			dd($message);
			redirect('/department/add');  
		}
	}
}