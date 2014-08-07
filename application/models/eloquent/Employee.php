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

                      // Employee Details 

                      'employee_type',
                      'payroll_period'
                      'job_position',
                      'department',
                      'role_id',
                      'branch_id',
                      'date_hired',
                      'date_ended',

                      // Government Details

                      'basic_pay',
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


 public function getName()
 {
    return $this->first_name .' ' . $this->middle_name . ' ' . $this->last_name;
 }               
 public function getJobPosition()
 {
    return Job_Position::find($this->job_position)->job_position;
 }
 public function getProfilePicture()
 {
  return '/media?image=' . $this->profile_picture;
 }
 public function getBranch()
 {
   return Branch::find($this->branch_id)->branch_name;
 }

 public function getPayrollPeriod()
 {
  return 'Monthly';
 }

}
