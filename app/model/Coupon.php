<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

	protected $fillable = [
    	'store_id', 'coupon_name', 'coupon_option', 'code', 'amount_type', 'amount', 'coupon_type', 'user_option', 'category_option', 'image', 'status'
    ];

    protected $primaryKey = 'id';
}
