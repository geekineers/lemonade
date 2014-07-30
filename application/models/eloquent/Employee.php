<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Employee extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "employees";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['first_name', 
  						 'middle_name', 
  						 'last_name', 
  						 'full_address', 
  						 'role_id', 
  						 'tin_number',
  						 'sss_number',
  						 'pagibig_number',
  						 'contact_number',
  						 'employee_type', // Daily, Semi-Monthly, Monthly
  						 'user_id',
  						 'branch_id',
  						 'job_position',
  						 'dependents',
  						 ];

  public function setPasswordAttribute($password)
  {
  		$this->attributes['password'] = md5($password);
  }

}
