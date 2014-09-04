<?php
use EmployeeCredits as FormCredits;

class EmployeeCreditsRepository extends BaseRepository {

	public function __construct()
	{
		$this->class = new FormCredits();

	}
	
	public function createNewCreditsForEmployee($employee_id, $data)
	{
		return $this->create([
				'employee_id' => $employee_id, 
				'credit_name'=>$data['form_type'], 
				'remaining_credits' => $data['credits'],
				'credit_purpose' => $data['purpose'],
				'valid' => date('Y-m-d',strtotime($data['validity']))
			]);

	}
	public function updateCreditsForEmployee($employee_id, $data)
	{
		return $this->where('id','=',$id)->update([
				'employee_id' => $employee_id, 
				'credit_name'=>$data['form_type'], 
				'remaining_credits' => $data['credits'],
				'credit_purpose' => $data['purpose'],
				'valid' => date('Y-m-d',strtotime($data['validity']))
			]);

	}

	public function getFormCreditByType($id,$type)
	{
		$form = $this->where('employee_id','=',$id)
					->where('credit_name','=',$type)->first();
		if($form==null)
		{
			return 'n/a';
		}
		else
		{
			return $form->remaining_credits;
		}
	}

	public function decrementCredit($id,$type,$credits)
	{
		$credits = $credits - 1;
		$this->where('employee_id','=',$id)
					->where('credit_name','=',$type)->update(['remaining_credits'=>$credits]);
	}
}