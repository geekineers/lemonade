<?php

require 'application/helpers/calculator_helper.php';

class EmployeeTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{


	}

	public function testDeductionRate()
	{
		$basic_salary = 25000;
		$payroll_period = "Monthly";
		$per_unit = "minute";

		$this->assertEquals(2.4, getDeductionRate($basic_salary, $payroll_period, $per_unit));
	}



}