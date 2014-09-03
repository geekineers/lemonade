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

    protected $fillable = [
        'evaluation_name',
        'employee_id',
        'evaluation_from',
        'evaluation_to',
        'evaluation_description',
        'created_by',
    ];

    public function getName()
    {
        return $this->evaluation_name;
    }

    public function getDescription()
    {
        return $this->evaluation_description;
    }
    public function getDateFromDiff()
    {
        $from = new Carbon($this->evaluation_from);
        return $from->diffForHumans(Carbon::now());
    }
    public function getDateToDiff()
    {
        $to = new Carbon($this->evaluation_to);
        return $to->diffForHumans(Carbon::now());
    }

}
