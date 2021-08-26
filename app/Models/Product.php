<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'code',
        'description',
        'retail_price',
        'wholesale_price',
        'brand_id',
        'category_id',
    ];

    protected $with = ['brand'];

    protected $hidden = [
        'brand_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function purchases() {
        return $this->belongsToMany('App\Models\Sale')->using('App\Models\ProductSale');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }


    public function brand() {
        return $this->belongsTo('App\Models\Brand');
    }
}
