<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class MainController extends BaseController 
{

	protected $employeeRepository;
	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->employeeRepository = new EmployeeRepository();

	}

	public function index()
	{

	}

	public function dashboard()
	{

		// dd($this->sentry->getUser());
		$data['user'] = $this->sentry->getUser();
		$data['title'] = "Dashboard";

		$this->render('index.twig.html', $data);
	}

	public function test()
	{
		// $salary = (int) $this->input->get('salary');
		
		// echo json_encode( getWithholdingTax($salary,true,true,true) );
		$save = $this->employeeRepository->create(
					[
						'id' => 3,
						'first_name' => '$first_name',
						'last_name' => '$last_name',
						'middle_name' => 'middle_name',
						'full_address' => '$full_address',
						'job_position' => '$job_position',
						'role_id' => '$role_id',
						'tin_number' => '$tin_number',
						'sss_number' => '$sss_number',
						'pagibig_number' => '$pagibig_number',
						'contact_number' => '$contact_number',
						'employee_type' =>' $employee_type',
						'dependents' =>' $dependents',
						'user_id' =>' $user_id',
						'branch_id' => '$branch_id'
				 ]
			);
		dd($save);
	}
}