<?php
use Department as Department;

class DepartmentRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Department();
	}

	public function createNotExist(array $input)
	{
		try {
			$count = $this->where('department_name','=',$input['department_name'])->count();
			// $this->create($input);

			if($count > 0)
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

	public function getDepartmentByBranch($id)
	{
		return $this->where('branch_id','=',$id)->get();
	}

}
