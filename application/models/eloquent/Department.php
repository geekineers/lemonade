<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Department extends BaseModel {
	use SoftDeletingTrait;
  	 public $table = "department";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['department_name', 'department_description','created_at'];

  public function setPasswordAttribute($password)
  {
  		$this->attributes['password'] = md5($password);
  }

}
