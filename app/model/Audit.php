<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
	protected $table = 'audits';

	protected $fillable = [
    	'branch_id', 'number', 'list', 'status'
    ];

    protected $primaryKey = 'id';
}
