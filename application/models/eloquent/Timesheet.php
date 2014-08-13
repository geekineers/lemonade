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

  public function getTimeDiff()
  {

  	$time_out = ($this->time_out == null) ? date('Y-m-d H:i:s') : $this->time_out;

  	$datetime_in = new DateTime($this->time_in);
  	$datetime_out = new DateTime($time_out);
  	
  	$interval = $datetime_in->diff($datetime_out);
  	return $interval->format('%H:%I:%s');
  }

}
