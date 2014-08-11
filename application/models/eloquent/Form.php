<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Form extends Eloquent {
	use SoftDeletingTrait;

	public $table = "forms";
	protected $datas = ['deleted_at'];


  protected $fillable = ['form_name', 'form_content', 'user_id'];

}
