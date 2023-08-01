<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class OrderConfirm extends Model
{
	protected $table = 'order_confirms';

	protected $fillable = [
    	'bill_number', 'status'
    ];

    protected $primaryKey = 'id';
}
