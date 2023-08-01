<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'orders';

	protected $fillable = [
    	'customer_id', 'store_id', 'payment_id', 'shipment_id', 'product_cart_id', 'bill_number', 'date', 'coupon_id'
    ];

    protected $primaryKey = 'id';
}
