<?php
use History as History;

class HistoryRepository extends BaseRepository {


	public function __construct()
	{
		$this->class = new History();


	}

	public function getByEmployee($employee_id)
	{
		return $this->where('employee_id', '=', $employee_id)->orderBy('date_happened', 'asc')->get();
	}


}

