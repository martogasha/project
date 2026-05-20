<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'name',
        'total',
        'payment_method',
        'date'
    ];
}
