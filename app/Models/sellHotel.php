<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sellHotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'barcode',
        'product_name',
        'quantity',
        'number_of_pack',
        'selling_price',
        'total',
        'date',
        'image',
    ];
}
