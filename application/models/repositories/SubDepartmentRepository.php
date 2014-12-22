<?php
use SubDepartment as SubDepartment;

class SubDepartmentRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new SubDepartment();
	}

	public function createNotExist(array $input)
	{
		try {
			$count = $this->where('sub_department_name', '=', $input['sub_department_name'])->count();
			// $this->create($input);

			if($count>0)
			{
				return false;
			}
			else
			{
				$x = SubDepartment::create($input);

				return true;
			}
		}
		catch (Exception $e) {
    		var_dump($e);
    		exit();
    	}
	}

}
