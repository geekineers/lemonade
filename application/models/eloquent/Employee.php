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

 public function getAllowance()
 {
  
 }

 public function getDeductions()
 {
  return EmployeeDeduction::where('employee_id', '=', $this->id)->get();
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

}
