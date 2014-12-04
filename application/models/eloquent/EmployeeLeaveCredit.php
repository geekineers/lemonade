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


}
