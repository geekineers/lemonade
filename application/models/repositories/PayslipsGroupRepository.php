<?php
use PayslipsGroup as PayslipsGroup;

class PayslipsGroupRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new PayslipsGroup();
	}

	public function getAllPayslipById($id,$from,$to)
	{
		return $this->where('id','=',$id)->get();
	}
	public function getPayslipById($id,$from,$to)
	{
		return $this->where('id','=',$id)->first();
	}
	
}
