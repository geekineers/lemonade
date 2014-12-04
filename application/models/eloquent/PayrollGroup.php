


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
                        'company_id',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                        'company_id'

               ];

  public function getPeriodName()
  {
      return $this->group_name . '-' . $this->period;
  }
  
  public function setPasswordAttribute($password)
  {
        $this->attributes['password'] = md5($password);
  }

  public function getBranch()
  {
        $branch =  Branch::find($this->branch_id);
        if($branch) {
          return $branch->branch_name;
        }

        return 'Null';
  }

  public function getBranchAddress()
  {
    $branch =  Branch::find($this->branch_id);
         if($branch) {
          return $branch->branch_address;
        }

        return 'Null';
  }

  public function getDate()
  {
        return date_format( date_create($this->from),'Y/m/d') .'-'.  date_format( date_create($this->to),'Y/m/d');;
  }

 


}
                      		