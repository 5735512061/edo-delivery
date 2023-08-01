<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ImageLogoWebsite extends Model
{
	protected $table = 'image_logo_websites';

	protected $fillable = [
    	'store_id', 'image'
    ];

    protected $primaryKey = 'id';
}
