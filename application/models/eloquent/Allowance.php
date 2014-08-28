<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Allowance extends BaseModel {
	use SoftDeletingTrait;
  	 public $table = "allowances";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['allowance_name','created_by', 'company_id'];

  public function getCreator()
  {
  	// dd($this->created_by);
  	// dd(Employee::find(1));
  	return Employee::find($this->created_by)->getName();
  }

}
