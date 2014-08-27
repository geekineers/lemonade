<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');

class MainController extends BaseController 
{

	protected $employeeRepository;
	protected $memoRepository;
	protected $announcementRepository;
	protected $holidayRepository;
	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->employeeRepository = new EmployeeRepository();
		$this->evaluationRepository = new EvaluationRepository();
		$this->memoRepository = new MemoRepository();
		$this->holidayRepository = new HolidayRepository($this->sentry);
		$this->announcementRepository = new AnnouncementRepository();
		$this->load->library('session');
	}

	public function index()
	{
		redirect('/auth');
	}

	public function dashboard()
	{

		
		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$data['datetime'] = array(
				'time' => date('h:i:s A'),
				'day' => date('l'),
				'month' => date('M'),
				'date' => date('d')

			);
		$data['time_in_status'] = $this->session->userdata('time_in_status');
		$data['evaluations_trainings'] = $this->evaluationRepository->getMyEval($data['user']->id);
		$data['title'] = "Dashboard";
		$data['birthdays'] = $this->employeeRepository->getNearBirthday();
		$data['memos'] = $this->memoRepository->where('to', $data['user']->id)->orderBy('id', 'desc')->get();
		$data['holidays'] = $this->holidayRepository->whereBetween('holiday_from', [date('Y-m-d'), date('Y-m-d', strtotime('+1 year'))])->take(3)->get();
		$data['announcements'] = $this->announcementRepository->getAllAnnouncement();
		
		$this->render('index.twig.html', $data);
	}

	
	public function test()
	{

		$salary = (int) $this->input->get('salary');
		$period =  $this->input->get('period');
		$dependents = (int) $this->input->get('dependents');
		echo json_encode( getWTax($salary,$period,$dependents) );
	}

	public function slip()
	{
		$salary = (int) $this->input->get('salary');
		$period =  $this->input->get('period');
		$dependents = (int) $this->input->get('dependents');
		$pagibig = $this->input->get('pagibig');
		$sss = $this->input->get('sss');
		$ph = $this->input->get('ph');
		$data =  getWithholdingTax($salary,$period ,$dependents,$ph,$pagibig,$sss) ;
		$this->render('slip.twig.html',$data);

	}



}