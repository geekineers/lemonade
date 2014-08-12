<?php
use PayrollGroup as PayrollGroup;

class PayrollGroupRepository extends BaseRepository{

	public function __construct()
	{
		$this->class = new PayrollGroup;
	}

	


}