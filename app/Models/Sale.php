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
        'type',
        'folio'
    ];

    protected $casts = [
        'created_at'
    ];


    public function costumer() {
        return $this->belongsTo('App\Models\User', 'client_id', 'id');
    }
    public function seller() {
        return $this->belongsTo('App\Models\User', 'employee_id', 'id');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product')->using('App\Models\ProductSale')->withPivot(['quantity', 'subtotal', 'total']);
    }

    public function credit() {
        return $this->hasOne('App\Models\Credit');
    }

}
