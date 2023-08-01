<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	protected $table = 'contacts';

	protected $fillable = [
    	'store_id', 'customer_id', 'tel', 'subject', 'message', 'answer_message'
    ];

    protected $primaryKey = 'id';
}
