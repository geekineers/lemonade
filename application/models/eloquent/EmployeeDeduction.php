<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class EmployeeDeduction extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "employee_deductions";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['employee_id',
  						 'deduction_id',
  						 'recurring',
  						 'deduction_type',
  						 'amount',
  						 'percentage',
  						 'basis',
  						 'valid_from',
  						 'valid_to'
  					     ];


}
