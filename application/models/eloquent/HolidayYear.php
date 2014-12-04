
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class HolidayYear extends BaseModel {
	use SoftDeletingTrait;
  	 public $table = "holiday_years";
	 protected $datas = ['deleted_at'];


  protected $fillable = ['year', 'created_by', 'company_id'];

  public function getCreator()
  {
  	return Employee::where('user_id', $this->created_by)->first()->getName();
  }
}
