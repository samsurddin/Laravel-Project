<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
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
}
