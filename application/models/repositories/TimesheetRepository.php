<?php
use Timesheet as Timesheet;

class TimesheetRepository extends BaseRepository {
	protected $employeeRepository;


	public function __construct()
	{
		$this->class = new Timesheet();
		$this->employeeRepository = new EmployeeRepository();
	}

	public function timeIn($sentry_user, $employee_id = null)
	{

		$cookie = $_COOKIE['cartalyst_sentry'];
		$employee_id = ($employee_id == null) ? $this->employeeRepository->getLoginUser($sentry_user)->id : $employee_id;
		$user = $sentry_user;
		$current = date('Y-m-d H:i:s');

		$data = [
			'employee_id' => $employee_id,
			'source' => 'Payroll Login',
			'time_in' => $current,
			'cookie_registry' => $cookie

		];

		$this->create($data);


		return true;



	}

	public function timeOut()
	{
		$cookie = $_COOKIE['cartalyst_sentry'];
		$current = date('Y-m-d H:i:s');
		$this->where('cookie_registry', '=', $cookie)->update(['time_out'  => $current]);
		return true;
	}

	public function getLoginTime()
	{

	}

}