

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class PayrollGroup extends Eloquent {
    use SoftDeletingTrait;
     public $table = "payroll_group";
     protected $datas = ['deleted_at'];


    protected $fillable = [
                        'branch_id',
                        'group_name',
                        'period',
                        'prepared_by',
                        'created_at',
                        'updated_at',
                        'deleted_at'

               ];


  
  public function setPasswordAttribute($password)
  {
        $this->attributes['password'] = md5($password);
  }

  public function getBranch()
  {
        return Branch::find($this->branch_id)->branch_name;
  }



}
                      		