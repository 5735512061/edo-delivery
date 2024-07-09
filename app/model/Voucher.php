<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

	protected $fillable = [
    	'admin_id', 'serialnumber', 'creator', 'branch_id', 'status', 'date', 'amount', 'staff_branch_id'
    ];

    protected $primaryKey = 'id';
}
