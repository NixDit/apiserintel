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
        'type', // 1:Prepago, 2:Pagado, 3: Postpago
        'folio',
        'status', // 0:Pending, 1:Completed, 2:Rejected,
        'payment_method' // 1:Efectivo, 2:Tarjeta
    ];

    protected $casts = [
        'created_at'
    ];

    protected $appends = ['format_created_at'];

    /**
     * MUTATORS
     */

    public function getFormatCreatedAtAttribute() {
        return $this->created_at->format('d/m/Y');
    }

    public function customer() {
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
