
<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Training extends BaseModel
{
    use SoftDeletingTrait;
    public $table    = "trainings";
    protected $datas = ['deleted_at'];

    protected $fillable = ['name', 'employee_id', 'status', 'description', 'from', 'to', 'company_id'];

}
