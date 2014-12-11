<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EmployeeLeaveCredit extends Eloquent {
	use SoftDeletingTrait;
	public $table    = "employee_leave_credits";
	protected $datas = ['deleted_at'];

	protected $fillable = ['employee_id', 'leave_type_id'];


	public static function getEmployeeRemainingCredits($employee_id, $leave_type_id)
	{
		$credit = EmployeeLeaveCredit::where('employee_id', $employee_id)
									 ->where('leave_type_id', $leave_type_id)
									 ->first();

		$leave_type = LeaveType::find($leave_type_id);

		return ($credit) ? $credit->counter : 	(int) $leave_type->leave_type_base_points;
	}

	public static function deductPoint($employee_id, $leave_type)
	{
		$remaining_points = $this->getEmployeeRemainingCredits($from, $to);
		$remaining_points = $remaining_points - 1;

		$credit = EmployeeLeaveCredit::where('employee_id', $employee_id)
									 ->where('leave_type_id', $leave_type_id)
									 ->first();
		$credit->counter = $remaining_points;
		$credit->save();				

		return true;
	}
}
