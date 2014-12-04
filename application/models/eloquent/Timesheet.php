<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Timesheet extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "timesheet";
	 protected $datas = ['deleted_at'];

  protected $fillable = ['id', 'employee_id', 'source', 'time_in', 'time_out', 'cookie_registry','status'];

  public function employee()
  {
        return $this->belongsTo('Employee');
  }

  public function getEmployee()
  {
    return Employee::where('id', '=',$this->employee_id)->withTrashed()->first();
    // if($employee){
    //   $employee = Employee::find($this->employee_id);
    // }

    // $employee = new Employee();
    // $employee->first_name = "Deleted";
    // $employee->last_name = "User";

    // return 
  }

  public function getTimeOut()
  {
  	if($this->time_out == null) return 'Still Logged In';

  	return $this->time_out;
  }


  public function getTimeInHours()
  {
    // dd($this->time_in);
    return date('h:i A', strtotime($this->time_in));
   
  }
  

  public function getTimeOutHours()
  {
    return date('h:i A', strtotime($this->time_out));
   
  }

  public function getTimeInDate()
  {
     return date('Y-m-d', strtotime($this->time_in));
  }
  public function getTimeOutDate()
  {
       return date('Y-m-d', strtotime($this->time_out));
  }
  public function getTimeDiff()
  {

  	$time_out = ($this->time_out == null) ? date('Y-m-d H:i:s') : $this->time_out;

  	$datetime_in = new DateTime($this->time_in);
  	$datetime_out = new DateTime($time_out);
  	
  	$interval = $datetime_in->diff($datetime_out);
  	return $interval->format('%H:%I:%s');
  }


  public function checkIfEmployeeDeleted()
  {
    return (boolean) $this->getEmployee()->trashed();
  }

}
