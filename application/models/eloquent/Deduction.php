<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Deduction extends BaseModel {
	use SoftDeletingTrait;
  	 public $table = "deductions";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['deduction_name', 'deduction_type', 'created_by'];

  public function getCreator()
  {
  	return Employee::find($this->created_by)->getName();
  }

}
