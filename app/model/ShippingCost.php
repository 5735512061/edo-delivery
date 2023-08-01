<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ShippingCost extends Model
{
	protected $table = 'shipping_costs';

	protected $fillable = [
    	'store_id', 'province', 'amphoe', 'place', 'min_cost', 'price'
    ];

    protected $primaryKey = 'id';
}
