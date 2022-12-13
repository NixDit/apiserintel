<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $table = 'provider';

    protected $fillable = [
        'provider_id',
        'razon_social',
        'rfc',
        'phone',
        'address'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function provider() {
        return $this->belongsTo('App\Models\User', 'provider_id', 'id');
    }
}
