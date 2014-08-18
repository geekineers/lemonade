<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class EmployeeAllowance extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "employee_allowances";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['employee_id',
  						 'allowance_id',
  						 'recurring',
  						
  						 'amount',
  				
  						 'valid_from',
  						 'valid_to'
  					     ];


   public function getName()
   {
   	 return Allowance::find($this->allowance_id)->allowance_name;
   }

    public function getAmount($number_format = true)
   {
     if($number_format) return number_format($this->amount);
     return $this->amount;
   }
   
}
