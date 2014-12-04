<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class BasicPayAdjustment extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "basic_pay_adjustments";
	 protected $datas = ['deleted_at'];


  protected $fillable = [
  						'employee_id',
  						'current_basic_pay',
  						'new_basic_pay',
  						'effective_date',
  						'adjustment_date',
  						'adjustment_reason',
  						'created_by',
  					];

 public function getCreatedBy()
 {
 		return Employee::find($this->created_by)->getName();
 }

 public function getCurrentBasicPay()
 {
 	 return number_format($this->current_basic_pay, 2,'.', ',');
 }

 public function getNewBasicPay()
 {
 	 return number_format($this->new_basic_pay, 2,'.', ',');
 }

}
