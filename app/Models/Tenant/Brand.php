<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'website',
        'contact_person',
        'contact_number',
        'contact_email',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
