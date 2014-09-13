<?php

require 'application/helpers/helper_helper.php';

class CalculatorTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{


	}

	public function testWtax()
	{
		$basic_salary = 6306.55;
		$payroll_period = "semi-monthly";

		$this->assertEquals(615.48, getWTax($basic_salary, $payroll_period));
	}



}