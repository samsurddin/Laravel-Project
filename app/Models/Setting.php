<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Tenant;

class Setting extends Model
{
    use HasFactory;
    
    protected $connection = 'tenant';

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }
}
