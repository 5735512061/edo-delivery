<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class MenuPrice extends Model
{
	protected $table = 'menu_prices';

	protected $fillable = [
    	'menu_id', 'price', 'status'
    ];

    protected $primaryKey = 'id';
}
