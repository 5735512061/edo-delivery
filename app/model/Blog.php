<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $table = 'blogs';

	protected $fillable = [
    	'store_id', 'image', 'thai_name', 'eng_name', 'detail'
    ];

    protected $primaryKey = 'id';
}
