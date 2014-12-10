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


    public function getName($from = null, $to = null) 
    {
   
    // dd($this->frequency);
        if($this->frequency == "daily" && $from != null){
            return $this->allowance_name . "X" . $this->getEmployee()->getInAttendance($from, $to);
        }
        return $this->allowance_name;
    }

    public function getAmount($number_format = true, $from = null, $to=null) {
    
   

        if($this->frequency == "daily") {
                $amount = $this->amount * $this->getEmployee()->getInAttendance($from, $to);
                if ($number_format) { return number_format( $amount, 2); }
        }

        if ($number_format) { return number_format($this->amount, 2); }

        return $this->amount;
    }

}
