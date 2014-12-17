<?php
use Department as Department;

class DepartmentRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new SubDepartment();
	}

	public function createNotExist(array $input)
	{
		try {
			$count = $this->where('sub_department_name','=',$input['department_name'])->count();
			// $this->create($input);

			if($count>0)
			{
				return false;
			}
			else
			{
				$this->create($input);

				return true;
			}
		}
		catch (Exception $e) {
    		var_dump($e);
    		exit();
    	}
	}

}
