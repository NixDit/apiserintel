<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $with = ['image'];


    public function products() {

        return $this->hasMany('App\Models\Product');

    }

    public function image() {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
