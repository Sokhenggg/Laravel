<?php

namespace App\Models\Food;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    //
    use HasFactory;

    protected $table = 'bookings';
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'num_people',
        'date',
        'request',
        'status'
    ];

    public $timestamps = true;
}
