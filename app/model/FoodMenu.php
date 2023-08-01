<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class FoodMenu extends Model
{
	protected $table = 'food_menus';

	protected $fillable = [
    	'menu_type_id', 'store_id', 'code', 'thai_name', 'eng_name', 'detail', 'status', 'stock'
    ];

    protected $primaryKey = 'id';
}
