<?php

function getYearlyWorkingMinutes()
{
	return 260*8*60;
}

function getMonths($year)
{
	$list = [];
  	$year = (is_null($year)) ? date('Y') : $year;	
  	for($month = 1; $month <= 12; $month++)
  	{
  		$date = new DateDto();
		$start = 1;
		$end = date('t', strtotime($year . '-'. $month . '-1' ));	
  	
		$startMonth = date('Y-m-d', strtotime($year . '-'. $month . '-' . $start));
		$endMonth = date('Y-m-d', strtotime($year . '-'. $month . '-' . $end));
  		$monthName = date('M', strtotime($year . '-'. $month . '-1' ));
  		
  		$date->year = $year;
  		$date->month = $month;	
  		$date->monthName = $monthName;	
  		$date->startMonth = $startMonth;	
  		$date->endMonth = $endMonth;	

  		array_push($list, $date);
  	}

  	return $list;

	

}

class DateDto{
	public $year, $month, $monthName, $startMonth, $endMonth;

	public function toArray()
	{
		return [
			'year' => $this->year,
			'month' => $this->month,
			'monthName' => $this->monthName,
			'startMonth' => $this->startMonth,
			'endMonth' => $this->endMonth
		];
	}

	public function toString()
	{
		return $this->month;
	}
}