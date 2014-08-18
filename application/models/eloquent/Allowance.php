<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Allowance extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "allowances";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['allowance_name','created_by'];

  public function getCreator()
  {
  	return Employee::find($this->created_by)->getName();
  }

}
