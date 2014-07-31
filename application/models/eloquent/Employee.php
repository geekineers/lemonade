<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

// use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Employee extends Eloquent {
	// use SoftDeletingTrait;
  	 protected $table = "employees_profile";
	 // protected $datas = ['deleted_at'];


  protected $fillable = ['first_name', 'last_name',  'middle_name','full_address','role_id', 'branch_id',
  						 'job_position',
               'tin_number',
               'sss_number',
               'pagibig_number',
               'contact_number',
               'employee_type', 
               'user_id',
  						 'dependents',
               'created_at',
               'updated_at'
  						 ];



}
