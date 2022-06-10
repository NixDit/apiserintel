<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'employee_id',
        'day'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    public function clients() {
        return $this->belongsToMany('App\Models\User')->using('App\Models\RouteClient');
    }

    public function scanLogs() {
        return $this->hasMany('App\Models\ScanLog');
    }


}
