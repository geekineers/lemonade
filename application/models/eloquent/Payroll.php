<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Payroll extends Eloquent {
	use SoftDeletingTrait;
  // 	 public $table = branches;
	 // protected $datas = ['deleted_at'];


  // protected $fillable = ['branch_name', 'branch_description', 'branch_address', 'branch_contact_numb'ER''];

   
 
// SSS Contribution 2014 updated 
// conv'ER'ted http://shancart'ER'.github.io/mr-data-conv'ER't'ER'/
// legend
// ER = Emplyer Rate
 	// EE = Employee Rate
 	// TC = total contrib (EE+ER)
 	// TTC = total contrilb se/vm
	$sss_range = array(array('range'=> 1,249.99 ,'ER'=> 83.70 ,'EE'=> 36.30 ,'TC'=> 120.00 ,'TTC'=> 110.00 ),
		  array('range'=> 1,749.99 ,'ER'=> 120.50 ,'EE'=> 54.50 ,'TC'=> 175.00 ,'TTC'=> 165.00 ),
		  array('range'=> 2,249.99 ,,'ER'=> 157.30 ,'EE'=> 72.70 ,'TC'=> 230.00 ,'TTC'=> 220.00 ),
		  array('range'=> 2,749.99 ,'ER'=> 194.20 ,'EE'=> 90.80 ,'TC'=> 285.00 ,'TTC'=> 275.00 ),
		  array('range'=> 3,249.99 ,'ER'=> 231.00 ,'EE'=> 109.00 ,'TC'=> 340.00 ,'TTC'=> 330.00 ),
		  array('range'=> 3,749.99 ,'ER'=> 267.80 ,'EE'=> 127.20 ,'TC'=> 395.00 ,'TTC'=> 385.00 ),
		  array('range'=> 4,249.99 ,'ER'=> 304.70 ,'EE'=> 145.30 ,'TC'=> 450.00 ,'TTC'=> 440.00 ),
		  array('range'=> 4,749.99 ,'ER'=> 341.50 ,'EE'=> 163.50 ,'TC'=> 505.00 ,'TTC'=> 495.00 ),
		  array('range'=> 5,249.99 ,'ER'=> 378.30 ,'EE'=> 181.70 ,'TC'=> 560.00 ,'TTC'=> 550.00 ),
		  array('range'=> 5,749.99 ,'ER'=> 415.20 ,'EE'=> 199.80 ,'TC'=> 615.00 ,'TTC'=> 605.00 ),
		  array('range'=> 6,249.99 ,'ER'=> 452.00 ,'EE'=> 218.00 ,'TC'=> 670.00 ,'TTC'=> 660.00 ),
		  array('range'=> 6,749.99 ,'ER'=> 488.80 ,'EE'=> 236.20 ,'TC'=> 725.00 ,'TTC'=> 715.00 ),
		  array('range'=> 7,249.99 ,'ER'=> 525.70 ,'EE'=> 254.30 ,'TC'=> 780.00 ,'TTC'=> 770.00 ),
		  array('range'=> 7,749.99 ,'ER'=> 562.50 ,'EE'=> 272.50 ,'TC'=> 835.00 ,'TTC'=> 825.00 ),
		  array('range'=> 8,249.99 ,'ER'=> 599.30 ,'EE'=> 290.70 ,'TC'=> 890.00 ,'TTC'=> 880.00 ),
		  array('range'=> 8,749.99 ,'ER'=> 636.20 ,'EE'=> 308.80 ,'TC'=> 945.00 ,'TTC'=> 935.00 ),
		  array('range'=> 9,249.99 ,'ER'=> 673.00 ,'EE'=> 327.00 ,'TC'=> 1,000.00 ,'TTC'=> 990.00 ),
		  array('range'=> 9,749.99 ,'ER'=> 709.80 ,'EE'=> 345.20 ,'TC'=> 1,055.00 ,'TTC'=> 1,045.00 ),
		  array('range'=> 10,249.99 ,'ER'=> 746.70 ,'EE'=> 363.30 ,'TC'=> 1,110.00 ,'TTC'=> 1,100.00 ),
		  array('range'=> 10,749.99 ,'ER'=> 783.50 ,'EE'=> 381.50 ,'TC'=> 1,165.00 ,'TTC'=> 1,155.00 ),
		  array('range'=> 11,249.99 ,'ER'=> 820.30 ,'EE'=> 399.70 ,'TC'=> 1,220.00 ,'TTC'=> 1,210.00 ),
		  array('range'=> 11,749.99 ,'ER'=> 857.20 ,'EE'=> 417.80 ,'TC'=> 1,275.00 ,'TTC'=> 1,265.00 ),
		  array('range'=> 12,249.99 ,'ER'=> 894.00 ,'EE'=> 436.00 ,'TC'=> 1,330.00 ,'TTC'=> 1,320.00 ),
		  array('range'=> 12,749.99 ,'ER'=> 930.80 ,'EE'=> 454.20 ,'TC'=> 1,385.00 ,'TTC'=> 1,375.00 ),
		  array('range'=> 13,249.99 ,'ER'=> 967.70 ,'EE'=> 472.30 ,'TC'=> 1,440.00 ,'TTC'=> 1,430.00 ),
		  array('range'=> 13,749.99 ,'ER'=> 1,004.50 ,'EE'=> 490.50 ,'TC'=> 1,495.00 ,'TTC'=> 1,485.00 ),
		  array('range'=> 14,249.99 ,'ER'=> 1,041.30 ,'EE'=> 508.70 ,'TC'=> 1,550.00 ,'TTC'=> 1,540.00 ),
		  array('range'=> 14,749.99 , ,'ER'=> 1,078.20 ,'EE'=> 526.80 ,'TC'=> 1,605.00 ,'TTC'=> 1,595.00 ),
		  array('range'=> 15,249.99 , ,'ER'=> 1,135.00 ,'EE'=> 545.00 ,'TC'=> 1,680.00 ,'TTC'=> 1,650.00 ),
		  array('range'=> 15,749.99 , ,'ER'=> 1,171.80 ,'EE'=> 563.20 ,'TC'=> 1,735.00 ,'TTC'=> 1,705.00 )
		  array('range'=> 16,000.99 , ,'ER'=> 1,208.70 ,'EE'=> 581.30 ,'TC'=> 1,790.00 ,'TTC'=> 1,760.00 )
	);

	
	public function getSSS($basic_salary)
	{
		$sss_val = array();
		foreach ($sss_range as $sss => $val) {
			if($basic_salary <= $sss_range[$sss]['range'])
			{
				$sss_val = array(
						'range' =>  $sss_range[$sss]['range'],
						'ER' =>  $sss_range[$sss]['ER'],
						'EE' =>  $sss_range[$sss]['EE'],
						'TC' =>  $sss_range[$sss]['TC'],
						'TTC' =>  $sss_range[$sss]['TTC']
					)
			}
		}
		
		return $sss_val;
	}


}


