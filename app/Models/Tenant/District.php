<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    /**
     * Get associated division
     *
     * @return BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get related upazilas
     *
     * @return HasMany
     */
    public function upazilas()
    {
        return $this->hasMany(Upazila::class);
    }

    /**
     * Get related upazilas
     *
     * @return HasMany
     */
    public function postcodes()
    {
        return $this->hasMany(Postcode::class);
    }
}
