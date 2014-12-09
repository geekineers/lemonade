<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Allowance extends BaseModel
{
    use SoftDeletingTrait;
    public $table    = "allowances";
    protected $datas = ['deleted_at'];

    protected $fillable = ['allowance_name', 'created_by', 'company_id', 'frequency'];

    public function getCreator()
    {
        $employee = Employee::find($this->created_by);

        if ($employee) {
            return $employee->getName();
        }
        return 'Super Administrator';

    }

    public function getFrequency()
    {
        if($this->frequency == 'daily'){
            return 'Daily';
        }

        return 'Once Every Payroll';
    }

}
