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


}
