<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class LeaveType extends BaseModel
{
    use SoftDeletingTrait;
    public $table    = "leave_types";
    protected $datas = ['deleted_at'];

    protected $fillable = ['leave_type_name', 'leave_type_approval_sequence', 'leave_type_required_approval',
        'leave_type_base_points',
        'leave_type_points_earning'
    ];


    public function getName()
    {
    	return $this->leave_type_name;
    }

    public function checkIfApproved()
    {
    	$list_of_approvals = explode("|", $this->leave_type_required_approval);
    	$type_of_approval = $this->leave_type_approval_sequence;

    	switch ($type_of_approval) {
    		case 'or':
   				foreach ($list_of_approvals as $key => $value) {
   					# code...
   				}

       			break;
    		case 'and':
    			# code...
    			break;
    		default:
    			# code...
    			break;
    	}

    	return (boolean) false;
    }

}
