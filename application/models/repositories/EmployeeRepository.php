<?php
use Employee as Employee;

class EmployeeRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Employee();

	}

	public function getLoginUser($sentry)
	{
		
		return Employee::where('user_id', '=', $sentry->id)->first();
	}

	public function getUserById($id)
	{
		return Employee::where('id', '=', $id)->first();
	}

	public function getNearBirthday()
	{
		// 1992-09-03
		// now(), +3weeks

		// $startDate = date('Y-m-d', strtotime('+3 weeks'));

		// dd($startDate);

		$startDate = Carbon::now();
		$endDate = $startDate->copy()->addWeeks(3);
		$query = $this->whereRaw("DATE_FORMAT(birthdate, '%m%d') BETWEEN " . $startDate->format('m') . $startDate->day . " AND " . $endDate->format('m') . $endDate->day, []);

		// dd($query->getQuery()->toSql());
		return $query->get();
	}
					

}