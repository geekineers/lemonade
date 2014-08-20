<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Memo extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "memos";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['from','to', 'title', 'message'];

  public function getCreator()
  {
  	return Employee::find($this->created_by)->getName();
  }

  public function getFrom()
  {
  	return Employee::find($this->from);
  }

  public function getTo()
  {
  	return Employee::find($this->to);
  }

  public function getMessage()
  {
  	return $this->message;
  }

  public function getPostTimeDiff()
  {
  	$posted = new Carbon($this->created_at);
  	return Carbon::now()->diffForHumans($posted);
  }

}
