<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'code',
        'phone',
        'address'
    ];

    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function category() {
        return $this->belongsTo('App\Models\User');
    }
    public function customer() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
