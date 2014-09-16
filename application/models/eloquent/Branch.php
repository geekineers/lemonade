<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Branch extends BaseModel {
	use SoftDeletingTrait;
  	 public $table = "branches";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['branch_name', 'branch_description', 'branch_address', 'branch_contact_number'];

  public function setPasswordAttribute($password)
  {
  		$this->attributes['password'] = md5($password);
  }


  public function getGrossReport($year = null)
  {
  	$grossReport = [];
  	$employees = Employee::where('branch_id', '=', $this->id)->get();


  	foreach (getMonths($year) as $month){
	  	$totalgross = 0;
	  	$current_date = date('Y-m-d');
	  	$loop_date = date('Y-m-d', strtotime($month->year .'-'. $month->month . '-1'));
		if($loop_date <= $current_date){
		foreach ($employees as $employee) {
  			$totalgross += $employee->getBasicPay(false, $month->startMonth, $month->endMonth) 
  						+ $employee->getTotalAllowances($month->startMonth, $month->endMonth, false) 
  						+ $employee->getOvertime($month->startMonth, $month->endMonth);

  			}
	  	}
  	
  		$data = $month;
  		$data->totalgross = $totalgross;
  		array_push($grossReport, $data);
  	}
  	return $grossReport;
  	
   }

   public function getAbsentReport($year = null)
   {
	$absentReport = [];
  	$employees = Employee::where('branch_id', '=', $this->id)->get();


  	foreach (getMonths($year) as $month) {
	  	$total_absent = 0;
  		 	$current_date = date('Y-m-d');
	  	$loop_date = date('Y-m-d', strtotime($month->year .'-'. $month->month . '-1'));
		if($loop_date <= $current_date){
  		foreach ($employees as $employee) {
  			$total_absent += $employee->getAbsent($month->startMonth, $month->endMonth);
  				

  		}
  	}
  		$data = $month;
  		$data->total_absent = $total_absent;
  		array_push($absentReport, $data);
  	}

  	return $absentReport;

   }

  public function getLateReport($year = null)
   {
	$lateReport = [];
  	$employees = Employee::where('branch_id', '=', $this->id)->get();


  	foreach (getMonths($year) as $month) {
	  	$total_late = 0;
  		 	$current_date = date('Y-m-d');
	  	$loop_date = date('Y-m-d', strtotime($month->year .'-'. $month->month . '-1'));
		if($loop_date <= $current_date){
  		foreach ($employees as $employee) {
  			$total_late += $employee->getLate($month->startMonth, $month->endMonth);
  				

  		}
  	}
  		$data = $month;
  		$data->total_late = $total_late;
  		array_push($lateReport, $data);
  	}

  	return $lateReport;

   }

   public function getTotalAbsent($year = null)
   {
 	$employees = Employee::where('branch_id', '=', $this->id)->get();
  	$total_absent = 0;

  	foreach (getMonths($year) as $month) {
  		foreach ($employees as $employee) {
  			$total_absent += $employee->getAbsent($month->startMonth, $month->endMonth);
  				

  		}
  	}

  	return $total_absent;  	
   }

   public function getTotalEmployees()
   {
   		return  Employee::where('branch_id', '=', $this->id)->count();
   }

   public function getTardinessRate($year=null)
   {
 	$employees = Employee::where('branch_id', '=', $this->id)->get();
   	$total_late = 0;
	foreach (getMonths($year) as $month) {
  		
  		foreach ($employees as $employee) {
  			$total_late += $employee->getLate($month->startMonth, $month->endMonth);
  		}
  	}
  	$total_working_mins = getYearlyWorkingMinutes();

  	$tardiness = $total_late/$total_working_mins;
  	$rate =  $tardiness * 100;
  	return number_format($rate, 2);
   }

   public function getTotalExpenses($year=null)
   {
	$grossReport = [];
  	$employees = Employee::where('branch_id', '=', $this->id)->get();
	$totalgross = 0;


  	foreach (getMonths($year) as $month) {
  		  	$current_date = date('Y-m-d');
	  	$loop_date = date('Y-m-d', strtotime($month->year .'-'. $month->month . '-1'));
	
  			if($loop_date <= $current_date){
  		foreach ($employees as $employee) {
  			$totalgross += $employee->getBasicPay(false, $month->startMonth, $month->endMonth) 
  						+ $employee->getTotalAllowances($month->startMonth, $month->endMonth, false) 
  						+ $employee->getOvertime($month->startMonth, $month->endMonth);

  		}
  	}
  	}

  	return number_format($totalgross, 2);  	
   }

}
