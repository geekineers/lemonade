<?php

function getRate($basic_salary, $payroll_period, $per_unit, $number_format = true)
{
	$basic_salary = floatval($basic_salary);
	// dd($payroll_period);
	switch ($payroll_period) {
		case 'Monthly':
			$amount = $basic_salary * 12;
			$daily = $amount / 260;
			$amount = $daily / 8;

			if($per_unit == 'Monthly')
			{
				if($number_format) return number_format($basic_salary, 2);
				return $basic_salary;
			}
			if($per_unit == 'Semi-Monthly')
			{
				if($number_format) return number_format($basic_salary/2, 2);
				return	$basic_salary/2;
			} 	
			if($per_unit == 'daily')
			{
				if($number_format) return number_format($daily, 2);
				return $daily;
			} 			

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

			if($per_unit == 'Semi-Monthly')
			{
				return $basic_salary;
			}
			if($per_unit == 'daily')
			{
				if($number_format) return number_format($amount, 2);
				return $amount;
			} 

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
			$amount = $basic_salary / 8;
			
			if($per_unit == 'Daily')
			{
				return $basic_salary;
			}
			if($per_unit == 'hour')
			{
				if($number_format) return number_format($amount, 2);
				return $amount;
			} 

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

	function createDateRangeArray($strDateFrom,$strDateTo)
	{
		$strDateFrom = date('Y-m-d', strtotime($strDateFrom));
		$strDateTo = date('Y-m-d', strtotime($strDateTo));

	    // takes two dates formatted as YYYY-MM-DD and creates an
	    // inclusive array of the dates between the from and to dates.

	    // could test validity of dates here but I'm already doing
	    // that in the main script

	    $aryRange=array();

	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=86400; // add 24 hours
	            array_push($aryRange,date('Y-m-d',$iDateFrom));
	        }
	    }
	    return $aryRange;
	}

function getInterval($right_time, $arrive_time, $unit)
{
	// dd(Carbon::now());
	$right_time = new Carbon($right_time);
	$arrive_time = new Carbon($arrive_time);
	// dd($right_time, $arrive_time);
	if($right_time->lt($arrive_time)) {
		if($unit = 'minute')return $right_time->diffInMinutes($arrive_time);
		return $right_time->diffInHours($arrive_time);	
	}
	return 0;
}
