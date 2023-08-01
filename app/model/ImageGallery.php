<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
	protected $table = 'image_gallerys';

	protected $fillable = [
    	'store_id', 'image'
    ];

    protected $primaryKey = 'id';
}
