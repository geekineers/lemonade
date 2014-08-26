<?php
use Payroll_Period as Payroll_Period;

class Payroll_Period_Repository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Payroll_Period();

	}

	public function createNotExist(array $input)
	{
		try{
			$count = $this->where('period','=',$input['job_position'])->count();
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