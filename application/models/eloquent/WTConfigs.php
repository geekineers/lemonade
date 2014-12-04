
<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class WTConfigs extends BaseModel
{
    use SoftDeletingTrait;
    public $table    = "wt_settings";
    protected $datas = ['deleted_at'];

    protected $fillable = ['period',
        'to_range',
        'from_range',
        'dependents',
        'index',
        'exemption',
        'status'
    ];

}
