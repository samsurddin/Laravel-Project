<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Product;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'slug',
        'order',
    ];

    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
        // return $this->hasManyThrough(Product::class, Category::class, 'parent_id', 'category_id', 'id');
        // return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('child');
    }
}
