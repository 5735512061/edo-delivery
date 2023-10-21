<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class UrlApplyWork extends Model
{
    protected $table = 'url_apply_works';

    protected $fillable = [
        'branch_name', 'url_name'
    ];
    
    protected $primaryKey = 'id';
}
