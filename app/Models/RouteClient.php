<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RouteClient extends Pivot
{
    
    protected $table = 'route_user';

    protected $fillable = [
        'route_id',
        'user_id'
    ];
    
    public $timestamps = false;


}
