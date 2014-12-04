<?php
use EmployeeType as EmployeeType;

class EmployeeTypeRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new EmployeeType();

	}

	public function saveEmployeeType($name){
		$data = array(
				'employee_type_name' => $name,
				'company_id' => COMPANY_ID
			);

		$save = $this->create($data);

		if($save){
			return true;
		}

		return false;
	}

	public function updateEmployeeType($id, $name)
	{
		$type = $this->find($id);

		if($type){
			return $type->update(['employee_type_name' => $name]);
		}

		return false;
	}


}