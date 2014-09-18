<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
require_once ('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SSSConfigs extends BaseModel
{
    use SoftDeletingTrait;
    public $table    = "sss_settings";
    protected $datas = ['deleted_at'];

    protected $fillable = ['from_range', ',company_id','to_range', 'monthly_salary_credit', 'ER', 'EE', 'EC', 'TTC'];

}
