<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ApplyWork extends Model
{
    protected $table = 'apply_works';

    protected $fillable = [
        'branch_id', 'position', 'salary', 'name', 'surname', 'age', 'tel', 'history_work', 'performance', 'facebook', 'image', 'card_id'
    ];
    
    protected $primaryKey = 'id';
}
