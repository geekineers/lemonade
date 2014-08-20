<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Announcement extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "announcement";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['author','title','content'];


  public function getAuthor()
  {
  	return Employee::find($this->author);
  }

  public function getPostTimeDiff()
  {
  	$posted = new Carbon($this->created_at);
  	return Carbon::now()->diffInHours($posted);
  }
  public function getMessage()
  {
  	return $this->content;
  }

}
