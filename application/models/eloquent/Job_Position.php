<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Job_Position extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "job_position";
	 protected $datas = ['deleted_at'];


    protected $fillable = ['job_position', 'job_description',  'created_at',
               'updated_at'];

  public function setPasswordAttribute($password)
  {
  		$this->attributes['password'] = md5($password);
  }

}
