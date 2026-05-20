<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'barcode',
        'product_name',
        'quantity',
        'quantity_of_pack',
        'number_of_pack',
        'buying_price',
        'selling_price',
        'date',
        'image',
    ];
}
