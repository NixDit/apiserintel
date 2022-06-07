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
        'created_at',
        'updated_at',
    ];

    public function category() {
        return $this->belongsTo('App\Models\User');
    }
}
