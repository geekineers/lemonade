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
                        'prepared_by',
                        'from',
                        'to',
                        'net',
                        'gross'
               ];

  public function getPreparedBy()
  {
    return Employee::where('id','=',$this->employee_id)->first()->getName();
  }
  public function getPayrollDate()
  {
    $from = date_format( date_create($this->from),'Y/m/d');
    $to = date_format( date_create($this->to),'Y/m/d ');
    return $from.' - '.$to;
  }
  public function getEmployee()
  {
    return Employee::where('id','=',$this->employee_id)->first();
  }

  public function getGroupName()
  {
    return PayrollGroup::where('id','=',$this->payroll_group)->first()->group_name;
  }

  public function getGroupPeriod()
  {
    return PayrollGroup::where('id','=',$this->payroll_group)->first()->period;
  }

  public function getName()
  {
    $first_name = Employee::where('id','=',$this->employee_id)->first()->first_name;
    $last_name = Employee::where('id','=',$this->employee_id)->first()->last_name;
     return $first_name.' '.$last_name;
  }

  public function getBranch()
  {
        return Branch::find($this->branch_id)->branch_name;
  }
  
  public function setPasswordAttribute($password)
  {
      $this->attributes['password'] = md5($password);
  }

  

} 
