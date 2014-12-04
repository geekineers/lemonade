<?php
use EmployeeLeaveCredit as EmployeeLeaveCredit;

class EmployeeLeaveCreditRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new EmployeeLeaveCredit();

	}

	function getLeaveCreditOfEmployee($employee_id)
	{
		$this->where('employee_id', '=', $employee_id)->get();
	}

	function deductCredit($employee_id, $leave_type_id)
	{
		$leave_type = $this->where('employee_id', '=', $employee_id)
			 ->where('leave_type_id', '=', $leave_type_id)
			 ->first();

	    $

	}

}