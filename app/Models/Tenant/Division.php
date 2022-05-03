<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    /**
     * Get related districts
     *
     * @return HasMany
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    /**
     * Get related districts
     *
     * @return HasMany
     */
    public function postcodes()
    {
        return $this->hasMany(Postcode::class);
    }

    /**
     * Get related districts
     *
     * @return HasMany
     */
    public function city_with_postcodes()
    {
        return $this->hasMany(District::class)->with('postcodes');
    }
}
