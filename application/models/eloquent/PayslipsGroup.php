<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class PayslipsGroup extends BaseModel {
	use SoftDeletingTrait;
  public $table = "payslips_group";
	protected $datas = ['deleted_at'];


  protected $fillable = ['payroll_group', 'from','to','status','prepared_by','company_id'];

  public function setPasswordAttribute($password)
  {
  		$this->attributes['password'] = md5($password);
  }



  public function getPayslip()
  {
  	return Payslips::where('payslip_group_id','=',$this->id)->first();
  }

  public function getAllPayslips()
  {
    return Payslips::where('payslip_group_id','=',$this->id)->get();
  }

  public function getPayslipsByDepartments()
  {
    $output = array();

    $departments = Payslips::where('payslip_group_id', '=', $this->id)->groupBy('department_id')->get();

    foreach ($departments as $department) {
      $e['name'] = $department->getDepartment();
      $e['items'] =  Payslips::where('payslip_group_id', '=', $this->id)->where('department_id', $department->department_id)->get();

      array_push($output, $e);
    }


    return $output;
  }
  public function getPayrollGroup()
  {
  	return PayrollGroup::where('id','=',$this->payroll_group)->first();
  }

  public function getName()
  {
    return Payslips::where('payslip_group_id','=',$this->id)->first()->getName();
  }

  public function getBranch()
  {
  	return PayrollGroup::where('id','=',$this->payroll_group)->first()->getBranch();
  }
  
  public function getPreparedBy()
  {
    $emp = Employee::where('id','=',$this->prepared_by)->first();

    return (is_null($emp)) ? 'Super Administrator' :  $emp->getName();
  }
}
