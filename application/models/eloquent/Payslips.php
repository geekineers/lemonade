<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Payslips extends Eloquent
{
    use SoftDeletingTrait;
    public $table    = "payslips";
    protected $datas = ['deleted_at'];

    protected $fillable = [
        'employee_id',
        'branch_id',
        'payslip_group_id',
        'payroll_group',
        'sss',
        'philhealth',
        'pagibig',
        'other_deductions',
        'prepared_by',
        'from',
        'to',
        'net',
        'gross',
        'company_id',
        'withholding_tax',
        'sss_employer'
    ];

    public function getPayslipsGroup()
    {
        return PayslipsGroup::where('id', '=', $this->payslip_group_id)->first();
    }
    public function getPreparedBy()
    {
        return Employee::where('id', '=', $this->employee_id)->first()->getName();
    }
    public function getPayrollDate()
    {
        $from = date_format(date_create($this->from), 'Y/m/d');
        $to   = date_format(date_create($this->to), 'Y/m/d ');
        return $from . ' - ' . $to;
    }
    public function getEmployee()
    {
        return Employee::where('id', '=', $this->employee_id)->first();
    }

    public function getEmployees()
    {
        return Employee::where('id', '=', $this->employee_id)->get();
    }

    public function getGroupName()
    {
        return PayrollGroup::where('id', '=', $this->payroll_group)->first()->group_name;
    }

    public function getGroupPeriod()
    {
        return PayrollGroup::where('id', '=', $this->payroll_group)->first()->period;
    }

    public function getName()
    {
        $first_name = Employee::where('id', '=', $this->employee_id)->first()->first_name;
        $last_name  = Employee::where('id', '=', $this->employee_id)->first()->last_name;
        return $first_name . ' ' . $last_name;
    }

    public function getBranch()
    {

        return Branch::find($this->branch_id)->branch_name;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = md5($password);
    }

    public function getGross($format = true)
    {

        $total_Allowance = 0;
        $total           = 0;

        $total = $this->getEmployee()->getOvertime($this->from, $this->to) + intval($this->getEmployee()->getTotalAllowances(null, null, false)) + intval($this->getEmployee()->getBasicPay(false));

        if ($format) {
            return number_format($total, 2);
        } else {

            return $total;
        }

    }

}
