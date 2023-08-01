<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class PaymentCheckout extends Model
{
	protected $table = 'payment_checkouts';

	protected $fillable = [
    	'customer_id', 'bill_number', 'payday', 'time', 'money', 'slip'
    ];

    protected $primaryKey = 'id';
}
