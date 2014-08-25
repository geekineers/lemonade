<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Evaluation extends Eloquent
{
    use SoftDeletingTrait;
    public $table    = "evaluations";
    protected $datas = ['deleted_at'];

    protected $fillable = ['evaluation_name',
        'employee_id',
        'date_from',
        'date_to',
        'created_by',
    ];

}
