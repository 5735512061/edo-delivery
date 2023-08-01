<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customers';

    protected $guard = 'customer';

    protected $fillable = [
        'customer_code', 'name', 'surname', 'phone', 'username', 'password', 'date', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
