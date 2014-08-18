<?php
use EmployeeAllowance as EmployeeAllowance;

class EmployeeAllowanceRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new EmployeeAllowance();

	}

}