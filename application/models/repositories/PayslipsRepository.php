<?php
use Payslips as Payslips;

class PayslipsRepository extends BaseRepository {

	protected $employeeRepository,$payrollGroupRepository;
	public function __construct()
	{
		$this->class = new Payslips();

		$this->employeeRepository = new EmployeeRepository();
        $this->payrollGroupRepository= new PayrollGroupRepository();
	}

	public function generatePayslip(array $input)
	{
		// dd();
		$payrollGroup = $this->payrollGroupRepository->where('id','=',$input['group_name'])->first();

		$employees = $this->employeeRepository->where('branch_id','=',$payrollGroup['branch_id'])->get();
			
		foreach ($employees as $employee) {
				
		}

	}



}