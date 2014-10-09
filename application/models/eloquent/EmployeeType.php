<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Cartalyst\Sentry\Groups\Eloquent\Group;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EmployeeType extends BaseModel {
	use SoftDeletingTrait;
  	 public $table = "employee_types";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['employee_type_name', 'company_id'];

  public function getName()
  {
    return $this->employee_type_name;
  }





}
