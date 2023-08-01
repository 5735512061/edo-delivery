<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class MenuPricePromotion extends Model
{
	protected $table = 'menu_price_promotions';

	protected $fillable = [
    	'menu_id', 'promotion_price', 'status'
    ];

    protected $primaryKey = 'id';
}
