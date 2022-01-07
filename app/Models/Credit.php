<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'total',
        'status',
    ];


    public function sale() {
        return $this->belongsTo('App\Models\Sale');
    }

    public function payments() {
        return $this->hasMany('App\Models\CreditPayment');
    }

    
}
