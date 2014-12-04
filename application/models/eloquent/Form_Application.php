<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Form_Application extends BaseModel {
	use SoftDeletingTrait;

	public $table = "form_application";
	protected $datas = ['deleted_at'];


  protected $fillable = ['employee_id', 'prepared_by', 'effective_date','from','to','status','form_data','form_type'];

  public function getEmployee()
  {
    return Employee::find($this->employee_id);
  }

    
  public function getEmployeeNames()
  {
  	return Employee::find($this->employee_id)->getName();
  }
  public function getPreparedBy()
  {
  	return Employee::find($this->prepared_by)->getName();
  }
  public function getDepartment()
  {
    return Employee::find($this->employee_id)->getDepartment();
  }
}
