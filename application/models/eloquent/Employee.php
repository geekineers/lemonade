<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

// use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Employee extends Eloquent {
	// use SoftDeletingTrait;
  	 protected $table = "employees";
	 // protected $datas = ['deleted_at'];


  protected $fillable = [
                      'user_id',
                      // Basic Info
                      'first_name',
                      'last_name',
                      'middle_name',
                      'full_address',
                      'birthdate',
                      'gender',
                      'marital_status',
                      'spouse_name',
                      

                      // Employee Details 

                      'employee_type',
                      'payroll_period',
                      'job_position',
                      'department',
                      'role_id',
                      'branch_id',
                      'date_hired',
                      'date_ended',
                      'basic_pay',

                      // Government Details

                      'tin_number',
                      'sss_number',
                      'pagibig_number',
                      'dependents',

                      // Contact info

                      'contact_number',
                      'profile_picture',
                      'fb',
                      'email', 

                ];

 public function getDateHired()
 {
  return $this->date_hired;
 }
 public function getName()
 {
    return $this->first_name .' ' . $this->middle_name . ' ' . $this->last_name;
 }               
 public function getFullAddress()
 {
  return $this->full_address;
 }
 public function getBirthdate()
 {
  return $this->birthdate;
 }
 public function getGender()
 {
  return $this->gender;
 }
 public function getMaritalStatus()
 {
  return $this->marital_status;
 }
// Employee Details
 public function getEmployeeType()
 {
   return $this->employee_type;
 }
 public function getPayrollPeriod()
 {  
  return $this->payroll_period;
 }

 public function getJobPosition()
 {
    return Job_Position::find($this->job_position)->job_position;
 }
  public function getDepartment()
 {
    return Department::find($this->department)->department_name;
 }
 public function getDateEnded()
 {
   return $this->date_ended;
 }
 public function getTin()
 {
  return $this->tin_number;
 }
  public function getSSS()
 {

  return $this->sss_number;
 }

 public function getPagibig()
 {
  return $this->pagibig_number;
 }

 public function getProfilePicture()
 {
  return '/media?image=' . $this->profile_picture;
 }
 public function getBranch()
 {
   return Branch::find($this->branch_id)->branch_name;
 }

 public function getDocuments()
 {
  return Document::where('employee_id', '=', $this->id)->get();
 }



 public function getContributions()
 {

 }

 public function getTotalDeductions($from= null, $to= null, $number_format=false)
 {
    $deductions = $this->getDeductions($from, $to);
    $total = 0;

    foreach ($deductions as $deduction) {
      $total += $deduction->amount;
    }

    if($number_format) return number_format($total,2);
    return $total;

 }

 public function getDeductions($from = null, $to = null)
 {

  if($from == null or $to == null) return EmployeeDeduction::where('employee_id', '=', $this->id)->get();

  return EmployeeDeduction::where('employee_id', '=', $this->id)
                          ->where('valid_from', '<=' , $to)  
                          ->where('valid_to', '>=' , $from)  
                          ->get();
 }

 public function getTotalAllowances($from= null, $to= null, $number_format=true)
 {
    $allowances = $this->getAllowances($from, $to);
    $total = 0;

    foreach ($allowances as $allowance) {
      $total += $allowance->amount;
    }

    if($number_format) return number_format($total,2);
    return $total;

 }

 public function getGross($format = true)
 {
    
    $total_Allowance = 0;
    $total = 0;
    
    $total = intval($this->getTotalAllowances(null,null,false)) + intval($this->getBasicPay(false));

    if($format)
    {
      return number_format($total,2);
    } else {

      return $total; 
    }

 }

public function getAllowances($from = null, $to = null)
 {

  if($from == null or $to == null) return EmployeeAllowance::where('employee_id', '=', $this->id)->get();
  
  $allowance = EmployeeAllowance::where('employee_id', '=', $this->id)
                          ->where('valid_from', '<=' , $to)  
                          ->where('valid_to', '>=' , $from)  
                          ->get();
   return $allowances;
 }


 public function getBasicPay($format=true)
 {
  if (count($this->getBasicPayAdjustments()) > 0){
      $adjustment =  BasicPayAdjustment::where('effective_date', '<=', date('Y-m-d'))->orderBy('id', 'desc')->first();
  
      if($adjustment){
        if($format){
         return number_format($adjustment->new_basic_pay, 2,'.', ',');
        }

        return $adjustment->new_basic_pay;
      }
  }

  if($format){
   return number_format($this->basic_pay, 2,'.', ',');
    }
  
  return $this->basic_pay;

 }

 public function getBasicPayAdjustments($limit = 5, $skip = 0)
 {
  return BasicPayAdjustment::where('employee_id', '=', $this->id)->orderBy('id', 'desc')->take($limit)->skip($skip)->get();
 }

 public function getEntitledNightDifferential()
 {
    if($this->entitled_night_differential) return 'Yes';
    return 'No';
 }
 public function getEntitledOvertimePay()
 {
    if($this->entitled_overtime_pay) return 'Yes';
    return 'No';
 } 
 public function getTimesheetRequired()
 {
    if($this->timesheet_required) return 'Yes';
    return 'No';
 }

public function getDeductSSS($english_format = true)
{
    if($english_format){
      if($this->deduct_sss) return 'Yes';
      return 'No';
    }

    return $this->deduct_sss;

}

public function getDeductHDMF($english_format = true)
{
    if($english_format){
      if($this->deduct_hdmf) return 'Yes';
      return 'No';
    }

    return $this->deduct_hdmf;
}

public function getDeductPhilhealth($english_format = true)
{
    if($english_format){
      if($this->deduct_philhealth) return 'Yes';
      return 'No';
    }

    return $this->deduct_philhealth;
    
}

public function getUnderTimeDeductionRate($per_unit)
{
  return getDeductionRate($this->basic_pay, $this->payroll_period, $per_unit);


}

public function getTimeShiftStart($military_format = false)
{
  if($military_format) return $this->timeshift_start;
  return date('h:i a', strtotime($this->timeshift_start));
}


public function getTimeShiftEnd($military_format = false)
{
  if($military_format) return $this->timeshift_end;
  return date('h:i a', strtotime($this->timeshift_end));
}

public function getTax()
{
    $salary = intval($this->getBasicPay(false));
    $dependents = $this->dependents;
    $period = $this->period;

    $sss_val = $this->fixed_sss_amount==null ? getSSS($salary)['EE'] : (int) $sss;

    $philhealth_val =$this->fixed_philhealth_amount==null ? getPH($salary)['Employee_Share'] : (int) $philhealth;
    
    $pagibig_val = $this->fixed_hdmf_amount==null ? 100 : (int) $pagibig;

    $curr_salary =    $salary - ($sss_val + $philhealth_val + $pagibig_val );
    // return $curr_salary;

    $wt = getWTax( $curr_salary , $period , $dependents);

    $deductions = ($sss_val + $philhealth_val + $pagibig_val +  intval($this->getTotalDeductions())  ) ;

    $total_deductions = $deductions + $wt;

    $net = intval($this->getGross(false)) - $total_deductions;

    return array(
        'gross' => number_format($salary,2),
        'widthholding_tax' => number_format($wt,2),
        'philhealth' => number_format($philhealth_val,2),
        'SSS' => number_format($sss_val,2),
        'pagibig'=> number_format($pagibig_val,2),
        'basic' => number_format($salary,2),
        'taxable' => number_format($curr_salary,2),
        'total_deduc' => number_format( $total_deductions,2),
        'net' => number_format($net,2)
      );
}


}
