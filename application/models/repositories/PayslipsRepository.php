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
	public function getTotalSSS($slips)
	{	
		$total = 0;
		foreach ($slips as $slip) {
			$total = $total + intval($slip->sss);
		}
		return $total;
	}
	public function getTotalWtax()
	{

	}

	public function getSlipById($id)
	{
		return $this->where('id','=',$id)->first();
	}

	public function getTotalCompensationPerGroup($from,$to,$id)
	{
		$slips = $this->where('id','=',$id)
					->whereBetween('from',['from','to'])
					->get();

	}
	
	public function getAllPayslip()
	{
		return $this->all();
	}

	public function getPayslipById($id,$from,$to)
	{
		return $this->where('payroll_group','=',$id)
					->where('from','=',$from)
					->groupBy('from')->get();
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
		// dd($employees[0]->payroll_period.' = '.$payrollGroup['period'] );
		foreach ($employees as $employee) {
			if($employee->payroll_period == $payrollGroup['period'])
			{
				$pays[] = [
					'employees_id' => $employee->id,
					'basic_pay' => toInt($employee->getBasicPay()),
					'payslip' => $this->getWithholdingTax( 
											$employee,
											$payrollGroup ,
											toInt($employee->basic_pay) ,
											$payrollGroup['period'] ,
											intval($employee->dependents) ,
											null ,
											null ,
											null
										 )
				];
				$payslip = $this->getWithholdingTax( 
											$employee,
											$payrollGroup ,
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
	                    'other_deductions' => '',
	                    'prepared_by' => $payrollGroup['prepared_by']
					]);
			}

		}
		header("Content-Type: application/json");
		echo json_encode($pays);
	}

	
  
	public  function getWithholdingTax( $employee,$group,$salary = 0 , $period = 'monthly', $dependents = 0, $philhealth = 0 , $pagibig = 0, $sss = 0 )
	{

		$sss_val = $sss==null ? getSSS($salary)['EE'] : (int) $sss;

		$philhealth_val = $philhealth==null ? getPH($salary)['Employee_Share'] : (int) $philhealth;
		
		$pagibig_val = $pagibig==null ? 100 : (int) $pagibig;

		$absents = $employee->getAbsentDeduction($group->from,$group->to);

		$overtime = $employee->getOvertime($group->from,$group->to);

		$curr_salary =    $salary - ($sss_val + $philhealth_val + $pagibig_val +  $absents );
		// return $curr_salary;
		$deductions = ($sss_val + $philhealth_val + $pagibig_val + $absents );

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
	

	public function generateGovermentForms($id,$type,$from,$to)
	{
		$pdf = new FPDI();
		$slips = $this->getPayslipById($id,$from,$to);
		$group = PayrollGroup::where('id','=',$id)->first();
		// set the sourcefile
		// $pdf->setSourceFile($pdf_template);
		if($type=='mcrf')
		{

			$pageCount = $pdf->setSourceFile('pdf_template/FPF060.pdf');
			// iterate through all pages
			$templateArr = [];
			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
			    // import a page
			    $templateId = $pdf->importPage($pageNo);
			    // get the size of the imported page
			    $size = $pdf->getTemplateSize($templateId);
			    $templateArr[] = $templateId;
			    // create a page (landscape or portrait depending on the imported page size)
			    if ($size['w'] > $size['h']) {
			        $pdf->AddPage('L', array($size['w'], $size['h']));
			    } else {
			        $pdf->AddPage('P', array($size['w'], $size['h']));
			    }

			    // use the imported page
			    if($templateId==1){
			    	$pdf->useTemplate($templateId);
			    	$pdf->SetFont('Helvetica');
					$pdf->SetFontSize('8');
					$pdf->SetTextColor(0,0, 0);
					$pdf->SetXY(7, 44); 
					$data = $group->getBranch();
					$pdf->Write(0,$data);
			    	foreach ($slips as $i => $slip) {

			    		$tin =  $slip->getEmployee()->tin_number!=null ?  $slip->getEmployee()->tin_number : 'n/a';
			    		$birth = $slip->getEmployee()->birthdate;
			    		$fname = $slip->getEmployee()->first_name;
			    		$mname = $slip->getEmployee()->middle_name;
			    		$lname = $slip->getEmployee()->last_name;
			    		$ee = 100;
			    		$er = 200;
			    		$total = $ee+$er;
						$pdf->SetXY(7, 69+(4*$i)); 
						$data = $tin .'                    '.$birth.'                     '.$lname.'              '.$fname.'                           '.$mname .'                                '.$ee.'                       '.$er.'                       '.$total;
						$pdf->Write(0,$data);
					
			    	}
			    }else{
				    $pdf->useTemplate($templateId);

				    $pdf->SetFont('Helvetica');
				    $pdf->SetXY(5, 5);
				    $pdf->Write(8, 'A complete document imported with FPDI');
			    }
			}
			
			$pdf->Output();
		}
		else if ($type=='1601C')
		{
			$pageCount = $pdf->setSourceFile('pdf_template/1601C.pdf');
			// iterate through all pages
			$templateArr = [];
			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
			    // import a page
			    $templateId = $pdf->importPage($pageNo);
			    // get the size of the imported page
			    $size = $pdf->getTemplateSize($templateId);
			    $templateArr[] = $templateId;
			    // create a page (landscape or portrait depending on the imported page size)
			    if ($size['w'] > $size['h']) {
			        $pdf->AddPage('L', array($size['w'], $size['h']));
			    } else {
			        $pdf->AddPage('P', array($size['w'], $size['h']));
			    }

			    // use the imported page
			    // fill first page 
			    if($templateId==1){
			    	
			    	$pdf->useTemplate($templateId);
			    	$pdf->SetFont('Helvetica');
					
					$pdf->SetTextColor(0,0, 0);



					// month
					$data = date("m", strtotime($slips[0]->to));
					$pdf->SetFontSize('14');
					$pdf->SetXY(45, 56); 
					$pdf->Write(0,$data);
					// year
					$data = date("Y", strtotime($slips[0]->to));
					$pdf->SetFontSize('14');
					$pdf->SetXY(55, 56); 
					$pdf->Write(0,$data);
					// polt
					$pdf->SetFontSize('14');
					$pdf->SetXY(106, 56); 
					$pdf->Write(0,'X');

					// tin

					$pdf->SetFontSize('14');
					$tin = Company::first()->company_tin;
			    	$tin_ = substr($tin, 0, 3).'       '.substr($tin, 3, 3).'       '.substr($tin, 6, 3).'       '.substr($tin, 9, 3) ;
					$pdf->SetXY(22, 68); 
					$pdf->Write(0,$tin_);
					

					$pdf->SetFontSize('12');
					$pdf->SetXY(20, 79); 
					$pdf->Write(0, Company::first()->company_name);
					// group


					// line of business

					$pdf->SetFontSize('10');
					$pdf->SetXY(162, 68); 
					$pdf->Write(0, Company::first()->line_of_business);
			    	// group
					$pdf->SetFontSize('12');
					$pdf->SetXY(20, 89); 
					$pdf->Write(0, Company::first()->company_address);
			    	
			    }else{
				    $pdf->useTemplate($templateId);

				    $pdf->SetFont('Helvetica');
				    $pdf->SetXY(5, 5);
				    $pdf->Write(8, 'A complete document imported with FPDI');
			    }
			}
			
			$pdf->Output();
		}
		else if($type=="sss-r3")
		{
			$pageCount = $pdf->setSourceFile('pdf_template/sss-r3.pdf');
			// iterate through all pages
			$templateArr = [];
			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
			    // import a page
			    $templateId = $pdf->importPage($pageNo);
			    // get the size of the imported page
			    $size = $pdf->getTemplateSize($templateId);
			    $templateArr[] = $templateId;
			    // create a page (landscape or portrait depending on the imported page size)
			    if ($size['w'] > $size['h']) {
			        $pdf->AddPage('L', array($size['w'], $size['h']));
			    } else {
			        $pdf->AddPage('P', array($size['w'], $size['h']));
			    }

			    // use the imported page
			    if($templateId==1){
			    	$pdf->useTemplate($templateId);
			    	$pdf->SetFont('Helvetica');
					$pdf->SetFontSize('8');
				

					// sss number
					$pdf->SetFontSize('12');
					$pdf->SetXY(15, 34); 
					$pdf->SetFont('');
					$pdf->CellFitSpaceForce(53, 10, Company::first()->company_sss,2,1, 1);
					// address
					$pdf->SetXY(70, 48); 
					$pdf->SetFontSize('10');
					$data = Company::first()->company_address;
					$pdf->Write(0,$data);

					// tel
					$pdf->SetXY(15, 48); 
					$pdf->SetFontSize('10');
					$data = Company::first()->company_tel;
					$pdf->Write(0,$data);

					// employer name
					$pdf->SetFontSize('10');
					$pdf->SetXY(70, 38); 
					$pdf->Write(0, Company::first()->company_name);

			    	foreach ($slips as $i => $slip) {

			    		$sss =  $slip->getEmployee()->sss_number!=null ?  $slip->getEmployee()->sss_number : '';
			    		$birth = $slip->getEmployee()->birthdate;
			    		$fname = $slip->getEmployee()->first_name;
			    		$mname = $slip->getEmployee()->middle_name;
			    		$lname = $slip->getEmployee()->last_name;
			    		$ee = 100;
			    		$er = 200;
			    		$total = $ee+$er;
						$pdf->SetXY(15, 69+(4*$i)); 
						$data = '                                                  '.$lname.'         '.$fname.'       '.$mname ;

						$pdf->CellFitSpaceForce(40, 0, $sss,2,1, 1);
						$pdf->Write(0,$data);
						$pdf->SetXY(133.5, 69+(4*$i)); 
						$pdf->Write(0,number_format($slip->sss,2));
						$pdf->Ln();


			    	}

			    	// total amount
			    	$pdf->SetFontSize('10');
					$pdf->SetXY(145.5, 168); 
					$pdf->Write(0, number_format($this->getTotalSSS($slips),2));
			    }else{
				    $pdf->useTemplate($templateId);

				    $pdf->SetFont('Helvetica');
				    $pdf->SetXY(5, 5);
				    $pdf->Write(8, '');
			    }
			}
			
			$pdf->Output();
		}
	}
}	