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

	public function getAllPayslip()
	{
		return $this->all();
	}

	public function getAllPayrollGroupBySlips()
	{
		$slip = $this->groupBy('from')->groupBy('payroll_group');
		return $slip->get();
	}


	public function generatePayslip(array $input)
	{
		// get payroll group

		$payrollGroup = $this->payrollGroupRepository->where('id','=',$input['group_name'])->first();
		// emoloyee
		$employees = $this->employeeRepository->where('branch_id','=',$payrollGroup['branch_id'])->get();
			
		$pays = [];
		foreach ($employees as $employee) {
			
			$pays[] = [
				'employees_id' => $employee->id,
				'basic_pay' => toInt($employee->basic_pay),
				'payslip' => $this->getWithholdingTax( 
										toInt($employee->basic_pay) ,
										$payrollGroup['period'] ,
										intval($employee->dependents) ,
										null ,
										null ,
										null
									 )
			];
			$payslip = $this->getWithholdingTax( 
										toInt($employee->basic_pay) ,
										$payrollGroup['period'] ,
										intval($employee->dependents) ,
										null ,
										null ,
										null
									 );
			$this->create([
					'employee_id'  => $employee->id,
                    'branch_id' => $payrollGroup['branch_id'],
                    'payroll_group' => $payrollGroup['id'],
                    'sss' => $payslip['SSS'],
                    'philhealth' => $payslip['philhealth'],
                    'pagibig' => $payslip['pagibig'],
                    'from'=> Carbon::createFromFormat('m-d-Y',$input['start']),
                    'to'=> Carbon::createFromFormat('m-d-Y',$input['end']),
                    'net' => $payslip['net'],
                    'gross'=>$payslip['gross'],
                    'other_deductions' => 'not available',
                    'prepared_by' => $payrollGroup['prepared_by']
				]);

		}
		header("Content-Type: application/json");
		echo json_encode($pays);
	}


	public static function getWithholdingTax( $salary = 0 , $period = 'monthly', $dependents = 0, $philhealth = 0 , $pagibig = 0, $sss = 0 )
	{

		$sss_val = $sss==null ? getSSS($salary)['EE'] : (int) $sss;

		$philhealth_val = $philhealth==null ? getPH($salary)['Employee_Share'] : (int) $philhealth;
		
		$pagibig_val = $pagibig==null ? 100 : (int) $pagibig;

		$curr_salary =    $salary - ($sss_val + $philhealth_val + $pagibig_val );
		// return $curr_salary;
		$deductions = ($sss_val + $philhealth_val + $pagibig_val );

		$wt = getWTax( $curr_salary , $period , $dependents);

		return array(
			    'gross' => number_format($salary,2),
				'widthholding_tax' => number_format($wt,2),
				'philhealth' => number_format($philhealth_val,2),
				'SSS' => number_format($sss_val,2),
				'pagibig'=> number_format($pagibig_val,2),
				'basic' => number_format($salary,2),
				'taxable' => number_format($curr_salary,2),
				'total_deduc' => number_format($deductions,2),
				'net' => number_format($salary-$deductions-$wt,2)
			);
	}
	
}	