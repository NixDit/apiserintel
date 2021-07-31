<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'client_id',
        'employee_id',
        'subtotal',
        'total',
        'folio'
    ];

    public function products() {
        return $this->belongsToMany('App\Models\Products')->using('App\Models\ProductSale');
    }

}
