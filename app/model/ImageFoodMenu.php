<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ImageFoodMenu extends Model
{
	protected $table = 'image_food_menus';

	protected $fillable = [
    	'menu_id', 'image'
    ];

    protected $primaryKey = 'id';
}
