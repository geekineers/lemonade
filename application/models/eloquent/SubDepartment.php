<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class SubDepartment extends BaseModel {
  
  use SoftDeletingTrait;
  public $table = "sub_department";
  protected $datas = ['deleted_at'];

  protected $fillable = [
  	'sub_department_name',
  	'sub_department_description', 
  	'created_at', 
  	'deleted_at', 
  	'updated_at'];
}

