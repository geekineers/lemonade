<?php
use Form as Form;

class FormRepository extends BaseRepository {
	protected $formApplicationRepository;
	public function __construct()
	{
		$this->class = new Form();
		$this->formApplicationRepository = new FormApplicationRepository();
	}

	public function viewForm($form,$id)
	{
		$pdf = new FPDI();
		$forms = $this->formApplicationRepository->getFormAppId($id);
		// set the sourcefile
		// $pdf->setSourceFile($pdf_template);
		if($form=='ob')
		{

			$pageCount = $pdf->setSourceFile('pdf_template/OB_Form.pdf');
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
					$pdf->SetFontSize('12');
					$pdf->SetTextColor(0,0, 0);
					$pdf->SetXY(35, 32); 
					$data = $forms->getEmployeeNames() ;
					$pdf->Write(0,$data);

					$pdf->SetXY(45, 37); 
					
					$pdf->Write(0,$forms->getDepartment());
			    	
			    	$pdf->SetXY(150, 37); 
					
					$pdf->Write(0,$forms->getEmployee()->getJobPosition());

					$pdf->SetXY(150, 32); 
					
					$pdf->Write(0,date('m-d-Y',strtotime($forms->created_at)));

			    }else{
				    $pdf->useTemplate($templateId);

				    $pdf->SetFont('Helvetica');
				    $pdf->SetXY(100, 5);
				    $pdf->Write(8, 'A complete document imported with FPDI');
			    }
			}
			
			$pdf->Output();
		}
		if($form=='ot')
		{

			$pageCount = $pdf->setSourceFile('pdf_template/OT_Request_Form.pdf');
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
					$pdf->SetFontSize('12');
					$pdf->SetTextColor(0,0, 0);
					$pdf->SetXY(35, 32); 
					$data = $forms->getEmployeeNames() ;
					$pdf->Write(0,$data);

					$pdf->SetXY(45, 37); 
					
					$pdf->Write(0,$forms->getDepartment());
			    	
			    	$pdf->SetXY(150, 37); 
					
					$pdf->Write(0,$forms->getEmployee()->getJobPosition());

					$pdf->SetXY(150, 32); 
					
					$pdf->Write(0,date('m-d-Y',strtotime($forms->created_at)));

			    }else{
				    $pdf->useTemplate($templateId);

				    $pdf->SetFont('Helvetica');
				    $pdf->SetXY(5, 5);
				    $pdf->Write(8, 'A complete document imported with FPDI');
			    }
			}
			
			$pdf->Output();
		}
		if($form=='undertime')
		{

			$pageCount = $pdf->setSourceFile('pdf_template/Undertime_Form.pdf');
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
					$pdf->SetFontSize('12');
					$pdf->SetTextColor(0,0, 0);
					$pdf->SetXY(35, 32); 
					$data = $forms->getEmployeeNames() ;
					$pdf->Write(0,$data);

					$pdf->SetXY(45, 37); 
					
					$pdf->Write(0,$forms->getDepartment());
			    	
			    	$pdf->SetXY(150, 37); 
					
					$pdf->Write(0,$forms->getEmployee()->getJobPosition());

					$pdf->SetXY(150, 32); 
					
					$pdf->Write(0,date('m-d-Y',strtotime($forms->created_at)));

			    }else{
				    $pdf->useTemplate($templateId);

				    $pdf->SetFont('Helvetica');
				    $pdf->SetXY(5, 5);
				    $pdf->Write(8, 'A complete document imported with FPDI');
			    }
			}
			
			$pdf->Output();
		}
		if($form=='leave')
		{

			$pageCount = $pdf->setSourceFile('pdf_template/Leave_Form.pdf');
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
					$pdf->SetFontSize('12');
					$pdf->SetTextColor(0,0, 0);
					$pdf->SetXY(35, 32); 
					$data = $forms->getEmployeeNames() ;
					$pdf->Write(0,$data);

					$pdf->SetXY(45, 37); 
					
					$pdf->Write(0,$forms->getDepartment());
			    	
			    	$pdf->SetXY(150, 37); 
					
					$pdf->Write(0,$forms->getEmployee()->getJobPosition());

					$pdf->SetXY(150, 32); 
					
					$pdf->Write(0,date('m-d-Y',strtotime($forms->created_at)));

			    }else{
				    $pdf->useTemplate($templateId);

				    $pdf->SetFont('Helvetica');
				    $pdf->SetXY(5, 5);
				    $pdf->Write(8, 'A complete document imported with FPDI');
			    }
			}
			
			$pdf->Output();
		}
		
	}
}
