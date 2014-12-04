<?php

// require 'application/helpers/calculator_helper.php';
require 'application/helpers/employee_helper.php';
class EmployeeTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    public function testDeductionRate()
    {
        $basic_salary   = 25000;
        $payroll_period = "Semi-monthly";
        $per_unit       = "daily";

        // $this->assertEquals('2,307.69', getRate($basic_salary, $payroll_period, $per_unit, false));
    }

    public function testEmployeeID()
    {
        $id       = 1;
        $expected = "00001";

        $employee_id = createEmployeeID($id);
        $this->assertEquals($expected, $employee_id);

    }

}
