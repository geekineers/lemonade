<?php
use Illuminate\Database\Eloquent\Collection as Collection;
class EmployeeTransformer {
	public function __construct(){

	}

	public static function transform(Collection $collection){
		$items = [];
	        foreach ($collection as $employee) {
      
	        $data = $employee;
	        $data->profile_picture = $employee->getProfilePicture();
	        $data->name = $employee->getName();
	        $data->position = $employee->getJobPosition();

            array_push($items, $data);
	}

	return $items;

	}
}