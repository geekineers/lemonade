<?php
use PHConfigs as PHConfigs;
use Respect\Validation\Validator as Validator;

class PHConfigsRepository extends BaseRepository {

	protected $employeeRepository,$payrollGroupRepository,$payslipsGroupRepository;
	
	public function __construct()
	{
		$this->class = new PHConfigs();

		$this->employeeRepository = new EmployeeRepository();
        $this->payrollGroupRepository= new PayrollGroupRepository();
        $this->payslipsGroupRepository = new PayslipsGroupRepository();
	}

	
	public function createPH($data)
	{
		// $validator = Validator::arr()->key('from_range', Validator::notEmpty())
  //                                    ->key('to_range', Validator::notEmpty())
  //                                    ->key('salary_base', Validator::notEmpty())
  //                                    ->key('total_monthly_premium', Validator::notEmpty())
  //                                    ->key('employee_share',  Validator::notEmpty())
  //                                    ->key('employer_share',  Validator::notEmpty())
  //                                    ->validate($data);

      return $this->create($data);
      
	}

	public function updatePH($data , $id)
	{

		$validator = Validator::arr()->key('from_range', Validator::notEmpty())
                                     ->key('to_range', Validator::notEmpty())
                                     ->key('salary_base', Validator::notEmpty())
                                     ->key('total_monthly_premium', Validator::notEmpty())
                                     ->key('employee_share',  Validator::notEmpty())
                                     ->key('employer_share',  Validator::notEmpty())
                                     ->validate($data);

                                
        if ($validator) {

            return $this->where('id','=',$id)->update($data);
       
        } else {
        	
            return false;
        }
	}
}