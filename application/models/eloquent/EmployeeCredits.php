<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EmployeeCredits extends BaseModel
{
    use SoftDeletingTrait;
    public $table    = "employee_credits";
    protected $datas = ['deleted_at'];

    protected $fillable = ['employee_id', 'credit_name', 'remaining_credits','credit_purpose','valid'];


    public function getEmployee()
    {
    	return Employee::find($this->employee_id);
    }

}
