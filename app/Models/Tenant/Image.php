<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'folder',
        'name',
        'extension',
        'alt',
        'caption',
        'description',
    ];


    // public function product_featured()
    // {
    //     return $this->hasMany(Product::class);
    // }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'imageable');
    }
}
