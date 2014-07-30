<?php
use Employee as Employee;

class EmployeeRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Employee();

	}

}