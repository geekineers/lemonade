<?php
use Employee as Employee;

class EmployeeRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Employee();

	}

	public function getLoginUser($sentry)
	{
		
		return Employee::where('user_id', '=', $sentry->id)->first();
	}

}