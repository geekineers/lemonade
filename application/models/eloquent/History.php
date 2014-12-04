<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}
require_once ('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class History extends BaseModel {
	use SoftDeletingTrait;
  	 public $table = "histories";
	 protected $datas = ['deleted_at'];


    protected $fillable = ['employee_id', 'action',  'company_id','date_happened'
               ];


    public function getEmployeeName()
    {
    	$logged_user = get_instance()->sentry->getUser();
    	if($logged_user->id == $this->employee_id){
    		return 'You';
    	}
    	else{
    		$employee = Employee::find($this->employee_id);
    		return $employee->getName();
    	}
    }

    public function getAction()
    {
    	return (is_null($this->action)) ? 'None' : $this->action; 

    }

    public function getDate()
    {
    	if(is_null($this->date_happened)) {
    		return 'None';
    	}

    	return date('Y-m-d', strtotime($this->date_happened));

    }
 

}
