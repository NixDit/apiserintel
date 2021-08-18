<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanLog extends Model
{
    use HasFactory;

    protected $table = 'scan_logs';

    protected $fillable = [
        'latlng',
        'client_id',
        'employee_id',
        'route_id',
    ];

    public function client() {
        return $this->belongsTo('App\Models\User', 'client_id', 'id');
    }

    public function employee() {
        return $this->belongsTo('App\Models\User', 'employee_id', 'id');
    }

    public function route() {
        return $this->belongsTo('App\Models\Route');
    }



}
