<?php
use PayrollGroup as PayrollGroup;

class PayrollGroupRepository extends BaseRepository{

	public function __construct()
	{
		$this->class = new PayrollGroup;
	}

	public function getDate($id)
	{
	    return date_format( date_create($this->where('id','=',$id)->get()->from),'Y/m/d') .'-'.  date_format( date_create($this->where('id','=',$id)->get()->to),'Y/m/d');;
	}

	public function getGroup($id)
	{
		return $this->where('id','=',$id)->first();
	}

}