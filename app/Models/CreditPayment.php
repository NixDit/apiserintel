<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_id',
        'quantity'
    ];

    public function credit() {
        return $this->belongsTo('App\Models\Credit');
    }
}
