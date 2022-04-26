<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Multitenancy\Models\Tenant;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'features', 'price', 'discount', 'price_yearly', 'discount_yearly'];

    protected $connection = 'tenant';

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);

        if (!Tenant::checkCurrent()) {
            $this->connection = 'landlord';
        }
    }

    /**
     * Get all of the tenants for the Plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }
}
