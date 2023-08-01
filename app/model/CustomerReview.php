<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model
{
	protected $table = 'customer_reviews';

	protected $fillable = [
    	'branch_name', 'feedback', 'comment'
    ];

    protected $primaryKey = 'id';
}
