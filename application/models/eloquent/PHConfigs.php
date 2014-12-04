
<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PHConfigs extends BaseModel
{
    use SoftDeletingTrait;
    public $table    = "ph_settings";
    protected $datas = ['deleted_at'];

    protected $fillable = ['from_range', 'company_id','to_range', 'salary_base', 'total_monthly_premium', 'employee_share', 'employer_share'];

}
