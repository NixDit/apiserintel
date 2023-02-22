<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCellphone extends Model
{
    use HasFactory;

    protected $table = 'company_cellphones';

    protected $fillable = [
        'id',
        'name',
    ];




}
