<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
	protected $table = 'shipments';

	protected $fillable = [
    	'customer_id', 'bill_number', 'name', 'phone', 'address', 'district', 'amphoe', 'province', 'zipcode'
    ];

    protected $primaryKey = 'id';
}
