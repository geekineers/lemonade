<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Timesheet extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "timesheet";
	 protected $datas = ['deleted_at'];

  protected $fillable = ['id', 'employee_id', 'source', 'time_in', 'time_out', 'cookie_registry'];



  public function getEmployee()
  {
  	return Employee::find($this->employee_id);
  }

  public function getTimeOut()
  {
  	if($this->time_out == null) return 'Still Logged In';

  	return $this->time_out;
  }

}
