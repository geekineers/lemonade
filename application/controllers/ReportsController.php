<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class ReportsController extends BaseController
{
	protected $branchRepository, $employeeRepository, $departmentRepository;

	public function __construct()
	{
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->branchRepository = new BranchRepository();
		$this->departmentRepository = new DepartmentRepository();
		        $this->employeeRepository = new EmployeeRepository();

	}

	public function generate()
	{
			// $year = ($this->input->get('year') == null) ? date('Y') : $this->input->get('year'); 
			$data['company'] = $this->company;
		 $data['title']    = "Generate Report";
		 $data['branches'] = $this->branchRepository->all();
		   $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());

		  	 $this->render('reports/generate.twig.html',$data);
	
	}

	public function company()
	{
		 $data['title']    = $this->company->company_name . " Report ({$year})";
		 $data['branches'] = $this->branchRepository->all();
		   $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		 $this->render('reports/company.twig.html',$data);
	}
	public function branch($id)
	{
		$year = ($this->input->get('year') == null) ? date('Y') : $this->input->get('year'); 
		$data['company'] = $this->company;
		   $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		$branch = $this->branchRepository->find($id);
		$data['departments'] = $this->departmentRepository->where('branch_id', '=', $id)->get();
        $data['title']    = $branch->branch_name . " Report ({$year})";
		$data['gross_reports'] = $branch->getGrossReport();
		$data['absent_report'] = $branch->getAbsentReport();
		$data['total_absent'] = $branch->getTotalAbsent();
		$data['total_employee'] = $branch->getTotalEmployees();
		$data['total_expenses'] = $branch->getTotalExpenses();
		$data['tardiness_rate'] = $branch->getTardinessRate();
		$data['branch_id'] = $branch->id;
		$data['branches'] = $this->branchRepository->all();
		$data['year'] = $year;

	  	// dd($data['gross_report']);
	    $this->render('reports/branch.twig.html',$data);

	}

	public function grossReport($id)
	{
		$year = ($this->input->get('year') == null) ? null : $this->input->get('year'); 
		$data = [];

		$department_id = ($this->input->get('department_id') == null) ? null : $this->input->get('department_id'); 

		if($department_id == null || $department_id == "NULL"){
			$branch = $this->branchRepository->find($id);	
			$reports = $branch->getGrossReport($year);
			
		}
		else{
			$department = $this->departmentRepository->find($department_id);	
			// dd($department->department_name);
			$reports = $department->getGrossReport($year);
				
		}	
	
		foreach ($reports as $report) {
			$item = [
				'year' => $report->year . '-' . $report->month,
				'expense' => $report->totalgross
			];

			array_push($data, $item);
		}
		// dd($data);

		$this->sendJSON($data);
	}

	public function companyGrossReport()
	{
		$year = ($this->input->get('year') == null) ? null : $this->input->get('year'); 
		$data = [];
		$branches = $this->branchRepository->all();
		foreach ($branches as $branch) {
			$reports = $branch->getGrossReport($year);

			foreach ($reports as $report) {
				$item = [
					'year' => $report->year . '-' . $report->month,
					$branch->branch_name . '-expense' => $report->totalgross
				];
				if(count($data) >= 12){
					$data[$report->month-1][$branch->branch_name . '-expense'] = $report->totalgross;
				}
				else{
					// var_dump('here');
					array_push($data, $item);
					
				}
			}
		}

		$this->sendJSON($data);
	}
	public function absentReport($id)
	{
		$year = ($this->input->get('year') == null) ? null : $this->input->get('year'); 
		$data = [];
		$department_id = ($this->input->get('department_id') == null) ? null : $this->input->get('department_id'); 
		if($department_id == null || $department_id == "NULL"){
			$branch = $this->branchRepository->find($id);	
			$reports = $branch->getAbsentReport($year);
			
		}
		else{
			$department = $this->departmentRepository->find($department_id);	
			// dd($department->department_name);
			$reports = $department->getAbsentReport($year);
				
		}

		foreach ($reports as $report) {
			$item = [
				'year' => $report->year . '-' . $report->month,
				'absent' => $report->total_absent
			];

			array_push($data, $item);
		}
		// dd($data);

		$this->sendJSON($data);
	}


		public function lateReport($id)
	{
		$year = ($this->input->get('year') == null) ? null : $this->input->get('year'); 
		$department_id = ($this->input->get('department_id') == null) ? null : $this->input->get('department_id'); 
		$data = [];
		// dd($department_id);
		if($department_id == null || $department_id == "NULL"){
			$branch = $this->branchRepository->find($id);	
			$reports = $branch->getLateReport($year);
			
		}
		else{
			$department = $this->departmentRepository->find($department_id);	
			// dd($department->department_name);
			$reports = $department->getLateReport($year);
				
		}

		foreach ($reports as $report) {
			$item = [
				'year' => $report->year . '-' . $report->month,
				'late' => $report->total_late
			];

			array_push($data, $item);
		}
		// dd($data);

		$this->sendJSON($data);
	}


}

