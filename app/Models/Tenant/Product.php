<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'brand_id',
        'featured_img',
        'sku',
        'stock_quantity',
        'stock_available',
        'what_is_q',
        'what_is_a',
        'shop_id',
    ];

    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    // public function featured_img()
    // {
    //     return $this->belongsTo(Image::class);
    // }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class)->withPivot('value');
    }
}
