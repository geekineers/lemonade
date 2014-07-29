<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Branch extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "branches";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['branch_name', 'branch_description', 'branch_address', 'branch_contact_number'];

  public function setPasswordAttribute($password)
  {
  		$this->attributes['password'] = md5($password);
  }

}
