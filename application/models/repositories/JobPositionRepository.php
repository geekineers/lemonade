<?php
use Job_Position as Job;

class JobPositionRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Job();

	}

	public function createNotExist(array $input)
	{
		try{
			$count = $this->where('job_position','=',$input['job_position'])->count();
			// $this->create($input);
			if($count>0){
				return false;
			}else{
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