<?php
use Payslips as Payslips;

class PayslipsRepository extends BaseRepository {

	protected $employeeRepository;
	public function __construct()
	{
		$this->class = new Payslips();

		$this->employeeRepository = new EmployeeRepository();
        
	}

	public function generatePaySlips()
	{

	}

}