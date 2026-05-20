<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;
    protected $fillable = [
        'barcode',
        'product_name',
        'quantity',
        'number_of_pack',
        'discount',
        'discount_percentage',
        'selling_price',
        'total',
        'date',
        'image',
    ];
}
