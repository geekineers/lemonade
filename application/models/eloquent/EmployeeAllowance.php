<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EmployeeAllowance extends Eloquent {
	use SoftDeletingTrait;
	public $table    = "employee_allowances";
	protected $datas = ['deleted_at'];

	protected $fillable = ['employee_id',
		'allowance_id',
		'recurring',

		'amount',

		'valid_from',
		'valid_to'
	];


	public function getEmployee()
	{
		return Employee::find($this->employee_id);
	}

	public function getName($from = null, $to = null) 
	{
		$allowance = Allowance::find($this->allowance_id);
		$name =  $allowance->allowance_name;
		$allowance_type = $allowance->frequency;

		if($allowance_type == "daily" && $from != null){
			return $name . " x " . $this->getEmployee()->getInAttendance($from, $to);
		}

		return $name;
	}

	public function getAmount($number_format = true, $from = null, $to=null) {
	
		$allowance = Allowance::find($this->allowance_id);
		$allowance_type = $allowance->frequency;

		if($allowance_type == "daily") {
				$amount = $this->amount * $this->getEmployee()->getInAttendance($from, $to);
				if ($number_format) { return number_format( $amount, 2); }
				return $amount;
		}

		if ($number_format) { return number_format($this->amount, 2); }

		return $this->amount;
	}

}
