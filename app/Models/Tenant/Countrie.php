<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countrie extends Model
{
    use HasFactory;

    protected $fillable  =[
        'iso', 
        'name', 
        'nicename', 
        'iso3', 
        'numcode', 
        'phonecode',
    ];
}
