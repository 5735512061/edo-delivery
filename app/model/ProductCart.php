<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProductCart extends Model
{
	protected $table = 'product_carts';

	protected $fillable = [
    	'customer_id', 'bill_number', 'product_id', 'price', 'qty', 'comment'
    ];

    protected $primaryKey = 'id';
}
