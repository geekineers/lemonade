<?php
use Form_Application as Form_Application;

class FormApplicationRepository extends BaseRepository {
	protected $formCredits;

	public function __construct()
	{

		$this->class = new Form_Application();
		$this->formCredits = new EmployeeCreditsRepository();

	}

	public function createForm($data)
	{
		$formCredit = $this->formCredits->getFormCreditByType($data['employee_id'],$data['form_type']);

		if( $formCredit > 0 || $formCredit == 'n/a')
		{
			
			$this->create($data);
			if($formCredit != 'n/a')
			{
				$this->formCredits->decrementCredit($data['employee_id'],$data['form_type'],$formCredit);
			}
			return true;
		}
		else
		{

			
			return false;
			// return sendJSON(['status'=>'no-credits-left']);
		}
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
	
	
	
}