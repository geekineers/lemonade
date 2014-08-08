<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Payslips extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "payslips";
	 protected $datas = ['deleted_at'];


    protected $fillable = [
                        'employee_id',
                        'branch_id',
                        'payroll_group',
                        'sss',
                        'philhealth',
                        'pagibig',
                        'other_deductions',
                        'prepared_by'
               ];


  
  public function setPasswordAttribute($password)
  {
  		$this->attributes['password'] = md5($password);
  }

}
