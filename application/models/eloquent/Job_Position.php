<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Job_Position extends BaseModel {
	use SoftDeletingTrait;
  	 public $table = "job_position";
	 protected $datas = ['deleted_at'];


    protected $fillable = ['job_position', 'job_description',  'created_at',
               'updated_at', 'branch_id'];

  public function setPasswordAttribute($password)
  {
  		$this->attributes['password'] = md5($password);
  }


  public function getBranchName()
  {
  	$branch = Branch::find($this->branch_id);
  	if($branch){
  		return $branch->branch_name;
  	}
  	return 'None';

  }
}
