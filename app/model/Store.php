<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
	protected $table = 'stores';

	protected $fillable = [
    	'code', 'name', 'branch', 'address', 'phone', 'status', 'logo', 'facebook', 'facebook_url', 'instagram', 'instagram_url', 'line', 'line_url', 'mail'
    ];

    protected $primaryKey = 'id';
}
