<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $table = 'division';

    protected $fillable = [
        'name'
    ];

    // protected $hidden = [
    //     'deleted_at'
    // ];

    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
