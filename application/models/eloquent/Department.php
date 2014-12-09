<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Department extends BaseModel {
  use SoftDeletingTrait;
  public $table = "department";
  protected $datas = ['deleted_at'];


  protected $fillable = ['department_name', 'department_description','created_at', 'branch_id'];


  public function employee()
  {
    return $this->hasMany('Employee', 'department', 'id');
  }

  public function getLateReport($year = null)
  {
    $lateReport = [];
    $employees = Employee::where('department', '=', $this->id)->get();
    	

    foreach (getMonths($year) as $month) {
  	  $total_late = 0;
    	$current_date = date('Y-m-d');
  	  $loop_date = date('Y-m-d', strtotime($month->year .'-'. $month->month . '-1'));
  		if($loop_date <= $current_date)
      {
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

  public function getAbsentReport($year = null)
  {
    $absentReport = [];
    $employees = Employee::where('department', '=', $this->id)->get();
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
  public function getGrossReport($year = null)
  {
    	
    $grossReport = [];
    $employees = Employee::where('department', '=', $this->id)->get();

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
}