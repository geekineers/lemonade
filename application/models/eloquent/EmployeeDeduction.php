<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EmployeeDeduction extends Eloquent {
	use SoftDeletingTrait;
	public $table    = "employee_deductions";
	protected $datas = ['deleted_at'];

	protected $fillable = ['employee_id',
		'deduction_id',
		'recurring',
		'deduction_type',
		'amount',
		'percentage',
		'basis',
		'valid_from',
		'valid_to'
	];

	public function getName() {
		return Deduction::find($this->deduction_id)->deduction_name;
	}

	public function getAmount($number_format = true) {
		if ($number_format) {return number_format($this->amount, 2);
		}

		return $this->amount;
	}

}
