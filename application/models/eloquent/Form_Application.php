<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Form_Application extends BaseModel {
	use SoftDeletingTrait;

	public $table = "form_application";
	protected $datas = ['deleted_at'];


  protected $fillable = ['employee_id', 'prepared_by', 'effective_date','from','to','status','form_data','form_type', 'approved_by'];

  public function getEmployee()
  {
    return Employee::find($this->employee_id);
  }

  public function getFormData()
  {
      return json_decode($this->form_data);
  }

  public function getFormType()
  {
    $form_type = $this->form_type;

    switch ($form_type) {
      case 'ot':
        return 'Over Time';
        break;
      case 'ob':
        return 'Official Business';
        break;
      case 'undertime':
        return 'Undertime';
        break;
      case 'leave':
        return 'Leave';    
        break;

      default:
        # code...
        break;
    }

  }
    
  public function getEmployeeNames()
  {
  	return Employee::find($this->employee_id)->getName();
  }
  public function getPreparedBy()
  {
  	return Employee::find($this->prepared_by)->getName();
  }
  public function getDepartment()
  {
    return Employee::find($this->employee_id)->getDepartment();
  }

  public function getApprovedBy()
  {
    return Employee::find($this->employee_id);
  }
}
