<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
    use HasFactory;

    /**
     * Get associated districts
     *
     * @return BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get associated division
     *
     * @return BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
