<?php

namespace App\Models\Food;

use Illuminate\Database\Eloquent\Model;

class checkout extends Model{
   //
    protected $table = 'checkout';
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'town',
        'country',
        'zipcode',
        'user_id',
        'price',
        'status'
    ];

    public $timestamps = true;
}
