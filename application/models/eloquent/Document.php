<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

require_once ('connection.php');

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Document extends Eloquent
{
    use SoftDeletingTrait;
    protected $table = 'documents';
    protected $datas = ['deleted_at'];

    protected $fillable = ['employee_id', 'name', 'file_name', 'file_size', 'file_extension', 'file_type', 'file_description', 'document_type'];
}
