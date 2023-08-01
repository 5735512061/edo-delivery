<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class SpecialMenu extends Model
{
	protected $table = 'special_menus';

	protected $fillable = [
    	'store_id', 'heading', 'detail', 'image'
    ];

    protected $primaryKey = 'id';
}
