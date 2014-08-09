<?php
use EmployeeDeduction as EmployeeDeduction;

class EmployeeDeductionRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new EmployeeDeduction();

	}

}