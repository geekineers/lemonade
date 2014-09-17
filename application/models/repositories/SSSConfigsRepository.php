<?php
use SSSConfigs as SSSConfigs;
use Respect\Validation\Validator as Validator;

class SSSConfigsRepository extends BaseRepository {

	protected $employeeRepository,$payrollGroupRepository,$payslipsGroupRepository;
	
	public function __construct()
	{
		$this->class = new SSSConfigs();

		$this->employeeRepository = new EmployeeRepository();
        $this->payrollGroupRepository= new PayrollGroupRepository();
        $this->payslipsGroupRepository = new PayslipsGroupRepository();
	}

	
	public function createSSS($data)
	{
		$validator = Validator::arr()->key('from_range', Validator::notEmpty())
                                     ->key('to_range', Validator::notEmpty())
                                     ->key('monthly_salary_credit', Validator::notEmpty())
                                     ->key('ER', Validator::notEmpty())
                                     ->key('EE',  Validator::notEmpty())
                                     ->key('EC',  Validator::notEmpty())
                                     ->key('TTC',  Validator::notEmpty())
                                     ->validate($data);


        if ($validator) {
            return $this->create($data);
        } else {

            return false;
        }
	}

	public function updateSSS($data , $id)
	{

		$validator = Validator::arr()->key('from_range', Validator::notEmpty())
                                     ->key('to_range', Validator::notEmpty())
                                     ->key('monthly_salary_credit', Validator::notEmpty())
                                     ->key('ER', Validator::notEmpty())
                                     ->key('EE',  Validator::notEmpty())
                                     ->key('EC',  Validator::notEmpty())
                                     ->key('TTC',  Validator::notEmpty())
                                     ->validate($data);

                                
        if ($validator) {

            return $this->where('id','=',$id)->update($data);
       
        } else {
        	
            return false;
        }
	}
}