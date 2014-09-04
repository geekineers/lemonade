<?php
use Payslips as Payslips;
use Respect\Validation\Validator as Validator;

class PayslipsRepository extends BaseRepository {

	protected $employeeRepository,$payrollGroupRepository,$payslipsGroupRepository;
	public function __construct()
	{
		$this->class = new Payslips();

		$this->employeeRepository = new EmployeeRepository();
        $this->payrollGroupRepository= new PayrollGroupRepository();
        $this->payslipsGroupRepository = new PayslipsGroupRepository();
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

		return $this->where('payslip_group_id','=',$id)
					->get();
	}

	public function getAllPayrollGroupBySlips()
	{
		$slip = $this->groupBy('from')->groupBy('payroll_group');
		return $slip->get();
	}


	public function generatePayslip( $input ,$prepared_by)
	{
		// get payroll group
		$validator = Validator::arr()->key('group_name', Validator::notEmpty())
                                     ->key('from', Validator::date('Y-m-d'))
                                     ->key('to', Validator::date('Y-m-d'))
        							 ->validate($input);

        if ($validator) 
        {
        	$from = date('Y-m-d',strtotime($input['from']));	
        	$to = date('Y-m-d',strtotime($input['to']));	
        	
        	$payslip_group_from = $this->payslipsGroupRepository->whereBetween('from',[$from,$to] )->count();
			$payslip_group_to = $this->payslipsGroupRepository->whereBetween('to',[$from,$to] )->count();
			
        	if( $payslip_group_from==0 && $payslip_group_to==0)
        	{
        		return $this->generate([
	        				'from' 	=> $from,
	        				'to'	=> $to,
	        				'payroll_group' => $input['group_name'],
	        				'status'=>'open',
	        				'prepared_by' => $prepared_by
	        			]);
        	}else{
        		return json_encode(['status'=>'fail']);
        	}
        } 
        else 
        {
            return json_encode(['status'=>'fail']);
        }

			
		
	}
	public function generate($input)
	{
		$from = $input['from'];
		$to   = $input['to'];
		$prepared_by = $input['prepared_by'];

		$payrollGroup = $this->payrollGroupRepository->where('id','=',$input['payroll_group'])->first();
		// emoloyee
	
		$employees = $this->employeeRepository->where('branch_id','=',$payrollGroup['branch_id'])->get();
		$payslip_group = $this->payslipsGroupRepository->create($input);
		// dd($payslip_group->id);

			foreach ($employees as $employee) {
				if($employee->payroll_period == $payrollGroup['period'] )
				{
					$employee_slip['payslip_group_id'] = $payslip_group->id;
					$employee_slip['employee_id'] 	= $employee->id;
					$employee_slip['payroll_group'] = $payrollGroup->id;
					$employee_slip['branch_id'] 	= $payrollGroup->branch_id;
					$employee_slip['sss']			= $employee->getSSSValue();
					$employee_slip['philhealth']	= $employee->getPhilhealthValue();
					$employee_slip['pagibig']		= $employee->getHDMFValue();
					$employee_slip['other_deductions']	= $employee->getTotalDeductions($from,$to,false);
					$employee_slip['net']			= $employee->getNet($from,$to,false);
					$employee_slip['gross']			= $employee->getGross($from,$to,false);
					$employee_slip['prepared_by']	= $prepared_by;

					$this->create($employee_slip);
				}

			}

		return  json_encode(['status'=>'success']);
	}

	
	public function generateGovermentForms($id,$type,$from,$to)
	{
		$pdf = new FPDI();
		$slips = $this->getPayslipById($id,$from,$to);

		$group = $this->payslipsGroupRepository->where('id','=',$id)->first();
		// set the sourcefile

		// dd($group->getPayrollGroup()->getBranch());
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
					$data = $group->getPayrollGroup()->getBranch();
					$pdf->Write(0,$data);
			    	foreach ($slips as $i => $slip) {

			    		$tin =  $slip->getEmployee()->tin_number!=null ?  $slip->getEmployee()->tin_number : 'n/a     ';
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