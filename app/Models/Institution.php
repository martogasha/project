<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
        protected $fillable = [
        'institution_name',
        'registration_fee',
        'instalation_fee',
        'monthly_payment_id',
        'No_of_computers',
        'lan_nodes',
        'monthlyPayment_id',
        'fine',
        'reconnection_fee',
        'defaulters_status',
        'connection_status',
        
    ];
     public function monthly_payment(){
        return $this->belongsTo(monthlyPayment::class);
    }
}
