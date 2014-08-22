<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Form_Application extends Eloquent {
	use SoftDeletingTrait;

	public $table = "form_application";
	protected $datas = ['deleted_at'];


  protected $fillable = ['employee_id', 'prepared_by', 'effective_date','from','to','status','form_data','form_type'];

}
