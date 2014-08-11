<?php
use Timesheet as Timesheet;

class TimesheetRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Timesheet();

	}

}