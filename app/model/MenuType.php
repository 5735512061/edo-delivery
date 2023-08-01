<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class MenuType extends Model
{
	protected $table = 'menu_types';

	protected $fillable = [
    	'menu_type', 'menu_type_eng', 'status', 'store_id', 'image'
    ];

    protected $primaryKey = 'id';
}
