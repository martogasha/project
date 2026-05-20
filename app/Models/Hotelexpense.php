<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotelexpense extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'desc',
        'amount',
        'date',
        'end_date',
        'barcode',
        'payment_method',
    ];
}
