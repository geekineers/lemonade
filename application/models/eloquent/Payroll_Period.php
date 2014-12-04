<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Payroll_Period extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "payroll_period";
	 protected $datas = ['deleted_at'];


    protected $fillable = [
    		   'period_name', 
    		   'created_by',  
    		   'created_at',
               'updated_at'];



}
