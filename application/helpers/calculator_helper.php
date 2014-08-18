<?php

function getDeductionRate($basic_salary, $payroll_period, $per_unit, $number_format = true)
{
	$basic_salary = floatval($basic_salary);

	switch ($payroll_period) {
		case 'Monthly':
			$amount = $basic_salary * 12;
			$amount = $amount / 260;
			$amount = $amount / 8;

			if($per_unit == 'hour')
			{
				if($number_format) return number_format($amount, 2);
				return $amount;
			} 

			$amount = $amount/60;

			if($number_format) return number_format($amount, 2);
			return $amount;
			

			break;
		case 'Semi-Monthly':
			$amount = $basic_salary * 2 * 12;
			$amount = $amount / 260;
			$amount = $amount / 8;

			if($per_unit == 'hour')
			{
				if($number_format) return number_format($amount, 2);
				return $amount;
			} 

			$amount = $amount/60;

			if($number_format) return number_format($amount, 2);
			return $amount;
			

			break;
		case 'Daily':
			$amount = $amount / 8;

			if($per_unit == 'hour')
			{
				if($number_format) return number_format($amount, 2);
				return $amount;
			} 

			$amount = $amount/60;

			if($number_format) return number_format($amount, 2);
			return $amount;
			

			break;
		
		default:
			# code...
			break;
	}

}