<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Company extends Eloquent {
	use SoftDeletingTrait;
  	 public $table = "companies";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['company_name', 'company_description', 'company_address', 'company_contact_number', 'company_logo'];

  public function getCreator()
  {
  	return Employee::find($this->created_by)->getName();
  }

   public function getCompanyLogo()
 {
  return '/media?image=' . $this->company_logo;
 }
}
