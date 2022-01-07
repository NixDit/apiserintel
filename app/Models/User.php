<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\SaleCollection;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot'
    ];

    // protected $with = ['roles'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function clientInformation() {
        return $this->hasOne('App\Models\ClientInformation');
    }

    public function devices() {
        return $this->hasMany('App\Models\Device');
    }

    public function fullName() {
        return ucfirst($this->name) . ' ' . ucfirst($this->last_name);
    }

    public function sales() {
        return $this->hasMany('App\Models\Sale', 'employee_id', 'id');
    }

    public function purchases() {
        return $this->hasMany('App\Models\Sale', 'client_id', 'id');
    }

    public function debts() { //In order to get prepago purchases type
        return $this->purchases()->whereHas('credit' , function($query) {
            return $query->where('status', 0 );
        });
    }
    //ROUTES THAT BELONGS THIS CLIENT
    public function routes() {
        return $this->belongsToMany('App\Models\Route')->using('App\Models\RouteClient');
    }

}
