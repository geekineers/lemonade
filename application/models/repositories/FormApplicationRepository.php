<?php
use Form_Application as Form_Application;

class FormApplicationRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new Form_Application();

	}
	public function getFormAppId($id)
	{
		return $this->where('id','=',$id)->first();	
	}
	public function approved($id)
	{
		return $this->where('id','=',$id)->update(['status'=>'approved']);
	}

	public function disapproved($id)
	{

		return $this->where('id','=',$id)->update(['status'=>'disapproved']);
	}
	public function search($query)
	{
		return $this->where('form_type', 'like', "%{$query}%")
					->orWhere('last_name', 'like', "%{$query}%")
					// ->orWhere('job_position', 'like', "%{$query}%")
					->orWhere('email', 'like', "%{$query}%")
					->get();


	}

	public function delete($id)
	{
		return $this->find($id)->delete();
	}
	public function getStatus()
	{
		
	}
	
}