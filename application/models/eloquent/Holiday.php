<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Holiday extends Eloquent
{
    use SoftDeletingTrait;
    public $table    = "holidays";
    protected $datas = ['deleted_at'];

    protected $fillable = ['year', 'holiday_year_id', 'holiday_name', 'holiday_type', 'holiday_from', 'holiday_to'];


    public function getDay()
    {
    	return date('j', strtotime($this->holiday_from));
    }

    public function getMonth()
    {
    	return date('M', strtotime($this->holiday_from));
    }

    public function getYear()
    {
    	return date('Y', strtotime($this->holiday_from));
    }


}
