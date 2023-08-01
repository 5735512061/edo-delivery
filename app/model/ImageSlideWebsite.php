<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ImageSlideWebsite extends Model
{
	protected $table = 'image_slide_websites';

	protected $fillable = [
    	'store_id', 'image'
    ];

    protected $primaryKey = 'id';
}
